<?php 
    include 'data/dataBase.php';
    include 'classes/cUsuario.php';
    include 'classes/ctipoUsuario.php';
    include 'classes/cclinica.php';
    
    $oUser  = new Usuario();
    $oTipo  = new tipoUsuario();
    $oClinica  = new clinica();
      
    if ( !$oUser->verSession() ) {
      header("Location: login.php");
      exit();
    }
    $accion   = "Crear";
    $option   = "n";
    $vUser    = "";
    $vTipo    = "";

    //valores 
    $nombre     = "";
    $apellido   = "";
    $usuario   = "";
    $imagen   = "user.png";
    
    if(isset($_REQUEST['opt']) && $_REQUEST['opt']== "m"){
      $option = $_REQUEST['opt'];
      $idObj  = $_REQUEST['id'];
    }

    if ($option == "m") {
      $vUser = $oUser->getOne($idObj);
      if($vUser){
        $accion   = "Modificar";
        
           foreach ($vUser AS $id => $info){ 
              $idusuario    =      $info["idusuario"];
              $nombre       = $info["nombre"];
              $apellido       = $info["apellido"];
              $usuario       = $info["usuario"];
              $imagen       = $info["imagen"];
              $telefono       = $info["telefono"];
              $correo       = $info["correo"];
              $notas       = $info["notas"];
              $idtipoUsuario  = $info["idtipoUsuario"];
              $idclinica  = $info["idclinica"];

            }
      }else{
        header("Location: fusuario.php");
        exit();
      }
    }

    if($_SESSION['csmart']['tipo']=='1'){
      $vUser     = $oUser->getAll();
    
    }else{
      $vUser     = $oUser->getAllxClinica($_SESSION['csmart']['clinica']);
    
    }
    $vTipo     = $oTipo->getAll();    
    $vClinica     = $oClinica->getAll();

 ?>  

 <!DOCTYPE html>
<html >

