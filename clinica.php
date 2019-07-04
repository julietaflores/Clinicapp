	<?php 
		include 'data/dataBase.php';
		include 'classes/cclinica.php';
		include 'classes/cUsuario.php';
		
		$oUser 	= new Usuario();
			
		if ( !$oUser->verSession() ) {
			header("Location: login.php");
			exit();
		}
		$oclinica = new clinica();
		$accion 	= "Crear";
		$option 	= "n";
		$idclinica 	= "";
	        $nombre 	= "";
	        $registro 	= "";
	        $direccion 	= "";
	        $telefono1 	= "";
	        $telefono2 	= "";
	        $correo 	= "";
	        $imagen 	= "logo.png";
	        $fecha_val 	= "";
	        $superusuario 	= "";
	        $idestado 	= "";
	        
	    if(isset($_REQUEST['opt']) && $_REQUEST['opt']== "m"){
		$option = $_REQUEST['opt'];
		$idObj	= $_REQUEST['id'];
	}

	if ($option == "m") {
		$vclinica = $oclinica->getOne($idObj);
		if($vclinica){
			$accion 	= "Modificar";
			
			   foreach ($vclinica AS $id => $info){ 
			   	  
			   	  $idclinica		= $info["idclinica"];
		        $nombre		= $info["nombre"];
		        $registro		= $info["registro"];
		        $direccion		= $info["direccion"];
		        $telefono1		= $info["telefono1"];
		        $telefono2		= $info["telefono2"];
		        $correo		= $info["correo"];
		        $imagen		= $info["imagen"];
		        $fecha_val		= $info["fecha_val"];
		        $superusuario		= $info["superusuario"];
		        $idestado		= $info["idestado"];
		         }
		}else{
			header("Location: clinica.php");
			exit();
		}
	}
  $vclinica 		= $oclinica->getAll();
  
