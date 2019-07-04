<?php


// DataBase
include_once '../data/dataBase.php';
// Classes
include_once '../classes/cpacienteNotas.php';


$opacienteNotas  	= new pacienteNotas();
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
		//$idpacienteNota		= $data['idpacienteNota']; 
		$idpaciente		= $_REQUEST['idpaciente']; 
		$detalle		= $_REQUEST['val']; 
		//$fecha		= $data['fecha']; 
		$idusuario		= $_SESSION['csmart']['idusuario']; 


			$params = array($idpaciente,$detalle,$idusuario);
			$id   = $opacienteNotas->nuevo($params);
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

	$idpacienteNota		= $data['idpacienteNota'];  
		$idpaciente		= $data['idpaciente'];  
		$detalle		= $data['detalle'];  
		$fecha		= $data['fecha'];  
		$idusuario		= $data['idusuario'];  
		if($idpacienteNota==''){
									echo 1;
								}
								elseif($idpaciente==''){
									echo 2;
								}
								elseif($detalle==''){
									echo 3;
								}
								elseif($fecha==''){
									echo 4;
								}
								elseif($idusuario==''){
									echo 5;
								}
								
		
		else {
			try {
			
			$params = array($idpaciente,$detalle,$fecha,$idusuario,$idpacienteNota);
			$save   = $opacienteNotas->actualizar($params);
			
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

if($option=="bpacienteNotas"){
	try{
		$id		= $_REQUEST['id'];
		$update   = $opacienteNotas->bloqueo($id);
		if ( $update ) {
			echo "0";
		} else {
			echo "400";
		}
	}catch(Exception $e){
		echo "400";
	}
}
if($option=="hpacienteNotas"){
	try{
		$id		= $_REQUEST['id'];
		$update   = $opacienteNotas->habilitar($id);
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
		$update   = $opacienteNotas->eliminar($id);
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