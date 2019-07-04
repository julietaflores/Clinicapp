		<?php 
		include 'data/dataBase.php';
		include 'classes/cpaciente.php';
		include 'classes/cUsuario.php';
		include 'classes/cdepartamento.php';
		include 'classes/chistorial_medico.php';
		
		$oUser 	= new Usuario();
			
		if ( !$oUser->verSession() ) {
			header("Location: login.php");
			exit();
		}
		$opaciente = new paciente();
		$odepto = new departamento();
		$ohistorial = new historial_medico();
		$accion 	= "Crear";
		$option 	= "n";

		$idpaciente 	= "";
	        $nombre 	= "";
	        $apellido 	= "";
	        $identificacion 	= "";
	        $genero 	= "";
	        $imagen 	= "";
	        $direccion 	= "";
	        $telefono1 	= "";
	        $telefono2 	= "";
	        $correo 	= "";
	        $fecha_nac 	= "";
	        $fecha_mod 	= "";
	        $fecha_cre 	= "";
	        $notas 	= "";
	        $idestado 	= "";
	        $iddepartamento 	= "";
	        $responsable 	= "";
	        $telefono_resp 	= "";
	        $medico_fam 	= "";
	        $ocupacion 	= "";
	    $imagen   = "user.png";
    
	        
	    if(isset($_REQUEST['opt']) && $_REQUEST['opt']== "m"){
		$option = $_REQUEST['opt'];
		$idObj	= $_REQUEST['id'];
	}

	if ($option == "m") {
		$vpaciente = $opaciente->getOne($idObj);
		if($vpaciente){
			$accion 	= "Modificar";
			
			   foreach ($vpaciente AS $id => $info){ 
			   	  
			   	  $idpaciente		= $info["idpaciente"];
		        $nombre		= $info["nombre"];
		        $apellido		= $info["apellido"];
		        $identificacion		= $info["identificacion"];
		        $genero		= $info["genero"];
		        $imagen		= $info["imagen"];
		        $direccion		= $info["direccion"];
		        $telefono1		= $info["telefono1"];
		        $telefono2		= $info["telefono2"];
		        $correo		= $info["correo"];
		        $fecha_nac		= $info["fecha_nac"];
		        $fecha_mod		= $info["fecha_mod"];
		        $fecha_cre		= $info["fecha_cre"];
		        $notas		= $info["notas"];
		        $idestado		= $info["idestado"];
		        $iddepartamento		= $info["iddepartamento"];
		        $responsable		= $info["responsable"];
		        $telefono_resp		= $info["telefono_resp"];
		        $medico_fam		= $info["medico_fam"];
		        $ocupacion		= $info["ocupacion"];

		        
		         }
		        $vhistorial = $ohistorial->getOne($idObj);
		        foreach ($vhistorial AS $id => $info){ 
		        	$cenfermedad		= $info["cenfermedad"];
			        $nenferemedad		= $info["nenferemedad"];
			        $calergia		= $info["calergia"];
			        $cdesmayos		= $info["cdesmayos"];
			        $cdiabetes		= $info["cdiabetes"];
			        $chepatitis		= $info["chepatitis"];
			        $cartritis		= $info["cartritis"];
			        $cpresion		= $info["cpresion"];
			        $cmedicamento		= $info["cmedicamento"];
			        $nmedicamento		= $info["nmedicamento"];
			        $cembarazo		= $info["cembarazo"];
			        $nembarazo		= $info["nembarazo"];
			        $cfuma		= $info["cfuma"];
			        $ctoma		= $info["ctoma"];
			        $fecha_ult_control		= $info["fecha_ult_control"];
			        $cfractura		= $info["cfractura"];
			        $nfractura		= $info["nfractura"];
			        $cchupeteo		= $info["cchupeteo"];
			        $clabio		= $info["clabio"];
			        $csuccion		= $info["csuccion"];
			        $cortodoncia		= $info["cortodoncia"];
				}
		
		}else{
			header("Location: paciente.php");
			exit();
		}
	}
  $vpaciente 		= $opaciente->getAll();
  $vDepto			= $odepto->getAll();
  
