<!DOCTYPE html>
<html lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Sistema Integral para el Control Escolar</title>
        <!-- plugins:css -->
        <link rel="shortcut icon" href="<?php echo base_url(); ?>/assets/images/icowoori.ico"> 
        <!-- Firefox, Opera  -->
        <link rel="icon" href="<?php echo base_url(); ?>/assets/images/icowoori.ico">
        <link rel="stylesheet" href="<?php echo base_url('assets/login/css/vendor.bundle.base.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/login/css/vendor.bundle.addons.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/login/css/style.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/login/css/materialdesignicons.min.css'); ?>">
        <script src="<?php echo base_url(); ?>/assets/js/jquery.min.js"></script>

  <script src="<?php echo base_url(); ?>/assets/js/bootstrap.min.js"></script>
   <script src="<?php echo base_url(); ?>/assets/js/sweetalert2/dist/sweetalert2.min.js"></script>
        <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/js/sweetalert2/dist/sweetalert2.min.css">
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
                                 <center><h3  align="center" class="mr-auto"><strong>S</strong>istema <strong>I</strong>ntegral para el <strong>C</strong>ontrol <strong>E</strong>scolar</h3></center>

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

                                 <hr>
                                 <div style="display: block;">
                                 <button  class="btn btn-primary btnalumno" style="border: solid #ccc 1px" >ALUMNO</a>
                                  <button  class="btn btn-default btndocente" style="border: solid #ccc 1px">DOCENTE</a>
                                   <button   class="btn btn-default btntutor" style="border: solid #ccc 1px" >TUTOR</button> 
                                </div>

                                <div id="divalumno">
                                    <br>
                                    <h4 align="center">Alumnos</h4>
                                <form  method="POST" action="<?= base_url('welcome/alumno') ?>" > 
                                     <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="mdi mdi-account-outline"></i>
                                                </span>
                                            </div>
                                            <input type="text" name="matricula" class="form-control" placeholder="Matricula" required="required"> </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="mdi mdi-lock-outline"></i>
                                                </span>
                                            </div>
                                            <input type="password" name="password" class="form-control" placeholder="Contraseña" required="required"> </div>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-primary submit-btn" type="submit" >ENTRAR</button>
                                    </div> 
                                </form>
                            </div>


                                 <div id="divdocente" style="display: none;">
                                <form  method="POST" action="<?= base_url('welcome/docente') ?>" > 
                                    <br>
                                    <h4 align="center">Docentes</h4>
                                     <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="mdi mdi-account-outline"></i>
                                                </span>
                                            </div>
                                            <input type="email" name="correo" class="form-control" placeholder="Correo Electronico" required="required"> </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="mdi mdi-lock-outline"></i>
                                                </span>
                                            </div>
                                            <input type="password" name="password" class="form-control" placeholder="Contraseña" required="required"> </div>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-primary submit-btn" type="submit">ENTRAR</button>
                                    </div> 
                                </form>
                            </div>


                                 <div id="divtutor" style="display: none;">
                                <form  method="POST" action="<?= base_url('welcome/tutor') ?>" > 
                                    <br>
                                    <h4 align="center">Tutores</h4>
                                     <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="mdi mdi-account-outline"></i>
                                                </span>
                                            </div>
                                            <input type="email" name="correo" class="form-control" placeholder="Correo Electronico" required="required"> </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="mdi mdi-lock-outline"></i>
                                                </span>
                                            </div>
                                            <input type="password" name="password" class="form-control" placeholder="Contraseña" required="required"> </div>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-primary submit-btn" type="submit">ENTRAR</button>
                                    </div> 
                                </form>
                            </div>




                            </div>
                        </div>
                    </div>
                </div> 
            </div> 
        </div>
        <script type="text/javascript">
             
                $(document).on( "click", '.btnalumno',function(e) { 
                $("#divdocente").css('display','none'); 
                $("#divtutor").css('display','none'); 
                 $("#divalumno").css('display','block');
                 $('.btndocente').removeClass('btn btn-primary').addClass('btn btn-default').show(); 
                 $('.btntutor').removeClass('btn btn-primary').addClass('btn btn-default').show(); 
                
                 $('.btnalumno').removeClass('btn btn-default').addClass('btn btn-primary').show(); 
            }); 
                $(document).on( "click", '.btndocente',function(e) { 
                $("#divdocente").css('display','block'); 
                $("#divtutor").css('display','none'); 
                $("#divalumno").css('display','none'); 
                  $('.btnalumno').removeClass('btn btn-primary').addClass('btn btn-default').show(); 
                 $('.btntutor').removeClass('btn btn-primary').addClass('btn btn-default').show(); 

                $('.btndocente').removeClass('btn btn-default').addClass('btn btn-primary').show(); 
            }); 
                $(document).on( "click", '.btntutor',function(e) { 
                $("#divdocente").css('display','none'); 
                $("#divtutor").css('display','block'); 
                 $("#divalumno").css('display','none'); 
                   $('.btnalumno').removeClass('btn btn-primary').addClass('btn btn-default').show(); 
                 $('.btndocente').removeClass('btn btn-primary').addClass('btn btn-default').show(); 

                 $('.btntutor').removeClass('btn btn-default').addClass('btn btn-primary').show(); 
            });


        </script> 

    
    </body> 
</html>