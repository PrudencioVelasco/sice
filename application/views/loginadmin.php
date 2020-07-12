<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Sistema Integral para el Control Escolar</title>

  <!-- Bootstrap core CSS -->

  <link href="<?php echo base_url(); ?>/assets/css/bootstrap.min.css" rel="stylesheet">

  <link href="<?php echo base_url(); ?>/assets/assets/fonts/css/font-awesome.min.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>/assets/css/animate.min.css" rel="stylesheet">

  <!-- Custom styling plus plugins -->
  <link href="<?php echo base_url(); ?>/assets/css/custom.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>/assets/css/icheck/flat/green.css" rel="stylesheet">


  <script src="<?php echo base_url(); ?>/assets/js/jquery.min.js"></script>
  <script src="<?php echo base_url(); ?>/assets/js/sweetalert2/dist/sweetalert2.min.js"></script>
  <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/js/sweetalert2/dist/sweetalert2.min.css">

  <style>
    .swal2-popup {
      font-size: 1.4rem;
    }
  </style>
  <!--[if lt IE 9]>
        <script src="../assets/js/ie8-responsive-file-warning.js"></script>
        <![endif]-->

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

</head>

<body style="background:#F7F7F7;">

  <div class="">

    <div id="wrapper">
      <div id="login" class="animate form">
        <section class="login_content">

          <div class="nav-get-started">

            <?php if (isset($_SESSION['err'])) : ?>
              <script>
                swal({
                  type: 'error',
                  title: 'Oops...',
                  text: '<?= $this->session->userdata('err'); ?>',
                  footer: ''
                });
              </script>
            <?php endif ?>
          </div>
          <form method="POST" action="<?= base_url('welcome/admin') ?>">
            <h1><strong>S I C E</strong></h1>
            <div>
              <input type="text" class="form-control" name="usuario" placeholder="Usuario" required="" />
            </div>
            <div>
              <input type="password" class="form-control" name="password" placeholder="Contraseña" required="" />
            </div>
            <div>
              <button type="submit" class="btn btn-primary">ENTRAR</button>
            </div>
          </form>
          <div class="clearfix"></div>
          <div class="separator">

            <br />
            <div>
              <h2>
                <p>Sistema Integral para el Control Escolar</p>
              </h2>

              <p><?php echo date("Y") ?> Todos los Derechos Reservados</p>
            </div>
          </div>

          <!-- form -->
        </section>
        <!-- content -->
      </div>
    </div>
  </div>

</body>

</html>