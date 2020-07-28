<!DOCTYPE html>
<html lang="en">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>SICE - Sistema Integral de Control Escolar </title>

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
        <link href="<?php echo base_url(); ?>/assets/css/estilomodal.css" rel="stylesheet" type="text/css" />      
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
                                <img src="<?php echo base_url(); ?>/assets/images/user2.png" alt="..."
                                     class="img-circle profile_img">
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
                                <h3>Profesor</h3>
                                <ul class="nav side-menu">
                                    <li><a href="<?= base_url('/Profesores/') ?>"><i class="fa fa-home"></i> Inicio</a></li>
                                    <li><a href="<?= base_url('/Phorario/') ?>"><i class="fa fa-clock-o"></i> Horario</a>
                                    </li>
                                    <li><a href="<?= base_url('/Pgrupo/') ?>"><i class="fa fa-users"></i> Grupo</a></li>
                                    <li><a href="<?= base_url('/Pprofesor/planeacion') ?>"><i class="fa fa-slideshare"></i>
                                            Planificación</a></li>


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
                                    <a  href="#" style=" padding:0 10px 0 0;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        <img src="<?php echo base_url(); ?>/assets/images/user2.png"
                                             alt=""><?php echo $this->session->nombre ?>
                                        <span class=" fa fa-angle-down"></span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-usermenu animated fadeInDown pull-right">
                                        <li><a href="<?= base_url('/welcome/logout') ?>"><i
                                                    class="fa fa-sign-out pull-right"></i> SALIR</a>
                                        </li>
                                    </ul>
                                </li>

                            </ul>
                        </nav>
                    </div>

                </div>
                <!-- /top navigation -->