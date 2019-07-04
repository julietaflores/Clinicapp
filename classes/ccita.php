<?php

class cita{

	function __construct() {
        global $DATA;
        $this->DATA = $DATA;
    }
	
	 function getAll($idclinica)
    {
        $sql = "SELECT c.idcita,c.idusuario,c.fecha,c.fecha_prog,c.idestado,c.comentario,c.idtipocita,c.idpaciente 
        		FROM cita c join usuario u on c.idusuario = u.idusuario where u.idclinica= $idclinica  ;";
        $rs = $this->DATA->Execute($sql);
        if ( $rs->RecordCount()) {
            while(!$rs->EOF){

         		$id                  	= $rs->fields['idcita'];
				   	$info[$id]['idcita']	= $rs->fields['idcita'];
								$info[$id]['idusuario']	= $rs->fields['idusuario'];
								$info[$id]['fecha']	= $rs->fields['fecha'];
								$info[$id]['fecha_prog']	= $rs->fields['fecha_prog'];
								$info[$id]['idestado']	= $rs->fields['idestado'];
								$info[$id]['comentario']	= $rs->fields['comentario'];
								$info[$id]['idtipocita']	= $rs->fields['idtipocita'];
								$info[$id]['idpaciente']	= $rs->fields['idpaciente'];
								
                $rs->MoveNext();
            }
            $rs->Close();
            return $info;
        } else {
            return false;
        }
    }

     function getAllpaciente($id)
    {
        $sql = "SELECT c.id, c.start, c.comentario, c.idtipocita, c.idestado, t.tipo, c.maxSup, c.maxInf, c.observaciones, c.valor, c.factura FROM cita c join tipocita t 
        		on c.idtipocita = t.idtipocita
        		WHERE c.idpaciente = $id order by c.start desc;";
        $rs = $this->DATA->Execute($sql);
        if ( $rs->RecordCount()) {
            while(!$rs->EOF){

         		$id                  	= $rs->fields['id'];
				   	$info[$id]['id']	= $rs->fields['id'];
					$info[$id]['start']	= $rs->fields['start'];
					$info[$id]['idestado']	= $rs->fields['idestado'];
					$info[$id]['comentario']	= $rs->fields['comentario'];
					$info[$id]['idtipocita']	= $rs->fields['idtipocita'];
					$info[$id]['tipo'] = $rs->fields['tipo'];
                    $info[$id]['maxSup']  = $rs->fields['maxSup'];
                    $info[$id]['maxInf']  = $rs->fields['maxInf'];
                    $info[$id]['observaciones']  = $rs->fields['observaciones'];
                    $info[$id]['valor']  = $rs->fields['valor'];
                    $info[$id]['factura']  = $rs->fields['factura'];
                    			
                $rs->MoveNext();
            }
            $rs->Close();
            return $info;
        } else {
            return false;
        }
    }
    function getCitasXusuario($fecha,$idusuario){

    	$sql = "SELECT count(id) as cantidad from cita 
        		WHERE idusuario= $idusuario and start BETWEEN '$fecha 00:00' and '$fecha 23:59:59';";
        $rs = $this->DATA->Execute($sql);
        if ( $rs->RecordCount()) {
            while(!$rs->EOF){

         		$cantidad    = $rs->fields['cantidad'];
				$rs->MoveNext();
            }
            $rs->Close();
            return $cantidad;
        } else {
            return false;
        }
	}

     function getAllfecha($fecha, $idclinica)
    {
        $sql = "SELECT c.id, c.start, c.comentario, c.idpaciente, c.title, c.idtipocita, c.idestado, t.tipo, p.imagen
        		FROM cita c join tipocita t 
        		on c.idtipocita = t.idtipocita join paciente p 
        		on c.idpaciente = p.idpaciente join usuario u 
        		on c.idusuario = u.idusuario 
        		WHERE u.idclinica= $idclinica and c.start BETWEEN '$fecha 00:00' and '$fecha 23:59:59'  order by c.start desc;";
        $rs = $this->DATA->Execute($sql);
        if ( $rs->RecordCount()) {
            while(!$rs->EOF){

         		$id                  	= $rs->fields['id'];
				$info[$id]['id']	= $rs->fields['id'];
				$info[$id]['start']	= $rs->fields['start'];
				$info[$id]['idestado']	= $rs->fields['idestado'];
				$info[$id]['idpaciente']	= $rs->fields['idpaciente'];
				$info[$id]['comentario']	= $rs->fields['comentario'];
				$info[$id]['idtipocita']	= $rs->fields['idtipocita'];
				$info[$id]['tipo']	= $rs->fields['tipo'];
				$info[$id]['title']	= $rs->fields['title'];
				$info[$id]['imagen']	= $rs->fields['imagen'];
								
                $rs->MoveNext();
            }
            $rs->Close();
            return $info;
        } else {
            return false;
        }
    }
    function getCitasXusuarioXrango($fecha,$fecha2,$idusuario){

    	$sql = "SELECT count(id) as cantidad from cita 
        		WHERE idusuario= $idusuario and start BETWEEN '$fecha 00:00' and '$fecha2 23:59:59';";
        $rs = $this->DATA->Execute($sql);
        if ( $rs->RecordCount()) {
            while(!$rs->EOF){

         		$cantidad    = $rs->fields['cantidad'];
				$rs->MoveNext();
            }
            $rs->Close();
            return $cantidad;
        } else {
            return false;
        }
	}

	
	function getUsuarioInactivos($fecha, $idclinica){
		$fechainicio=date("Y/m/d", strtotime("-6 month"));

		$sql = "SELECT  max(c.start) as ultima, c.idpaciente, concat(p.nombre, ' ', p.apellido) as nombres FROM cita c join paciente p on c.idpaciente=p.idpaciente 
				join usuario u on c.idusuario=u.idusuario
				where TIMESTAMPDIFF(MONTH,c.start,'$fecha') >= 6 and p.idestado=1 and u.idclinica=$idclinica and c.idpaciente NOT IN (SELECT i.idpaciente from cita i join usuario s on i.idusuario=s.idusuario where i.start BETWEEN '$fechainicio' and '$fecha' and s.idclinica=$idclinica) 
				GROUP by c.idpaciente";
		$rs = $this->DATA->Execute($sql);
        if ( $rs->RecordCount()) {
            while(!$rs->EOF){

         		$id              = $rs->fields['idpaciente'];
				$info[$id]['id']	= $rs->fields['idpaciente'];
				$info[$id]['start']	= $rs->fields['ultima'];
				$info[$id]['nombres']	= $rs->fields['nombres'];
				$rs->MoveNext();
            }
            $rs->Close();
            return $info;
        } else {
            return false;
        }
	}

