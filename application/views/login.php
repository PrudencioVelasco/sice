<!DOCTYPE html>
<html lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SICE®</title>
        <!-- plugins:css -->
        <link rel="shortcut icon" href="<?php echo base_url(); ?>/assets/images/icosice.ico"> 
        
        
        <!-- Firefox, Opera  -->
        <link rel="icon" href="<?php echo base_url(); ?>/assets/images/icosice.ico">
        <link rel="stylesheet" href="<?php echo base_url('assets/login/css/vendor.bundle.base.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/login/css/vendor.bundle.addons.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/login/css/style.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/login/css/materialdesignicons.min.css'); ?>">
        <script src="<?php echo base_url(); ?>/assets/js/jquery.min.js"></script>

        <script src="<?php echo base_url(); ?>/assets/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>/assets/js/sweetalert2/dist/sweetalert2.min.js"></script>
        <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/js/sweetalert2/dist/sweetalert2.min.css">
        <style>
            .cuadro{
                border:solid red 2px;
                padding-left: 20px;
                border-radius: 10px;
            }
        </style>
    </head>

    <body>
        <div class="container-scroller">
            <div class="container-fluid page-body-wrapper full-page-wrapper">
                <div class="content-wrapper auth p-0 theme-two">
                    <div class="row d-flex align-items-stretch">
                        <div class="col-md-4 banner-section d-none d-md-flex align-items-stretch justify-content-center">
                            <div class="slide-content bg-1"> </div>
                        </div>
                        <div class="col-12 col-md-8 h-100 bg-white">

                            <div class="auto-form-wrapper d-flex align-items-center justify-content-center flex-column"> 
                             

                                <div class="nav-get-started">

                                    <?php if (isset($_SESSION['err'])): ?>
                                        <script>
                                            swal({
                                                type: 'error',
                                                title: 'Oops...',
                                                text: '<?= $this->session->userdata('err'); ?>',
                                                footer: ''
                                            });


                                        </script>

                                    <?php endif ?>
                                    <?php if (isset($_SESSION['err2'])): ?>
                                        <script>
                                            swal({
                                                type: 'error',
                                                title: 'Oops...',
                                                text: '<?= $this->session->userdata('err2'); ?>',
                                                footer: ''
                                            });

                                        </script>

                                    <?php endif ?>
                                    <?php if (isset($_SESSION['err3'])): ?>
                                        <script>
                                            swal({
                                                type: 'error',
                                                title: 'Oops...',
                                                text: '<?= $this->session->userdata('err3'); ?>',
                                                footer: ''
                                            });

                                        </script>

                                    <?php endif ?>
                                </div>

                                <div class="card">
                                    <article class="card-body"> 
                                        <h3 align="center" class="txtinstituto"><strong>INSTITUTO MORELOS</strong></h3>
                                        <div style="display: block;">
                                            <button  class="btn btn-primary btnalumno" style="border: solid #ccc 1px;" >ALUMNO</a>
                                                <button  class="btn btn-default btndocente" style="border: solid #ccc 1px">DOCENTE</a>
                                                    <button   class="btn btn-default btntutor" style="border: solid #ccc 1px" >TUTOR</button> 
                                                    </div>
                                                    <hr>
                                                    <div id="divalumno"> 
                                                        <form  method="POST" action="<?= base_url('welcome/alumno') ?>">
                                                            <div class="form-group">
                                                                <label>Matricula</label>
                                                                <input name="matricula" class="form-control" placeholder="Matricula" type="text">
                                                            </div> <!-- form-group// -->
                                                            <div class="form-group">
                                                                <label>Contraseña</label>
                                                                <input class="form-control" name="password"  id="password_alumno" placeholder="******" type="password">
                                                                  <input type="checkbox"onclick="alumno()" /> <small>Mostrar/Ocultar contraseña</small>
                                                            </div> <!-- form-group// -->   
                                                            <div class="form-group">
                                                                <button type="submit" class="btn btn-primary btn-block"> Entrar  </button>
                                                            </div> <!-- form-group// -->                                                           
                                                        </form>
                                                    </div>
                                                    <div id="divdocente" style="display: none;">
                                                        <form  method="POST" action="<?= base_url('welcome/docente') ?>" > 
                                                            <div class="form-group">
                                                                <label>Correo Electronico</label>
                                                                <input  type="email" name="correo" class="form-control" placeholder="Correo Electronico">
                                                            </div> <!-- form-group// -->
                                                            <div class="form-group">
                                                                <a class="float-right" href="#">Recuperar?</a>
                                                                <label>Contraseña</label>
                                                                <input class="form-control" placeholder="******" id="password_docente" name="password" type="password">
                                                                <input type="checkbox"onclick="docente()" /> <small>Mostrar/Ocultar contraseña</small>
                                                            </div> <!-- form-group// -->   
                                                            <div class="form-group">
                                                                <button type="submit" class="btn btn-primary btn-block"> Entrar  </button>
                                                            </div> <!-- form-group// -->                                                           
                                                        </form>
                                                    </div>
                                                    <div id="divtutor" style="display: none;">
                                                        <form  method="POST" action="<?= base_url('welcome/tutor') ?>" > 
                                                            <div class="form-group">
                                                                <label>Correo Electronico</label>
                                                                <input  type="email" name="correo" class="form-control" placeholder="Correo Electronico">
                                                            </div> <!-- form-group// -->
                                                            <div class="form-group">
                                                                <a class="float-right" href="#">Recuperar?</a>
                                                                <label>Contraseña</label>
                                                                <input class="form-control"  name="password"  id="password_tutor" placeholder="******" type="password">
                                                                  <input type="checkbox"onclick="tutor()" /> <small>Mostrar/Ocultar contraseña</small>
                                                            </div> <!-- form-group// -->   
                                                            <div class="form-group">
                                                                <button type="submit" class="btn btn-primary btn-block"> Entrar  </button>
                                                            </div> <!-- form-group// -->                                                           
                                                        </form>
                                                    </div>
                                                    </article>
                                                    </div> <!-- card.// -->



                                                    </div>
                                                    </div>
                                                    </div>
                                                    </div> 
                                                    </div> 
                                                    </div>
         <script>
   function alumno() {
  var x = document.getElementById("password_alumno");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
} 
   function docente() {
  var x = document.getElementById("password_docente");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
} 
   function tutor() {
  var x = document.getElementById("password_tutor");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
} 
    </script>
                                                    <script type="text/javascript">

                                                        $(document).on("click", '.btnalumno', function (e) {
                                                            $("#divdocente").css('display', 'none');
                                                            $("#divtutor").css('display', 'none');
                                                            $("#divalumno").css('display', 'block');
                                                            $('.btndocente').removeClass('btn btn-primary').addClass('btn btn-default').show();
                                                            $('.btntutor').removeClass('btn btn-primary').addClass('btn btn-default').show();

                                                            $('.btnalumno').removeClass('btn btn-default').addClass('btn btn-primary').show();
                                                        });
                                                        $(document).on("click", '.btndocente', function (e) {
                                                            $("#divdocente").css('display', 'block');
                                                            $("#divtutor").css('display', 'none');
                                                            $("#divalumno").css('display', 'none');
                                                            $('.btnalumno').removeClass('btn btn-primary').addClass('btn btn-default').show();
                                                            $('.btntutor').removeClass('btn btn-primary').addClass('btn btn-default').show();

                                                            $('.btndocente').removeClass('btn btn-default').addClass('btn btn-primary').show();
                                                        });
                                                        $(document).on("click", '.btntutor', function (e) {
                                                            $("#divdocente").css('display', 'none');
                                                            $("#divtutor").css('display', 'block');
                                                            $("#divalumno").css('display', 'none');
                                                            $('.btnalumno').removeClass('btn btn-primary').addClass('btn btn-default').show();
                                                            $('.btndocente').removeClass('btn btn-primary').addClass('btn btn-default').show();

                                                            $('.btntutor').removeClass('btn btn-default').addClass('btn btn-primary').show();
                                                        });


                                                    </script> 


                                                    </body> 
                                                    </html>