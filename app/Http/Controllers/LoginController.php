<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class LoginController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function loginpage(){

        return view('loginpage');
    }

    public function loginProcess(Request $request)
{
  
    $user = User::where('username', $request->username)->first();

    if ($user && Hash::check($request->password, $user->password)) {
        // Debugging here
        dd('Password match');

        Auth::login($user);


        if ($user->roles === 'hr') {
            return redirect()->route('view.dashboard.hr');
        } elseif ($user->roles === 'admin') {
            return redirect()->route('view.dashboard');
        } elseif ($user->roles === 'lawyer') {
            return redirect()->route('view.dashboard.lawyer');
        } 
    }

    return back()->with('error', 'Invalid credentials');
}


    

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