    function getAllfechaRango($fecha, $fecha2, $idclinica)
    {
        $sql = "SELECT c.id, c.start, c.comentario, c.title, c.idtipocita, c.idestado, t.tipo, p.imagen
        		FROM cita c join tipocita t 
        		on c.idtipocita = t.idtipocita join paciente p 
        		on c.idpaciente = p.idpaciente join usuario u
        		on c.idusuario = u.idusuario 
        		WHERE u.idclinica= $idclinica and c.start BETWEEN '$fecha 00:00' and '$fecha2 23:59:59'  order by c.start desc;";
        $rs = $this->DATA->Execute($sql);
        if ( $rs->RecordCount()) {
            while(!$rs->EOF){

         		$id                  	= $rs->fields['id'];
				$info[$id]['id']	= $rs->fields['id'];
				$info[$id]['start']	= $rs->fields['start'];
				$info[$id]['idestado']	= $rs->fields['idestado'];
				$info[$id]['comentario']	= $rs->fields['comentario'];
				$info[$id]['idtipocita']	= $rs->fields['idtipocita'];
				$info[$id]['tipo']	= $rs->fields['tipo'];
				$info[$id]['title']	= $rs->fields['title'];
				$info[$id]['imagen']	= $rs->fields['imagen'];
								
                $rs->MoveNext();
            }
            $rs->Close();
            return $info;
        } else {
            return false;
        }
    }

    

    function getAlljson(){
    	// List of events
		 $json = array();

		 // Query that retrieves events
		 $requete = "SELECT * FROM evenement";

		 // connection to the database
		 try {
		 $bdd = new PDO('mysql:host=localhost;dbname=clinica', 'root', 'root');
		 } catch(Exception $e) {
		  exit('Unable to connect to database.');
		 }
		 // Execute the query
		 $resultat = $bdd->query($requete) or die(print_r($bdd->errorInfo()));

		 // sending the encoded result to success page
		 return json_encode($resultat->fetchAll(PDO::FETCH_ASSOC));

    }
	
	function getOne($id)
    {
        $sql = "SELECT * FROM cita WHERE idcita = ? ;";

        $rs = $this->DATA->Execute($sql, $id);
        if ( $rs->RecordCount()) {
            while(!$rs->EOF){
                $id                  	= $rs->fields['idcita'];
				   	$info[$id]['idcita']	= $rs->fields['idcita'];
								$info[$id]['idusuario']	= $rs->fields['idusuario'];
								$info[$id]['fecha']	= $rs->fields['fecha'];
								$info[$id]['fecha_prog']	= $rs->fields['fecha_prog'];
								$info[$id]['idestado']	= $rs->fields['idestado'];
								$info[$id]['comentario']	= $rs->fields['comentario'];
								$info[$id]['idtipocita']	= $rs->fields['idtipocita'];
								$info[$id]['idpaciente']	= $rs->fields['idpaciente'];
								
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
		
			$sql = "INSERT INTO cita (idusuario,title,start,end,idestado,comentario,idtipocita,idpaciente,allDay,url) VALUES (?,?,?,?,?,?,?,?,?,?);";
				
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
    function nuevoCita($params) 
	{
		try{
		
			$sql = "INSERT INTO evenement (title,start,end,url,allDay) VALUES (?,?,?,?,?);";
				 
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
    function modificarCita($params) 
	{
		try{
		
			$sql = "UPDATE cita SET start=?, end=?  WHERE id = ?";
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

    function modificarCitaControl($params) 
    {
        try{
        
            $sql = "UPDATE cita SET maxSup=?, maxInf=?, observaciones=?, valor=?, idestado=2, factura=?  WHERE id = ?";
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
    

	function actualizar($params) 
	{
		try{
		
			$sql = "UPDATE cita SET idusuario=?,fecha=?,fecha_prog=?,idestado=?,comentario=?,idtipocita=?,idpaciente=? WHERE idcita = ?";
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
        $sql = "UPDATE cita SET estado = 2 WHERE idcita = ?";

        $update = $this->DATA->Execute($sql, $id);
        if ($update){
            return true;
        } else {
            return false;
        }
    }
	
	
	function habilitar($id) {
        $sql = "UPDATE cita SET estado = 1 WHERE idcita = ?";

        $update = $this->DATA->Execute($sql, $id);
        if ($update){
            return true;
        } else {
            return false;
        }
    }
	
	function eliminar($id) {
        $sql = "delete from cita where id = ?";

        $update = $this->DATA->Execute($sql, $id);
        if ($update){
            return true;
        } else {
            return false;
        }
    }
	
}
?>
		