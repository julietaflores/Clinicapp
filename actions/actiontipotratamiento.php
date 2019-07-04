<?php


// DataBase
include_once '../data/dataBase.php';
// Classes
include_once '../classes/ctipoTratamiento.php';


$otipoTratamiento  	= new tipoTratamiento();
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
		$idtipoTratamiento		= $data['idtipoTratamiento']; $tipoTratamiento		= $data['tipoTratamiento']; $idestado		= $data['idestado']; if($idtipoTratamiento==''){
									echo 1;
								}
								elseif($tipoTratamiento==''){
									echo 2;
								}
								elseif($idestado==''){
									echo 3;
								}
								
		
		else {
			$params = array($tipoTratamiento,$idestado);
			$id   = $otipoTratamiento->nuevo($params);
			if ( $id ) {
				echo "0";
			} else {
				echo "400";
			}
		}
	}catch (Exception $e){
		echo  $e;
	}
}

if ( $option == 'm' ) {

	$idtipoTratamiento		= $data['idtipoTratamiento'];  
		$tipoTratamiento		= $data['tipoTratamiento'];  
		$idestado		= $data['idestado'];  
		if($idtipoTratamiento==''){
									echo 1;
								}
								elseif($tipoTratamiento==''){
									echo 2;
								}
								elseif($idestado==''){
									echo 3;
								}
								
		
		else {
			try {
			
			$params = array($tipoTratamiento,$idestado,$idtipoTratamiento);
			$save   = $otipoTratamiento->actualizar($params);
			
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

if($option=="btipoTratamiento"){
	try{
		$id		= $_REQUEST['id'];
		$update   = $otipoTratamiento->bloqueo($id);
		if ( $update ) {
			echo "0";
		} else {
			echo "400";
		}
	}catch(Exception $e){
		echo "400";
	}
}
if($option=="htipoTratamiento"){
	try{
		$id		= $_REQUEST['id'];
		$update   = $otipoTratamiento->habilitar($id);
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
		$update   = $otipoTratamiento->eliminar($id);
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