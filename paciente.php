		<?php 
		include 'data/dataBase.php';
		include 'classes/cpaciente.php';
		include 'classes/cUsuario.php';	
		$oUser 	= new Usuario();
			
		if ( !$oUser->verSession() ) {
			header("Location: login.php");
			exit();
		}
		$opaciente = new paciente();
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
		}else{
			header("Location: paciente.php");
			exit();
		}
	}
  $vpaciente 		= $opaciente->getAll();
  
?>
<!DOCTYPE HTML><html>
<head>
 	 <?php include 'header.php'; ?>

		<script type="text/javascript">	
			
			function guardarformulario(){
				
				var form = $("#form").serializeJSON(); 
				$.ajax({
					url:'actions/actionpaciente.php',
					type:'POST',
					data: { valor: form, }
				}).done(function( data ){
					
					if(data == 0){
						new PNotify({
		                 	title: 'Datos Guardados',
			                text: 'Todos los datos fueron guardados. Puede continuar.',
			                type: 'success'
			             });
            
						window.setTimeout("document.location.href='paciente.php';",2500);
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
				window.setTimeout("document.location.href='paciente.php';",500);

			}
			function eliminar(id) {
				
					if (confirm("Atencion! Va a proceder eliminar este registro. Desea continuar?")) {
						var form = "valor"; 
						$.ajax({
							url: 'actions/actionpaciente.php?opt=epaciente&id='+id,
							type:'POST',
							data: { valor: form, }
						}).done(function( data ){
							
							if(data == 0){
								new PNotify({
				                   title: 'Datos Eliminados',
				                    text: 'Todos los datos fueron guardados. Puede continuar.!',
				                    type: 'success'
				                  });
							window.setTimeout("document.location.href='paciente.php';",2500);
							}
							else if(data == 1){
								msg = "Error en idpaciente.";
								showWarning(msg,5000);
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
                <div class="x_title">
                  <h2>Administración de paciente</h2>
                    
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">

                

                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
                    <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                      <li id="tab1" role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Listado</a>
                      </li>
                      <li id="tab2" role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false"><?=$accion;?> paciente</a>
                      </li>
                      
                    </ul>
                    <div id="myTabContent" class="tab-content">
                      <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
                        
                        <!-- tab 1 -->
                        <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                          <div class="x_title">
                            <h2>paciente Registrados  </h2>
                            
                            <div class="clearfix"></div>
                          </div>
                          <div class="x_content">
                            <p class="text-muted font-13 m-b-30">
                              Listado de todos los paciente registrados</p>
                            <table id="datatable-buttons" class="table table-striped table-bordered">
                              <thead>
											      <tr>
											        <th>idpaciente</th>
												        <th>nombre</th>
												        <th>apellido</th>
												        <th>identificacion</th>
												        <th>genero</th>
												        <th>direccion</th>
												        <th>telefono1</th>
												        <th>telefono2</th>
												        <th>correo</th>
												        <th>notas</th>
												        <th>idestado</th>
												        
												        
											         <th>Opciones</th>
											      </tr>
											    </thead>
											    <tbody>
													<?php
													if($vpaciente){
														foreach ($vpaciente AS $id => $array) {
													?>
														<tr><td align="left"><?=$array['idpaciente'];?></td>
															<td align="left"><?=$array['nombre'];?></td>
															<td align="left"><?=$array['apellido'];?></td>
															<td align="left"><?=$array['identificacion'];?></td>
															<td align="left"><?=$array['genero'];?></td>
															<td align="left"><?=$array['direccion'];?></td>
															<td align="left"><?=$array['telefono1'];?></td>
															<td align="left"><?=$array['telefono2'];?></td>
															<td align="left"><?=$array['correo'];?></td>
															<td align="left"><?=$array['idestado'];?></td>
																
														<td>
															
																	<a href="paciente.php?opt=mpaciente&id=<?=$id;?>" title="Modificar" >
																		<span class="label label-primary" >
																			<i class="fa fa-pencil" title="Modificar"></i>
																		</span>
																	</a>
																	<?php 
																		if($array['idestado']==1){
																	?>
																			<a href="#" id="opt=bpaciente&id=<?=$id?>" class="actiones" data-action="actionpaciente.php" data-tittle="Deshabilitar" data-msg="¿Esta seguro que desea deshabilitar este registro?" name="" title="Deshabilitar">
																				<img src="img/icon_delete.png">
																			</a>
																	<?php
																		}elseif($array['idestado']==2){
																	?>
																			<a href="#" id="opt=hpaciente&id=<?=$id?>" class="actiones" data-action="actionpaciente.php" data-tittle="Habilitar" data-msg="¿Desea habilitar este registro?" name="" title="Habilitar">
																				<img src="img/checkmark2.png" >
																			</a>
																	<?php
																	}
																	?>
																	 
																	<span class="label label-default" onClick="eliminar(<?=$id?>)" >
																		<i class="fa fa-trash-o" title="Eliminar"></i>	
																
																	</span>	
																	
															</td>										
																
														</tr>
													<?php
														}
													}	
													?>
												</tbody>
											  </table>
						                	
						                	</div>
                        </div>
                      </div>

                      </div>
                      <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
                        
                        <form id="form" class="form-horizontal form-label-left" novalidate>
                    <p>Ingrese la información en la casilla correspondiente  
                    </p><span class="section">Ingresar Informacion</span>

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
                    
                     		 <h2>Example: Vertical Style</h2>
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
		                        <input id="nombre" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" name="nombre" value="<?=$nombre?>" placeholder="nombre" required="required" type="text">
		                      </div>
		                    </div>

							
								 
							 <div class="item form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="apellido">apellido <span class="required">*</span>
		                      </label>
		                      <div class="col-md-6 col-sm-6 col-xs-12">
		                        <input id="apellido" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" name="apellido" value="<?=$apellido?>" placeholder="apellido" required="required" type="text">
		                      </div>
		                    </div>

							
								 
							 <div class="item form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="identificacion">identificacion 
		                      </label>
		                      <div class="col-md-6 col-sm-6 col-xs-12">
		                        <input id="identificacion" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" name="identificacion" value="<?=$identificacion?>"  type="text">
		                      </div>
		                    </div>

							
								 
							 <div class="item form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="genero">genero <span class="required">*</span>
		                      </label>
		                      <div class="col-md-6 col-sm-6 col-xs-12">
		                        <input id="genero" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" name="genero" value="<?=$genero?>" placeholder="genero" required="required" type="text">
		                      </div>
		                    </div>

							                         
                        	<div class="item form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="fecha_nac">Fecha de Nacimiento <span class="required">*</span>
		                      </label>
		                      <div class="col-md-6 col-sm-6 col-xs-12">
		                        <input id="fecha_nac" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" name="fecha_nac" value="<?=$fecha_nac?>" placeholder="fecha_nac" required="required" type="text">
		                      </div>
		                    </div>

		                    <div class="item form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ocupacion">ocupacion 
		                      </label>
		                      <div class="col-md-6 col-sm-6 col-xs-12">
		                        <input id="ocupacion" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" name="ocupacion" value="<?=$ocupacion?>"  type="text">
		                      </div>
		                    </div>

                      
                    </div>
                    <div id="step-22">
                      <h2 class="StepTitle">Paso 2 </h2>
                      <span class="section">Datos de contacto </span>

							 <div class="item form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="direccion">direccion <span class="required">*</span>
		                      </label>
		                      <div class="col-md-6 col-sm-6 col-xs-12">
		                        <input id="direccion" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" name="direccion" value="<?=$direccion?>" placeholder="direccion" required="required" type="text">
		                      </div>
		                    </div>

		                    <div class="item form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="iddepartamento">iddepartamento <span class="required">*</span>
		                      </label>
		                      <div class="col-md-6 col-sm-6 col-xs-12">
		                        <input id="iddepartamento" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" name="iddepartamento" value="<?=$iddepartamento?>" placeholder="iddepartamento" required="required" type="text">
		                      </div>
		                    </div>
							
								 
							 <div class="item form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="telefono1">telefono1 <span class="required">*</span>
		                      </label>
		                      <div class="col-md-6 col-sm-6 col-xs-12">
		                        <input id="telefono1" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" name="telefono1" value="<?=$telefono1?>" placeholder="telefono1" required="required" type="text">
		                      </div>
		                    </div>

							
								 
							 <div class="item form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="telefono2">telefono2 <span class="required">*</span>
		                      </label>
		                      <div class="col-md-6 col-sm-6 col-xs-12">
		                        <input id="telefono2" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" name="telefono2" value="<?=$telefono2?>" placeholder="telefono2" required="required" type="text">
		                      </div>
		                    </div>

							
								 
							 <div class="item form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="correo">correo <span class="required">*</span>
		                      </label>
		                      <div class="col-md-6 col-sm-6 col-xs-12">
		                        <input id="correo" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" name="correo" value="<?=$correo?>" placeholder="correo" required="required" type="text">
		                      </div>
		                    </div>
                      
                    </div>
                    <div id="step-33">
                      <h2 class="StepTitle">Paso 3 </h2>
                      		 <div class="item form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="responsable">responsable <span class="required">*</span>
		                      </label>
		                      <div class="col-md-6 col-sm-6 col-xs-12">
		                        <input id="responsable" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" name="responsable" value="<?=$responsable?>" placeholder="responsable" required="required" type="text">
		                      </div>
		                    </div>

							
								 
							 <div class="item form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="telefono_resp">telefono_resp <span class="required">*</span>
		                      </label>
		                      <div class="col-md-6 col-sm-6 col-xs-12">
		                        <input id="telefono_resp" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" name="telefono_resp" value="<?=$telefono_resp?>" placeholder="telefono_resp" required="required" type="text">
		                      </div>
		                    </div>

							
								 
							 <div class="item form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="medico_fam">medico_fam <span class="required">*</span>
		                      </label>
		                      <div class="col-md-6 col-sm-6 col-xs-12">
		                        <input id="medico_fam" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" name="medico_fam" value="<?=$medico_fam?>" placeholder="medico_fam" required="required" type="text">
		                      </div>
		                    </div>
                    </div>
                    <div id="step-44">
                      <h2 class="StepTitle">Paso 4 </h2>
                      
                      	<div class="item form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="imagen">Foto 
		                      </label>
		                      <div class="col-md-6 col-sm-6 col-xs-12">
		                        <input id="imagen" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" name="imagen" value="<?=$imagen?>"  type="text">
		                      </div>
		                    </div>

		                <div class="item form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="idestado">Estado <span class="required">*</span>
		                      </label>
		                      <div class="col-md-6 col-sm-6 col-xs-12">
		                        <input id="idestado" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" name="idestado" value="<?=$idestado?>" placeholder="idestado" required="required" type="text">
		                      </div>
		                    </div>


                      	<div class="item form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="notas">Notas 
		                      </label>
		                      <div class="col-md-6 col-sm-6 col-xs-12">
		                        <input id="notas" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" name="notas" value="<?=$notas?>" type="text">
		                      </div>
		                </div>

		                <div class="item form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="fecha_cre">Fecha de Alta 
		                      </label>
		                      <div class="col-md-6 col-sm-6 col-xs-12">
		                        <input id="fecha_cre" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" name="fecha_cre" value="<?=$fecha_cre?>" placeholder="fecha_cre"  type="text">
		                      </div>
		                    </div>

                    </div>
                  </div>

                  <!-- End SmartWizard Content -->
													
							 					
													
								<div class="ln_solid"></div>
				                    <div class="form-group">
				                      <div class="col-md-6 col-md-offset-3">
				                        <input type="button" onClick="cancelar();" class="btn btn-primary" value="Cancelar">
				                        <button  id="send" class="btn btn-success">Guardar</button>
				                      </div>
				                    </div>
				                  </form>
									
								</div>
                     
                    </div>
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
  
   <!-- Datatables-->
        <script src="js/datatables/jquery.dataTables.min.js"></script>
        <script src="js/datatables/dataTables.bootstrap.js"></script>
        <script src="js/datatables/dataTables.buttons.min.js"></script>
        <script src="js/datatables/buttons.bootstrap.min.js"></script>
        <script src="js/datatables/jszip.min.js"></script>
        <script src="js/datatables/pdfmake.min.js"></script>
        <script src="js/datatables/vfs_fonts.js"></script>
        <script src="js/datatables/buttons.html5.min.js"></script>
        <script src="js/datatables/buttons.print.min.js"></script>
        <script src="js/datatables/dataTables.fixedHeader.min.js"></script>
        <script src="js/datatables/dataTables.responsive.min.js"></script>
        <script src="js/datatables/responsive.bootstrap.min.js"></script>
        <script src="js/datatables/dataTables.scroller.min.js"></script>

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
        <script>
          var handleDataTableButtons = function() {
              "use strict";
              0 !== $("#datatable-buttons").length && $("#datatable-buttons").DataTable({
                dom: "Bfrtip",
                buttons: [{
                  extend: "csv",
                  className: "btn-sm"
                }, {
                  extend: "excel",
                  className: "btn-sm"
                }, {
                  extend: "pdf",
                  className: "btn-sm"
                }, {
                  extend: "print",
                  className: "btn-sm"
                }],
                responsive: !0
              })
            },
            TableManageButtons = function() {
              "use strict";
              return {
                init: function() {
                  handleDataTableButtons()
                }
              }
            }();
        </script>
         <script type="text/javascript">
          $(document).ready(function() {
          	// Smart Wizard
		      $('#wizard_verticle').smartWizard({
		        transitionEffect: 'slide'
		      });
            <?php
              if($option == "m"){
            ?>
                $("#tab1").removeClass('active');
                $("#tab2").addClass('active');
                $("#tab_content1").removeClass('active in');
                $("#tab_content2").addClass('active in');
                
            <? } ?>

            $('#datatable').dataTable();
            $('#datatable-keytable').DataTable({
              keys: true
            });
            $('#datatable-responsive').DataTable();
            
            var table = $('#datatable-fixed-header').DataTable({
              fixedHeader: true
            });
          });
          TableManageButtons.init();
        </script>
</body>

</html>

