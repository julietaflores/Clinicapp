<?php


// DataBase
include_once '../data/dataBase.php';
// Classes
include_once '../classes/cpaciente.php';
include_once '../classes/chistorial_medico.php';


$opaciente  	= new paciente();
$ohistorial_medico = new historial_medico();
$option = '';

session_start();

if (isset($_REQUEST['valor'])){
  $data 	= $_REQUEST['valor'];
  $option 	= $data['opt'];
}else{
	$option =  $_REQUEST['opt'];
}

//$option 	= $_REQUEST['opt'];

if($option == 'j'){

	$filtro 	= $_REQUEST['q'];
	
	$pac = $opaciente->getAllfiltrado($filtro);
	
	// foreach ($pac AS $id => $array) {
	// 	$val[$array['idpaciente']] = $array['nombre'];
	// }
	
	echo json_encode($pac);
													
										
	//echo "[{\"id\":\"14\",\"title\":\"New Event\",\"start\":\"2016-06-24 16:00:00\",\"allDay\":false}]";
}

if ( $option == 'n' ) {
	try{
		$nombre		= $data['nombre']; 
		$apellido		= $data['apellido']; 
		$identificacion		= $data['identificacion']; 
		$genero		= $data['genero']; 
		$imagen		= $data['img']; 
		$direccion		= $data['direccion']; 
		$telefono1		= $data['telefono1']; 
		$telefono2		= $data['telefono2']; 
		$correo		= $data['correo']; 
		$fecha_nac		= $data['fecha_nac']; 
		$fecha_cre		= $data['fecha_cre']; 
		$notas		= $data['notas']; 
		$idestado		= $data['idestado']; 
		$idusuario		= $_SESSION['csmart']['idusuario'];
		$idclinica		= $_SESSION['csmart']['clinica'];
		$iddepartamento		= $data['iddepartamento']; 
		$responsable		= $data['responsable']; 
		$telefono_resp		= $data['telefono_resp']; 
		$medico_fam		= $data['medico_fam']; 
		$ocupacion		= $data['ocupacion']; 


			$params = array($nombre,$apellido,$identificacion,$genero,$imagen,$direccion,$telefono1,$telefono2,$correo,$fecha_nac,$fecha_cre,$notas,$idestado,$idusuario,$idclinica,$iddepartamento,$responsable,$telefono_resp,$medico_fam,$ocupacion);
			$id   = $opaciente->nuevo($params);
			if ( $id ) {

				$idpaciente		= $id;  
				$cenfermedad		= $data['cenfermedad1'];  
				$nenferemedad		= $data['nenferemedad'];  
				$calergia		= $data['calergia1'];  
				$cdesmayos		= $data['cdesmayos1'];  
				$cdiabetes		= $data['cdiabetes1'];  
				$chepatitis		= $data['chepatitis1'];  
				$cartritis		= $data['cartritis1'];  
				$cpresion		= $data['cpresion1'];  
				$cmedicamento		= $data['cmedicamento1'];  
				$nmedicamento		= $data['nmedicamento'];  
				$cembarazo		= $data['cembarazo1'];  
				$nembarazo		= $data['nembarazo'];  
				$cfuma		= $data['cfuma1'];  
				$ctoma		= $data['ctoma1'];  
				$fecha_ult_control		= $data['fecha_ult_control'];  
				$cfractura		= $data['cfractura1'];  
				$nfractura		= $data['nfractura'];  
				$cchupeteo		= $data['cchupeteo1'];  
				$clabio		= $data['clabio1'];  
				$csuccion		= $data['csuccion1'];  
				$cortodoncia		= $data['cortodoncia1']; 

				$params = array($idpaciente,$cenfermedad,$nenferemedad,$calergia,$cdesmayos,$cdiabetes,$chepatitis,$cartritis,$cpresion,$cmedicamento,$nmedicamento,$cembarazo,$nembarazo,$cfuma,$ctoma,$fecha_ult_control,$cfractura,$nfractura,$cchupeteo,$clabio,$csuccion,$cortodoncia);
				$id   = $ohistorial_medico->nuevo($params);
				
				echo $id;
			} else {
				echo "0";
			}
		
	}catch (Exception $e){
		echo  $e;
	}
}

