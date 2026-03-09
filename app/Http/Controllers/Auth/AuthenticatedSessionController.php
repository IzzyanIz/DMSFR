<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
{
    $request->authenticate();

    $request->session()->regenerate();
    $user = Auth::user();
    $request->session()->put('username', $user->name);
   // dd($user);

    // Redirect based on user level
    switch ($user->roles) {
        case 'Lawyer':
            return redirect()->route('view.dashboard.lawyer');
        case 'Admin':
            return redirect()->route('view.dashboard');
        case 'Human Resource':
            return redirect()->route('view.dashboard.hr');
        case 'Manager':
            return redirect()->route('view.dashboard.manager');
        case 'CEO':
            return redirect()->route('view.dashboard.CEO');
        default:
            return redirect('/'); 
    }
}



    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
