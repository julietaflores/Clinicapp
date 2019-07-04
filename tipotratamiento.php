		<?php 
		include 'data/dataBase.php';
		include 'classes/ctipoTratamiento.php';
		include 'classes/cUsuario.php';
		
		$oUser 	= new Usuario();
			
		if ( !$oUser->verSession() ) {
			header("Location: login.php");
			exit();
		}
		$otipoTratamiento = new tipoTratamiento();
		$accion 	= "Crear";
		$option 	= "n";
		$idtipoTratamiento 	= "";
	        $tipoTratamiento 	= "";
	        $idestado 	= "";
	        
	    if(isset($_REQUEST['opt']) && $_REQUEST['opt']== "m"){
		$option = $_REQUEST['opt'];
		$idObj	= $_REQUEST['id'];
	}

	if ($option == "m") {
		$vtipoTratamiento = $otipoTratamiento->getOne($idObj);
		if($vtipoTratamiento){
			$accion 	= "Modificar";
			
			   foreach ($vtipoTratamiento AS $id => $info){ 
			   	  
			   	  $idtipoTratamiento		= $info["idtipoTratamiento"];
		        $tipoTratamiento		= $info["tipoTratamiento"];
		        $idestado		= $info["idestado"];
		         }
		}else{
			header("Location: tipoTratamiento.php");
			exit();
		}
	}
  $vtipoTratamiento 		= $otipoTratamiento->getAll();
  
?>
<!DOCTYPE HTML><html>
<head>
 	 <?php include 'header.php'; ?>

		<script type="text/javascript">	
			
			function guardarformulario(){
				
				var form = $("#form").serializeJSON(); 
				$.ajax({
					url:'actions/actiontipoTratamiento.php',
					type:'POST',
					data: { valor: form, }
				}).done(function( data ){
					
					if(data == 0){
						new PNotify({
		                 	title: 'Datos Guardados',
			                text: 'Todos los datos fueron guardados. Puede continuar.',
			                type: 'success'
			             });
            
						window.setTimeout("document.location.href='tipoTratamiento.php';",2500);
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
				window.setTimeout("document.location.href='tipoTratamiento.php';",500);

			}
			function eliminar(id) {
				
					if (confirm("Atencion! Va a proceder eliminar este registro. Desea continuar?")) {
						var form = "valor"; 
						$.ajax({
							url: 'actions/actiontipoTratamiento.php?opt=etipoTratamiento&id='+id,
							type:'POST',
							data: { valor: form, }
						}).done(function( data ){
							
							if(data == 0){
								new PNotify({
				                   title: 'Datos Eliminados',
				                    text: 'Todos los datos fueron guardados. Puede continuar.!',
				                    type: 'success'
				                  });
							window.setTimeout("document.location.href='tipoTratamiento.php';",2500);
							}
							else if(data == 1){
								msg = "Error en idtipoTratamiento.";
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
                  <h2>Administración de tipoTratamiento</h2>
                    
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">

                

                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
                    <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                      <li id="tab1" role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Listado</a>
                      </li>
                      <li id="tab2" role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false"><?=$accion;?> tipoTratamiento</a>
                      </li>
                      
                    </ul>
                    <div id="myTabContent" class="tab-content">
                      <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
                        
                        <!-- tab 1 -->
                        <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                          <div class="x_title">
                            <h2>tipoTratamiento Registrados  </h2>
                            
                            <div class="clearfix"></div>
                          </div>
                          <div class="x_content">
                            <p class="text-muted font-13 m-b-30">
                              Listado de todos los tipoTratamiento registrados</p>
                            <table id="datatable-buttons" class="table table-striped table-bordered">
                              <thead>
											      <tr>
											        <th>idtipoTratamiento</th>
												        <th>tipoTratamiento</th>
												        <th>idestado</th>
												        
											         <th>Opciones</th>
											      </tr>
											    </thead>
											    <tbody>
													<?php
													if($vtipoTratamiento){
														foreach ($vtipoTratamiento AS $id => $array) {
													?>
														<tr><td align="left"><?=$array['idtipoTratamiento'];?></td>
															<td align="left"><?=$array['tipoTratamiento'];?></td>
															<td align="left"><?=$array['idestado'];?></td>
																
														<td>
															
																	<a href="tipoTratamiento.php?opt=mtipoTratamiento&id=<?=$id;?>" title="Modificar" >
																		<span class="label label-primary" >
																			<i class="fa fa-pencil" title="Modificar"></i>
																		</span>
																	</a>
																	<?php 
																		if($array['idestado']==1){
																	?>
																			<a href="#" id="opt=btipoTratamiento&id=<?=$id?>" class="actiones" data-action="actiontipoTratamiento.php" data-tittle="Deshabilitar" data-msg="¿Esta seguro que desea deshabilitar este registro?" name="" title="Deshabilitar">
																				<img src="img/icon_delete.png">
																			</a>
																	<?php
																		}elseif($array['idestado']==2){
																	?>
																			<a href="#" id="opt=htipoTratamiento&id=<?=$id?>" class="actiones" data-action="actiontipoTratamiento.php" data-tittle="Habilitar" data-msg="¿Desea habilitar este registro?" name="" title="Habilitar">
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
                            <input type="hidden" name="idusuario" value="<?=$idusuario?>"/>
                            <input type="hidden" name="opt" id="opt" value="m" />
                        <?php
                          }else{
                        ?>
                            <input type="hidden" name="opt" id="opt" value="n" />
                        <?php
                          }
                        ?>
                    
                   
													
							 <div class="item form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="idtipoTratamiento">idtipoTratamiento <span class="required">*</span>
		                      </label>
		                      <div class="col-md-6 col-sm-6 col-xs-12">
		                        <input id="idtipoTratamiento" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" name="idtipoTratamiento" value="<?=$idtipoTratamiento?>" placeholder="idtipoTratamiento" required="required" type="text">
		                      </div>
		                    </div>

							
								 
							 <div class="item form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tipoTratamiento">tipoTratamiento <span class="required">*</span>
		                      </label>
		                      <div class="col-md-6 col-sm-6 col-xs-12">
		                        <input id="tipoTratamiento" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" name="tipoTratamiento" value="<?=$tipoTratamiento?>" placeholder="tipoTratamiento" required="required" type="text">
		                      </div>
		                    </div>

							
								 
							 <div class="item form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="idestado">idestado <span class="required">*</span>
		                      </label>
		                      <div class="col-md-6 col-sm-6 col-xs-12">
		                        <input id="idestado" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" name="idestado" value="<?=$idestado?>" placeholder="idestado" required="required" type="text">
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

