		<?php

class historial_medico{

	function __construct() {
        global $DATA;
        $this->DATA = $DATA;
    }
	
	 function getAll()
    {
        $sql = "SELECT idhistorial_medico,idpaciente,cenfermedad,nenferemedad,calergia,cdesmayos,cdiabetes,chepatitis,cartritis,cpresion,cmedicamento,nmedicamento,cembarazo,nembarazo,cfuma,ctoma,fecha_ult_control,cfractura,nfractura,cchupeteo,clabio,csuccion,cortodoncia FROM historial_medico;";
        $rs = $this->DATA->Execute($sql);
        if ( $rs->RecordCount()) {
            while(!$rs->EOF){

         		$id                  	= $rs->fields['idhistorial_medico'];
				   	$info[$id]['idhistorial_medico']	= $rs->fields['idhistorial_medico'];
								$info[$id]['idpaciente']	= $rs->fields['idpaciente'];
								$info[$id]['cenfermedad']	= $rs->fields['cenfermedad'];
								$info[$id]['nenferemedad']	= $rs->fields['nenferemedad'];
								$info[$id]['calergia']	= $rs->fields['calergia'];
								$info[$id]['cdesmayos']	= $rs->fields['cdesmayos'];
								$info[$id]['cdiabetes']	= $rs->fields['cdiabetes'];
								$info[$id]['chepatitis']	= $rs->fields['chepatitis'];
								$info[$id]['cartritis']	= $rs->fields['cartritis'];
								$info[$id]['cpresion']	= $rs->fields['cpresion'];
								$info[$id]['cmedicamento']	= $rs->fields['cmedicamento'];
								$info[$id]['nmedicamento']	= $rs->fields['nmedicamento'];
								$info[$id]['cembarazo']	= $rs->fields['cembarazo'];
								$info[$id]['nembarazo']	= $rs->fields['nembarazo'];
								$info[$id]['cfuma']	= $rs->fields['cfuma'];
								$info[$id]['ctoma']	= $rs->fields['ctoma'];
								$info[$id]['fecha_ult_control']	= $rs->fields['fecha_ult_control'];
								$info[$id]['cfractura']	= $rs->fields['cfractura'];
								$info[$id]['nfractura']	= $rs->fields['nfractura'];
								$info[$id]['cchupeteo']	= $rs->fields['cchupeteo'];
								$info[$id]['clabio']	= $rs->fields['clabio'];
								$info[$id]['csuccion']	= $rs->fields['csuccion'];
								$info[$id]['cortodoncia']	= $rs->fields['cortodoncia'];
								
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
        $sql = "SELECT * FROM historial_medico WHERE idpaciente = ? ;";

        $rs = $this->DATA->Execute($sql, $id);
        if ( $rs->RecordCount()) {
            while(!$rs->EOF){
                $id                  	= $rs->fields['idhistorial_medico'];
				   	$info[$id]['idhistorial_medico']	= $rs->fields['idhistorial_medico'];
								$info[$id]['idpaciente']	= $rs->fields['idpaciente'];
								$info[$id]['cenfermedad']	= $rs->fields['cenfermedad'];
								$info[$id]['nenferemedad']	= $rs->fields['nenferemedad'];
								$info[$id]['calergia']	= $rs->fields['calergia'];
								$info[$id]['cdesmayos']	= $rs->fields['cdesmayos'];
								$info[$id]['cdiabetes']	= $rs->fields['cdiabetes'];
								$info[$id]['chepatitis']	= $rs->fields['chepatitis'];
								$info[$id]['cartritis']	= $rs->fields['cartritis'];
								$info[$id]['cpresion']	= $rs->fields['cpresion'];
								$info[$id]['cmedicamento']	= $rs->fields['cmedicamento'];
								$info[$id]['nmedicamento']	= $rs->fields['nmedicamento'];
								$info[$id]['cembarazo']	= $rs->fields['cembarazo'];
								$info[$id]['nembarazo']	= $rs->fields['nembarazo'];
								$info[$id]['cfuma']	= $rs->fields['cfuma'];
								$info[$id]['ctoma']	= $rs->fields['ctoma'];
								$info[$id]['fecha_ult_control']	= $rs->fields['fecha_ult_control'];
								$info[$id]['cfractura']	= $rs->fields['cfractura'];
								$info[$id]['nfractura']	= $rs->fields['nfractura'];
								$info[$id]['cchupeteo']	= $rs->fields['cchupeteo'];
								$info[$id]['clabio']	= $rs->fields['clabio'];
								$info[$id]['csuccion']	= $rs->fields['csuccion'];
								$info[$id]['cortodoncia']	= $rs->fields['cortodoncia'];
								
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
		
			$sql = "INSERT INTO historial_medico (idpaciente,cenfermedad,nenferemedad,calergia,cdesmayos,cdiabetes,chepatitis,cartritis,cpresion,cmedicamento,nmedicamento,cembarazo,nembarazo,cfuma,ctoma,fecha_ult_control,cfractura,nfractura,cchupeteo,clabio,csuccion,cortodoncia) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
				 
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
		
			$sql = "UPDATE historial_medico SET cenfermedad=?,nenferemedad=?,calergia=?,cdesmayos=?,cdiabetes=?,chepatitis=?,cartritis=?,cpresion=?,cmedicamento=?,nmedicamento=?,cembarazo=?,nembarazo=?,cfuma=?,ctoma=?,fecha_ult_control=?,cfractura=?,nfractura=?,cchupeteo=?,clabio=?,csuccion=?,cortodoncia=? WHERE idpaciente = ? ;";
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
        $sql = "UPDATE historial_medico SET estado = 2 WHERE idhistorial_medico = ?";

        $update = $this->DATA->Execute($sql, $id);
        if ($update){
            return true;
        } else {
            return false;
        }
    }
	
	
	function habilitar($id) {
        $sql = "UPDATE historial_medico SET estado = 1 WHERE idhistorial_medico = ?";

        $update = $this->DATA->Execute($sql, $id);
        if ($update){
            return true;
        } else {
            return false;
        }
    }
	
	function eliminar($id) {
        $sql = "delete from historial_medico where idhistorial_medico = ?";

        $update = $this->DATA->Execute($sql, $id);
        if ($update){
            return true;
        } else {
            return false;
        }
    }
	
}
?>
		