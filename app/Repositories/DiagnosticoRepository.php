<?php
namespace App\Repositories;



class DiagnosticoRepository
{
     protected $modelo;
     
     public function __construct()
     {
       	$this->modelo =  modelo("Diagnostico");
     }
     
     public function buscaDx($cie10)
     {
         return $this->modelo->select('DIAG_ID','DIAG_DESCRIPCION')->where('DIAG_CODIGO',$cie10)->get();
     }

     	public function autoComplete($term) {
	    	return $this->modelo->where('DIAG_DESCRIPCION','LIKE','%'.$term.'%')
				 		->take(10)
				 		->get();
	}

	public function getData()
	{
			return $this->modelo->select(['DIAG_ID','DIAG_CODIGO','DIAG_DESCRIPCION'])->get();
	}
}
?>