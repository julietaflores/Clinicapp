		<?php 
		include 'data/dataBase.php';
		include 'classes/cproducto.php';
		include 'classes/cUsuario.php';
		
		$oUser 	= new Usuario();
			
		if ( !$oUser->verSession() ) {
			header("Location: login.php");
			exit();
		}
		$oproducto = new producto();
		$accion 	= "Crear";
		$option 	= "n";
		$idproducto 	= "";
	        $idclinica 	= "";
	        $nombre 	= "";
	        $precio 	= "";
	        $stock 	= "";
	        $idestado 	= "";
	        $fecha 	= "";
	        
	    if(isset($_REQUEST['opt']) && $_REQUEST['opt']== "m"){
		$option = $_REQUEST['opt'];
		$idObj	= $_REQUEST['id'];
	}

	if ($option == "m") {
		$vproducto = $oproducto->getOne($idObj);
		if($vproducto){
			$accion 	= "Modificar";
			
			   foreach ($vproducto AS $id => $info){ 
			   	  
			   	  $idproducto		= $info["idproducto"];
		        $idclinica		= $info["idclinica"];
		        $nombre		= $info["nombre"];
		        $precio		= $info["precio"];
		        $costo 		= $info["costo"];
		        $tipo 		= $info["idtipo"];
		        $stock		= $info["stock"];
		        $idestado		= $info["idestado"];
		        $fecha		= $info["fecha"];
		         }
		}else{
			header("Location: producto.php");
			exit();
		}
	}
  $vproducto 		= $oproducto->getAll($_SESSION['csmart']['clinica']);
  
?>
<!DOCTYPE HTML><html>
<head>
 	 <?php include 'header.php'; ?>

		<script type="text/javascript">	
			
			function guardarformulario(){
				
				var form = $("#form").serializeJSON(); 
				$.ajax({
					url:'actions/actionproducto.php',
					type:'POST',
					data: { valor: form, }
				}).done(function( data ){
					
					if(data == 0){
						new PNotify({
		                 	title: 'Datos Guardados',
			                text: 'Todos los datos fueron guardados. Puede continuar.',
			                type: 'success'
			             });
            
						window.setTimeout("document.location.href='producto.php';",2500);
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
				window.setTimeout("document.location.href='producto.php';",500);

			}
			function eliminar(id) {
				
					if (confirm("Atencion! Va a proceder eliminar este registro. Desea continuar?")) {
						var form = "valor"; 
						$.ajax({
							url: 'actions/actionproducto.php?opt=eproducto&id='+id,
							type:'POST',
							data: { valor: form, }
						}).done(function( data ){
							
							if(data == 0){
								new PNotify({
				                   title: 'Datos Eliminados',
				                    text: 'Todos los datos fueron guardados. Puede continuar.!',
				                    type: 'success'
				                  });
							window.setTimeout("document.location.href='producto.php';",2500);
							}
							else if(data == 1){
								msg = "Error en idproducto.";
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
                  <h2>Administración de productos</h2>
                    
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">

                

                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
                    <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                      <li id="tab1" role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Listado</a>
                      </li>
                      <li id="tab2" role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false"><?=$accion;?> producto</a>
                      </li>
                      
                    </ul>
                    <div id="myTabContent" class="tab-content">
                      <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
                        
                        <!-- tab 1 -->
                        <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                          <div class="x_title">
                            <h2>Productos registrados  </h2>
                            
                            <div class="clearfix"></div>
                          </div>
                          <div class="x_content">
                            <p class="text-muted font-13 m-b-30">
                              Listado de todos los producto registrados</p>
                            <table id="datatable-buttons" class="table table-striped table-bordered">
                              <thead>
											      <tr>
											        <th>#</th>
												        <th>nombre</th>
												        <th>precio</th>
												        <th>stock</th>
												        <th>estado</th>
												       
											         <th>Opciones</th>
											      </tr>
											    </thead>
											    <tbody>
													<?php
													if($vproducto){
														$i=1;
														foreach ($vproducto AS $id => $array) {
													?>
														<tr><td align="left"><?=$i;?></td>
															<td align="left"><?=$array['nombre'];?></td>
															<td align="left"><?=$array['precio'];?></td>
															<td align="left"><?=$array['stock'];?></td>
															<td align="left"><?php if($array['idestado']==1){ ?> <span class="label label-success">Activo</span> 
																			<?php }else{ ?>
																					<span class="label label-warning">Inactivo</span>
																				<?php };?></td>	
														<td>
															
																	<a href="producto.php?opt=m&id=<?=$id;?>" title="Modificar" >
																		<span class="label label-primary" >
																			<i class="fa fa-pencil" title="Modificar"></i>
																		</span>
																	</a>
																																		 
																	<span class="label label-default" onClick="eliminar(<?=$id?>)" >
																		<i class="fa fa-trash-o" title="Eliminar"></i>	
																
																	</span>	
																	
															</td>										
																
														</tr>
													<?php
														$i++;}
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
                            <input type="hidden" name="idproducto" value="<?=$idproducto?>"/>
                            <input type="hidden" name="opt" id="opt" value="m" />
                        <?php
                          }else{
                        ?>
                            <input type="hidden" name="opt" id="opt" value="n" />
                        <?php
                          }
                        ?>
                    						
							 
								 
							

							
								 
							 <div class="item form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nombre">nombre <span class="required">*</span>
		                      </label>
		                      <div class="col-md-6 col-sm-6 col-xs-12">
		                        <input id="nombre" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" name="nombre" value="<?=$nombre?>" required="required" type="text">
		                      </div>
		                    </div>

							
								 
							 

		                    <div class="form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Tipo</label>
		                      <div class="col-md-6 col-sm-6 col-xs-12">
		                        <div id="tipo" class="btn-group" data-toggle="buttons">
		                          
		                          <label class="btn btn-default <?php if($tipo=='1' or $tipo==''){ echo active;} ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
		                            <input type="radio" name="tipo" value="1" >  Producto
		                          </label>
		                          <label class="btn btn-default <?php if($tipo=='2'){ echo active;} ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
		                            <input type="radio" name="tipo" value="2" > Servicio &nbsp;
		                          </label>
								 	
		                         </div>
		                        <input id="idtipo" name="idtipo" value="<?php if($tipo==''){ echo '1';}else{ echo $tipo;}?>" type="hidden">
		                      
		                      </div>
		                    </div>
		                    	 
							 <div class="item form-group">
		                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="precio">Precio Venta<span class="required">*</span>
		                      </label>
		                      <div class="col-md-2 col-sm-2 col-xs-12">
		                        <input id="precio" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" name="precio" value="<?=$precio?>" placeholder="0.00" required="required" type="text">
		                      </div>

		                        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="stock">stock 
		                      </label>
		                      <div class="col-md-2 col-sm-2 col-xs-12">
		                        <input id="stock" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" name="stock" value="<?=$stock?>" placeholder="0" type="text">
		                      </div>


		                    </div>

							
								 
							 <div class="item form-group">
		                     <label class="control-label col-md-3 col-sm-3 col-xs-12" for="costo">Costo <span class="required">*</span>
		                      </label>
		                      <div class="col-md-2 col-sm-2 col-xs-12">
		                        <input id="costo" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" name="costo" value="<?=$costo?>" placeholder="0.00" type="text">
		                      </div>

		                       <label class="control-label col-md-2 col-sm-2 col-xs-12">Estado <span class="required">*</span></label>
		                      <div class="col-md-2 col-sm-2 col-xs-12">
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
          	$('#tipo').change(function(){
		      	var valor = $("input:radio[name ='tipo']:checked").val();
				$('#idtipo').val(valor);
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

