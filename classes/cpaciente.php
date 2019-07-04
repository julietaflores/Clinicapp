		<?php

class paciente{

	function __construct() {
        global $DATA;
        $this->DATA = $DATA;
    }
	
	 function getAll()
    {
    	$clinica= $_SESSION['csmart']['clinica'];
        $sql = "SELECT idpaciente,nombre,apellido,identificacion,genero,imagen,direccion,telefono1,telefono2,correo,fecha_nac,fecha_mod,fecha_cre,notas,idestado,idusuario,idclinica,iddepartamento,responsable,telefono_resp,medico_fam,ocupacion 
        		FROM paciente WHERE idclinica=$clinica;";
        $rs = $this->DATA->Execute($sql);
        if ( $rs->RecordCount()) {
            while(!$rs->EOF){

         		$id                  	= $rs->fields['idpaciente'];
				   	$info[$id]['idpaciente']	= $rs->fields['idpaciente'];
								$info[$id]['nombre']	= $rs->fields['nombre'];
								$info[$id]['apellido']	= $rs->fields['apellido'];
								$info[$id]['identificacion']	= $rs->fields['identificacion'];
								$info[$id]['genero']	= $rs->fields['genero'];
								$info[$id]['imagen']	= $rs->fields['imagen'];
								$info[$id]['direccion']	= $rs->fields['direccion'];
								$info[$id]['telefono1']	= $rs->fields['telefono1'];
								$info[$id]['telefono2']	= $rs->fields['telefono2'];
								$info[$id]['correo']	= $rs->fields['correo'];
								$info[$id]['fecha_nac']	= $rs->fields['fecha_nac'];
								$info[$id]['fecha_mod']	= $rs->fields['fecha_mod'];
								$info[$id]['fecha_cre']	= $rs->fields['fecha_cre'];
								$info[$id]['notas']	= $rs->fields['notas'];
								$info[$id]['idestado']	= $rs->fields['idestado'];
								$info[$id]['idusuario']	= $rs->fields['idusuario'];
								$info[$id]['idclinica']	= $rs->fields['idclinica'];
								$info[$id]['iddepartamento']	= $rs->fields['iddepartamento'];
								$info[$id]['responsable']	= $rs->fields['responsable'];
								$info[$id]['telefono_resp']	= $rs->fields['telefono_resp'];
								$info[$id]['medico_fam']	= $rs->fields['medico_fam'];
								$info[$id]['ocupacion']	= $rs->fields['ocupacion'];
								
                $rs->MoveNext();
            }
            $rs->Close();
            return $info;
        } else {
            return false;
        }
    }
	
	function getAllfiltrado($filtro)
    {	
    	$clinica = $_SESSION['csmart']['clinica'];
        $sql = "SELECT idpaciente,concat(nombre, ' ' , apellido) as paciente,identificacion FROM paciente where idclinica = $clinica and idestado =1 and (nombre like '%$filtro%' or apellido like '%$filtro%') LIMIT 10 ;";
        $rs = $this->DATA->Execute($sql);
        if ( $rs->RecordCount()) {
            while(!$rs->EOF){

         		$id     = $rs->fields['idpaciente'];
				$info[$id]['idpaciente']	= $rs->fields['idpaciente'];
				$info[$id]['nombre']	= $rs->fields['paciente'];
				$info[$id]['identificacion']	= $rs->fields['identificacion'];
								
                $rs->MoveNext();
            }
            $rs->Close();
            return $info;
        } else {
            return false;
        }
    }

