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

        <link href="<?php echo base_url(); ?>/assets/css/bootstrap.min.css" rel="stylesheet">

        <link href="<?php echo base_url(); ?>/assets/fonts/css/font-awesome.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>/assets/css/animate.min.css" rel="stylesheet">

        <link href="<?php echo base_url(); ?>/assets/css/style.css" rel="stylesheet">
        <!-- Custom styling plus plugins -->
        <link href="<?php echo base_url(); ?>/assets/css/custom.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>/assets/css/icheck/flat/green.css" rel="stylesheet">

        <link href="<?php echo base_url(); ?>/assets/media/css/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>/assets/js/datatables/buttons.bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>/assets/js/datatables/fixedHeader.bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>/assets/js/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>/assets/js/datatables/scroller.bootstrap.min.css" rel="stylesheet" type="text/css" />


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
                        <div class="profile">
                            <div class="profile_pic">
                                <img src="<?php echo base_url(); ?>/assets/images/user2.png" alt="..." class="img-circle profile_img">
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
                                <h3>Alumno(a)</h3>
                                <ul class="nav side-menu">
                                    <li><a href="<?= base_url('/Alumnos/') ?>"><i class="fa fa-home"></i> Inicio</a></li>
                                    <li><a href="<?= base_url('/Aalumno/horario') ?>"><i class="fa fa-calendar"></i> Horario</a></li>
                                    <li><a href="<?= base_url('/Aalumno/clases') ?>"><i class="fa fa-book"></i> Clases</a></li>
                                    <li><a href="<?= base_url('/Aalumno/actual') ?>"><i class="fa fa-tasks"></i> Calificación</a></li>
                                    <li><a href="<?= base_url('/Aalumno/kardex') ?>"><i class="fa fa-list"></i> Kardex</a></li>


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
                                        <img src="<?php echo base_url(); ?>/assets/images/user2.png" alt=""><?php echo $this->session->nombre ?>
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