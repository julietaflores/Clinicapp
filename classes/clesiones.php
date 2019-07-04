		<?php

class lesiones{

	function __construct() {
        global $DATA;
        $this->DATA = $DATA;
    }
	
	 function getAll($idpaciente)
    {
        $sql = "SELECT l.* , concat(u.nombre, ' ', u.apellido) as nombre, t.nombre as lesion  FROM lesiones l join usuario u on l.idusuario=u.idusuario 
        		join tipoLesion t on l.idtipoLesion=t.idtipoLesion where l.idpaciente=$idpaciente;";
        $rs = $this->DATA->Execute($sql);
        if ( $rs->RecordCount()) {
            while(!$rs->EOF){

         		$id                  	= $rs->fields['idlesion'];
				   	$info[$id]['idlesion']	= $rs->fields['idlesion'];
								$info[$id]['idpaciente']	= $rs->fields['idpaciente'];
								$info[$id]['idtipoLesion']	= $rs->fields['lesion'];
								$info[$id]['pieza']	= $rs->fields['pieza'];
								$info[$id]['nota']	= $rs->fields['nota'];
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
        $sql = "SELECT * FROM lesiones WHERE idlesion = ? ;";

        $rs = $this->DATA->Execute($sql, $id);
        if ( $rs->RecordCount()) {
            while(!$rs->EOF){
                $id                  	= $rs->fields['idlesion'];
				   	$info[$id]['idlesion']	= $rs->fields['idlesion'];
								$info[$id]['idpaciente']	= $rs->fields['idpaciente'];
								$info[$id]['idtipoLesion']	= $rs->fields['idtipoLesion'];
								$info[$id]['nota']	= $rs->fields['nota'];
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
		
			$sql = "INSERT INTO lesiones (idpaciente,idtipoLesion,pieza,nota,idusuario) VALUES (?,?,?,?,?);";
				 
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
		
			$sql = "UPDATE lesiones SET idpaciente=?,idtipoLesion=?,nota=?,fecha=?,idusuario=? WHERE idlesion = ?";
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
        $sql = "UPDATE lesiones SET estado = 2 WHERE idlesion = ?";

        $update = $this->DATA->Execute($sql, $id);
        if ($update){
            return true;
        } else {
            return false;
        }
    }
	
	
	function habilitar($id) {
        $sql = "UPDATE lesiones SET estado = 1 WHERE idlesion = ?";

        $update = $this->DATA->Execute($sql, $id);
        if ($update){
            return true;
        } else {
            return false;
        }
    }
	
	function eliminar($id) {
        $sql = "delete from lesiones where idlesion = ?";

        $update = $this->DATA->Execute($sql, $id);
        if ($update){
            return true;
        } else {
            return false;
        }
    }
	
}
?>
		