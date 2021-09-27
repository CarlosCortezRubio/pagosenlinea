<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use App\Traits\Tables;

class ResetPasswordController extends Controller
{
   use ResetsPasswords;
   use Tables;

   // protected $redirectTo = '/home';

   public function __construct()
   {
      $this->middleware('guest');
   }

   public function showResetForm(Request $request, $token = null)
   {
      $proceso = $this->getProceso('V');

      return view('auth.passwords.reset', ['proceso'=>$proceso])->with(
         ['token' => $token, 'email' => $request->email]
      );
   }
}
