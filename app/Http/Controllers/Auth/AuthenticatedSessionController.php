<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Show the login form.
     */
    public function create(): View
    {
       
        return view('auth.login');
    }

    /**
     * Handle login request.
     */
 public function store(LoginRequest $request): RedirectResponse
{
    $request->validate([
        'loginAs' => 'required|in:admin,subadmin,teacher',
    ]);

    $credentials = $request->only('email', 'password');
    $loginAs = $request->input('loginAs');

    if (Auth::attempt($credentials)) {

        $user = Auth::user();

        if ($user->type !== $loginAs) {

            Auth::logout();

            return redirect()->back()
                ->with('error','Selected login type does not match your account.')
                ->withErrors([
                    'loginAs' => 'Selected login type does not match your account.'
                ])
                ->withInput();
        }

        $request->session()->regenerate();

        return redirect()
            ->route('dashboard')
            ->with('success','Welcome, '.$user->name.'! You have logged in successfully.');
    }

    return redirect()->back()
        ->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])
        ->withInput();
}


    /**
     * Logout the user.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
