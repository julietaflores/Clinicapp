<?php 
    include 'data/dataBase.php';
    include 'classes/cpaciente.php';
    include 'classes/cUsuario.php';
    include 'classes/ccita.php';
    include 'classes/ctipoLesion.php';
    include 'classes/cpacienteNotas.php';
    include 'classes/clesiones.php';
    
    $oUser  = new Usuario();
    $oCita  = new cita();
    $otipo = new tipoLesion();
    $oNotas = new pacienteNotas();
    $oLesiones = new lesiones();

    if ( !$oUser->verSession() ) {
      header("Location: login.php");
      exit();
    }
    $opaciente = new paciente();
    $accion   = "Crear";
    $option   = "n";
    $idpaciente   = "";
          $nombre   = "";
          $apellido   = "";
          $identificacion   = "";
          $genero   = "";
          $imagen   = "";
          $direccion  = "";
          $telefono1  = "";
          $telefono2  = "";
          $correo   = "";
          $fecha_nac  = "";
          $fecha_mod  = "";
          $fecha_cre  = "";
          $notas  = "";
          $idestado   = "";
          $iddepartamento   = "";
          $responsable  = "";
          $telefono_resp  = "";
          $medico_fam   = "";
          $ocupacion  = "";
          
  if(isset($_REQUEST['id'])){
    $idObj  = $_REQUEST['id'];

    $vpaciente = $opaciente->getOne($idObj);
    if($vpaciente){
      $accion   = "Modificar";
      
         foreach ($vpaciente AS $id => $info){ 
            
            $idpaciente   = $info["idpaciente"];
            $id   = $info["idpaciente"];
            $nombre   = $info["nombre"];
            $apellido   = $info["apellido"];
            $identificacion   = $info["identificacion"];
            $genero   = $info["genero"];
            $imagen   = $info["imagen"];
            $direccion    = $info["direccion"];
            $telefono1    = $info["telefono1"];
            $telefono2    = $info["telefono2"];
            $correo   = $info["correo"];
            $fecha_nac    = $info["fecha_nac"];
            $fecha_mod    = $info["fecha_mod"];
            $fecha_cre    = $info["fecha_cre"];
            $notas    = $info["notas"];
            $idestado   = $info["idestado"];
            $iddepartamento   = $info["iddepartamento"];
            $responsable    = $info["responsable"];
            $telefono_resp    = $info["telefono_resp"];
            $medico_fam   = $info["medico_fam"];
            $ocupacion    = $info["ocupacion"];
             }
       $vcita = $oCita->getAllpaciente($idObj);
    }else{
      header("Location: paciente.php");
      exit();
    }
  }

  $vtipo    = $otipo->getAll();
  $vNotas    = $oNotas->getAll($idpaciente );
  $vLesiones    = $oLesiones->getAll($idpaciente);
  $vGaleria  = $opaciente->getGaleria($idpaciente);
  
  
?>
<!DOCTYPE html>
<html ng-app="clinicapp">

