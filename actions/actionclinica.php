<?php


// DataBase
include_once '../data/dataBase.php';
// Classes
include_once '../classes/cclinica.php';


$oclinica  	= new clinica();
$option = '';

session_start();

if (isset($_REQUEST['valor'])){
  $data 	= $_REQUEST['valor'];
  $option 	= $data['opt'];
}else{
	$option =  $_REQUEST['opt'];
}

if ( $option == 'n' ) {
	try{
		$nombre			= $data['nombre']; 
		$registro		= $data['registro']; 
		$direccion		= $data['direccion']; 
		$telefono1		= $data['telefono1']; 
		$telefono2		= $data['telefono2']; 
		$correo			= $data['correo']; 
		$imagen			= $data['img']; 
		$fecha_val = date($data['fecha_val']);
		$superusuario	= $_SESSION['csmart']['idusuario']; 
		$idestado		= $data['idestado']; 

		$params = array($nombre,$registro,$direccion,$telefono1,$telefono2,$correo,$imagen,$fecha_val,$superusuario,$idestado);
			$id   = $oclinica->nuevo($params);
			if ( $id ) {
				echo $id;
			} else {
				echo "0";
			}
		
	}catch (Exception $e){
		echo  $e;
	}
}

if ( $option == 'm' ) {

		$idclinica		= $data['idclinica'];  
		$nombre		= $data['nombre'];  
		$registro		= $data['registro'];  
		$direccion		= $data['direccion'];  
		$telefono1		= $data['telefono1'];  
		$telefono2		= $data['telefono2'];  
		$correo		= $data['correo'];  
		$imagen		= $data['img'];  
		$superusuario		= $_SESSION['csmart']['idusuario'];  
		$idestado		= $data['idestado'];  
		
		$fecha_val = date($data['fecha_val']);
		
		try {
			
			$params = array($nombre,$registro,$direccion,$telefono1,$telefono2,$correo,$imagen,$fecha_val,$superusuario,$idestado,$idclinica);
			$save   = $oclinica->actualizar($params);
			
			if ( $save ) {
				echo $idclinica;
			} else {
				echo "0";
			}
		}catch (Exception $e){
			echo  $e;
		}
	
}

if($option=="bclinica"){
	try{
		$id		= $_REQUEST['id'];
		$update   = $oclinica->bloqueo($id);
		if ( $update ) {
			echo "0";
		} else {
			echo "400";
		}
	}catch(Exception $e){
		echo "400";
	}
}
if($option=="hclinica"){
	try{
		$id		= $_REQUEST['id'];
		$update   = $oclinica->habilitar($id);
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
		$update   = $oclinica->eliminar($id);
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