?>
<!DOCTYPE HTML>
<html lang="es">
<head>
 	 <?php include 'header.php'; ?>

		<script type="text/javascript">	
			
			function guardarformulario(){
				
				var file_data = $('#imagenS').prop('files')[0];   
		        var form_data = new FormData();                  
		        form_data.append('file', file_data);
		        
		        if(file_data){ // SI EXISTE IMAGEN PARA SUBIR o ACTUALIZAR
		          var fsize = $('#imagenS')[0].files[0].size; //get file size
		          //$('#img').val($('#imagenS').val());
		          if(fsize>1048576) 
		          {
		            new PNotify({
		                 title: 'Error en Imagen!',
		                 text: 'Excede el tamaño máximo permitido. Tamaño permitido menor a 1 Mb.'
		             });
		          }else{
		            //guardar datos con imagen
		            
		            
		          }
		        
		        }
		        var form = $("#form").serializeJSON(); 
				console.log(form);
				$.ajax({
					url:'actions/actionpaciente.php',
					type:'POST',
					data: { valor: form, }
				}).done(function( data ){
					 console.log(data);
					if(data > 0){

						$.ajax({
		                      url: 'processUpload.php?id='+data + '&tipo=paciente', // point to server-side PHP script 
		                      dataType: 'text',  // what to expect back from the PHP script, if anything
		                      cache: false,
		                      contentType: false,
		                      processData: false,
		                      data: form_data,                         
		                      type: 'post',
		                      success: function(val){
		                          //alert(val); // display response from the PHP script, if any
		                      }
		              	});
						new PNotify({
		                 	title: 'Datos Guardados',
			                text: 'Todos los datos fueron guardados. Puede continuar.',
			                type: 'success'
			             });
            
						window.setTimeout("document.location.href='pacientes.php';",2500);
					}
					
					else{
						new PNotify({
			                title: 'Error en formulario',
			                text: 'No se puedieron guardar los datos, intente de nuevo.',
			                type: 'error'
			             });
			            window.setTimeout("location.reload(true);",2500);
					}
					
				});
			}
			function cancelar(){
				window.setTimeout("document.location.href='pacientes.php';",500);

			}

			
	</script>



</head>