<head>
  <?php include 'header.php'; ?>

  <script type="text/javascript"> 
      
      function subir(id){
        
        var file_data3 = $('#imagenS3').prop('files')[0];   
        var form_data3 = new FormData();                  
        form_data3.append('file', file_data3);
    
        if(file_data3){ // SI EXISTE IMAGEN PARA SUBIR o ACTUALIZAR
              var fsize3 = $('#imagenS3')[0].files[0].size; //get file size
              if(fsize3>548576 ) 
              {
                valido = false;
                new PNotify({
                     title: 'Error en Imagen 3!',
                     text: 'Excede el tamaño máximo permitido. Tamaño permitido menor a 500 Kb.'
                 });
              }
            }
        
        //var form = $("#form").serializeJSON(); 
        var nombre = $("#img3").val();

        $.ajax({
          url:'actions/actionpaciente.php?opt=subir&id='+id + '&nombre=' + nombre,
          type:'POST',
          data: {  }
        }).done(function( data ){
           
          if(data > 0){

            $.ajax({
                          url: 'processUpload.php?id='+id + '&tipo=paciente', // point to server-side PHP script 
                          dataType: 'text',  // what to expect back from the PHP script, if anything
                          cache: false,
                          contentType: false,
                          processData: false,
                          data: form_data3,                         
                          type: 'post',
                          success: function(val){

                            var codigo = $('#newGal').html();
                            $('#newGal').html(codigo + '<div class="col-md-55" id="'+data+'"><div class="thumbnail"><div class="image view-first fotoGal"><img style="width: 100%; display: block;" onclick="onClick(this)" src="images/paciente/'+id+'/'+nombre+'" alt="image" /></div><div class="caption"><p><a href="" onClick="eliminarFoto('+data+','+id+',\''+nombre+'\')"> <i class="fa fa-times"></i></a> '+nombre+'</p></div></div></div>');
                            
                            // new PNotify({
                            //     title: 'Datos Guardados',
                            //     text: 'Todos los datos fueron guardados. Puede continuar.',
                            //     type: 'success'
                            //  });

                            // var codigo = $('#newGal').html();
                            // $('#newGal').html(codigo + '<div class="col-md-55" id="'+data+'"><div class="thumbnail"><div class="image view-first fotoGal"><img style="width: 100%; display: block;" onclick="onClick(this)" src="images/paciente/'+id+'/'+nombre+'" alt="image" /></div><div class="caption"><p><a href="" onClick="eliminarFoto()"> <i class="fa fa-times"></i></a> '+nombre+'</p></div></div></div>');
                              //alert(val); // display response from the PHP script, if any
                          }
                    });
            
            
            //window.setTimeout("document.location.href='pacienteperfil.php?id="+id+"';",2500);
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
      
      function eliminarFoto(id,px,archivo) {
        
          if (confirm("Atencion! Va a proceder eliminar este registro. Desea continuar?")) {
            var form = "valor"; 
            $.ajax({
              url: 'actions/actionpaciente.php?opt=efoto&id='+id+'&px='+px+'&archivo='+archivo,
              type:'POST',
              data: { }
            }).done(function( data ){
              
              if(data == 0){
                $("#gal" + id).html(''); 

                new PNotify({
                           title: 'Datos Eliminados',
                            text: 'Todos los datos fueron guardados. Puede continuar.!',
                            type: 'success'
                          });

              //window.setTimeout("document.location.href='paciente.php';",2500);
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
               // window.setTimeout("location.reload(true);",2500);
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
          <div class="page-title">
            <!-- <div class="title_left">
              <h3>Perfil de Paciente</h3>
            </div> -->

            
          </div>
          <div class="clearfix"></div>

          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Perfil de Paciente {{1+1}}</h2>
                  
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">

                  <div class="col-md-3 col-sm-3 col-xs-12 profile_left">

                    <div class="profile_img">
                        <div class="avatar-view" title="Foto de paciente">
                          <img id="fotoPerfil" src="images/paciente/<?=$idpaciente;?>/<?=$imagen;?>" alt="Avatar">
                          <input type="hidden" id="idpaciente" value="<?=$idpaciente;?>" />
                        </div>
                     

                    </div>
                    <h3><?=$nombre.' '.$apellido;?></h3>

                    <ul class="list-unstyled user_data">
                      <li><i class="fa fa-map-marker user-profile-icon"></i> <?=$direccion;?>
                      </li>

                      <li>
                        <i class="fa fa-briefcase user-profile-icon"></i> <?=$ocupacion?>
                      </li>
                       <li>
                        <i class="fa fa-phone user-profile-icon"></i> <?=$telefono1?>
                      </li>
                      <li class="m-top-xs">
                        <i class="fa fa-envelope user-profile-icon"></i>
                        <a href="#" target="_blank"><?=$correo;?></a>
                      </li>
                    </ul>

                    <a href="pacientenuevo.php?opt=m&id=<?=$id?>" class="btn btn-success"><i class="fa fa-edit m-right-xs"></i>Editar Paciente</a>
                    <br />

                    

                  </div>
                  <div class="col-md-9 col-sm-9 col-xs-12">

                    <!-- <div class="profile_title">
                      <div class="col-md-6">
                        <h2>User Activity Report</h2>
                      </div>
                      <div class="col-md-6">
                        <div id="reportrange" class="pull-right" style="margin-top: 5px; background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #E6E9ED">
                          <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                          <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
                        </div>
                      </div>
                    </div> -->
                    <!-- start of user-activity-graph -->
                    <!-- <div id="graph_bar" style="width:100%; height:280px;"></div> -->
                    <!-- end of user-activity-graph -->

                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
                      <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                        <!-- <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Citas Recientes</a>
                        </li> -->
                        <li role="presentation" class="active"><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="true">Historial Citas</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Notas</a>
                        </li>
                       <!--  <li role="presentation" class=""><a href="#tab_content4" role="tab" id="profile-tab4" data-toggle="tab" aria-expanded="false">Odontograma</a>
                        </li> -->
                        <li role="presentation" class=""><a href="#tab_content5" role="tab" id="profile-tab5" data-toggle="tab" aria-expanded="false">Galería</a>
                        </li>
                      </ul>
                      <div id="myTabContent" class="tab-content">
                      
                        <div role="tabpanel" class="tab-pane fade active in" id="tab_content2" aria-labelledby="profile-tab">

                          <!-- start user projects -->
                          <table class="data table table-striped no-margin">
                            <thead>
                              <tr>
                                <th>#</th>
                                <th>Tipo</th>
                                <th>Detalle</th>
                                <th>Fecha</th>
                              </tr>
                            </thead>
                            <tbody>

                              <?php if($vcita){
                                $i=1;
                                foreach ($vcita AS $id => $array) {?>

                                  <tr>
                                    <td><?=$i;?></td>
                                    <td><?=$array['tipo'];?></td>
                                    <td><?=$array['comentario'];?></td>
                                    <td><?php $date = date_create($array['start']); echo date_format($date, 'd/m/Y H:i'); ?></td>
                                    <td align="left">
                                      <?php if($array['idestado']==0){ ?> <span class="label label-danger cita" data-toggle="modal" data-target="#ModalCita" data-id="<?=$array['id']?>" data-ms="<?=$array['maxSup']?>" data-mi="<?=$array['maxInf']?>" data-obs="<?=$array['observaciones']?>" data-valor="<?=$array['valor']?>" data-fact="<?=$array['factura']?>">Cancelada</span> 
                                       <?php }else if($array['idestado']==1){ ?>
                                                  <span class="label label-warning cita" data-toggle="modal" data-target="#ModalCita" data-id="<?=$array['id']?>"  data-ms="<?=$array['maxSup']?>" data-mi="<?=$array['maxInf']?>" data-obs="<?=$array['observaciones']?>" data-valor="<?=$array['valor']?>"  data-fact="<?=$array['factura']?>">Programada</span>
                                       <?php }else { ;?>
                                                  <span class="label label-success cita" data-toggle="modal" data-target="#ModalCita" data-id="<?=$array['id']?>" data-ms="<?=$array['maxSup']?>" data-mi="<?=$array['maxInf']?>" data-obs="<?=$array['observaciones']?>" data-valor="<?=$array['valor']?>"  data-fact="<?=$array['factura']?>">Finalizada</span>
                                        <?php } ;?></td>

                                  </tr>
                                
                                
                            <?php $i++; } } ?>
                              <!-- <tr>
                                <td>1</td>
                                <td>New Company Takeover Review</td>
                                <td>Deveint Inc</td>
                                <td class="hidden-phone">18</td>
                                <td class="vertical-align-mid">
                                  <div class="progress">
                                    <div class="progress-bar progress-bar-success" data-transitiongoal="35"></div>
                                  </div>
                                </td>
                              </tr> -->
                              
                            </tbody>
                          </table>
                          <!-- end user projects -->

                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab">
                          <p>Registro de la evolución:</p>
                           
                          <div class="x_content">
                            <div class="dashboard-widget-content">
                              <input id="nota" name="nota" type="text" style="width:50%;" /> 
                              <button type="button"  class="btn btn-success btn-xs" onclick="guardarnota()"> Agregar <i class="fa fa-chevron-right"></i> </button>
                                  <ul class="list-unstyled timeline widget">
                                     
                                    <div id="nnotas">

                                    </div>
                                    <?php if($vNotas){
                                        foreach ($vNotas AS $id => $array) {?>

                                        <li>
                                          <div class="block">
                                            <div class="block_content">
                                              
                                              <p class="excerpt">  <?=$array['detalle'];?>
                                              </p>
                                              <div class="byline">
                                                <span><?=$array['fecha'];?></span> por <?=$array['idusuario'];?>
                                              </div>
                                            </div>
                                          </div>
                                        </li>
                                    
                                    <?php } } ?>
                                  </ul>
                          </div>
                        </div>
                          

                        </div>

                        <div role="tabpanel" class="tab-pane fade" id="tab_content4" aria-labelledby="profile-tab">
                          
                          <div class="odonto">

                            <div class="diente">
                              <a href="#" class="enlace"  data-toggle="modal" data-target="#myModal" data-id="18" >
                                <img src="images/18.png" />
                              </a>
                            </div>
                            <div class="diente">
                              <a href="#" class="enlace" data-toggle="modal" data-target="#myModal" data-id="17" >
                                <img src="images/17.png" />
                              </a>
                            </div>


                            <div class="diente">
                              <a href="#" class="enlace" data-toggle="modal" data-target="#myModal" data-id="16" >
                                <img src="images/16.png" />
                              </a>
                            </div>


                            <div class="diente">
                              <a href="#" class="enlace" data-toggle="modal" data-target="#myModal" data-id="15" >
                                <img src="images/15.png" />
                              </a>
                            </div>


                            <div class="diente">
                              <a href="#" class="enlace" data-toggle="modal" data-target="#myModal" data-id="14" >
                                <img src="images/14.png" />
                              </a>
                            </div>
                            
                            <div class="diente">
                              <a href="#" class="enlace" data-toggle="modal" data-target="#myModal" data-id="13" >
                                <img src="images/13.png" />
                              </a>
                            </div>


                            <div class="diente">
                              <a href="#" class="enlace" data-toggle="modal" data-target="#myModal" data-id="12" >
                                <img src="images/12.png" />
                              </a>
                            </div>


                            <div class="diente">
                              <a href="#" class="enlace" data-toggle="modal" data-target="#myModal" data-id="11" >
                                <img src="images/11.png" />
                              </a>
                            </div>


                            

                          
                            
                            <div class="diente">
                              <a href="#" class="enlace" data-toggle="modal" data-target="#myModal" data-id="21" >
                                <img src="images/21.png" />
                              </a>
                            </div>
                            <div class="diente">
                              <a href="#" class="enlace" data-toggle="modal" data-target="#myModal" data-id="22" >
                                <img src="images/22.png" />
                              </a>
                            </div>
                            <div class="diente">
                              <a href="#" class="enlace" data-toggle="modal" data-target="#myModal" data-id="23" >
                                <img src="images/23.png" />
                              </a>
                            </div>
                            <div class="diente">
                              <a href="#" class="enlace" data-toggle="modal" data-target="#myModal" data-id="24" >
                                <img src="images/24.png" />
                              </a>
                            </div>
                            <div class="diente">
                              <a href="#" class="enlace" data-toggle="modal" data-target="#myModal" data-id="25" >
                                <img src="images/25.png" />
                              </a>
                            </div>
                            <div class="diente">
                              <a href="#" class="enlace" data-toggle="modal" data-target="#myModal" data-id="26" >
                                <img src="images/26.png" />
                              </a>
                            </div>
                            <div class="diente">
                              <a href="#" class="enlace" data-toggle="modal" data-target="#myModal" data-id="27" >
                                <img src="images/27.png" />
                              </a>
                            </div>
                            <div class="diente">
                              <a href="#" class="enlace" data-toggle="modal" data-target="#myModal" data-id="28" >
                                <img src="images/28.png" />
                              </a>
                            </div>

                            <bR><br><bR><br><bR><br><bR><br><bR><br><bR><br>

                            <div class="diente">
                              <a href="#" class="enlace" data-toggle="modal" data-target="#myModal" data-id="48" >
                                <img src="images/48.png" />
                              </a>
                            </div>
                            <div class="diente">
                              <a href="#" class="enlace" data-toggle="modal" data-target="#myModal" data-id="47" >
                                <img src="images/47.png" />
                              </a>
                            </div>
                            <div class="diente">
                              <a href="#" class="enlace" data-toggle="modal" data-target="#myModal" data-id="46" >
                                <img src="images/46.png" />
                              </a>
                            </div>
                            <div class="diente">
                              <a href="#" class="enlace" data-toggle="modal" data-target="#myModal" data-id="45" >
                                <img src="images/45.png" />
                              </a>
                            </div>
                            <div class="diente">
                              <a href="#" class="enlace" data-toggle="modal" data-target="#myModal" data-id="44" >
                                <img src="images/44.png" />
                              </a>
                            </div>
                            <div class="diente">
                              <a href="#" class="enlace" data-toggle="modal" data-target="#myModal" data-id="43" >
                                <img src="images/43.png" />
                              </a>
                            </div>
                            <div class="diente">
                              <a href="#" class="enlace" data-toggle="modal" data-target="#myModal" data-id="42" >
                                <img src="images/42.png" />
                              </a>
                            </div>
                            <div class="diente">
                              <a href="#" class="enlace" data-toggle="modal" data-target="#myModal" data-id="41" >
                                <img src="images/41.png" />
                              </a>
                            </div>
                            

                            <div class="diente">
                              <a href="#" class="enlace" data-toggle="modal" data-target="#myModal" data-id="31" >
                                <img src="images/31.png" />
                              </a>
                            </div>
                            <div class="diente">
                              <a href="#" class="enlace" data-toggle="modal" data-target="#myModal" data-id="32" >
                                <img src="images/32.png" />
                              </a>
                            </div>
                            <div class="diente">
                              <a href="#" class="enlace" data-toggle="modal" data-target="#myModal" data-id="33" >
                                <img src="images/33.png" />
                              </a>
                            </div>
                            <div class="diente">
                              <a href="#" class="enlace" data-toggle="modal" data-target="#myModal" data-id="34" >
                                <img src="images/34.png" />
                              </a>
                            </div>
                            <div class="diente">
                              <a href="#" class="enlace" data-toggle="modal" data-target="#myModal" data-id="35" >
                                <img src="images/35.png" />
                              </a>
                            </div>
                            <div class="diente">
                              <a href="#" class="enlace" data-toggle="modal" data-target="#myModal" data-id="36" >
                                <img src="images/36.png" />
                              </a>
                            </div>
                            <div class="diente">
                              <a href="#" class="enlace" data-toggle="modal" data-target="#myModal" data-id="37" >
                                <img src="images/37.png" />
                              </a>
                            </div>
                            <div class="diente">
                              <a href="#" class="enlace" data-toggle="modal" data-target="#myModal" data-id="38" >
                                <img src="images/38.png" />
                              </a>
                            </div>
                            
                          </div>

                          <br>
                          <br> 

                          <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                              
                              <div class="x_content">
                                <ul class="list-unstyled timeline">
                                  
                                  <div id="nlesiones">

                                    </div>
                                    <?php if($vLesiones){
                                        foreach ($vLesiones AS $id => $array) {?>

                                        
                                        <li>
                                          <div class="block">
                                            <div class="tags">
                                              <a href="" class="tag">
                                                <span><?=$array['idtipoLesion'];?></span>
                                              </a>
                                            </div>
                                            <div class="block_content">
                                              <h2 class="title">
                                                              <a>Pieza <?=$array['pieza'];?></a>
                                                          </h2>
                                              <div class="byline">
                                                <span><?=$array['fecha'];?> por <?=$array['idusuario'];?></span> 
                                              </div>
                                              <p class="excerpt"><?=$array['nota'];?>
                                              </p>
                                            </div>
                                          </div>
                                        </li>
                                    
                                    <?php } } ?>

                                 
                                  <!-- <li>
                                    <div class="block">
                                      <div class="tags">
                                        <a href="" class="tag">
                                          <span>Ausencia</span>
                                        </a>
                                      </div>
                                      <div class="block_content">
                                        <h2 class="title">
                                                        <a>Pieza 18</a>
                                                    </h2>
                                        <div class="byline">
                                          <span>13/04/2016 por Dr. Medina</span> 
                                        </div>
                                        <p class="excerpt">Observaciones realizadas a la pieza
                                        </p>
                                      </div>
                                    </div>
                                  </li> -->
                                </ul>

                              </div>
                            </div>
                          </div>
                        </div>

                        <div role="tabpanel" class="tab-pane fade" id="tab_content5" aria-labelledby="profile-tab">
                          <div class="row">
                            <p>Galería de imagenes del paciente.</p>

                            <br>
                            
                             
                            <div class="item form-group">
                                <label class="control-label col-md-2 col-sm-2 col-xs-12" for="imagenS3"> Subir imagen:
                                </label>

                                <div class="col-md-3"> 
                                  
                                  <input name="imagenS3" class="fileupload " id="imagenS3" type="file" />
                                  <input name="img3" id="img3" type="hidden" value="<?=$imagen3?>" />
                                 
                                </div>

                                <div class="col-md-2"> 
                                   <a href="" onClick="subir(<?=$idpaciente?>)" class="btn btn-success btn-xs"><i class="fa fa-upload m-right-xs"></i> Guardar</a>
                                </div>
                            </div>

                            <br><br><br><br>
                            
                              
                                <?php if($vGaleria){
                                        foreach ($vGaleria AS $id => $array) {?>

                                          <div class="col-md-55" id="gal<?=$array["idimagen"];?>">
                                            <div class="thumbnail">  
                                            <div class="image view-first fotoGal">
                                              <img style="width: 100%; display: block;" onclick="onClick(this)" src="images/paciente/<?=$array["idpaciente"];?>/<?=$array["nombre"];?>" alt="image" />
                                              <div class="mask">
                                                <p>clic para ampliar</p>
                                                <div class="tools tools-bottom">
                                                  <a href="" onClick="eliminarFoto(<?=$array["idimagen"];?>)"><i class="fa fa-times"></i></a>
                                                </div>
                                              </div>
                                            </div>
                                            <div class="caption">
                                              <p><a href="" onClick="eliminarFoto(<?=$array["idimagen"];?>,<?=$array["idpaciente"];?>,'<?=$array["nombre"];?>')"> <i class="fa fa-times"></i></a> <?=$array["nombre"];?></p>
                                            </div>
                                            </div>
                                            </div>
                                        <? } 
                                      }?>

                                  <div id="newGal">

                                  </div>
                              <!--  <div class="col-md-55">       
                               <div class="thumbnail">  
                                <div class="image view view-first">
                                  <img style="width: 100%; display: block;" src="images/4.jpg" alt="image" />
                                  <div class="mask">
                                    <p>Your Text</p>
                                    <div class="tools tools-bottom">
                                      <a href="#"><i class="fa fa-times"></i></a>
                                    </div>
                                  </div>
                                </div>
                                <div class="caption">
                                  <p>Snow and Ice Incoming for the South</p>
                                </div>
                              </div>
                            </div> -->
                            

                          </div>
                        </div>

                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

          <!-- Modal Lesion -->
          <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <!-- <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="myModalLabel">Agregar registro</h4>
                </div>
                 --><div class="modal-body">
                  <label for="">Pieza<input type="text" name="bookId" id="bookId" value=""/></label>
                  <!-- <div class="well">
                    <label for="">Procedimento</label>
                  </div> -->
                  <div class="form-group">
                        <label class="col-sm-3 control-label">Tipo de lesión </label>
                        <div class="col-sm-9">
                          <select id="idtipoLesion" name="idtipoLesion" class="form-control">
                            <option>Elegir una opción</option>
                            <?php if($vtipo){
                                  foreach ($vtipo AS $id => $array) {?>

                                  <option value="<?=$array['idtipoLesion'];?>" <?php if($idtipocita==$id){echo"selected='selected'";}?>><?=$array['nombre'];?></option>
                            <?php } } ?>
                          </select>
                        </div>
                      </div>
                  <textarea class="form-control" cols="20" id="nota" rows="6"></textarea>
                  
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default closemodal" data-dismiss="modal">Cancelar</button>
                  <button type="button" class="btn btn-success guardaLesion">Guardar</button>
                </div>
              </div>
            </div>
          </div>

        <!-- Modal Foto -->
        <div class="modal fade" id="myModalFoto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-body">

                <label for="">Foto Galeria</label>

                <img id="img01" style="width: 100%; display: block;" alt="image" />
                                              
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default closemodal" data-dismiss="modal">Cerrar</button>
              </div>
            </div>
          </div>
        </div>

        <!-- Modal Cita -->
        <div class="modal fade" id="ModalCita" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"> Control de cita</h4>
              </div>
              <div class="modal-body">
                
                <div class="item form-group">
                     
                Maxilar Superior
                <textarea class="form-control" cols="20" id="maxSup" rows="3"></textarea>
                Maxilar Inferior
                <textarea class="form-control" cols="20" id="maxInf" rows="3"></textarea>
                Observaciones
                <textarea class="form-control" cols="20" id="observaciones" rows="2"></textarea>
                
                <br>
                 <label class="col-sm-3 control-label">Costo de Consulta </label>
                      <div class="col-sm-1">
                        <input type="text" name="valor" id="valor" value="0"/>
                        <input type="hidden" name="idcita" id="idcita" value="0"/>
                      </div>

                <label class="col-sm-3 control-label"> </label>
                      <div id="facturaDiv" class="col-md-3 col-sm-3 col-xs-12">
                        <div class="checkbox"  >
                            <label>
                              <input id="factura" name="factura" type="checkbox" class=""> Generar Factura
                              <input id="idfactura" name="idfactura" type="hidden" value="0"  > 
                            </label>
                        </div>
                      </div>  
                </div>
              </div>
              <br>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger ">Cancelar</button>
                <button type="button" class="btn btn-success guardarResultado">Guardar</button>
              </div>
            </div>
          </div>
        </div>

        <script type="text/javascript">
                    
          $(document).ready(function() {
              
              $('#factura').change(function(){
                  if ($('#factura').is(":checked")){
                    $('#idfactura').val('1');
                  }else{
                    $('#idfactura').val('0');
                    
                  }
                  console.log('3');
              });
            
                      
            });
       </script>

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

  <script src="js/custom.js"></script>

  <!-- image cropping -->
  <script src="js/cropping/cropper.min.js"></script>
  <script src="js/cropping/main.js"></script>

  <!-- daterangepicker -->
  <script type="text/javascript" src="js/moment/moment.min.js"></script>
  <script type="text/javascript" src="js/datepicker/daterangepicker.js"></script>

  <!-- chart js -->
  <script src="js/chartjs/chart.min.js"></script>

  <!-- moris js -->
  <script src="js/moris/raphael-min.js"></script>
  <script src="js/moris/morris.min.js"></script>

  <!-- pace -->
  <script src="js/pace/pace.min.js"></script>

  

   <script>

      function onClick(element) {
        document.getElementById("img01").src = element.src;
        $('#myModalFoto').modal('show');
        //document.getElementById("myModalFoto").style.display = "block";
      }

      function guardarnota(){
        var detalle = $('#nota').val();
        var idpaciente = $('#idpaciente').val();
        $.ajax({
          url:'actions/actionpacienteNotas.php',
          type:'POST',
          data: { opt: 'n', val: detalle, idpaciente: idpaciente  }
        }).done(function( data ){
            var num = data;
            var codigo = $('#nnotas').html();
            $('#nnotas').html('<li><div class="block"><div class="block_content"><p class="excerpt">  '+detalle+' </p><div class="byline"><span>fecah</span> por usuario</div></div></div></li>' + codigo)
            //$('#nnotas').html(codigo + '<li id="'+num+'"><p><button type="button" class="btn btn-xs" onclick="borrarnota('+num+')"><i class="fa fa-square-o"></i> </button>'+detalle +'  </p></li>');
            //$('#nnotas').load('divs/div_notas.php');
          
        });

        $("#nota").val('');
      }

      function borrarnota(id){
        var cod = id;
        $.ajax({
          url:'actions/actionnotas.php',
          type:'POST',
          data: { opt: 'b', val: cod  }
        }).done(function( data ){
          
            //var codigo = $('#nnotas').html();
            //$('#nnotas').html(codigo + '<li><p><button type="button" class="btn btn-xs" onclick="borrarnota()"><i class="fa fa-square-o"></i> </button>'+detalle +'  </p></li>');
            //$('#nnotas').load('divs/div_notas.php');
            $('#'+id+'').hide();
            
        });

      }
  </script>

  <!-- datepicker -->
  <script type="text/javascript">
    $(document).on("click", ".enlace", function () {
         var myBookId = $(this).data('id');
         $(".modal-body #bookId").val( myBookId );
         // As pointed out in comments, 
         // it is superfluous to have to manually call the modal.
         // $('#addBookDialog').modal('show');
    });

    $(document).on("click", ".cita", function () {
         var myBookId = $(this).data('id');
         $(".modal-body #idcita").val( myBookId );
         var ms = $(this).data('ms');
         $(".modal-body #maxSup").val( ms );
         var mi = $(this).data('mi');
         $(".modal-body #maxInf").val( mi);
         var obs = $(this).data('obs');
         $(".modal-body #observaciones").val( obs );
         var valor = $(this).data('valor');
         $(".modal-body #valor").val( valor );
         var fact = $(this).data('fact');
         if(fact==1){
            $(".modal-body #facturaDiv").hide( );
         }
         // As pointed out in comments, 
         // it is superfluous to have to manually call the modal.
         // $('#addBookDialog').modal('show');
    });

    $(document).on("click", ".guardaLesion", function() {
            
            var id = $("#bookId").val();
            
            if (id) {
                   var idpaciente =  $("#idpaciente").val();
                   var idtipo = $("#idtipoLesion").val();
                   var nota = $("#nota").val();
                  
                  
                   $.ajax({
                       url: 'actions/actionlesiones.php?opt=np',
                       data: 'idtipoLesion='+ idtipo +'&idpaciente='+ idpaciente +'&pieza='+ id +'&nota='+ nota ,
                       type: "POST",
                       success: function(json) {
                         //alert('Added Successfully: '+json); 
                         $("#idtipoLesion").val('0');
                         $("#nota").val('');
                         
                         $('.closemodal').click();
                          //alert(json);
            
                         //return false;
                     }
                   });
                   
               }
       });
    $(document).on("click", ".guardarResultado", function() {
            
            var id = $("#idcita").val();
            
            if (id) {
                   var maxSup =  $("#maxSup").val();
                   var maxInf = $("#maxInf").val();
                   var observaciones = $("#observaciones").val();
                   var valor = $("#valor").val();
                   var factura = $("#idfactura").val();
                   var idpaciente = $("#idpaciente").val();
                  $.ajax({
                       url: 'actions/actioncita.php?opt=control',
                       data: 'id='+ id +'&maxSup='+ maxSup +'&maxInf='+ maxInf +'&observaciones='+ observaciones +'&valor='+ valor +'&factura='+ factura +'&idpaciente='+ idpaciente ,
                       type: "POST",
                       success: function(json) {
                         //alert('Added Successfully: '+json); 
                         
                         $("#maxSup").val('');
                         $("#maxInf").val('');
                         $("#observaciones").val('');
                         $("#valor").val('');
                         
                         $('.close').click();
                          //alert(json);
                        // new PNotify({
                        //     title: 'Datos Guardados',
                        //     text: 'El seguimiento y control de la cita fueron guardados.',
                        //     type: 'success'
                        //  });
                         //return false;
                     }
                   });             
               }
      });
    // $(document).on("click", ".fotoGal", function () {
    //      //var myBookId = $(this).data('id');
    //      //$(".modal-body #bookId").val( myBookId );
    //      // As pointed out in comments, 
    //      // it is superfluous to have to manually call the modal.
    //       //document.getElementById("img01").src = element.src;
    //       $('#myModalFoto').modal('show');
    // });


    $(document).ready(function() {

      $('#imagenS3').change(function() {
                var filename = $(this).val();
                var lastIndex = filename.lastIndexOf("\\");
                if (lastIndex >= 0) {
                    filename = filename.substring(lastIndex + 1);
                } 
                $('#img3').val(filename);
            });

      var cb = function(start, end, label) {
        console.log(start.toISOString(), end.toISOString(), label);
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        //alert("Callback has fired: [" + start.format('MMMM D, YYYY') + " to " + end.format('MMMM D, YYYY') + ", label = " + label + "]");
      }

      var optionSet1 = {
        startDate: moment().subtract(29, 'days'),
        endDate: moment(),
        minDate: '01/01/2012',
        maxDate: '12/31/2015',
        dateLimit: {
          days: 60
        },
        showDropdowns: true,
        showWeekNumbers: true,
        timePicker: false,
        timePickerIncrement: 1,
        timePicker12Hour: true,
        ranges: {
          'Today': [moment(), moment()],
          'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days': [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month': [moment().startOf('month'), moment().endOf('month')],
          'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        opens: 'left',
        buttonClasses: ['btn btn-default'],
        applyClass: 'btn-small btn-primary',
        cancelClass: 'btn-small',
        format: 'MM/DD/YYYY',
        separator: ' to ',
        locale: {
          applyLabel: 'Submit',
          cancelLabel: 'Clear',
          fromLabel: 'From',
          toLabel: 'To',
          customRangeLabel: 'Custom',
          daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
          monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
          firstDay: 1
        }
      };
      $('#reportrange span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
      $('#reportrange').daterangepicker(optionSet1, cb);
      $('#reportrange').on('show.daterangepicker', function() {
        console.log("show event fired");
      });
      $('#reportrange').on('hide.daterangepicker', function() {
        console.log("hide event fired");
      });
      $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
        console.log("apply event fired, start/end dates are " + picker.startDate.format('MMMM D, YYYY') + " to " + picker.endDate.format('MMMM D, YYYY'));
      });
      $('#reportrange').on('cancel.daterangepicker', function(ev, picker) {
        console.log("cancel event fired");
      });
      $('#options1').click(function() {
        $('#reportrange').data('daterangepicker').setOptions(optionSet1, cb);
      });
      $('#options2').click(function() {
        $('#reportrange').data('daterangepicker').setOptions(optionSet2, cb);
      });
      $('#destroy').click(function() {
        $('#reportrange').data('daterangepicker').remove();
      });
    });
  </script>
  <!-- /datepicker -->
</body>

</html>
