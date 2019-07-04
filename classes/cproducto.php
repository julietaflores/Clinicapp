		<?php

class producto{

	function __construct() {
        global $DATA;
        $this->DATA = $DATA;
    }
	
	 function getAll($idclinica)
    {
        $sql = "SELECT idproducto,idclinica,nombre,precio,costo,idtipo,stock,idestado,fecha FROM producto where idclinica=$idclinica;";
        $rs = $this->DATA->Execute($sql);
        if ( $rs->RecordCount()) {
            while(!$rs->EOF){

         		$id                  	= $rs->fields['idproducto'];
				   	$info[$id]['idproducto']	= $rs->fields['idproducto'];
								$info[$id]['idclinica']	= $rs->fields['idclinica'];
								$info[$id]['nombre']	= $rs->fields['nombre'];
								$info[$id]['precio']    = $rs->fields['precio'];
                                $info[$id]['costo']    = $rs->fields['costo'];
                                $info[$id]['idtipo']    = $rs->fields['idtipo'];
                                $info[$id]['stock']	= $rs->fields['stock'];
								$info[$id]['idestado']	= $rs->fields['idestado'];
								$info[$id]['fecha']	= $rs->fields['fecha'];
								
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
        $sql = "SELECT idproducto, nombre, precio FROM producto where  idestado =1  and idclinica=$clinica and (nombre like '%$filtro%') LIMIT 10 ;";
        $rs = $this->DATA->Execute($sql);
        if ( $rs->RecordCount()) {
            while(!$rs->EOF){

         		$id     = $rs->fields['idproducto'];
				$info[$id]['idproducto']	= $rs->fields['idproducto'];
				$info[$id]['nombre']	= $rs->fields['nombre'];
				$info[$id]['precio']	= $rs->fields['precio'];
								
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
        $sql = "SELECT * FROM producto WHERE idproducto = ? ;";

        $rs = $this->DATA->Execute($sql, $id);
        if ( $rs->RecordCount()) {
            while(!$rs->EOF){
                $id                  	= $rs->fields['idproducto'];
				   	$info[$id]['idproducto']	= $rs->fields['idproducto'];
								$info[$id]['idclinica']	= $rs->fields['idclinica'];
								$info[$id]['nombre']	= $rs->fields['nombre'];
								$info[$id]['precio']	= $rs->fields['precio'];
								$info[$id]['costo']    = $rs->fields['costo'];
                                $info[$id]['idtipo']    = $rs->fields['idtipo'];
                                $info[$id]['stock']	= $rs->fields['stock'];
								$info[$id]['idestado']	= $rs->fields['idestado'];
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
		
			$sql = "INSERT INTO producto (idclinica,nombre,precio,costo,idtipo,stock,idestado) VALUES (?,?,?,?,?,?,?);";
				 
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
		
			$sql = "UPDATE producto SET idclinica=?,nombre=?,precio=?,costo=?,idtipo=?,stock=?,idestado=? WHERE idproducto = ?";
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
        $sql = "UPDATE producto SET estado = 2 WHERE idproducto = ?";

        $update = $this->DATA->Execute($sql, $id);
        if ($update){
            return true;
        } else {
            return false;
        }
    }
	
	
	function habilitar($id) {
        $sql = "UPDATE producto SET estado = 1 WHERE idproducto = ?";

        $update = $this->DATA->Execute($sql, $id);
        if ($update){
            return true;
        } else {
            return false;
        }
    }
	
	function eliminar($id) {
        $sql = "delete from producto where idproducto = ?";

        $update = $this->DATA->Execute($sql, $id);
        if ($update){
            return true;
        } else {
            return false;
        }
    }
	
}
?>
		