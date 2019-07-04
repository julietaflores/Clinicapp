
<div class="navbar nav_title" style="border: 0;">
            <a href="index.php" class="site_title"><img src="images/logo.png" style="width:75%; margin-left:10px;"/></a>
</div>
<div class="clearfix"></div>
<!-- menu prile quick info -->
          <div class="profile">
            <div class="profile_pic">
              <img src="images/usuario/<?=$_SESSION['csmart']['idusuario']?>/<?=$_SESSION['csmart']['iperfil']?>" alt="..." class="img-circle profile_img">
            </div>
            <div class="profile_info">
              <span>Bienvenido,</span>
              <h2><?=$_SESSION['usuario'];?></h2>
            </div>
          </div>
          <!-- /menu prile quick info -->

          <br />

<!-- sidebar menu -->
          <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

            <div class="menu_section">
              <h3>General</h3>
              <ul class="nav side-menu">
                <li><a><i class="fa fa-home"></i> Inicio <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                    
                    <li><a href="index.php">Panel de Control</a>
                    </li>
                    <!-- <li><a href="index2.html">Dashboard2</a>
                    </li>
                    <li><a href="index3.html">Dashboard3</a>
                    </li> -->
                  </ul>
                </li>
                <li><a><i class="fa fa-calendar"></i> Agenda <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                    <li><a href="agenda.php">Mis Citas</a>
                    </li>
                    <!-- <li><a href="agenda1.php">Nueva Cita</a>
                    </li> -->

                   
                  </ul>
                </li>
                <li><a><i class="fa fa-heart"></i> Mi Clinica <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                    <li><a href="pacientes.php">Mis Pacientes</a>
                    </li>
                    <li><a href="pacientenuevo.php">Nuevo Paciente</a>
                    </li>
                    <!-- <li><a href="#">Tratamientos</a>
                    </li> -->
                    <li><a href="presupuesto.php">Presupuestos</a>
                    </li>
                    <li><a href="producto.php">Productos</a>
                    </li>
                    
                  </ul>
                </li>
                <li><a><i class="fa fa-gears"></i> Administración <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                    <li><a href="factura.php">Facturar</a>
                    </li>
                    <li><a href="gasto.php">Gastos</a>
                    </li>
                    <li><a href="fusuario.php">Usuarios</a>
                    </li>
                    <li><a href="#">Reportes <span class="label label-warning">Próximamente</span></a>
                    </li>
                  </ul>
                </li>

                <?php if($_SESSION['csmart']['permisos']=='1'){ ?>
                <li><a><i class="fa fa-gears"></i> Super User <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                    <li><a href="clinica.php">Clinicas</a>
                    </li>
                    <li><a href="fusuario.php">Usuarios</a>
                    </li>
                    <li><a href="tipocita.php">Tipos de Cita</a>
                    </li>
                    <li><a href="tipotratamiento.php">Tipo Tratamientos</a>
                    </li>
                    <li><a href="Generador.php">Generador</a> 
                    </li>
                    
                  </ul>
                </li>
                <?php } ?>
                <!-- <li><a><i class="fa fa-edit"></i> Forms <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                    <li><a href="form.html">General Form</a>
                    </li>
                    <li><a href="form_advanced.html">Advanced Components</a>
                    </li>
                    <li><a href="form_validation.html">Form Validation</a>
                    </li>
                    <li><a href="form_wizards.html">Form Wizard</a>
                    </li>
                    <li><a href="form_upload.html">Form Upload</a>
                    </li>
                    <li><a href="form_buttons.html">Form Buttons</a>
                    </li>
                  </ul>
                </li>
                <li><a><i class="fa fa-desktop"></i> UI Elements <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                    <li><a href="general_elements.html">General Elements</a>
                    </li>
                    <li><a href="media_gallery.html">Media Gallery</a>
                    </li>
                    <li><a href="typography.html">Typography</a>
                    </li>
                    <li><a href="icons.html">Icons</a>
                    </li>
                    <li><a href="glyphicons.html">Glyphicons</a>
                    </li>
                    <li><a href="widgets.html">Widgets</a>
                    </li>
                    <li><a href="invoice.html">Invoice</a>
                    </li>
                    <li><a href="inbox.html">Inbox</a>
                    </li>
                    <li><a href="calender.html">Calender</a>
                    </li>
                  </ul>
                </li>
                <li><a><i class="fa fa-table"></i> Tables <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                    <li><a href="tables.html">Tables</a>
                    </li>
                    <li><a href="tables_dynamic.html">Table Dynamic</a>
                    </li>
                  </ul>
                </li>
                <li><a><i class="fa fa-bar-chart-o"></i> Data Presentation <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                    <li><a href="chartjs.html">Chart JS</a>
                    </li>
                    <li><a href="chartjs2.html">Chart JS2</a>
                    </li>
                    <li><a href="morisjs.html">Moris JS</a>
                    </li>
                    <li><a href="echarts.html">ECharts </a>
                    </li>
                    <li><a href="other_charts.html">Other Charts </a>
                    </li>
                  </ul>
                </li> -->
              </ul>
            </div>
            <div class="menu_section">
              <h3>Soporte</h3>
              <ul class="nav side-menu">
                <li><a><i class="fa fa-bug"></i> Incidencias <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                    <!-- <li><a href="e_commerce.html">Contacto</a>
                    </li> -->
                    <li><a href="incidencia.php">Reportar incidencias</a>
                    </li>
                   
                  </ul>
                </li>
                
              </ul>
            </div>

          </div>
          <!-- /sidebar menu