<body class="nav-md">

  <div class="container body">


    <div class="main_container">

      <div class="col-md-3 left_col">
        <div class="left_col scroll-view">

          
          <!-- sidebar menu -->
            <?php include "menu.php" ?>
          <!-- /sidebar menu -->

         
        </div>
      </div>

      <!-- top navigation -->
           <?php include "top_nav.php" ?>
      <!-- /top navigation -->

      <!-- page content -->
      <div class="right_col" role="main">

        <div class="">
          
         
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                
                <div class="x_content">

                
                      
                        
                  <form id="form" class="form-horizontal form-label-left" novalidate>
                   
                    <?php
                          if ($option == "m") {
                        ?>
                            <input type="hidden" name="idpaciente" value="<?=$idpaciente?>"/>
                            <input type="hidden" name="opt" id="opt" value="m" />
                        <?php
                          }else{
                        ?>
                            <input type="hidden" name="opt" id="opt" value="n" />
                        <?php
                          }
                        ?>
                    
                     <h2>Nuevo Paciente</h2>		 
                  <!-- Tabs -->
                  <div id="wizard_verticle" class="form_wizard wizard_verticle">
                    <ul class="list-unstyled wizard_steps">
                      <li>
                        <a href="#step-11">
                          <span class="step_no">1</span>
                        </a>
                      </li>
                      <li>
                        <a href="#step-22">
                          <span class="step_no">2</span>
                        </a>
                      </li>
                      <li>
                        <a href="#step-33">
                          <span class="step_no">3</span>
                        </a>
                      </li>
                      <li>
                        <a href="#step-44">
                          <span class="step_no">4</span>
                        </a>
                      </li>
                    </ul>

                    <div id="step-11">
                      <h2 class="StepTitle">Paso 1 </h2>
                      
                        <span class="section">Informacion Personal </span>

                        		 
							 <div class="item form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nombre">Nombre <span class="required">*</span>
		                      </label>
		                      <div class="col-md-6 col-sm-6 col-xs-12">
		                        <input id="nombre" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" name="nombre" value="<?=$nombre?>"  required="required" type="text">
		                      </div>
		                    </div>

							
								 
							 <div class="item form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="apellido">Apellido <span class="required">*</span>
		                      </label>
		                      <div class="col-md-6 col-sm-6 col-xs-12">
		                        <input id="apellido" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" name="apellido" value="<?=$apellido?>" required="required" type="text">
		                      </div>
		                    </div>

							
								 
							 <div class="item form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="identificacion">No. Identificación 
		                      </label>
		                      <div class="col-md-6 col-sm-6 col-xs-12">
		                        <input id="identificacion" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" name="identificacion" value="<?=$identificacion?>"  type="text">
		                      </div>
		                    </div>

							<div class="form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Genero</label>
		                      <div class="col-md-6 col-sm-6 col-xs-12">
		                        <div id="gender" class="btn-group" data-toggle="buttons">
		                          <label class="btn btn-default <?php if($genero=='Hombre'){ echo active;} ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
		                            <input type="radio" name="gender" value="Hombre" >  Hombre
		                          </label>
		                          <label class="btn btn-default <?php if($genero=='Mujer' or $genero==''){ echo active;} ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
		                            <input type="radio" name="gender" value="Mujer" > Mujer &nbsp;
		                          </label>
		                        </div>
		                        <input id="genero" name="genero" value="<?=$genero?>" type="hidden">
		                      
		                      </div>
		                    </div>
							
							                         
                        	<div class="item form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="fecha_nac">Fecha de Nacimiento 
		                      </label>
		                      <div class="col-md-6 col-sm-6 col-xs-12">
		                        <input id="fecha_nac" class="form-control col-md-7 col-xs-12" data-inputmask="'mask': '9999-99-99'" placeholder="AAAA-mm-dd" name="fecha_nac" value="<?=$fecha_nac?>"  type="text">
		                      </div>
		                    </div>

		                    <div class="item form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="edad">Edad
		                      </label>
		                      <div class="col-md-6 col-sm-6 col-xs-12">
		                        <input id="edad" class="form-control col-md-7 col-xs-12" name="edad" value=""   type="text">
		                      </div>
		                    </div>

		                    <div class="item form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ocupacion">Ocupación 
		                      </label>
		                      <div class="col-md-6 col-sm-6 col-xs-12">
		                        <input id="ocupacion" class="form-control col-md-7 col-xs-12" name="ocupacion" value="<?=$ocupacion?>"  type="text">
		                      </div>
		                    </div>

                      
                    </div>
                    <div id="step-22">
                      <h2 class="StepTitle">Paso 2 </h2>
                      <span class="section">Datos de contacto </span>

							 <div class="item form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="direccion">Dirección 
		                      </label>
		                      <div class="col-md-6 col-sm-6 col-xs-12">
		                        <input id="direccion" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" name="direccion" value="<?=$direccion?>" type="text">
		                      </div>
		                    </div>

		                    <div class="form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="iddepartamento">Departamento 
		                      </label>
		                      <div class="col-md-6 col-sm-6 col-xs-12">
		                        <select id="iddepartamento" name="iddepartamento" class="form-control">
		                          <option>Elegir una opción</option>
		                          <?php if($vDepto){
		                                foreach ($vDepto AS $id => $array) {?>

		                                <option value="<?=$array['iddepartamento'];?>" <?php if($iddepartamento==$id){echo"selected='selected'";}?>><?=$array['nombredepto'];?></option>
		                          <?php } } ?>
		                        </select>
		                      </div>
		                    </div>

		                    	 
							 <div class="item form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="telefono1">Teléfono </label>
		                      <div class="col-md-6 col-sm-6 col-xs-12">
		                        <input id="telefono1" class="form-control col-md-7 col-xs-12"  name="telefono1" value="<?=$telefono1?>" type="text">
		                      </div>
		                    </div>

							
								 
							 <div class="item form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="telefono2">Celular  
		                      </label>
		                      <div class="col-md-6 col-sm-6 col-xs-12">
		                        <input id="telefono2" class="form-control col-md-7 col-xs-12"  name="telefono2" value="<?=$telefono2?>"  type="text">
		                      </div>
		                    </div>

							
								 
							 <div class="item form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="correo">Correo 
		                      </label>
		                      <div class="col-md-6 col-sm-6 col-xs-12">
		                        <input id="correo" class="form-control col-md-7 col-xs-12"  name="correo" value="<?=$correo?>"  type="email">
		                      </div>
		                    </div>

		                    <span class="section">En caso de emergencia </span>

                      		 <div class="item form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="responsable">Persona responsable 
		                      </label>
		                      <div class="col-md-6 col-sm-6 col-xs-12">
		                        <input id="responsable" class="form-control col-md-7 col-xs-12"  name="responsable" value="<?=$responsable?>" type="text">
		                      </div>
		                    </div>

							
								 
							 <div class="item form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="telefono_resp">Teléfono del Responsable 
		                      </label>
		                      <div class="col-md-6 col-sm-6 col-xs-12">
		                        <input id="telefono_resp" class="form-control col-md-7 col-xs-12"  name="telefono_resp" value="<?=$telefono_resp?>" type="text">
		                      </div>
		                    </div>

							
								 
							 <div class="item form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="medico_fam">Médico familiar 
		                      </label>
		                      <div class="col-md-6 col-sm-6 col-xs-12">
		                        <input id="medico_fam" class="form-control col-md-7 col-xs-12"  name="medico_fam" value="<?=$medico_fam?>" type="text">
		                      </div>
		                    </div>
                      
                    </div>
                    <div id="step-33">
                      <h2 class="StepTitle">Paso 3 </h2>
                      	<span class="section">Datos Finales </span>

                      	<div class="item form-group">
	                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">
	                      </label>
	                      <div class="col-md-5">
	                            <img src="images/paciente/<?=$idpaciente?>/<?=$imagen?>" alt="" class="img-circle img-responsive">
	                          </div>
	                    </div>
	                    <div class="item form-group">
	                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="imagenS"> Foto perfil 
	                      </label>
	                      <div class="col-md-5"> 
	                        <input name="imagenS" class="fileupload " id="imagenS" type="file" />
	                        <input name="img" id="img" type="hidden" value="<?=$imagen?>" />
	                     </div>
	                                
	                    </div>
                      	

		                <div class="form-group">
	                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Estado <span class="required">*</span></label>
	                      <div class="col-md-6 col-sm-6 col-xs-12">
	                        <select id="idestado" name="idestado" class="form-control">
	                          <option>Elegir una opción</option>
	                          <option value="0" <?php if($idestado==0){echo"selected='selected'";}?>>Inactivo</option>
	                          <option value="1" <?php if($idestado==1){echo"selected='selected'";}?>>Activo</option>
	                          
	                        </select>
	                      </div>
	                    </div>


                      	<div class="item form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="notas">Notas 
		                      </label>
		                      <div class="col-md-6 col-sm-6 col-xs-12">
		                        <textarea id="notas" name="notas" class="form-control col-md-7 col-xs-12"><?=$notas?></textarea>
		                      </div>
		                </div>

		                <div class="item form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="fecha_cre">Fecha de Alta 
		                      </label>
		                      <div class="col-md-6 col-sm-6 col-xs-12">
		                        <input id="fecha_cre" class="form-control col-md-7 col-xs-12" data-inputmask="'mask': '9999-99-99'" placeholder="AAAA-mm-dd" name="fecha_cre" value="<?=$fecha_cre?>"   type="text">
		                      </div>
		                    </div>

                    </div>
                    <div id="step-44">
                      <h2 class="StepTitle">Paso 4 </h2>
                      	<input id="idhistorial_medico" name="idhistorial_medico" value="<?=$idhistorial_medico?>" type="hidden">
		                    <span class="section">Antecedentes médicos </span>
                      
								 
							 <div class="item form-group">
		                      <label class="control-label col-md-4 col-sm-4 col-xs-12" for="cenfermedad">Ha padecido alguna enfermedad grave? 
		                      </label>
		                      <div class="col-md-3 col-sm-3 col-xs-12">
		                      	<div id="cenfermedad" class="btn-group" data-toggle="buttons">
		                          <label class="btn btn-default <?php if($cenfermedad=='Si'){ echo active;} ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
		                            <input type="radio" name="cenfermedad" value="Si">  Si
		                          </label>
		                          <label class="btn btn-default <?php if($cenfermedad=='No' or $cenfermedad==''){ echo active;} ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
		                            <input type="radio" name="cenfermedad" value="No" checked=""> No 
		                          </label>
		                        </div>
		                        <input id="cenfermedad1" name="cenfermedad1" value="<?=$cenfermedad?>" type="hidden">
		                      	</div>
		                      <div class="col-md-4 col-sm-4 col-xs-12">
									<input id="nenferemedad" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" name="nenferemedad" value="<?=$nenferemedad?>" placeholder="nombre de enfermedad"  type="text">
		                     </div>
		                    </div>

							<div class="item form-group">
		                      <label class="control-label col-md-4 col-sm-4 col-xs-12" for="cmedicamento">Toma algún tipo de medicamento? 
		                      </label>
		                       <div class="col-md-3 col-sm-3 col-xs-12">
		                      <div id="cmedicamento" class="btn-group" data-toggle="buttons">
		                          <label class="btn btn-default <?php if($cmedicamento=='Si'){ echo active;} ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
		                            <input type="radio" name="cmedicamento" value="Si">  Si
		                          </label>
		                          <label class="btn btn-default  <?php if($cmedicamento=='No' or $cmedicamento==''){ echo active;} ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
		                            <input type="radio" name="cmedicamento" value="No" checked=""> No 
		                          </label>
		                          <input id="cmedicamento1" name="cmedicamento1" value="<?=$cmedicamento?>" type="hidden">
		                      	
		                        </div>
		                    </div>
		                      <div class="col-md-4 col-sm-4 col-xs-12">
		                        <input id="nmedicamento" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" name="nmedicamento" value="<?=$nmedicamento?>" placeholder="Que tipo de medicamento" type="text">
		                      </div>
		                    </div>

							
								 
							 <div class="item form-group">
		                      <label class="control-label col-md-4 col-sm-4 col-xs-12" for="calergia">Padece de alguna alergia?   
		                      </label>
		                      <div class="col-md-3 col-sm-3 col-xs-12">
			                    <div id="calergia" class="btn-group" data-toggle="buttons">
			                        <label class="btn btn-default <?php if($calergia=='Si'){ echo active;} ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
			                            <input type="radio" name="calergia" value="Si">  Si
			                        </label>
			                        <label class="btn btn-default <?php if($calergia=='No' or $calergia==''){ echo active;} ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
			                            <input type="radio" name="calergia" value="No" checked=""> No 
			                        </label>
			                        <input id="calergia1" name="calergia1" value="<?=$calergia?>" type="hidden">
		                      	
			                    </div>
			                  </div>
		                      
		                      <label class="control-label col-md-2 col-sm-2 col-xs-12" for="cdiabetes">Diabetes 
		                      </label>
		                      <div class="col-md-3 col-sm-3 col-xs-12">
			                    <div id="cdiabetes" class="btn-group" data-toggle="buttons">
			                        <label class="btn btn-default <?php if($cdiabetes=='Si'){ echo active;} ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
			                            <input type="radio" name="cdiabetes" value="Si">  Si
			                        </label>
			                        <label class="btn btn-default <?php if($cdiabetes=='No' or $cdiabetes==''){ echo active;} ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
			                            <input type="radio" name="cdiabetes" value="No" checked=""> No 
			                        </label>
			                        <input id="cdiabetes1" name="cdiabetes1" value="<?=$cdiabetes?>" type="hidden">
		                      	
			                    </div>
			                  </div>
		                    </div>

							
								 
							 <div class="item form-group">
		                      <label class="control-label col-md-4 col-sm-4 col-xs-12" for="cdesmayos">Desmayos frecuentes y prolongados 
		                      </label>
		                       <div class="col-md-3 col-sm-3 col-xs-12">
			                    <div id="cdesmayos" class="btn-group" data-toggle="buttons">
			                        <label class="btn btn-default <?php if($cdesmayos=='Si'){ echo active;} ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
			                            <input type="radio" name="cdesmayos" value="Si">  Si
			                        </label>
			                        <label class="btn btn-default <?php if($cdesmayos=='No' or $cdesmayos==''){ echo active;} ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
			                            <input type="radio" name="cdesmayos" value="No" checked=""> No 
			                        </label>
			                    </div>
			                    <input id="cdesmayos1" name="cdesmayos1" value="<?=$cdesmayos?>" type="hidden">
		                      	
			                  </div>
		                      
		                      <label class="control-label col-md-2 col-sm-2 col-xs-12" for="chepatitis">Hepatitis 
		                      </label>
		                      <div class="col-md-3 col-sm-3 col-xs-12">
			                    <div id="chepatitis" class="btn-group" data-toggle="buttons">
			                        <label class="btn btn-default <?php if($chepatitis=='Si'){ echo active;} ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
			                            <input type="radio" name="chepatitis" value="Si">  Si
			                        </label>
			                        <label class="btn btn-default <?php if($chepatitis=='No' or $chepatitis==''){ echo active;} ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
			                            <input type="radio" name="chepatitis" value="No" checked=""> No 
			                        </label>
			                    </div>
			                    <input id="chepatitis1" name="chepatitis1" value="<?=$chepatitis?>" type="hidden">
		                      	
			                  </div>
		                    </div>

							

								 
							 <div class="item form-group">
		                      <label class="control-label col-md-4 col-sm-4 col-xs-12" for="cpresion">Presión  arterial  alta 
		                      </label>
		                      <div class="col-md-3 col-sm-3 col-xs-12">
			                    <div id="cpresion" class="btn-group" data-toggle="buttons">
			                        <label class="btn btn-default <?php if($cpresion=='Si'){ echo active;} ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
			                            <input type="radio" name="cpresion" value="Si">  Si
			                        </label>
			                        <label class="btn btn-default <?php if($cpresion=='No' or $cpresion==''){ echo active;} ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
			                            <input type="radio" name="cpresion" value="No" checked=""> No 
			                        </label>
			                    </div>
			                    <input id="cpresion1" name="cpresion1" value="<?=$cpresion?>" type="hidden">
		                      	
			                  </div>
		                      
		                      <label class="control-label col-md-2 col-sm-2 col-xs-12" for="cartritis">Artritis
		                      </label>
		                       <div class="col-md-3 col-sm-3 col-xs-12">
			                    <div id="cartritis" class="btn-group" data-toggle="buttons">
			                        <label class="btn btn-default <?php if($cartritis=='Si'){ echo active;} ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
			                            <input type="radio" name="cartritis" value="Si">  Si
			                        </label>
			                        <label class="btn btn-default <?php if($cartritis=='No' or $cartritis==''){ echo active;} ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
			                            <input type="radio" name="cartritis" value="No" checked=""> No 
			                        </label>
			                    </div>
			                    <input id="cartritis1" name="cartritis1" value="<?=$cartritis?>" type="hidden">
		                      	
			                  </div>
		                    </div>

							
							
								 
							 <div class="item form-group">
		                      <label class="control-label col-md-4 col-sm-4 col-xs-12" for="cembarazo">Si es mujer: está usted embarazada?   
		                      </label>
		                      <div class="col-md-3 col-sm-3 col-xs-12">
			                    <div id="cembarazo" class="btn-group" data-toggle="buttons">
			                        <label class="btn btn-default <?php if($cembarazo=='Si'){ echo active;} ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
			                            <input type="radio" name="cembarazo" value="Si">  Si
			                        </label>
			                        <label class="btn btn-default <?php if($cembarazo=='No' or $cembarazo==''){ echo active;} ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
			                            <input type="radio" name="cembarazo" value="No" checked=""> No 
			                        </label>
			                    </div>
			                    <input id="cembarazo1" name="cembarazo1" value="<?=$cembarazo?>" type="hidden">
		                      	
			                  </div>

			                  
		                      
		                    </div>

							<input id="nembarazo" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" name="nembarazo" value="<?=$nembarazo?>" placeholder="nembarazo" type="hidden">
		                      
							 <div class="item form-group">
							 <label class="control-label col-md-4 col-sm-4 col-xs-12" for="cfuma">Fuma 
		                      </label>
		                      <div class="col-md-3 col-sm-3 col-xs-12">
			                    <div id="cfuma" class="btn-group" data-toggle="buttons">
			                        <label class="btn btn-default <?php if($cfuma=='Si'){ echo active;} ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
			                            <input type="radio" name="cfuma" value="Si">  Si
			                        </label>
			                        <label class="btn btn-default  <?php if($cfuma=='No' or $cfuma==''){ echo active;} ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
			                            <input type="radio" name="cfuma" value="No" checked=""> No 
			                        </label>
			                    </div>
			                    <input id="cfuma1" name="cfuma1" value="<?=$cfuma?>" type="hidden">
		                      	
			                  </div>

		                      <label class="control-label col-md-2 col-sm-2 col-xs-12" for="ctoma">Toma 
		                      </label>
		                       <div class="col-md-3 col-sm-3 col-xs-12">
			                    <div id="ctoma" class="btn-group" data-toggle="buttons">
			                        <label class="btn btn-default <?php if($ctoma=='Si'){ echo active;} ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
			                            <input type="radio" name="ctoma" value="Si">  Si
			                        </label>
			                        <label class="btn btn-default <?php if($ctoma=='No' or $ctoma==''){ echo active;} ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
			                            <input type="radio" name="ctoma" value="No" checked=""> No 
			                        </label>
			                    </div>
			                    <input id="ctoma1" name="ctoma1" value="<?=$ctoma?>" type="hidden">
		                      	
			                  </div>
		                     
		                    </div>

							<span class="section">Historia Odontológica </span>	 
							 
								
							 <div class="item form-group">
		                      

		                      <div class="col-md-4 col-sm-4 col-xs-12">
									<p>Ha tenido algún tipo de accidentes que involucren fracturas u otro tipo de daño a sus dientes?</p>
							 			                     
			                  </div>
		                      <div class="col-md-3 col-sm-3 col-xs-12">
			                    <div id="cfractura" class="btn-group" data-toggle="buttons">
			                        <label class="btn btn-default <?php if($cfractura=='Si'){ echo active;} ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
			                            <input type="radio" name="cfractura" value="Si">  Si
			                        </label>
			                        <label class="btn btn-default <?php if($cfractura=='No' or $cfractura==''){ echo active;} ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
			                            <input type="radio" name="cfractura" value="No" checked=""> No 
			                        </label>
			                    </div>
			                    <input id="cfractura1" name="cfractura1" value="<?=$cfractura?>" type="hidden">
		                      	
			                  </div>
			                  <div class="col-md-4 col-sm-4 col-xs-12">
									<input id="nfractura" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" name="nfractura" value="<?=$nfractura?>"  type="text">
											                     
			                  </div>
		                      
		                    </div>

							


							<p>Tiene algún hábito como: </p>
								 
							 <div class="item form-group">
		                      <label class="control-label col-md-4 col-sm-4 col-xs-12" for="cchupeteo">Chupeteo de dedo  
		                      </label>
		                       <div class="col-md-3 col-sm-3 col-xs-12">
			                    <div id="cchupeteo" class="btn-group" data-toggle="buttons">
			                        <label class="btn btn-default <?php if($cchupeteo=='Si'){ echo active;} ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
			                            <input type="radio" name="cchupeteo" value="Si">  Si
			                        </label>
			                        <label class="btn btn-default <?php if($cchupeteo=='No' or $cchupeteo==''){ echo active;} ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
			                            <input type="radio" name="cchupeteo" value="No" checked=""> No 
			                        </label>
			                    </div>
			                    <input id="cchupeteo1" name="cchupeteo1" value="<?=$cchupeteo?>" type="hidden">
		                      	
			                  </div>
		                      
		                    </div>

							
								 
							 <div class="item form-group">
		                      <label class="control-label col-md-4 col-sm-4 col-xs-12" for="clabio">Chupeteo labio  
		                      </label>
		                      <div class="col-md-3 col-sm-3 col-xs-12">
			                    <div id="clabio" class="btn-group" data-toggle="buttons">
			                        <label class="btn btn-default <?php if($clabio=='Si'){ echo active;} ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
			                            <input type="radio" name="clabio" value="Si">  Si
			                        </label>
			                        <label class="btn btn-default <?php if($clabio=='No' or $clabio==''){ echo active;} ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
			                            <input type="radio" name="clabio" value="No" checked=""> No 
			                        </label>
			                    </div>
			                    <input id="clabio1" name="clabio1" value="<?=$clabio?>" type="hidden">
		                      	
			                  </div>
		                      
		                    </div>

							
								 
							 <div class="item form-group">
		                      <label class="control-label col-md-4 col-sm-4 col-xs-12" for="csuccion">Succión  o morder   otro tipo de objeto   
		                      </label>

		                      <div class="col-md-3 col-sm-3 col-xs-12">
			                    <div id="csuccion" class="btn-group" data-toggle="buttons">
			                        <label class="btn btn-default <?php if($csuccion=='Si'){ echo active;} ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
			                            <input type="radio" name="csuccion" value="Si">  Si
			                        </label>
			                        <label class="btn btn-default <?php if($csuccion=='No' or $csuccion==''){ echo active;} ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
			                            <input type="radio" name="csuccion" value="No" checked=""> No 
			                        </label>
			                    </div>
			                    <input id="csuccion1" name="csuccion1" value="<?=$csuccion?>" type="hidden">
		                      	
			                  </div>
		                      
		                      
		                    </div>

							
								 
							 <div class="item form-group">
		                      <label class="control-label col-md-4 col-sm-4 col-xs-12" for="cortodoncia">Ha tenido antes  tratamiento de ortodoncia?  
		                      </label>
		                      <div class="col-md-3 col-sm-3 col-xs-12">
			                    <div id="cortodoncia" class="btn-group" data-toggle="buttons">
			                        <label class="btn btn-default <?php if($cortodoncia=='Si'){ echo active;} ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
			                            <input type="radio" name="cortodoncia" value="Si">  Si
			                        </label>
			                        <label class="btn btn-default  <?php if($cortodoncia=='No' or $cortodoncia==''){ echo active;} ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
			                            <input type="radio" name="cortodoncia" value="No" checked=""> No 
			                        </label>
			                    </div>
			                    <input id="cortodoncia1" name="cortodoncia1" value="<?=$cortodoncia?>" type="hidden">
		                      	
			                  </div>
		                      
		                      
		                    </div>

		                    <div class="item form-group">
		                      <label class="control-label col-md-4 col-sm-4 col-xs-12" for="fecha_ult_control">Fecha de último control 
		                      </label>
		                      <div class="col-md-4 col-sm-4 col-xs-12">
		                        <input id="fecha_ult_control" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" name="fecha_ult_control" value="<?=$fecha_ult_control?>" type="text">
		                      </div>
		                    </div>

                    </div>
                  </div>

                  <!-- End SmartWizard Content -->
													
							 					
													
								<div class="ln_solid"></div>
				                    <div class="form-group">
				                      <div class="col-md-6 col-md-offset-3">
				                        <input type="button" onClick="cancelar();" class="btn btn-primary" value="Cancelar">
				                        <!-- <button  id="send" class="btn btn-success">Guardar</button> -->
				                      </div>
				                    </div>
				                  </form>
									
								
                     
                    
                  </div>


                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- footer content -->
         <? include "pie.php"; ?>
        <!-- /footer content -->

      </div>
      <!-- /page content -->
    </div>

  </div>

  <div id="custom_notifications" class="custom-notifications dsp_none">
    <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
    </ul>
    <div class="clearfix"></div>
    <div id="notif-group" class="tabbed_notifications"></div>
  </div>

  <script src="js/bootstrap.min.js"></script>

  <!-- bootstrap progress js -->
  <script src="js/progressbar/bootstrap-progressbar.min.js"></script>
  <script src="js/nicescroll/jquery.nicescroll.min.js"></script>
  <!-- icheck -->
  <script src="js/icheck/icheck.min.js"></script>
  <!-- pace -->
  <script src="js/pace/pace.min.js"></script>
  <script src="js/custom.js"></script>
  <!-- form validation -->
  <script src="js/validator/validator.js"></script>
  <!-- PNotify -->
  <script type="text/javascript" src="js/notify/pnotify.core.js"></script>
  
 <!-- input mask -->
  <script src="js/input_mask/jquery.inputmask.js"></script>
    