    function getAllCumpleaneros($dia,$mes)
    {	
    	
        $sql = "SELECT idpaciente,concat(nombre, ' ' , apellido) as paciente,identificacion,fecha_nac 
        		FROM paciente where  idestado =1 and MONTH(fecha_nac) = $mes and DAY(fecha_nac)=$dia ;";
        $rs = $this->DATA->Execute($sql);
        if ( $rs->RecordCount()) {
            while(!$rs->EOF){

         		$id     = $rs->fields['idpaciente'];
				$info[$id]['idpaciente']	= $rs->fields['idpaciente'];
				$info[$id]['nombre']	= $rs->fields['paciente'];
				$info[$id]['identificacion']	= $rs->fields['identificacion'];
				$info[$id]['fecha_nac']	= $rs->fields['fecha_nac'];
								
                $rs->MoveNext();
            }
            $rs->Close();
            return $info;
        } else {
            return false;
        }
    }

 

    function getTotalPacientes($id){
        $sql = "SELECT COUNT(idpaciente) AS cantidad FROM paciente 
				WHERE idclinica=?;";

        $rs = $this->DATA->Execute($sql, array($id));
        if ( $rs->RecordCount()) {
            while(!$rs->EOF){
				$info    = $rs->fields['cantidad'];
				$rs->MoveNext();
            }
            $rs->Close();
            return $info;
        } else {
            return 0;
        }
    } 
	function getTotalPacientesXfecha($id,$fecha,$fecha2){
        $sql = "SELECT COUNT(idpaciente) AS cantidad FROM paciente 
				WHERE idclinica=? and fecha_cre BETWEEN '$fecha 00:00' and '$fecha2 23:59:59';";

        $rs = $this->DATA->Execute($sql, array($id));
        if ( $rs->RecordCount()) {
            while(!$rs->EOF){
				$info    = $rs->fields['cantidad'];
				$rs->MoveNext();
            }
            $rs->Close();
            return $info;
        } else {
            return 0;
        }
    }  

	function getAlljson(){
    	// List of events
		 $json = array();

		 // // Query that retrieves events
		 // $requete = "SELECT  idpaciente, nombre FROM paciente";

		 // // connection to the database
		 // try {
		 // $bdd = new PDO('mysql:host=localhost;dbname=clinica', 'root', 'root');
		 // } catch(Exception $e) {
		 //  exit('Unable to connect to database.');
		 // }
		 // // Execute the query
		 // $resultat = $bdd->query($requete) or die(print_r($bdd->errorInfo()));

		 // // sending the encoded result to success page
		 // return json_encode($resultat->fetchAll(PDO::FETCH_ASSOC));

		 	$result = mysql_query("SELECT idpaciente, nombre FROM paciente");	
			$data = array();
			while ($row = mysql_fetch_array($result)) {
				array_push($data, $row['nombre'] );


					
			}	
			$arr = array('productList' => $data);
			echo json_encode($arr);	


    }

	function getOne($id)
    {
        $sql = "SELECT * FROM paciente WHERE idpaciente = ? ;";

        $rs = $this->DATA->Execute($sql, $id);
        if ( $rs->RecordCount()) {
            while(!$rs->EOF){
                $id                  	= $rs->fields['idpaciente'];
				   	$info[$id]['idpaciente']	= $rs->fields['idpaciente'];
								$info[$id]['nombre']	= $rs->fields['nombre'];
								$info[$id]['apellido']	= $rs->fields['apellido'];
								$info[$id]['identificacion']	= $rs->fields['identificacion'];
								$info[$id]['genero']	= $rs->fields['genero'];
								$info[$id]['imagen']	= $rs->fields['imagen'];
								$info[$id]['direccion']	= $rs->fields['direccion'];
								$info[$id]['telefono1']	= $rs->fields['telefono1'];
								$info[$id]['telefono2']	= $rs->fields['telefono2'];
								$info[$id]['correo']	= $rs->fields['correo'];
								$info[$id]['fecha_nac']	= $rs->fields['fecha_nac'];
								$info[$id]['fecha_mod']	= $rs->fields['fecha_mod'];
								$info[$id]['fecha_cre']	= $rs->fields['fecha_cre'];
								$info[$id]['notas']	= $rs->fields['notas'];
								$info[$id]['idestado']	= $rs->fields['idestado'];
								$info[$id]['idusuario']	= $rs->fields['idusuario'];
								$info[$id]['idclinica']	= $rs->fields['idclinica'];
								$info[$id]['iddepartamento']	= $rs->fields['iddepartamento'];
								$info[$id]['responsable']	= $rs->fields['responsable'];
								$info[$id]['telefono_resp']	= $rs->fields['telefono_resp'];
								$info[$id]['medico_fam']	= $rs->fields['medico_fam'];
								$info[$id]['ocupacion']	= $rs->fields['ocupacion'];
								
                $rs->MoveNext();
            }
            $rs->Close();
            return $info;
        } else {
            return false;
        }
    }

