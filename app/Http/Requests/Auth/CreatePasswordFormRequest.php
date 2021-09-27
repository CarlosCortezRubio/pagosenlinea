<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class CreatePasswordFormRequest extends FormRequest
{
   public function authorize()
   {
      return true;
   }

   public function rules()
   {
      return [
         'password' => 'required|min:8|max:15',
         'password_confirm' => 'required|same:password'
      ];
   }

   public function messages()
   {
      return [
         'password.required' => 'Debe ingresar su contraseña.',
         'password.min' => 'La contraseña debe tener mínimo 8 caracteres.',
         'password.max' => 'La contraseña debe tener máximo 15 caracteres.',
         'password_confirm.required' => 'Debe ingresar la confirmación de la contraseña.',
         'password_confirm.same' => 'La confirmación de la contraseña no coincide.'
     ];
   }
}