<head>
  
  <?php include "header.php";?>
  <!--[if lt IE 9]>
        <script src="../assets/js/ie8-responsive-file-warning.js"></script>
        <![endif]-->

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
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
          url:'actions/actionUsuario.php',
          type:'POST',
          data: { valor: form }
        }).done(function( data ){
          
          var carp = data;
          if(data > 0){
            $.ajax({
                      url: 'processUpload.php?id='+data + '&tipo=usuario', // point to server-side PHP script 
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
            window.setTimeout("document.location.href='fusuario.php';",2500);
            
          }else{
            new PNotify({
                 title: 'Error en datos',
                text: 'Falta información!'
             });
          }
          
        });
      }

      function cancelar(){
        window.setTimeout("document.location.href='fusuario.php';",500);

      }

      function eliminar(id) {
        
          if (confirm("Atención! Va a proceder a eliminar este registro. Desea continuar?")) {
            var form = "valor"; 
            $.ajax({
              url: 'actions/actionUsuario.php?opt=e&id='+id,
              type:'POST',
              data: { valor: form, }
            }).done(function( data ){
              
              if(data == 0){
                  new PNotify({
                   title: 'Datos Eliminados',
                    text: 'Todos los datos fueron guardados. Puede continuar.!',
                    type: 'success'
                  });
              window.setTimeout("document.location.href='fusuario.php';",2500);
              }
              else if(data == 1){
                msg = "Error en idTipoCliente.";
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
                  <h2>Administración de Usuarios</h2>
                    
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">

                

                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
                    <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                      <li id="tab1" role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Listado</a>
                      </li>
                      <li id="tab2" role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false"><?=$accion;?> Usuarios</a>
                      </li>
                      
                    </ul>
                    <div id="myTabContent" class="tab-content">
                      <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
                        
                        <!-- tab 1 -->
                        <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                          <div class="x_title">
                            <h2>Usuarios Registrados  </h2>
                            
                            <div class="clearfix"></div>
                          </div>
                          <div class="x_content">
                            <p class="text-muted font-13 m-b-30">
                              Listado de todos los usuarios registrados</p>
                            <table id="datatable-buttons" class="table table-striped table-bordered">
                              <thead>
                                <tr>
                                  <th>#</th>
                                  <th>Nombre</th>
                                  <th>Apellido</th>
                                  <th>Usuario</th>
                                  <th>Tipo</th>
                                  <th>Opciones</th>
                                  
                                </tr>
                              </thead>

                              <tbody>
                                <?php
                                    if($vUser){
                                      $i=1;
                                      foreach ($vUser AS $id => $array) {
                                    ?>
                                      <tr>
                                        <td align="left"><?=$i;?></td>
                                        <td align="left"><?=$array['nombre'];?></td>
                                        <td align="left"><?=$array['apellido'];?></td>
                                        <td align="left"><?=$array['usuario'];?></td>
                                        <td align="left"><?=$array['tipo'];?></td>
                                        <td>
                                          <a href="fusuario.php?opt=m&id=<?=$id;?>" title="Modificar" >
                                              <span class="label label-primary" >
                                                <i class="fa fa-pencil" title="Modificar"></i>
                                              </span>
                                          </a>
                                          &nbsp;
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
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">
                      </label>
                      <div class="col-md-5">
                          <?php if ($option == "n") { ?>
                            <img src="images/user.png" alt="" class="img-circle img-responsive">
                          <?php }else{ ?>
                            <img src="images/usuario/<?=$idusuario?>/<?=$imagen?>" alt="" class="img-circle img-responsive">
                         <?php } ?>
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
                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Nombre <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="name" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" name="name" value="<?=$nombre?>" placeholder="nombre" required="required" type="text">
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
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="usuario">Usuario <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="usuario" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" name="usuario" value="<?=$usuario?>" placeholder="jcastro" required="required" type="text">
                      </div>
                    </div>
                    
                    <div class="item form-group">
                      <label for="password" class="control-label col-md-3 col-sm-3 col-xs-12">Clave</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="clave" type="password" name="clave" data-validate-length="6,8" class="form-control col-md-7 col-xs-12" required="required">
                      </div>
                    </div>
                    <div class="item form-group">
                      <label for="password2" class="control-label col-md-3 col-sm-3 col-xs-12">Repetir clave</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="password2" type="password" name="password2" data-validate-linked="clave" class="form-control col-md-7 col-xs-12" required="required">
                      </div>
                    </div>
                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="correo">Email <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="email" id="correo" name="correo" required="required" value="<?=$correo?>" class="form-control col-md-7 col-xs-12">
                      </div>
                    </div>
                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="telephone">Telefono <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="tel" id="telefono" name="telefono" required="required" value="<?=$telefono?>" data-validate-length-range="8,20" class="form-control col-md-7 col-xs-12">
                      </div>
                    </div>

                    <?php if($_SESSION['csmart']['clinica']==1){ ?>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Clinica <span class="required">*</span></label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <select id="idclinica" name="idclinica" class="form-control" disabled>
                          <option>Elegir una opción</option>
                          <?php if($vClinica){
                                foreach ($vClinica AS $id => $array) {?>

                                <option value="<?=$array['idclinica'];?>"  <?php if($_SESSION['csmart']['clinica']==$id){echo"selected='selected'";}?>><?=$array['nombre'];?></option>
                          <?php } } ?>
                        </select>
                      </div>
                    </div>

                    <?php }else{ ?>

                      <input type="hidden" name="idclinica" id="idclinica" value="<?=$_SESSION['csmart']['clinica'];?>" />

                    <?php } ?>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Tipo de Usuario <span class="required">*</span></label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <select id="idtipoUsuario" name="idtipoUsuario" class="form-control">
                          <option>Elegir una opción</option>
                          <?php if($vTipo){
                                foreach ($vTipo AS $id => $array) {?>

                                <option value="<?=$array['idtipoUsuario'];?>" <?php if($idtipoUsuario==$id){echo"selected='selected'";}?>><?=$array['nombre'];?></option>
                          <?php } } ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Estado <span class="required">*</span></label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <select id="idestado" name="idestado" class="form-control">
                          <option>Elegir una opción</option>
                          <option value="1" <?php if($idestado==1){echo"selected='selected'";}?>>Activo</option>
                          <option value="0" <?php if($idestado==0){echo"selected='selected'";}?>>Inactivo</option>
                          
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
