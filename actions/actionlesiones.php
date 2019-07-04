<?php


// DataBase
include_once '../data/dataBase.php';
// Classes
include_once '../classes/clesiones.php';


$olesiones  	= new lesiones();
$option = '';

session_start();

if (isset($_REQUEST['valor'])){
  $data 	= $_REQUEST['valor'];
  $option 	= $data['opt'];
}else{
	$option =  $_REQUEST['opt'];
}

$option 	= $_REQUEST['opt'];

if ( $option == 'np' ) {
	try{
		//$idlesion		= $data['idlesion']; 
		$idpaciente		= $_POST['idpaciente']; 
		$idtipoLesion		= $_POST['idtipoLesion']; 
		$pieza		= $_POST['pieza']; 
		$nota		= $_POST['nota']; 
		$idusuario		= 1; 


			$params = array($idpaciente,$idtipoLesion,$pieza,$nota,$idusuario);
			$id   = $olesiones->nuevo($params);
			if ( $id ) {
				echo "0";
			} else {
				echo "400";
			}
		
	}catch (Exception $e){
		echo  $e;
	}
}
if ( $option == 'n' ) {
	try{
		//$idlesion		= $data['idlesion']; 
		$idpaciente		= $data['idpaciente']; 
		$idtipoLesion		= $data['idtipoLesion']; 
		$pieza		= $data['pieza']; 
		$nota		= $data['nota']; 
		$idusuario		= 1; 


			$params = array($idpaciente,$idtipoLesion,$pieza,$nota,$idusuario);
			$id   = $olesiones->nuevo($params);
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

	$idlesion		= $data['idlesion'];  
		$idpaciente		= $data['idpaciente'];  
		$idtipoLesion		= $data['idtipoLesion'];  
		$nota		= $data['nota'];  
		$fecha		= $data['fecha'];  
		$idusuario		= $data['idusuario'];  
		if($idlesion==''){
									echo 1;
								}
								elseif($idpaciente==''){
									echo 2;
								}
								elseif($idtipoLesion==''){
									echo 3;
								}
								elseif($nota==''){
									echo 4;
								}
								elseif($fecha==''){
									echo 5;
								}
								elseif($idusuario==''){
									echo 6;
								}
								
		
		else {
			try {
			
			$params = array($idpaciente,$idtipoLesion,$nota,$fecha,$idusuario,$idlesion);
			$save   = $olesiones->actualizar($params);
			
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

if($option=="blesiones"){
	try{
		$id		= $_REQUEST['id'];
		$update   = $olesiones->bloqueo($id);
		if ( $update ) {
			echo "0";
		} else {
			echo "400";
		}
	}catch(Exception $e){
		echo "400";
	}
}
if($option=="hlesiones"){
	try{
		$id		= $_REQUEST['id'];
		$update   = $olesiones->habilitar($id);
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
		$update   = $olesiones->eliminar($id);
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