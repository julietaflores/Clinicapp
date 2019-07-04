<?php


// DataBase
include_once '../data/dataBase.php';
// Classes
include_once '../classes/cproducto.php';


$oproducto  	= new producto();
$option = '';

session_start();

if (isset($_REQUEST['valor'])){
  $data 	= $_REQUEST['valor'];
  $option 	= $data['opt'];
}else{
	$option =  $_REQUEST['opt'];
}

if($option == 'j'){

	$filtro 	= $_REQUEST['q'];
	
	$pac = $oproducto->getAllfiltrado($filtro);
	
	echo json_encode($pac);
													
									
}
if ( $option == 'n' ) {
	try{
		$idproducto		= $data['idproducto']; 
		$idclinica		= $_SESSION['csmart']['clinica']; 
		$nombre		= $data['nombre']; 
		$precio		= $data['precio']; 
		$costo		= $data['costo']; 
		$idtipo		= $data['idtipo']; 
		$stock		= $data['stock']; 
		$idestado		= $data['idestado']; 
		

		$params = array($idclinica,$nombre,$precio,$costo,$idtipo,$stock,$idestado);
			$id   = $oproducto->nuevo($params);
			if ( $id ) {
				echo "0";
			} else {
				echo "400";
			}
		
	}catch (Exception $e){
		echo  $e;
	}
}

if ( $option == 'm' ) {

	$idproducto		= $data['idproducto'];  
	$idclinica		= $_SESSION['csmart']['clinica'];  
		$nombre		= $data['nombre'];  
		$precio		= $data['precio'];
		$costo		= $data['costo'];  
		$idtipo		= $data['idtipo'];  
		$stock		= $data['stock'];  
		$idestado		= $data['idestado'];  
		//$fecha		= $data['fecha'];  
		
		try {
			$params = array($idclinica,$nombre,$precio,$costo,$idtipo,$stock,$idestado,$idproducto);
			$save   = $oproducto->actualizar($params);
			
			if ( $save ) {
				echo "0";
			} else {
				echo "400";
			}
		}catch (Exception $e){
			echo  $e;
		}
	
}

if($option=="bproducto"){
	try{
		$id		= $_REQUEST['id'];
		$update   = $oproducto->bloqueo($id);
		if ( $update ) {
			echo "0";
		} else {
			echo "400";
		}
	}catch(Exception $e){
		echo "400";
	}
}
if($option=="hproducto"){
	try{
		$id		= $_REQUEST['id'];
		$update   = $oproducto->habilitar($id);
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
		$update   = $oproducto->eliminar($id);
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