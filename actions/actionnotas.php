<?php


// DataBase
include_once '../data/dataBase.php';
// Classes
include_once '../classes/cnotas.php';


$onotas  	= new notas();
$option = '';

session_start();

if (isset($_REQUEST['valor'])){
  $data 	= $_REQUEST['valor'];
  $option 	= $data['opt'];
}else{
	$option =  $_REQUEST['opt'];
}

$option 	= $_REQUEST['opt'];
$val 	= $_REQUEST['val'];
  
if ( $option == 'n' ) {
	try{
		//$idnota		= $data['idnota']; 
		$idestado		= 1; 
		$detalle		= $val; 
		$idusuario		= $_SESSION['csmart']['idusuario']; 
		

			$params = array($idestado,$detalle,$idusuario);
			$id   = $onotas->nuevo($params);
			if ( $id ) {
				echo $id;
			} else {
				echo "400";
			}
		

	}catch (Exception $e){
		echo  $e;
	}
}

if ( $option == 'm' ) {

	$idnota		= $data['idnota'];  
		$idestado		= $data['idestado'];  
		$detalle		= $data['detalle'];  
		$idusuario		= $data['idusuario'];  
		$fecha		= $data['fecha'];  
		if($idnota==''){
									echo 1;
								}
								elseif($idestado==''){
									echo 2;
								}
								elseif($detalle==''){
									echo 3;
								}
								elseif($idusuario==''){
									echo 4;
								}
								elseif($fecha==''){
									echo 5;
								}
								
		
		else {
			try {
			
			$params = array($idestado,$detalle,$idusuario,$fecha,$idnota);
			$save   = $onotas->actualizar($params);
			
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

if($option=='b'){
	try{
		$id		= $val;
		$update   = $onotas->bloqueo($id);
		if ( $update ) {
			echo "0";
		} else {
			echo "400";
		}
	}catch(Exception $e){
		echo "400";
	}
}
if($option=="hnotas"){
	try{
		$id		= $_REQUEST['id'];
		$update   = $onotas->habilitar($id);
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
		$update   = $onotas->eliminar($id);
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