    function getGaleria($idpaciente)
    {
        $sql = "SELECT * FROM pacienteGaleria WHERE idpaciente = ? ;";

        $rs = $this->DATA->Execute($sql, $idpaciente);
        if ( $rs->RecordCount()) {
            while(!$rs->EOF){
                $id                  	= $rs->fields['idimagen'];
				$info[$id]['idimagen']	= $rs->fields['idimagen'];
				$info[$id]['idpaciente']	= $rs->fields['idpaciente'];
				$info[$id]['nombre']	= $rs->fields['nombre'];
				$info[$id]['fecha']	= $rs->fields['fecha'];
				$rs->MoveNext();
            }
            $rs->Close();
            return $info;
        } else {
            return false;
        }
    }


	function nuevo($params) 
	{
		try{
		
			$sql = "INSERT INTO paciente (nombre,apellido,identificacion,genero,imagen,direccion,telefono1,telefono2,correo,fecha_nac,fecha_cre,notas,idestado,idusuario,idclinica,iddepartamento,responsable,telefono_resp,medico_fam,ocupacion) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
				 
			$save = $this->DATA->Execute($sql, $params);
			$id 	= $this->DATA->Insert_ID();
			if ($save){
				return $id;
			} else {
				return false;
			}
		}catch(exception $e){
			return false;
		}
        
    }

    function subirIMG($params) 
	{
		try{
		
			$sql = "INSERT INTO pacienteGaleria (nombre,idpaciente) VALUES (?,?);";
				 
			$save = $this->DATA->Execute($sql,$params);
			$id 	= $this->DATA->Insert_ID();
			if ($save){
				return $id;
			} else {
				return false;
			}
		}catch(exception $e){
			return false;
		}
        
    }

	function actualizar($params) 
	{
		try{
		
			$sql = "UPDATE paciente SET nombre=?,apellido=?,identificacion=?,genero=?,imagen=?,direccion=?,telefono1=?,telefono2=?,correo=?,fecha_nac=?,fecha_cre=?,notas=?,idestado=?,idusuario=?,idclinica=?,iddepartamento=?,responsable=?,telefono_resp=?,medico_fam=?,ocupacion=? WHERE idpaciente = ?";
			$save = $this->DATA->Execute($sql, $params);
			if ($save){
				return true;
			} else {
				return false;
			}
		}catch(exception $e){
			return false;
		}
        
    }
	
	function bloqueo($id) {
        $sql = "UPDATE paciente SET estado = 2 WHERE idpaciente = ?";

        $update = $this->DATA->Execute($sql, $id);
        if ($update){
            return true;
        } else {
            return false;
        }
    }
	
	
	function habilitar($id) {
        $sql = "UPDATE paciente SET estado = 1 WHERE idpaciente = ?";

        $update = $this->DATA->Execute($sql, $id);
        if ($update){
            return true;
        } else {	
            return false;
        }
    }
	
	function eliminar($id) {
        $sql = "delete from paciente where idpaciente = ?";

        $update = $this->DATA->Execute($sql, $id);
        
        if ($update){
            return true;
        } else {
            return false;
        }
    }
    function eliminarFoto($id) {
        $sql = "delete from pacienteGaleria where idimagen = ?";

        $update = $this->DATA->Execute($sql, $id);
        if ($update){
            return true;
        } else {
            return false;
        }
    }
	
}
?>
		