		<?php

class pacienteNotas{

	function __construct() {
        global $DATA;
        $this->DATA = $DATA;
    }
	
	 function getAll($idpaciente)
    {
        $sql = "SELECT p.idpacienteNota,p.idpaciente,p.detalle,p.fecha,u.nombre FROM pacienteNotas p join usuario u on p.idusuario=u.idusuario WHERE p.idpaciente= $idpaciente order by idpacienteNota desc;";
        $rs = $this->DATA->Execute($sql);
        if ( $rs->RecordCount()) {
            while(!$rs->EOF){

         		$id                  	= $rs->fields['idpacienteNota'];
				   	$info[$id]['idpacienteNota']	= $rs->fields['idpacienteNota'];
								$info[$id]['idpaciente']	= $rs->fields['idpaciente'];
								$info[$id]['detalle']	= $rs->fields['detalle'];
								$info[$id]['fecha']	= $rs->fields['fecha'];
								$info[$id]['idusuario']	= $rs->fields['nombre'];
								
                $rs->MoveNext();
            }
            $rs->Close();
            return $info;
        } else {
            return false;
        }
    }
	
	function getOne($id)
    {
        $sql = "SELECT * FROM pacienteNotas WHERE idpacienteNota = ? ;";

        $rs = $this->DATA->Execute($sql, $id);
        if ( $rs->RecordCount()) {
            while(!$rs->EOF){
                $id                  	= $rs->fields['idpacienteNota'];
				   	$info[$id]['idpacienteNota']	= $rs->fields['idpacienteNota'];
								$info[$id]['idpaciente']	= $rs->fields['idpaciente'];
								$info[$id]['detalle']	= $rs->fields['detalle'];
								$info[$id]['fecha']	= $rs->fields['fecha'];
								$info[$id]['idusuario']	= $rs->fields['idusuario'];
								
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
		
			$sql = "INSERT INTO pacienteNotas (idpaciente,detalle,idusuario) VALUES (?,?,?);";
				 
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

	function actualizar($params) 
	{
		try{
		
			$sql = "UPDATE pacienteNotas SET idpaciente=?,detalle=?,fecha=?,idusuario=? WHERE idpacienteNota = ?";
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
        $sql = "UPDATE pacienteNotas SET estado = 2 WHERE idpacienteNota = ?";

        $update = $this->DATA->Execute($sql, $id);
        if ($update){
            return true;
        } else {
            return false;
        }
    }
	
	
	function habilitar($id) {
        $sql = "UPDATE pacienteNotas SET estado = 1 WHERE idpacienteNota = ?";

        $update = $this->DATA->Execute($sql, $id);
        if ($update){
            return true;
        } else {
            return false;
        }
    }
	
	function eliminar($id) {
        $sql = "delete from pacienteNotas where idpacienteNota = ?";

        $update = $this->DATA->Execute($sql, $id);
        if ($update){
            return true;
        } else {
            return false;
        }
    }
	
}
?>
		