<?php


// DataBase
include_once '../data/dataBase.php';
// Classes
include_once '../classes/cincidencia.php';


$oincidencia  	= new incidencia();
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
		//$id		= $data['id']; 
		$idusuario		= $_SESSION['csmart']['idusuario']; 
		$asunto		= $data['asunto']; 
		$detalle		= $data['detalle']; 
		//$fecha		= $data['fecha']; 
		$idestado		= 1; 
		$respuesta		= ""; 


			$params = array($idusuario,$asunto,$detalle,$idestado,$respuesta);
			$id   = $oincidencia->nuevo($params);
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

	$id		= $data['id'];  
		$idusuario		= $data['idusuario'];  
		$asunto		= $data['asunto'];  
		$detalle		= $data['detalle'];  
		$fecha		= $data['fecha'];  
		$idestado		= $data['idestado'];  
		$respuesta		= $data['respuesta'];  
		if($id==''){
									echo 1;
								}
								elseif($idusuario==''){
									echo 2;
								}
								elseif($asunto==''){
									echo 3;
								}
								elseif($detalle==''){
									echo 4;
								}
								elseif($fecha==''){
									echo 5;
								}
								elseif($idestado==''){
									echo 6;
								}
								elseif($respuesta==''){
									echo 7;
								}
								
		
		else {
			try {
			
			$params = array($idusuario,$asunto,$detalle,$fecha,$idestado,$respuesta,$id);
			$save   = $oincidencia->actualizar($params);
			
			if ( $save ) {
				
				
				echo "0";
			} else {
				echo "400";
			}
		}catch (Exception $e){
			echo  $e;
		}
	}
}

if($option=="bincidencia"){
	try{
		$id		= $_REQUEST['id'];
		$update   = $oincidencia->bloqueo($id);
		if ( $update ) {
			echo "0";
		} else {
			echo "400";
		}
	}catch(Exception $e){
		echo "400";
	}
}
if($option=="hincidencia"){
	try{
		$id		= $_REQUEST['id'];
		$update   = $oincidencia->habilitar($id);
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
		$update   = $oincidencia->eliminar($id);
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