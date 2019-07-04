<?php


// DataBase
include_once '../data/dataBase.php';
// Classes
include_once '../classes/cgasto.php';


$ogasto  	= new gasto();
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
	
	$pac = $ogasto->getjson($fecha1,$fecha2);
	
	echo $pac;
}

if ( $option == 'n' ) {
	try{
		$idtipoGasto		= $data['idtipoGasto']; 
		$detalle		= $data['detalle']; 
		$monto		= $data['monto']; 
		$idusuario		= $_SESSION['csmart']['idusuario']; 
		$idclinica		= $_SESSION['csmart']['clinica']; 
		$fecha		= $data['fechagasto']; 
		$idestado		= $data['idestado']; 


			$params = array($idtipoGasto,$detalle,$monto,$idusuario,$idclinica,$idestado,$fecha);
			$id   = $ogasto->nuevo($params);
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

		$idgasto		= $data['idgasto'];  
		$idtipoGasto	= $data['idtipoGasto'];  
		$detalle		= $data['detalle'];  
		$monto			= $data['monto'];  
		$idusuario		= $_SESSION['csmart']['idusuario']; 
		$idclinica		= $_SESSION['csmart']['clinica']; 
		$fecha			= $data['fechagasto'];  
		$idestado		= $data['idestado'];  
		
			try {
			
			$params = array($idtipoGasto,$detalle,$monto,$idusuario,$idclinica,$idestado,$fecha,$idgasto);
			$save   = $ogasto->actualizar($params);
			
			if ( $save ) {
				echo "0";
			} else {
				echo "400";
			}
		}catch (Exception $e){
			echo  $e;
		}
	
}

if($option=="bgasto"){
	try{
		$id		= $_REQUEST['id'];
		$update   = $ogasto->bloqueo($id);
		if ( $update ) {
			echo "0";
		} else {
			echo "400";
		}
	}catch(Exception $e){
		echo "400";
	}
}
if($option=="hgasto"){
	try{
		$id		= $_REQUEST['id'];
		$update   = $ogasto->habilitar($id);
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
		$update   = $ogasto->eliminar($id);
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