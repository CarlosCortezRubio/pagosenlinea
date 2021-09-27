<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Traits\Tables;
use Illuminate\Http\Request;

class LoginController extends Controller
{
   use AuthenticatesUsers;
   use Tables;

   // protected $redirectTo = '/home';

   public function __construct()
   {
      $this->middleware('guest')->except('logout');
   }

   public function showLoginForm()
   {
      return view('auth.login');
   }

   public function logout(Request $request)
   {
      $this->guard()->logout();

      $request->session()->invalidate();

      return $this->loggedOut($request) ?: redirect('login');
   }
}
