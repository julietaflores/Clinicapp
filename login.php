<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Clinica Smart | </title>

  <!-- Bootstrap core CSS -->

  <link href="css/bootstrap.min.css" rel="stylesheet">

  <link href="fonts/css/font-awesome.min.css" rel="stylesheet">
  <link href="css/animate.min.css" rel="stylesheet">

  <!-- Custom styling plus plugins -->
  <link href="css/custom.css" rel="stylesheet">
  <link href="css/icheck/flat/green.css" rel="stylesheet">


  <script src="js/jquery.min.js"></script>
  <script src="js/sigin.js"></script>

 
</head>

<body style="background:#1fb9d6;">

  <div class="">
    <a class="hiddenanchor" id="toregister"></a>
    <a class="hiddenanchor" id="tologin"></a>

    <div id="wrapper">
      <div id="login" class="animate form">
        <section class="login_content">
          <img src="images/logo.png" style="width:100%;" /><form>
            <h1>Ingreso</h1>

            <div>
              <input type="text" class="form-control" placeholder="Usuario" required="" id="username" name="username" />
            </div>
            <div>
              <input type="password" class="form-control" placeholder="Clave" required="" id="clave" name="clave"/>
            </div>
            <div>
              <a class="btn btn-default submit" href="#" onclick="Login();">Ingresar</a>
              <a class="reset_pass" href="#">Olvido su clave?</a>
            </div>
            <div class="clearfix"></div>
            <div class="separator">

              <p class="change_link">Eres nuevo?
                <a href="#toregister" class="to_register"> Solicitar cuenta </a>
              </p>
              <div class="clearfix"></div>
              <br />

              <div>
                <h1><i class="fa fa-cube" style="font-size: 26px;"></i> ClinicApp</h1>
                 <?php include "pie.php"; ?> 
                <!-- <p>©2015 All Rights Reserved. Gentelella Alela! is a Bootstrap 3 template. Privacy and Terms</p> -->
              </div>
            </div>
          </form>
          <!-- form -->
        </section>
        <!-- content -->
      </div>
      <div id="register" class="animate form">
        <section class="login_content">
          <form>
            <h1>Solicitar Cuenta<h1>
            <div>
              <input type="text" class="form-control" placeholder="Username" required="" />
            </div>
            <div>
              <input type="email" class="form-control" placeholder="Email" required="" />
            </div>
            <div>
              <input type="password" class="form-control" placeholder="Password" required="" />
            </div>
            <div>
              <a class="btn btn-default submit" href="index.html">Submit</a>
            </div>
            <div class="clearfix"></div>
            <div class="separator">

              <p class="change_link">Ya eres miembro ?
                <a href="#tologin" class="to_register"> Log in </a>
              </p>
              <div class="clearfix"></div>
              <br />
              <?php include "pie.php"; ?>
              <div>
                <h1><i class="fa fa-paw" style="font-size: 26px;"></i> Gentelella Alela!</h1>

                <p>©2015 All Rights Reserved. Gentelella Alela! is a Bootstrap 3 template. Privacy and Terms</p>
              </div>
            </div>
          </form>
          <!-- form -->
        </section>
        <!-- content -->
      </div>
    </div>
  </div>

</body>

</html>
