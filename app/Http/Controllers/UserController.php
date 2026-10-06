<?php

namespace App\Http\Controllers;
use Validator;
use Illuminate\Http\Request;
use App\Models\Slider;
use App\Models\OrderItem;
use App\Models\Order;
use App\Models\CustomerWallet;
use App\Models\CustomerAddress;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;


  use Barryvdh\DomPDF\Facade\Pdf; 



class UserController extends Controller
{

  

    public function send_otp(Request $request)
{

    $request->validate(['email' => 'required|email']);

    $otp = rand(100000, 999999); 

    
    session([
        'registration_email_otp' => $otp,
        'registration_email' => $request->email
    ]);

    Mail::raw("Your OTP for registration is: $otp", function ($msg) use ($request) {
        $msg->to($request->email)
            ->from('no-reply@firstnutrition.com', 'First Nutrition') 
            ->subject('Your Registration OTP');
    });


    return response()->json(['status' => 'success', 'message' => 'OTP sent to your email.']);
}



 public function register_end_user(Request $request)
{
   
    $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        'phone' => 'required',
        'password' => 'required',
        'confirm_password' => 'required|same:password',
        'otp' => 'required|numeric'
    ]);

    if ($request->email !== session('registration_email') || $request->otp != session('registration_email_otp')) {
        return redirect()->back()->with('error', 'OTP is incorrect or expired.')->withInput();
    }

    if (DB::table('tbl_customer')->where('email', $request->email)->exists()) {
        return redirect()->back()->with('error', 'Email Already Exists.')->withInput();
    }

    if (DB::table('tbl_customer')->where('phone', $request->phone)->exists()) {
        return redirect()->back()->with('error', 'Phone Already Exists.')->withInput();
    }


    
    
    $reff_type = null;
    $reff_by = null;
    $referral_by_name = null;

    if ($request->has('ref')) {
       
        $ref_id = $request->ref;

        
        $customerRef = DB::table('tbl_customer')->where('id', $ref_id)->first();
         
        if ($customerRef) {
            $reff_type = 'customer';
            $reff_by = $ref_id;
            $referral_by_name = $customerRef->name;

            
        }

        
        $influencerRef = DB::table('tbl_influencer')->where('id', $ref_id)->first();
        if ($influencerRef) {
            $reff_type = 'influencer';
            $reff_by = $ref_id;
            $referral_by_name = $influencerRef->name;
        }
    }

    
    $customerId = DB::table('tbl_customer')->insertGetId([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'password' => Hash::make($request->password),
        'wallet_balance' => $request->wallet_balance,
        'status' => 'Active',
        'reff_type' => $reff_type,
        'reff_by' => $reff_by,
        'created_at' => now(),
        'updated_at' => now()
    ]);

    
    if ($reff_by && $reff_type) {
        DB::table('tbl_customer_reffer_logs')->insert([
            'referral_by' => $reff_by,
            'referral_by_name' => $referral_by_name,
            'joining_id' => $customerId,
            'joining_name' => $request->name,
            'joining_date' => now(),
            'reff_type' => $reff_type,
            'is_deleted' => 0,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    session()->forget(['registration_email_otp', 'registration_email']);
    $user = DB::table('tbl_customer')->where('id', $customerId)->first();
    Session::put('end_user_login', true);
    Session::put('end_user_data', $user);

    return redirect('my-account')->with('wallet_added', true);
}



public function userLogin(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    
    $user = DB::table('tbl_customer')->where('email', $request->email)->first();

    
    if (!$user || !Hash::check($request->password, $user->password)) {
        return redirect()->back()->with('error', 'Invalid email or password.')->withInput();
    }

    
    if ($user->status !== 'Active') {
        return redirect()->back()->with('error', 'Your account is not active.')->withInput();
    }

    
    Session::put('end_user_login', true);
    Session::put('end_user_data', $user);

    
    if ($request->has('remember')) {
        Cookie::queue('remember_email', $request->email, 60 * 24 * 30);
    } else {
        Cookie::queue(Cookie::forget('remember_email'));
    }

    return redirect('my-account')->with('success', 'Logged in successfully.');
}





public function submitForgetPasswordForm(Request $request)
{
    $request->validate([
        'email' => 'required|email|exists:tbl_customer,email',
    ]);

    $temporaryPassword = Str::random(8);
    $hashedPassword = Hash::make($temporaryPassword);

    DB::table('tbl_customer')
        ->where('email', $request->email)
        ->update(['password' => $hashedPassword]);

    $htmlContent = '
        <html>
        <body style="font-family: Arial, sans-serif; color: #333;">
            <div style="max-width: 600px; margin: auto; padding: 20px; border: 1px solid #eee; border-radius: 8px;">
                <h2 style="color: #007bff;">Your Temporary Password</h2>
                <p>Hello,</p>
                <p>You requested a password reset. Please use the temporary password below to log in:</p>
                <div style="background: #f8f9fa; padding: 15px; border-left: 4px solid #007bff; margin: 20px 0;">
                    <strong style="font-size: 18px;">' . $temporaryPassword . '</strong>
                </div>
                <p>Please change your password after logging in.</p>
                <p>If you did not request this, please ignore this email.</p>
                <p>Thanks,<br>First Nutrition</p>
            </div>
        </body>
        </html>
    ';

    Mail::send([], [], function ($message) use ($request, $htmlContent) {
        $message->to($request->email)
                ->subject('Your Temporary Password')
                ->html($htmlContent); 
    });

    return back()->with('success', 'A temporary password has been sent to your email.');
}



public function updateCustomerProfile(Request $request)
{
   
    $request->validate([
        'name' => 'required'
    ]);

   
    if ($request->npassword !== $request->cpassword) {
        return redirect()->back()->with('error', 'New Password and Confirm Password do not match.');
    }

    $sessionUser = session('end_user_data');

    if (!$sessionUser) {
        return redirect()->back()->with('error', 'Session expired. Please log in again.');
    }

    $customer = CustomerWallet::find($sessionUser->id);

    if (!$customer) {
        return redirect()->back()->with('error', 'User not found.');
    }

   
    if (!Hash::check($request->password, $customer->password)) {
        return redirect()->back()->with('error', 'Current password is incorrect.');
    }

   
    if (Hash::check($request->npassword, $customer->password)) {
        return redirect()->back()->with('error', 'New password must be different from the current password.');
    }

   
    $customer->name = $request->name;
    $customer->phone = $request->phone;
    $customer->email = $request->email;
    $customer->password = Hash::make($request->npassword);
    $customer->save();

   
    session(['end_user_data' => $customer]);

    return redirect()->back()->with('success', 'Profile updated successfully.');
}



public function userLogout()
{
    Session::forget(['end_user_login', 'end_user_data']);
    return redirect('user-login')->with('success', 'Logged out successfully.');
}



  private function getCustomerId()
    {
        
        if (auth()->check()) {
            return auth()->id();
        } elseif (Session::has('end_user_login')) {
            return Session::get('end_user_data')->id;
        }
        return null;
    }

   public function addToCart(Request $request)
{
    $cust_id = auth()->id() ?? (Session::has('end_user_login') ? Session::get('end_user_data')->id : null);

    if (!$cust_id) {
        return response()->json(['status' => 'error', 'message' => 'User not logged in']);
    }

    $prod_id = $request->prod_id;
    $weight = $request->weight;
    $price = $request->price;
    $qty = $request->qty;

    $exists = DB::table('tbl_prod_cart')->where([
        'cust_id' => $cust_id,
        'prod_id' => $prod_id,
        'weight' => $weight,
    ])->exists();

    if ($exists) {
        return response()->json(['status' => 'exists']);
    }

    DB::table('tbl_prod_cart')->insert([
        'prod_id' => $prod_id,
        'weight' => $weight,
        'qty' => $qty,
        'cust_id' => $cust_id,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return response()->json(['status' => 'success']);
}


public function updateWeight(Request $request)
{
    $cust_id = auth()->id() ?? (Session::has('end_user_login') ? Session::get('end_user_data')->id : null);

    if (!$cust_id) {
        return response()->json(['status' => 'error', 'message' => 'User not logged in']);
    }

    $prod_id = $request->prod_id;
    $new_weight = $request->weight;

    // Update the matching row
    $updated = DB::table('tbl_prod_wishlist')
        ->where('cust_id', $cust_id)
        ->where('prod_id', $prod_id)
        ->update([
            'weight' => $new_weight,
            'updated_at' => now()
        ]);

    return response()->json([
        'status' => $updated ? 'success' : 'nochange'
    ]);
}


public function addToWishlist(Request $request)
{
    $request->validate([
        'prod_id' => 'required|integer',
        'weight'  => 'nullable|string',  // changed from size to weight
        'qty'     => 'required|integer|min:1'
    ]);

    $cust_id = $this->getCustomerId();
    if (!$cust_id) {
        return response()->json(['status' => 'error', 'message' => 'Please login to add to wishlist'], 401);
    }

    $exists = DB::table('tbl_prod_wishlist')
        ->where('cust_id', $cust_id)
        ->where('prod_id', $request->prod_id)
        ->where('weight', $request->weight) // check for same weight
        ->exists();

    if ($exists) {
        return response()->json(['status' => 'info', 'message' => 'Already in your wishlist']);
    }

    DB::table('tbl_prod_wishlist')->insert([
        'prod_id'    => $request->prod_id,
        'weight'     => $request->weight,
        'qty'        => $request->qty,
        'cust_id'    => $cust_id,
        'created_at' => now(),
    ]);

    return response()->json(['status' => 'success', 'message' => 'Product added to wishlist']);
}

 public function deleteSingle($wishlistItemId)
{
   
    $currentCustomerId = auth()->check() ? auth()->id() : (Session::has('end_user_data') ? Session::get('end_user_data')->id : null);

    if ($currentCustomerId) {
       
        $deleted = DB::table('tbl_prod_wishlist')
            ->where('id', $wishlistItemId)
            ->where('cust_id', $currentCustomerId)
            ->delete();

        if ($deleted) {
            return back()->with('success', 'Wishlist item deleted.');
        } else {
            return back()->with('error', 'Item not found or unauthorized.');
        }
    }

    return redirect()->route('login')->with('error', 'Please login first.');
}

public function deleteSelected(Request $request)
{
    
    $currentCustomerId = auth()->check() ? auth()->id() : (Session::has('end_user_data') ? Session::get('end_user_data')->id : null);

    if ($currentCustomerId) {
     
        $selectedWishlistIds = $request->input('wishlist_ids', []);

        if (!empty($selectedWishlistIds)) {
            
            $deleted = DB::table('tbl_prod_wishlist')
                ->whereIn('id', $selectedWishlistIds)
                ->where('cust_id', $currentCustomerId)
                ->delete();

            if ($deleted) {
                return back()->with('success', 'Selected wishlist items deleted.');
            } else {
                return back()->with('error', 'Items not found or unauthorized.');
            }
        }

        return back()->with('error', 'No items selected.');
    }

    return redirect()->route('login')->with('error', 'Please login first.');
}



public function delete($cartId)
{
    $cust_id = auth()->check()
        ? auth()->id()
        : (Session::has('end_user_login') ? Session::get('end_user_data')->id : null);

    DB::table('tbl_prod_cart')
        ->where('id', $cartId)
        ->where('cust_id', $cust_id)
        ->delete();

    return redirect()->back()->with('success', 'Item removed from cart');
}


public function applyCoupon(Request $request)
{
    $request->validate([
        'coupon_code' => 'required|string',
        'cart_total' => 'required|numeric|min:0',
    ]);

    $code = trim($request->coupon_code);
    $cartTotal = floatval($request->cart_total);

    // ✅ Get logged-in customer using session data
    $customerEmail = session('end_user_data')->email ?? null;

    if (!$customerEmail) {
        return response()->json(['status' => false, 'message' => 'Customer session not found.']);
    }

    // ✅ Fetch customer record from tbl_customer
    $customer = DB::table('tbl_customer')
        ->where('email', $customerEmail)
        ->where('status', 'Active')
        ->first();

    if (!$customer) {
        return response()->json(['status' => false, 'message' => 'Customer not found or inactive.']);
    }

    // ✅ Fetch the coupon
    $coupon = DB::table('tbl_coupon')
        ->whereRaw('LOWER(coupon_code) = ?', [strtolower($code)])
        ->where('is_deleted', 0)
        ->whereDate('start_date', '<=', now())
        ->whereDate('end_date', '>=', now())
        ->first();

    if (!$coupon) {
        return response()->json(['status' => false, 'message' => 'Invalid or expired coupon.']);
    }

     // ✅ Check if coupon is already used by this customer
    $alreadyUsed = DB::table('tbl_coupon_history')
        ->where('customer_id', $customer->id)
        ->where('coupon_code', $coupon->coupon_code)
        ->where('status', 'success')
        ->exists();

    if ($alreadyUsed) {
        return response()->json([
            'status' => false,
            'message' => 'You have already used this coupon.'
        ]);
    }

    // ✅ Check if this coupon is assigned to the customer
    if (!empty($coupon->assigned_customer_ids)) {
        $assignedIds = explode(',', $coupon->assigned_customer_ids); // e.g. "2,5,7"
        $assignedIds = array_map('trim', $assignedIds); // clean spaces

        if (!in_array($customer->id, $assignedIds)) {
            return response()->json([
                'status' => false,
                'message' => 'This coupon is not assigned to your account.'
            ]);
        }
    }

    // ✅ Check minimum cart amount
    if ($coupon->min_cart_amount && $cartTotal < $coupon->min_cart_amount) {
        return response()->json([
            'status' => false,
            'message' => 'Minimum cart amount must be ₹' . $coupon->min_cart_amount . ' to apply this coupon.'
        ]);
    }

    // ✅ Calculate discount
    $discount = 0;
    $couponType = strtolower($coupon->coupon_type);
    $discountType = strtolower($coupon->discount_type);

    if ($discountType === 'flat') {
        $discount = floatval($coupon->amount);
    } elseif ($discountType === 'percentage') {
        $percent = floatval(preg_replace('/[^0-9.]/', '', $coupon->amount));
        $discount = ($cartTotal * $percent) / 100;
    } else {
        return response()->json(['status' => false, 'message' => 'Invalid discount type.']);
    }

    // ✅ Apply max discount limit
    if ($coupon->max_limit && $discount > $coupon->max_limit) {
        $discount = floatval($coupon->max_limit);
    }

    $discount = min($discount, $cartTotal);
    $finalTotal = $cartTotal - $discount;

    // ✅ Final success response
    return response()->json([
        'status' => true,
        'message' => 'Coupon applied successfully!',
        'discount' => round($discount, 2),
        'final_total' => round($finalTotal, 2),
        'code' => $code,
        'type' => $couponType,
        'discount_type' => $discountType,
        'max_limit' => $coupon->max_limit ?? null,
        'min_cart_amount' => $coupon->min_cart_amount ?? null
    ]);
}




public function getShippingCharge(Request $request)
{
    $total = floatval($request->cart_total);
   
    $method = $request->shipping_method;

    $record = DB::table('tbl_shiping_charge')
        ->where('status', 'Active')
        ->where('is_deleted', 0)
        ->where('price_above', '<=', $total)
        ->orderByDesc('price_above')
        ->first();

    if (!$record) {
        return response()->json(['status' => false, 'message' => 'No shipping rule found']);
    }

    $shippingCharge = $method === 'online'
        ? floatval($record->shiping_charge_online)
        : floatval($record->shiping_charge);

    return response()->json([
        'status' => true,
        'shipping' => $shippingCharge
    ]);
}



public function updateWeightCart(Request $request)
{
    $request->validate([
        'cart_id' => 'required|integer',
        'weight' => 'required|string',
        'price' => 'required|numeric',
    ]);

    $cart = DB::table('tbl_prod_cart')->where('id', $request->cart_id)->first();

    if (!$cart) {
        return response()->json(['status' => 'error', 'message' => 'Cart not found']);
    }

    $updated = DB::table('tbl_prod_cart')
        ->where('id', $request->cart_id)
        ->update([
            'weight' => $request->weight,
            'sell_price' => $request->price,
            'updated_at' => now()
        ]);

    return response()->json([
        'status' => $updated ? 'success' : 'error',
        'old_weight' => $cart->weight,
        'new_weight' => $request->weight,
        'old_price' => $cart->sell_price,
        'new_price' => $request->price
    ]);
}




public function addressstore(Request $request) {
    $cust_id = session('end_user_data')->id;

    $address = new CustomerAddress();
    $address->customer_id = $cust_id;
    $address->address_line1 = $request->address_line1;
    $address->address_line2 = $request->address_line2;
    $address->city = $request->city;
    $address->state = $request->state;
    $address->pin_code = $request->pin_code;
    $address->country = $request->country;

    $address->save();

    return redirect()->back()->with('success', 'Address added successfully.');
}


public function addressupdate(Request $request, $id) {
    $cust_id = session('end_user_data')->id;

    $address = CustomerAddress::where('customer_id',  $cust_id)->findOrFail($id);
   $address->customer_id = $cust_id;
    $address->address_line1 = $request->address_line1;
    $address->address_line2 = $request->address_line2;
    $address->city = $request->city;
    $address->state = $request->state;
    $address->pin_code = $request->pin_code;
    $address->country = $request->country;
        $address->save();


    return redirect()->back()->with('success', 'Address updated successfully.');
}



public function addressdestroy($id) {
    $cust_id = session('end_user_data')->id ?? 0;

    
    $address = CustomerAddress::where('id', $id)
                ->where('customer_id', $cust_id)
                ->first();

    
    if (!$address) {
        return redirect()->back()->with('error', 'Address not found or access denied.');
    }

    
    $address->is_deleted = 1;
    $address->save();

    return redirect()->back()->with('success', 'Address deleted successfully.');
}




public function checkoutSubmit(Request $request)
{
    // Store cart and pricing info in session
    session(['checkout_data' => $request->all()]);
    return redirect()->route('checkout.page');
}

public function placeOrder(Request $request)
{
   dd($request);

    $cartItems = array_filter(json_decode($request->input('cart_items'), true), function ($item) {
        return isset($item['product_id'], $item['name'], $item['price'], $item['qty']);
    });

    dd($cartItems);

    if (empty($cartItems)) {
        return redirect()->back()->with('error', 'Cart is empty or invalid!');
    }

    $orderId = 'ORD' . strtoupper(uniqid());
    $custId = session('end_user_data')->id ?? null;

    $insertData = [
        'order_id'        => $orderId,
        'cust_id'         => $custId,
        'name'            => $request->full_name,
        'email'           => $request->email,
        'phone'           => $request->phone,
        'address'         => $request->address,
        'city'            => $request->city,
        'state'           => $request->state,
        'country'         => $request->country,
        'zip_code'        => $request->zip_code,
        'coupon_code'     => $request->coupon_code,
        'discount_amount' => $request->discount_amount ?? 0,
        'shipping_charge' => $request->shipping_charge ?? 0,
        'final_total'     => $request->final_total,
        'payment_method'  => $request->payment_method,
        'status'          => 'pending',
        'created_at'      => now(),
    ];

    DB::beginTransaction();
    try {
        DB::table('tbl_order')->insert($insertData);

        foreach ($cartItems as $item) {
            DB::table('tbl_order_items')->insert([
                'order_id'   => $orderId,
                'product_id' => $item['product_id'],
                'name'       => $item['name'],
                'weight'     => $item['weight'] ?? '',
                'price'      => $item['price'],
                'qty'        => $item['qty'],
                'total'      => $item['total'] ?? ($item['price'] * $item['qty']),
                'created_at' => now(),
            ]);
        }

        DB::commit();
        session()->forget('checkout_data');
        return redirect()->route('order.success')->with('success', 'Order placed successfully!');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'Order failed: ' . $e->getMessage());
    }
}

public function razorpayCallback(Request $request)
{
    // Get the payment ID
    $paymentId = $request->input('razorpay_payment_id');
    $orderId = 'ORD' . strtoupper(uniqid());

    // Get customer details
    $fullName = $request->input('full_name');
    $email = $request->input('email');
    $phone = $request->input('phone');
    $address = $request->input('address');
    $city = $request->input('city');
    $state = $request->input('state');
    $zip = $request->input('zip_code');
    $country = $request->input('country');
    $custId = session('end_user_data')->id ?? null;

    // Cart Items
    $cartItemsJson = $request->input('cart_items');
    $cartItems = json_decode($cartItemsJson, true);

    $filteredCartItems = array_filter($cartItems, function($item) {
        return isset($item['name']) && !empty($item['name']);
    });

    // Order details
    $discount = $request->input('discount_amount');
    $shipping = $request->input('shipping_charge');
    $finalTotal = $request->input('final_total');
    $paymentMethod = $request->input('payment_method');

    // Coupon code
    $couponCode = $request->input('coupon_code');

    

    // Save order
    $order = new Order();
    $order->payment_id = $paymentId;
    $order->order_id = $orderId;
    $order->name = $fullName;
    $order->email = $email;
    $order->phone = $phone;
    $order->address = $address;
    $order->city = $city;
    $order->state = $state;
    $order->zip_code = $zip;
    $order->country = $country;
    $order->discount_amount = $discount;
    $order->shipping_charge = $shipping;
    $order->final_total = $finalTotal;
    $order->payment_method = $paymentMethod;
    $order->cust_id = $custId;
    $order->payment_status = 'success';
    $order->save();

    // Save order items
    foreach ($filteredCartItems as $item) {
        $orderItem = new OrderItem();
        $orderItem->order_id = $order->order_id;
        $orderItem->name = $item['name'];
        $orderItem->weight = $item['weight'] ?? '';
        $orderItem->price = $item['price'] ?? 0;
        $orderItem->qty = $item['qty'] ?? 0;
        $orderItem->total = $item['total'] ?? 0;
        $orderItem->save();
    }

    
    // Save coupon usage
    if (!empty($couponCode) && floatval($discount) > 0) {
        $coupon = DB::table('tbl_coupon')
            ->whereRaw('LOWER(coupon_code) = ?', [strtolower($couponCode)])
            ->where('is_deleted', 0)
            ->first();

        if ($coupon) {
            DB::table('tbl_coupon_history')->insert([
                'customer_id'       => $custId,
                'coupon_id'         => $coupon->id,
                'coupon_code'       => $coupon->coupon_code,
                'usage_time'        => now(),
                'order_id'          => $order->id,
                'discount_applied'  => $discount,
                'cart_amount'       => $finalTotal + $discount - $shipping,
                'status'            => 'success',
                'discount_type'     => $coupon->discount_type ?? null,
                'coupon_type'       => $coupon->coupon_type ?? null,
                'created_at'        => now(),
                'updated_at'        => now()
            ]);
        }
    }

    // Clear cart
    if ($custId) {
        DB::table('tbl_prod_cart')->where('cust_id', $custId)->delete();
    }

    // Redirect to invoice page
    return redirect()->route('invoice.view', ['order_id' => $order->id]);
}




public function setAddressSession(Request $request)
{
    $data = $request->only(['id', 'address_line1', 'city', 'state', 'pin_code', 'country']);
    session()->put('selected_address', $data);

    return response()->json([
        'success' => true,
        'message' => 'Address saved in session.',
        'data' => $data
    ]);
}



public function invoicedownload($id)
{
    $order = Order::findOrFail($id);
    $orderItems = OrderItem::where('order_id', $id)->get(); // no relation
    $pdf = Pdf::loadView('frontend.invoice-pdf', compact('order', 'orderItems'));
    return $pdf->download('invoice-'.$order->id.'.pdf');
}




}