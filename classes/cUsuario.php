<?php
class Usuario {
    //Constructor
    function __construct() {
        global $DATA;
        $this->DATA = $DATA;
    }
	//FUNCION QUE VERIFICA EL INGRESO DE LOS USUARIOS EN EL ADMINISTRADOR WEB DE LA APLICACION
    function ingreso($usuario, $contrasenia)
    {
		try{
			$sha1pass = ($contrasenia);
			$sql = "SELECT idusuario,nombre,idTipoUsuario, imagen, idclinica, concat(nombre,' ',apellido) as nusuario FROM usuario WHERE usuario=? AND clave=? ;";
			$rs = $this->DATA->Execute($sql, array($usuario, $sha1pass));
			if ( $rs->RecordCount() > 0 ) {
				$_SESSION['csmart']['idusuario']     	= $rs->fields['idusuario'];
				$_SESSION['usuario']   	= $rs->fields['nusuario'];
				$_SESSION['csmart']['permisos']     = $rs->fields['idTipoUsuario'];
                $_SESSION['csmart']['status']   = "authenticate";
                $_SESSION['csmart']['clinica']   = $rs->fields['idclinica'];
                $_SESSION['csmart']['iperfil']   = $rs->fields['imagen'];
                // $sql2 = "SELECT iddetalle_permisos_rol,idrol,idpermiso FROM  detalle_permisos_rol WHERE idrol = ?;";
				// $data = $this->DATA->Execute($sql2, $rs->fields['idrol']);
				// for ($j = 1; $j <= 11; $j++) {
				// 	$_SESSION['taxinet']['permisos'][$j] = false;
				// } 
				// if ( $data->RecordCount()) {
				// 	while(!$data->EOF){
				// 		for ($i = 1; $i <= 11; $i++){
				// 			if($data->fields['idpermiso']==$i){
				// 				$_SESSION['taxinet']['permisos'][$i] = true;
				// 			}
				// 		}
				// 		$data->MoveNext();
				// 	}
				// }
				// $data->Close();
				$rs->Close();
				return true;
			} else {
				return false; 
			}
		}catch(Exception $e){
			return $e;
		}
		
    }

