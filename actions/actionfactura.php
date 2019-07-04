<?php


// DataBase
include_once '../data/dataBase.php';
// Classes
include_once '../classes/cfactura.php';


$ofactura  	= new factura();
$option = '';

session_start();

if (isset($_REQUEST['valor'])){
  $data 	= $_REQUEST['valor'];
  $option 	= $data['opt'];
}else{
	$option =  $_REQUEST['opt'];
}

if($option == 'd'){

	$fecha1 	= $_REQUEST['f1'];
	$fecha2 	= $_REQUEST['f2'];
	
	$pac = $ofactura->getjsonGrafico($fecha1,$fecha2);
	
	echo $pac;
}

if ( $option == 'n' ) {
	try{
		
		$total		= $data['total']; 
		$idestado	= $data['idestado']; 
		$fecha		= $data['fecha']; 
		$tipo		= $data['tipo']; 
		$correlativo		= $data['correlativo']; 
		$idpaciente		= $data['idpaciente']; 


			$params = array($total,$idestado,$fecha,$tipo,$idpaciente,$correlativo);
			$id   = $ofactura->nuevo($params);
			if ( $id ) {

				for($i=1;$i<=$data['linea'];$i++){
					if(isset($data['idproducto_'.$i])){
						$idproducto		= $data['idproducto_'.$i]; 
						$valor			= $data['valor_'.$i]; 
						$cantidad		= $data['cantidad_'.$i]; 

						$params = array($cantidad,$valor,$id,$idproducto);
						$val = $ofactura->nuevoDetalle($params);
						$val = $ofactura->outInventario($idproducto,$cantidad);
					}
			
				} 
				echo "0";
			} else {
				echo "400";
			}
		
	}catch (Exception $e){
		echo  $e;
	}
}

if ( $option == 'm' ) {

	$idfactura		= $data['idfactura'];  
		$total		= $data['total'];  
		$idestado		= $data['idestado'];  
		$fecha		= $data['fecha'];  
		$tipo		= $data['tipo'];  
		$correlativo	= $data['correlativo']; 
		$idpaciente		= $data['idpaciente'];  
		//$rows = $data['linea'] + 1;
				
			try {
			
			$params = array($total,$idestado,$fecha,$tipo,$idpaciente,$correlativo,$idfactura);
			$save   = $ofactura->actualizar($params);
			
			if ( $save ) {
				$val = $ofactura->regresarInventario($idfactura);
				for($i=1;$i<=$data['linea'];$i++){
					if(isset($data['idproducto_'.$i])){
						$idproducto		= $data['idproducto_'.$i]; 
						$valor			= $data['valor_'.$i]; 
						$cantidad		= $data['cantidad_'.$i]; 

						$params = array($cantidad,$valor,$idfactura,$idproducto);
						$val1 = $ofactura->nuevoDetalle($params);
						$val2 = $ofactura->outInventario($idproducto,$cantidad);
					}
				} 
				
				echo "0";
			} else {
				echo "400";
			}
		}catch (Exception $e){
			echo  $e;
		}
	
}

if($option=="bfactura"){
	try{
		$id		= $_REQUEST['id'];
		$update   = $ofactura->bloqueo($id);
		if ( $update ) {
			echo "0";
		} else {
			echo "400";
		}
	}catch(Exception $e){
		echo "400";
	}
}
if($option=="hfactura"){
	try{
		$id		= $_REQUEST['id'];
		$update   = $ofactura->habilitar($id);
		if ( $update ) {
			
			echo "0";
		} else {
			echo "400";
		}
	}catch(Exception $e){
		echo "error";
	}
}
if($option=="e"){
	try{
		$id		= $_REQUEST['id'];
		$update   = $ofactura->eliminar($id);
		if ( $update ) {
			echo "0";
		} else {
			echo "400";
		}
	}catch(Exception $e){
		echo "error";
	}
}


?>