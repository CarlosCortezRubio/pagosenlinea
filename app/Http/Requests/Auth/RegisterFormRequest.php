<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterFormRequest extends FormRequest
{

   public function authorize()
   {
      return true;
   }

   public function rules()
   {
      return [
         'tipo_docu_sol' => 'required',
         'nume_docu_sol' => 'required|max:20',
         'apel_pate_sol' => 'required|max:30',
         'apel_mate_sol' => 'required|max:30',
         'nomb_pers_sol' => 'required|max:40',
         'telf_celu_sol' => 'required|numeric|max:20',
         'mail_soli_sol' => 'required|email|max:100',
      ];
   }
  
   public function messages()
   {
      return [
         'telf_celu_sol.numeric' => 'El teléfono celular debe ser numérico.',
      ];
   }
}
