<?php
namespace App\Repositories;



class AusentismoRepository
{
     protected $modelo;
     
     public function __construct()
     {
             $this->modelo =  modelo("Ausentismo");
     }
     
     public function buscaDx($cie10)
     {
         return $this->modelo->select('DIAG_ID','DIAG_DESCRIPCION')->where('DIAG_CODIGO',$cie10)->get();
     }
}
?>