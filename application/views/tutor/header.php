<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>SICE  - Sistema Integral de Control Escolar </title>

  <!-- Bootstrap core CSS -->

  <link href="<?php echo base_url(); ?>/assets/css/bootstrap.min.css" rel="stylesheet">

  <link href="<?php echo base_url(); ?>/assets/fonts/css/font-awesome.min.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>/assets/css/animate.min.css" rel="stylesheet">

  <link href="<?php echo base_url(); ?>/assets/css/style.css" rel="stylesheet">
  <!-- Custom styling plus plugins -->
  <link href="<?php echo base_url(); ?>/assets/css/custom.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>/assets/css/icheck/flat/green.css" rel="stylesheet">

 <link href="<?php echo base_url(); ?>/assets/css/calendar/fullcalendar.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>/assets/css/calendar/fullcalendar.print.css" rel="stylesheet" media="print">
  <script src="<?php echo base_url(); ?>/assets/js/jquery.min.js"></script>

  <script src="<?php echo base_url(); ?>/assets/js/jquery.min.js"></script>
  <script src="<?php echo base_url() ?>/assets/vue/vue/vue.min.js"></script>
  <script src="<?php echo base_url() ?>/assets/vue/axios/axios.min.js"></script>
  <script src="<?php echo base_url(); ?>/assets/vue/pagination/pagination.js"></script>
   <script src="<?php echo base_url(); ?>/assets/vue/vue-column-sortable.js"></script>


      <!-- SweetAlert -->
    <script src="<?php echo base_url(); ?>/assets/js/sweetalert2/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/js/sweetalert2/dist/sweetalert2.min.css">
    <script src="<?php echo base_url(); ?>/assets/js/jquery.validate.min.js"></script>

     <script type="text/javascript" src="<?php echo base_url(); ?>/assets/js/bootstrapValidator.min.js"></script>
    <script type="text/javascript" src="https://openpay.s3.amazonaws.com/openpay.v1.min.js"></script>
    <script type='text/javascript' src="https://openpay.s3.amazonaws.com/openpay-data.v1.min.js"></script>
     
    
  <!--[if lt IE 9]>
        <script src="../assets/js/ie8-responsive-file-warning.js"></script>
        <![endif]-->

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
 <style type="text/css">
                .modal-mask {
                    position: fixed;
                    z-index: 9998;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background-color: rgba(0, 0, 0, .5);
                    display: table;
                    transition: opacity .3s ease;
                }
                .modal-wrapper {
                    display: table-cell;
                    vertical-align: middle;
                }
                .preloader2 {
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    z-index: 9999;
                    background-color: #fff;
                }
                .preloader2 .loading2 {
                    position: absolute;
                    left: 50%;
                    top: 50%;
                    transform: translate(-50%,-50%)
                };


            </style>
</head>


<body class="nav-md">

  <div class="container body">


    <div class="main_container">

      <div class="col-md-3 left_col">
        <div class="left_col scroll-view">

          <div class="navbar nav_title" style="border: 0;">
            <a href="index.html" class="site_title"><i class="fa fa-graduation-cap"></i> <span>SICE</span></a>
          </div>
          <div class="clearfix"></div>


          <!-- menu prile quick info -->
          <div class="profile">
            <div class="profile_pic">
              <img src="<?php echo base_url(); ?>/assets/images/img.jpg" alt="..." class="img-circle profile_img">
            </div>
            <div class="profile_info">
              <span>Bienvenido,</span>
              <h2><?php echo $this->session->nombre ?></h2>
            </div>
          </div>
          <!-- /menu prile quick info -->

          <br />

          <!-- sidebar menu -->
          <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

            <div class="menu_section">
              <h3>General</h3>
              <ul class="nav side-menu">
              <li><a href="<?= base_url('/Tutores/') ?>"><i class="fa fa-home"></i>  Inicio</a></li>
               <li><a href="<?= base_url('/Tutores/alumnos') ?>"><i class="fa fa-users"></i>  Alumnos</a></li>
                <li><a href="<?= base_url('/Tutores/mensajes') ?>"><i class="fa fa-tasks"></i>  Mesajes y Tareas</a></li> 
               <li><a href="<?= base_url('/Tutores/kardex') ?>"><i class="fa fa-list"></i>  Kardex</a></li>
               

              </ul>
            </div>
          

          </div>
          <!-- /sidebar menu -->
 
        </div>
      </div>

      <!-- top navigation -->
      <div class="top_nav">

        <div class="nav_menu">
          <nav class="" role="navigation">
            <div class="nav toggle">
              <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>

            <ul class="nav navbar-nav navbar-right">
              <li class="">
                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                  <img src="<?php echo base_url(); ?>/assets/images/img.jpg" alt=""><?php echo $this->session->nombre  ?>
                  <span class=" fa fa-angle-down"></span>
                </a>
                <ul class="dropdown-menu dropdown-usermenu animated fadeInDown pull-right">
                  <li><a href="<?= base_url('/welcome/logout') ?>"><i class="fa fa-sign-out pull-right"></i> Salir</a>
                  </li>
                </ul>
              </li>

        

            </ul>
          </nav>
        </div>

      </div>
      <!-- /top navigation -->