if ( $option == 'm' ) {

	$idpaciente		= $data['idpaciente'];  
		$nombre		= $data['nombre'];  
		$apellido		= $data['apellido'];  
		$identificacion		= $data['identificacion'];  
		$genero		= $data['genero'];  
		$imagen		= $data['img'];  
		$direccion		= $data['direccion'];  
		$telefono1		= $data['telefono1'];  
		$telefono2		= $data['telefono2'];  
		$correo		= $data['correo'];  
		$fecha_nac		= $data['fecha_nac'];  
		$fecha_cre		= $data['fecha_cre'];  
		$notas		= $data['notas'];  
		$idestado		= $data['idestado'];  
		$idusuario		= $_SESSION['csmart']['idusuario'];
		$idclinica		= $_SESSION['csmart']['clinica'];
		$iddepartamento		= $data['iddepartamento'];  
		$responsable		= $data['responsable'];  
		$telefono_resp		= $data['telefono_resp'];  
		$medico_fam		= $data['medico_fam'];  
		$ocupacion		= $data['ocupacion'];  
		
			try { 
			
			$params = array($nombre,$apellido,$identificacion,$genero,$imagen,$direccion,$telefono1,$telefono2,$correo,$fecha_nac,$fecha_cre,$notas,$idestado,$idusuario,$idclinica,$iddepartamento,$responsable,$telefono_resp,$medico_fam,$ocupacion,$idpaciente);
			$save   = $opaciente->actualizar($params);
			
			if ( $save ) {
				
				$idpaciente		= $idpaciente;  
				$cenfermedad		= $data['cenfermedad1'];  
				$nenferemedad		= $data['nenferemedad'];  
				$calergia		= $data['calergia1'];  
				$cdesmayos		= $data['cdesmayos1'];  
				$cdiabetes		= $data['cdiabetes1'];  
				$chepatitis		= $data['chepatitis1'];  
				$cartritis		= $data['cartritis1'];  
				$cpresion		= $data['cpresion1'];  
				$cmedicamento		= $data['cmedicamento1'];  
				$nmedicamento		= $data['nmedicamento'];  
				$cembarazo		= $data['cembarazo1'];  
				$nembarazo		= $data['nembarazo'];  
				$cfuma		= $data['cfuma1'];  
				$ctoma		= $data['ctoma1'];  
				$fecha_ult_control		= $data['fecha_ult_control'];  
				$cfractura		= $data['cfractura1'];  
				$nfractura		= $data['nfractura'];  
				$cchupeteo		= $data['cchupeteo1'];  
				$clabio		= $data['clabio1'];  
				$csuccion		= $data['csuccion1'];  
				$cortodoncia		= $data['cortodoncia1']; 

				$params = array($cenfermedad,$nenferemedad,$calergia,$cdesmayos,$cdiabetes,$chepatitis,$cartritis,$cpresion,$cmedicamento,$nmedicamento,$cembarazo,$nembarazo,$cfuma,$ctoma,$fecha_ult_control,$cfractura,$nfractura,$cchupeteo,$clabio,$csuccion,$cortodoncia,$idpaciente);
				$id   = $ohistorial_medico->actualizar($params);

				echo $idpaciente;
			} else {
				echo "0";
			}
		}catch (Exception $e){
			echo  $e;
		}
	
}
if($option=="subir"){
	try{
		$id		= $_REQUEST['id'];
		$nombre		= $_REQUEST['nombre'];
		$params = array($nombre,$id);
		$update   = $opaciente->subirIMG($params);
		if ( $update ) {
			echo $update ;
		} else {
			echo "500";
		}
	}catch(Exception $e){
		echo "400";
	}
}
if($option=="bpaciente"){
	try{
		$id		= $_REQUEST['id'];
		$update   = $opaciente->bloqueo($id);
		if ( $update ) {
			echo "0";
		} else {
			echo "400";
		}
	}catch(Exception $e){
		echo "400";
	}
}
if($option=="hpaciente"){
	try{
		$id		= $_REQUEST['id'];
		$update   = $opaciente->habilitar($id);
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
		$update   = $opaciente->eliminar($id);
		if ( $update ) {
			echo "0";
		} else {
			echo "400";
		}
	}catch(Exception $e){
		echo "error";
	}
}
if($option=="efoto"){
	try{
		$id		= $_REQUEST['id'];
		$px		= $_REQUEST['px'];
		$archivo		= $_REQUEST['archivo'];
		$update   = $opaciente->eliminarFoto($id);
		if ( $update ) {
			unlink("../images/paciente/".$px."/".$archivo);
        
			echo "0";
		} else {
			echo "400";
		}
	}catch(Exception $e){
		echo "error";
	}
}


?>