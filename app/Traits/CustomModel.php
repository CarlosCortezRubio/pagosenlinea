<?php

namespace App\Traits;

use Exception;
use Illuminate\Database\Eloquent\Builder;

trait CustomModel
{
   // Establecer forma de fecha/hora del modelo
   public function __construct()
   {
      $this->dateFormat = config('app.date_format_db');
   }

   // Establecer PK del modelo
   protected function setKeysForSaveQuery(Builder $query)
   {
      $keys = $this->getKeyName();
      if(!is_array($keys)){
         return parent::setKeysForSaveQuery($query);
      }

      foreach($keys as $keyName){
         $query->where($keyName, '=', $this->getKeyForSaveQuery($keyName));
      }

      return $query;
   }

   // Obtener PK del modelo
   protected function getKeyForSaveQuery($keyName = null)
   {
      if(is_null($keyName)){
         $keyName = $this->getKeyName();
      }

      if (isset($this->original[$keyName])) {
         return $this->original[$keyName];
      }

      return $this->getAttribute($keyName);
   }
}