<?php

namespace App\Classes;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Validator as LaravelValidator;

class Validator extends LaravelValidator {

   public function validateFotoPostulante($attribute, $value, $parameters)
   {
      $submit = $this->getValue($parameters[0]);
      $input = $this->getValue($parameters[1]);

      if ($submit == 'E') {
         if ($value == '.') {
            if (empty($input)) {
               return false;
            }
         }
      }
      return true;
   }

}
