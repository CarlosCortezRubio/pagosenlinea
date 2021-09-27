<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordFormRequest extends FormRequest
{
   public function authorize()
   {
      return true;
   }

   public function rules()
   {
      return [
         'current_password' => 'required|current_password',
         'password' => 'required|min:8|max:15',
         'password_confirm' => 'required|same:password'
      ];
   }

   public function messages()
   {
      return [
         'current_password.required' => 'Debe ingresar su contraseña actual.',
         'current_password.current_password' => 'La contraseña actual es incorrecta.',
         'password.required' => 'Debe ingresar su nueva contraseña.',
         'password.min' => 'La nueva contraseña debe tener mínimo 8 caracteres.',
         'password.max' => 'La nueva contraseña debe tener máximo 15 caracteres.',
         'password_confirm.required' => 'Debe ingresar la confirmación de la nueva contraseña.',
         'password_confirm.same' => 'La confirmación de la nueva contraseña no coincide.'
     ];
   }
}