<!-- form wizard -->
  <script type="text/javascript" src="js/wizard/jquery.smartWizard.js"></script>
  
  <script>
    // initialize the validator function
    validator.message['date'] = 'not a real date';

    // validate a field on "blur" event, a 'select' on 'change' event & a '.reuired' classed multifield on 'keyup':
    $('form')
      .on('blur', 'input[required], input.optional, select.required', validator.checkField)
      .on('change', 'select.required', validator.checkField)
      .on('keypress', 'input[required][pattern]', validator.keypress);

    $('.multi.required')
      .on('keyup blur', 'input', function() {
        validator.checkField.apply($(this).siblings().last()[0]);
      });

    // bind the validation to the form submit event
    //$('#send').click('submit');//.prop('disabled', true);

    $('form').submit(function(e) {
      e.preventDefault();
      var submit = true;

      
      // evaluate the form using generic validaing
      if (!validator.checkAll($(this))) {
        submit = false;
      }

      if (submit)
        guardarformulario();
      return false;
    });

    /* FOR DEMO ONLY */
    $('#vfields').change(function() {
      $('form').toggleClass('mode2');
    }).prop('checked', false);

    $('#alerts').change(function() {
      validator.defaults.alerts = (this.checked) ? false : true;
      if (this.checked)
        $('form .alert').remove();
    }).prop('checked', false);
  </script>
  <!-- pace -->
        <script src="js/pace/pace.min.js"></script>
        
         <script type="text/javascript">
          $(document).ready(function() {
          	// Smart Wizard
		      $('#wizard_verticle').smartWizard({
		        transitionEffect: 'slide'
		      });
            
          });
          
        </script>
        <!-- input_mask -->
  <script>
    $(document).ready(function() {
      $(":input").inputmask();

      $('#fecha_nac').change(function(){

      	fnac = $('#fecha_nac').val();
      	fecha = new Date(fnac);
		hoy = new Date();
		ed = parseInt((hoy - fecha)/365/24/60/60/1000);

		$('#edad').val(ed);
		
      });

      $('#gender').change(function(){
      	var valor = $("input:radio[name ='gender']:checked").val();
		$('#genero').val(valor);
      });
      $('#cenfermedad').change(function(){
      	var valor = $("input:radio[name ='cenfermedad']:checked").val();
		$('#cenfermedad1').val(valor);
      });
      $('#cmedicamento').change(function(){
      	var valor = $("input:radio[name ='cmedicamento']:checked").val();
		$('#cmedicamento1').val(valor);
      });
      $('#calergia').change(function(){
      	var valor = $("input:radio[name ='calergia']:checked").val();
		$('#calergia1').val(valor);
      });
      $('#cdesmayos').change(function(){
      	var valor = $("input:radio[name ='cdesmayos']:checked").val();
		$('#cdesmayos1').val(valor);
      });
      $('#cpresion').change(function(){
      	var valor = $("input:radio[name ='cpresion']:checked").val();
		$('#cpresion1').val(valor);
      });
      $('#cembarazo').change(function(){
      	var valor = $("input:radio[name ='cembarazo']:checked").val();
		$('#cembarazo1').val(valor);
      });
      $('#cfuma').change(function(){
      	var valor = $("input:radio[name ='cfuma']:checked").val();
		$('#cfuma1').val(valor);
      });
      $('#ctoma').change(function(){
      	var valor = $("input:radio[name ='ctoma']:checked").val();
		$('#ctoma1').val(valor);
      });
      $('#cdiabetes').change(function(){
      	var valor = $("input:radio[name ='cdiabetes']:checked").val();
		$('#cdiabetes1').val(valor);
      });
      $('#cartritis').change(function(){
      	var valor = $("input:radio[name ='cartritis']:checked").val();
		$('#cartritis1').val(valor);
      });
      $('#chepatitis').change(function(){
      	var valor = $("input:radio[name ='chepatitis']:checked").val();
		$('#chepatitis1').val(valor);
      });
      $('#cfractura').change(function(){
      	var valor = $("input:radio[name ='cfractura']:checked").val();
		$('#cfractura1').val(valor);
      });
      $('#cchupeteo').change(function(){
      	var valor = $("input:radio[name ='cchupeteo']:checked").val();
		$('#cchupeteo1').val(valor);
      });
      $('#clabio').change(function(){
      	var valor = $("input:radio[name ='clabio']:checked").val();
		$('#clabio1').val(valor);
      });
      $('#csuccion').change(function(){
      	var valor = $("input:radio[name ='csuccion']:checked").val();
		$('#csuccion1').val(valor);
      });
      $('#cortodoncia').change(function(){
      	var valor = $("input:radio[name ='cortodoncia']:checked").val();
		$('#cortodoncia1').val(valor);
      });
      

      $('#imagenS').change(function() {
                var filename = $(this).val();
                var lastIndex = filename.lastIndexOf("\\");
                if (lastIndex >= 0) {
                    filename = filename.substring(lastIndex + 1);
                } 
                $('#img').val(filename);
            });
    });
  </script>
  <!-- /input mask -->
</body>

</html>

