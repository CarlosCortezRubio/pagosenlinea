<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\Traits\Tables;

class ForgotPasswordController extends Controller
{
   use SendsPasswordResetEmails;
   use Tables;

   public function __construct()
   {
      $this->middleware('guest');
   }

   public function showLinkRequestForm()
   {
      $proceso = $this->getProceso('V');

      return view('auth.passwords.email', ['proceso'=>$proceso]);
   }
}