    function verSession()
    {
        session_start();
        if (isset($_SESSION['csmart']['status'])) {
            $status = $_SESSION['csmart']['status'];
            if ($status == "authenticate") {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    function getAll()
    {
        $sql = "SELECT u.*, t.nombre as tipo
                FROM usuario u join tipoUsuario t on u.idtipoUsuario=t.idtipoUsuario ;";
        $rs = $this->DATA->Execute($sql);
        if ( $rs->RecordCount()) {
            while(!$rs->EOF){

                $id                     = $rs->fields['idusuario'];
                    $info[$id]['idusuario'] = $rs->fields['idusuario'];
                                $info[$id]['nombre']    = $rs->fields['nombre'];
                                $info[$id]['apellido']  = $rs->fields['apellido'];
                                $info[$id]['usuario']   = $rs->fields['usuario'];
                                $info[$id]['clave'] = $rs->fields['clave'];
                                $info[$id]['idclinica'] = $rs->fields['idclinica'];
                                $info[$id]['imagen']    = $rs->fields['imagen'];
                                $info[$id]['fecha'] = $rs->fields['fecha'];
                                $info[$id]['tipo'] = $rs->fields['tipo'];
                                
                $rs->MoveNext();
            }
            $rs->Close();
            return $info;
        } else {
            return false;
        }
    }

    function getAllxClinica($idclinica)
    {
        $sql = "SELECT u.*, t.nombre as tipo
                FROM usuario u join tipoUsuario t on u.idtipoUsuario=t.idtipoUsuario where u.idclinica=$idclinica;";
        $rs = $this->DATA->Execute($sql);
        if ( $rs->RecordCount()) {
            while(!$rs->EOF){

                $id                     = $rs->fields['idusuario'];
                $info[$id]['idusuario'] = $rs->fields['idusuario'];
                $info[$id]['nombre']    = $rs->fields['nombre'];
                $info[$id]['apellido']  = $rs->fields['apellido'];
                $info[$id]['usuario']   = $rs->fields['usuario'];
                                $info[$id]['clave'] = $rs->fields['clave'];
                                $info[$id]['idclinica'] = $rs->fields['idclinica'];
                                $info[$id]['imagen']    = $rs->fields['imagen'];
                                $info[$id]['fecha'] = $rs->fields['fecha'];
                                $info[$id]['tipo'] = $rs->fields['tipo'];
                                
                $rs->MoveNext();
            }
            $rs->Close();
            return $info;
        } else {
            return false;
        }
    }
	
	function getRol()
    {
        $sql = "SELECT idrol,titulo FROM rol WHERE estado=1;";

        $rs = $this->DATA->Execute($sql);
        if ( $rs->RecordCount()) {
            while(!$rs->EOF){
                $id                   	= $rs->fields['idrol'];
				$info[$id]['nombre']	= $rs->fields['titulo'];
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
        $sql = "SELECT * FROM usuario WHERE idusuario = ?;";

        $rs = $this->DATA->Execute($sql, $id);
        if ( $rs->RecordCount()) {
            while(!$rs->EOF){
                $id                     = $rs->fields['idusuario'];
                    $info[$id]['idusuario'] = $rs->fields['idusuario'];
                                $info[$id]['nombre']    = $rs->fields['nombre'];
                                $info[$id]['apellido']  = $rs->fields['apellido'];
                                $info[$id]['usuario']   = $rs->fields['usuario'];
                                $info[$id]['clave'] = $rs->fields['clave'];
                                $info[$id]['telefono']  = $rs->fields['telefono'];
                                $info[$id]['correo']    = $rs->fields['correo'];
                                $info[$id]['imagen']    = $rs->fields['imagen'];
                                $info[$id]['fecha'] = $rs->fields['fecha'];
                                $info[$id]['notas'] = $rs->fields['notas'];
                                $info[$id]['idtipoUsuario'] = $rs->fields['idtipoUsuario'];
                                $info[$id]['idclinica'] = $rs->fields['idclinica'];
                                $info[$id]['idestado']  = $rs->fields['idestado'];
                                $rs->MoveNext();
            }
            $rs->Close();
            return $info;
        } else {
            return false;
        }
    }
    function nuevo2($params) 
	{
        $sql = "INSERT INTO usuario_web (nombre,idrol,password,estado) VALUES (?,?,?,?);";
			 
        $save = $this->DATA->Execute($sql, $params);
        if ($save){
            return true;
        } else {
            return false;
        }
    }

    function nuevo($params) 
    {
        try{
        
            $sql = "INSERT INTO usuario (nombre,apellido,usuario,clave,telefono,correo,imagen,notas,idtipoUsuario,idclinica,idestado) VALUES (?,?,?,?,?,?,?,?,?,?,?);";     
            $save = $this->DATA->Execute($sql, $params);
            $id     = $this->DATA->Insert_ID();
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
        
            $sql = "UPDATE usuario SET nombre=?,apellido=?,usuario=?,clave=?,telefono=?,correo=?,imagen=?,notas=?,idtipoUsuario=?,idclinica=?,idestado=? WHERE idusuario = ?";
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
	function modificar($params)
	{
        $sql = "UPDATE usuario_web SET idrol=?,password=?,estado=? WHERE idusuario_web=?;";

        $update = $this->DATA->Execute($sql, $params);
        if ($update){
            return true;
        } else {
            return false;
        }
    }
	function modificar2($params)
	{
        $sql = "UPDATE usuario_web SET idrol=?,estado=? WHERE idusuario_web=?;";

        $update = $this->DATA->Execute($sql, $params);
        if ($update){
            return true;
        } else {
            return false;
        }
    }
	
	function bloqueo($id) {
        $sql = "UPDATE usuario_web SET estado = 0 "
             . "WHERE idusuario_web = ?";

        $update = $this->DATA->Execute($sql, $id);
        if ($update){
            return true;
        } else {
            return false;
        }
    }
	function habilitar($id) {
        $sql = "UPDATE usuario_web SET  estado = 1 "
             . "WHERE idusuario_web = ?";

        $update = $this->DATA->Execute($sql, $id);
        if ($update){
            return true;
        } else {
            return false; 
        }
    }
	function eliminar($id) {
        $sql = "DELETE FROM usuario WHERE idusuario = ?";

        $delete = $this->DATA->Execute($sql, $id);
        if ($delete){
            return true;
        } else {
            return false; 
        }
    }
	function validar($titulo)
    {
        $sql = "SELECT COUNT(idusuario_web) AS cantidad FROM usuario_web WHERE nombre = ?;";

        $rs = $this->DATA->Execute($sql, $titulo);
        if ( $rs->RecordCount()) {
            while(!$rs->EOF){
                $id   	= $rs->fields['cantidad'];
                $rs->MoveNext();
            }
            $rs->Close();
            return $id;
        } else {
            return false;
        }
    }
}
?>