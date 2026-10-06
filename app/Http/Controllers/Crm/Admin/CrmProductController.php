<?php

namespace App\Http\Controllers\Crm\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Crm\CrmProduct;

class CrmProductController extends Controller
{
    public function index(Request $request)
    {
        $products = CrmProduct::latest()->paginate(10);
        return view('crm.admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('crm.admin.products.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string',
            'category' => 'required|string',
            'price' => 'required|numeric',
            'tax_rate' => 'required|numeric',
            'status' => 'required|string',
            'description' => 'nullable|string',
        ]);

        CrmProduct::create($data);
        return redirect()->route('crm.admin.products.index')->with('success', 'Product/Service added successfully!');
    }

    public function update(Request $request, $id)
    {
        $product = CrmProduct::findOrFail($id);
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string',
            'category' => 'required|string',
            'price' => 'required|numeric',
            'tax_rate' => 'required|numeric',
            'status' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $product->update($data);
        return redirect()->back()->with('success', 'Product updated!');
    }

    public function destroy($id)
    {
        CrmProduct::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Product deleted.');
    }
}
