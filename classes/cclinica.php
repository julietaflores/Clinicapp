<?php

class clinica{

	function __construct() {
        global $DATA;
        $this->DATA = $DATA;
    }
	
	 function getAll()
    {
        $sql = "SELECT idclinica,nombre,registro,direccion,telefono1,telefono2,correo,imagen,fecha_cre,fecha_val,superusuario,idestado FROM clinica;";
        $rs = $this->DATA->Execute($sql);
        if ( $rs->RecordCount()) {
            while(!$rs->EOF){

         		$id                  	= $rs->fields['idclinica'];
				   	$info[$id]['idclinica']	= $rs->fields['idclinica'];
								$info[$id]['nombre']	= $rs->fields['nombre'];
								$info[$id]['registro']	= $rs->fields['registro'];
								$info[$id]['direccion']	= $rs->fields['direccion'];
								$info[$id]['telefono1']	= $rs->fields['telefono1'];
								$info[$id]['telefono2']	= $rs->fields['telefono2'];
								$info[$id]['correo']	= $rs->fields['correo'];
								$info[$id]['imagen']	= $rs->fields['imagen'];
								$info[$id]['fecha_cre']	= $rs->fields['fecha_cre'];
								$info[$id]['fecha_val']	= $rs->fields['fecha_val'];
								$info[$id]['superusuario']	= $rs->fields['superusuario'];
								$info[$id]['idestado']	= $rs->fields['idestado'];
								
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
        $sql = "SELECT * FROM clinica WHERE idclinica = ? ;";

        $rs = $this->DATA->Execute($sql, $id);
        if ( $rs->RecordCount()) {
            while(!$rs->EOF){
                $id                  	= $rs->fields['idclinica'];
				   	$info[$id]['idclinica']	= $rs->fields['idclinica'];
								$info[$id]['nombre']	= $rs->fields['nombre'];
								$info[$id]['registro']	= $rs->fields['registro'];
								$info[$id]['direccion']	= $rs->fields['direccion'];
								$info[$id]['telefono1']	= $rs->fields['telefono1'];
								$info[$id]['telefono2']	= $rs->fields['telefono2'];
								$info[$id]['correo']	= $rs->fields['correo'];
								$info[$id]['imagen']	= $rs->fields['imagen'];
								$info[$id]['fecha_cre']	= $rs->fields['fecha_cre'];
								$info[$id]['fecha_val']	= $rs->fields['fecha_val'];
								$info[$id]['superusuario']	= $rs->fields['superusuario'];
								$info[$id]['idestado']	= $rs->fields['idestado'];
								
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
		
			$sql = "INSERT INTO clinica (nombre,registro,direccion,telefono1,telefono2,correo,imagen,fecha_val,superusuario,idestado) VALUES (?,?,?,?,?,?,?,?,?,?);";
				 
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
		
			$sql = "UPDATE clinica SET nombre=?,registro=?,direccion=?,telefono1=?,telefono2=?,correo=?,imagen=?,fecha_val=?,superusuario=?,idestado=? WHERE idclinica = ?";
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
        $sql = "UPDATE clinica SET estado = 2 WHERE idclinica = ?";

        $update = $this->DATA->Execute($sql, $id);
        if ($update){
            return true;
        } else {
            return false;
        }
    }
	
	
	function habilitar($id) {
        $sql = "UPDATE clinica SET estado = 1 WHERE idclinica = ?";

        $update = $this->DATA->Execute($sql, $id);
        if ($update){
            return true;
        } else {
            return false;
        }
    }
	
	function eliminar($id) {
        $sql = "delete from clinica where idclinica = ?";

        $update = $this->DATA->Execute($sql, $id);
        if ($update){
            return true;
        } else {
            return false;
        }
    }
	
}
?>
		