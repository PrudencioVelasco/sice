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

   <link href="<?php echo base_url(); ?>/assets/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

  <link href="<?php echo base_url(); ?>/assets/fonts/css/font-awesome.min.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>/assets/css/animate.min.css" rel="stylesheet">

  <link href="<?php echo base_url(); ?>/assets/css/style2.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>/assets/plugins/node-waves/waves.css" rel="stylesheet">
  <!-- Custom styling plus plugins -->
  <link href="<?php echo base_url(); ?>/assets/css/custom.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>/assets/css/icheck/flat/green.css" rel="stylesheet">


  <script src="<?php echo base_url(); ?>/assets/plugins/jquery/jquery.min.js"></script> 
  <script src="<?php echo base_url() ?>/assets/vue/vue/vue.min.js"></script>
  <script src="<?php echo base_url() ?>/assets/vue/axios/axios.min.js"></script>
  <script src="<?php echo base_url(); ?>/assets/vue/pagination/pagination.js"></script>
   <script src="<?php echo base_url(); ?>/assets/vue/vue-column-sortable.js"></script>

 

  <!-- select2 -->
  <link href="<?php echo base_url(); ?>/assets/css/select/select2.min.css" rel="stylesheet"> 
     <!-- Bootstrap Select Css -->
    <link href="<?php echo base_url(); ?>/assets/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />

 
    <!-- SweetAlert -->
    <script src="<?php echo base_url(); ?>/assets/js/sweetalert2/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/js/sweetalert2/dist/sweetalert2.min.css">
    

    <link href="<?php echo base_url(); ?>/assets/media/css/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>/assets/js/datatables/buttons.bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>/assets/js/datatables/fixedHeader.bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>/assets/js/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>/assets/js/datatables/scroller.bootstrap.min.css" rel="stylesheet" type="text/css" />
 
 

  <!--[if lt IE 9]>
        <script src="../assets/js/ie8-responsive-file-warning.js"></script>
        <![endif]-->

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <style>
   .swal2-popup{
     font-size: 1.4rem;
   }
   .is-invalid{
     border-color: red;
   }
 
 </style>
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
<div id="loadingnew"></div>
  <div class="container body">


    <div class="main_container">

      <div class="col-md-3 left_col">
        <div class="left_col scroll-view">

          <div class="navbar nav_title" style="border: 0;">
            <a href="#" class="site_title"><i class="fa fa-graduation-cap"></i> <span>SICE</span></a>
          </div>
          <div class="clearfix"></div>


          <!-- menu prile quick info -->
          <div class="profile" style="margin-top: 50px;">
            <div class="profile_pic">
              <img src="<?php echo base_url(); ?>/assets/images/user2.png" alt="..." class="img-circle profile_img">
            </div>
            <div class="profile_info">
              <span>Bienvenido,</span>
              <h2><?php echo $this->session->nombre   ?></h2>
            </div>
          </div>
          <!-- /menu prile quick info -->

          <br />

          <!-- sidebar menu -->
          <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

            <div class="menu_section">
              <h3>
                <?php 
                  if((isset($this->session->nivel_educativo) && !empty($this->session->nivel_educativo)) &&
                      (isset($this->session->idplantel) && !empty($this->session->idplantel) && $this->session->idplantel != 2)){
                      echo $this->session->nivel_educativo;
                  } else{
                    echo 'General';
                  }
                ?>
              </h3>
              <ul class="nav side-menu">
              <li><a href="<?= base_url('/Admin') ?>"><i class="fa fa-home"></i>  Inicio</a></li>
              <li><a href="<?= base_url('/Alumno/inicio') ?>"><i class="fa fa-slideshare"></i>  Alumnos</a></li>
               <li><a href="<?= base_url('/Tutor/inicio') ?>"><i class="fa fa-users"></i>  Tutores</a></li>
               <li><a href="<?= base_url('/Profesor/inicio') ?>"><i class="fa fa-user"></i>  Profesor</a></li>
               <li><a href="<?= base_url('/CicloEscolar/inicio') ?>"><i class="fa fa-bookmark-o"></i>  Ciclo Escolar</a></li>
               <li><a href="<?= base_url('/Grupo/inicio') ?>"><i class="fa fa-graduation-cap"></i>  Grupo</a></li>
               <li><a href="<?= base_url('/Horario/inicio') ?>"><i class="fa fa-clock-o"></i>  Horario</a></li>
               <li><a href="<?= base_url('/Promover/') ?>"><i class="fa fa-arrow-up"></i>  Promoción Alumno</a></li>

               <li><a href="<?= base_url('/Catalogo/') ?>"><i class="fa fa-folder-open"></i>  Catalogo</a></li>

              </ul>
            </div>
          

          </div> 
        </div>
      </div>

      <!-- top navigation -->
      <div class="top_nav">

        <div class="nav_menu">
          <nav class="" role="navigation">
            <div class="nav toggle">
              <a id="menu_toggle"><i class="fa fa-bars"></i></a> 
            </div> 
            <div class="nav toggle">
              <a id="menu_toggle"><label></label></a> 
            </div> 
            <ul class="nav navbar-nav navbar-right" >

              <li class="" >
                <a  href="#" style=" padding:0 10px 0 0;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                  <img src="<?php echo base_url(); ?>/assets/images/user2.png" alt=""><?php echo $this->session->nombre
                                ?>
                  <span class=" fa fa-angle-down"></span>
                </a>
                <ul  class="dropdown-menu dropdown-usermenu animated fadeInDown pull-right"> 
                  <?php 
                  
                    if(isset($this->session->planteles) && !empty($this->session->planteles)){
                      foreach($this->session->planteles as $row){
                  ?>
                  <li><a href="<?= base_url('/welcome/plantel/'.$row->idplantel) ?>"><?php echo $row->nombreniveleducativo ?></a></li>
                    <?php
                     }
                    }
                    ?>
                      <li><a href="<?= base_url('/welcome/logouta') ?>"><i class="fa fa-sign-out pull-right"></i> SALIR</a>
                  </li>
                </ul>
              </li> 

            </ul>
          </nav>
        </div>

      </div>
      <!-- /top navigation -->