?>
<!DOCTYPE HTML><html>
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
				$.ajax({
					url:'actions/actionclinica.php',
					type:'POST',
					data: { valor: form, }
				}).done(function( data ){
					
					if(data > 0){
						$.ajax({
		                      url: 'process/processUpload.php?id='+data + '&tipo=clinica', // point to server-side PHP script 
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
            
						window.setTimeout("document.location.href='clinica.php';",2500);
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
				window.setTimeout("document.location.href='clinica.php';",500);

			}
			function eliminar(id) {
				
					if (confirm("Atencion! Va a proceder eliminar este registro. Desea continuar?")) {
						var form = "valor"; 
						$.ajax({
							url: 'actions/actionclinica.php?opt=e&id='+id,
							type:'POST',
							data: { valor: form, }
						}).done(function( data ){
							
							if(data == 0){
								new PNotify({
				                   title: 'Datos Eliminados',
				                    text: 'Todos los datos fueron guardados. Puede continuar.!',
				                    type: 'success'
				                  });
							window.setTimeout("document.location.href='clinica.php';",2500);
							}
							else if(data == 1){
								msg = "Error en idclinica.";
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
                  <h2>Administración de clinica</h2>
                    
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">

                

                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
                    <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                      <li id="tab1" role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Listado</a>
                      </li>
                      <li id="tab2" role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false"><?=$accion;?> clinica</a>
                      </li>
                      
                    </ul>
                    <div id="myTabContent" class="tab-content">
                      <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
                        
                        <!-- tab 1 -->
                        <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                          <div class="x_title">
                            <h2>clinica Registrados  </h2>
                            
                            <div class="clearfix"></div>
                          </div>
                          <div class="x_content">
                            <p class="text-muted font-13 m-b-30">
                              Listado de todos los clinica registrados</p>
                            <table id="datatable-buttons" class="table table-striped table-bordered">
                              <thead>
											      <tr>
											        <th>#</th>
												        <th>nombre</th>
												        <th>registro</th>
												        <th>direccion</th>
												        <th>telefono1</th>
												        <th>telefono2</th>
												        <th>correo</th>
												        
												        <th>idestado</th>
												        
											         <th>Opciones</th>
											      </tr>
											    </thead>
											    <tbody>
													<?php
													if($vclinica){
														foreach ($vclinica AS $id => $array) {
													?>
														<tr><td align="left"><?=$array['idclinica'];?></td>
															<td align="left"><?=$array['nombre'];?></td>
															<td align="left"><?=$array['registro'];?></td>
															<td align="left"><?=$array['direccion'];?></td>
															<td align="left"><?=$array['telefono1'];?></td>
															<td align="left"><?=$array['telefono2'];?></td>
															<td align="left"><?=$array['correo'];?></td>
															<td align="left"><?=$array['idestado'];?></td>
																
														<td>
															
																	<a href="clinica.php?opt=m&id=<?=$id;?>" title="Modificar" >
																		<span class="label label-primary" >
																			<i class="fa fa-pencil" title="Modificar"></i>
																		</span>
																	</a>
																	<?php 
																		if($array['idestado']==1){
																	?>
																			<a href="#" id="opt=bclinica&id=<?=$id?>" class="actiones" data-action="actionclinica.php" data-tittle="Deshabilitar" data-msg="¿Esta seguro que desea deshabilitar este registro?" name="" title="Deshabilitar">
																				<img src="img/icon_delete.png">
																			</a>
																	<?php
																		}elseif($array['idestado']==2){
																	?>
																			<a href="#" id="opt=hclinica&id=<?=$id?>" class="actiones" data-action="actionclinica.php" data-tittle="Habilitar" data-msg="¿Desea habilitar este registro?" name="" title="Habilitar">
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
                            <input type="hidden" name="idclinica" value="<?=$idclinica?>"/>
                            <input type="hidden" name="opt" id="opt" value="m" />
                        <?php
                          }else{
                        ?>
                            <input type="hidden" name="opt" id="opt" value="n" />
                        <?php
                          }
                        ?>
                    
                   			<div class="item form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">
		                      </label>
		                      <div class="col-md-5">
		                            <img src="images/clinica/<?=$idclinica?>/<?=$imagen?>" alt="" class="img-circle img-responsive">
		                          </div>
		                    </div>

							<div class="item form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="imagen">Logo 
		                      </label>
		                      <div class="col-md-6 col-sm-6 col-xs-12">
		                        <input name="imagenS" class="fileupload " id="imagenS" type="file" />
                        		<input name="img" id="img" type="hidden" value="<?=$imagen?>" />
		                      </div>
		                    </div>

								 
							 <div class="item form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nombre">Nombre <span class="required">*</span>
		                      </label>
		                      <div class="col-md-6 col-sm-6 col-xs-12">
		                        <input id="nombre" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" name="nombre" value="<?=$nombre?>" placeholder="nombre" required="required" type="text">
		                      </div>
		                    </div>

							
								 
							 <div class="item form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="registro"> NIT 
		                      </label>
		                      <div class="col-md-6 col-sm-6 col-xs-12">
		                        <input id="registro" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" name="registro" value="<?=$registro?>"  type="text">
		                      </div>
		                    </div>

							
								 
							 <div class="item form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="direccion">Direccion <span class="required">*</span>
		                      </label>
		                      <div class="col-md-6 col-sm-6 col-xs-12">
		                        <input id="direccion" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" name="direccion" value="<?=$direccion?>" placeholder="direccion" required="required" type="text">
		                      </div>
		                    </div>

							
								 
							 <div class="item form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="telefono1">Telefono  <span class="required">*</span>
		                      </label>
		                      <div class="col-md-6 col-sm-6 col-xs-12">
		                        <input id="telefono1" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" name="telefono1" value="<?=$telefono1?>" placeholder="999-99-999" required="required" type="tel">
		                      </div>
		                    </div>

							
								 
							 <div class="item form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="telefono2">Telefono 2 
		                      </label>
		                      <div class="col-md-6 col-sm-6 col-xs-12">
		                        <input id="telefono2" class="form-control col-md-7 col-xs-12"  name="telefono2" value="<?=$telefono2?>" type="tel">
		                      </div>
		                    </div>

							
								 
							 <div class="item form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="correo">correo <span class="required">*</span>
		                      </label>
		                      <div class="col-md-6 col-sm-6 col-xs-12">
		                        <input id="correo" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" name="correo" value="<?=$correo?>" placeholder="correo" required="required" type="email">
		                      </div>
		                    </div>

				

							
								 
							 <div class="item form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="fecha_val">Fecha validez <span class="required">*</span>
		                      </label>
		                      <div class="col-md-6 col-sm-6 col-xs-12">
		                        <input type="text" class="form-control has-feedback-left" id="fecha_val" name="fecha_val" value="<?=$fecha_val?>" required="required" aria-describedby="fecha_val2">
	                              <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
	                              <span id="fecha_val2" name="fecha_val2" class="sr-only">(success)</span>
		                        </div>
		                    </div>

							
								 
							 	 
							 <div class="form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Estado <span class="required">*</span></label>
		                      <div class="col-md-6 col-sm-6 col-xs-12">
		                        <select id="idestado" name="idestado" class="form-control" required="required">
		                          <option>Elegir una opción</option>
		                          <option value="1" <?php if($idestado==1){echo"selected='selected'";}?>>Activo</option>
		                          <option value="0" <?php if($idestado==0){echo"selected='selected'";}?>>Inactivo</option>
		                          
		                        </select>
		                      </div>
		                    </div>

							
								 
													
													
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
<!-- daterangepicker -->
  <script type="text/javascript" src="js/moment/moment.min.js"></script>
  <script type="text/javascript" src="js/datepicker/daterangepicker.js"></script>
  

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
          	$('#fecha_val').daterangepicker({
		        singleDatePicker: true,
		        calender_style: "picker_3"
		      }, function(start, end, label) {
		        console.log(start.toISOString(), end.toISOString(), label);
		      });
          	$('#imagenS').change(function() {
                var filename = $(this).val();
                var lastIndex = filename.lastIndexOf("\\");
                if (lastIndex >= 0) {
                    filename = filename.substring(lastIndex + 1);
                } 
                $('#img').val(filename);
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

