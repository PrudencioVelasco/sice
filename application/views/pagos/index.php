<html>
    <head>
        <title></title>
        <link href="<?php echo base_url(); ?>/assets/pagos/bootstrap.min.css" rel="stylesheet">
     <script src="<?php echo base_url(); ?>/assets/pagos/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/pagos/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

 <link href="<?php echo base_url(); ?>/assets/fonts/css/font-awesome.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="container">
    <br>
    <p class="text-center">More bootstrap 4 components on <a href="http://bootstrap-ecommerce.com/">
            Bootstrap-ecommerce.com</a></p>
    <hr>

    <div class="row">
        <aside class="col-sm-6">
            <p><strong>1. Buscar el alumno.</strong></p>

            <article class="card">
                <div class="card-body p-5"> 
                          <div class="alert alert-danger print-error-msg" style="display:none"></div>
                    <form role="form">
                        <div class="row">
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <div class="form-group">
                                    <label><font color="red">*</font> Matricula</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-key "></i></span>
                                        </div>
                                        <input type="text" class="form-control" autofocus name="matricula" placeholder="" id="matricula" required="">
                                    </div> <!-- input-group.// -->
                                </div> <!-- form-group.// -->
                            </div>
                              <div class="col-md-3 col-sm-3 col-xs-12">
                                   <div class="form-group">
                                        <label>&nbsp;</label>
                                         <div class="input-group">
                                            <button class="btn btn-primary" type="button"  id="btnbuscar"><i class="fa fa-search"></i> Buscar</button>
                                         </div>
                                   </div>
                              </div>
                        </div>
                        <div class="form-group">
                            <label for="cardNumber"><font color="red">*</font> Alumno</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-user "></i></span>
                                </div>
                                <input type="text" class="form-control" name="cardNumber" placeholder="" id="nombrealumno">
                            </div> <!-- input-group.// -->
                        </div> <!-- form-group.// -->

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label><span class="hidden-xs"><font color="red">*</font> Mes a pagar</span> </label>
                                    <div class="form-inline">
                                        <select class="form-control" style="width:45%" id="mespago">
                                            <option value="">SELECCIONE</option>
                                            <?php
                                            if(isset($meses) && !empty($meses)){
                                                foreach($meses as $value){ ?>
                                                    <option value="<?php echo $value->idmes ?>"><?php echo $value->nombremes ?></option>
                                                <?php
                                                }
                                            }
                                            ?>
                                        </select> 
                                    </div>
                                </div>
                            </div> 
                        </div> <!-- row.// -->
                        <div class="row">
                             <div class="col-md-6 col-sm-6 col-xs-12">
                                <button class="subscribe btn btn-success btn-block" type="button" id="btnsiguiente"> Siguiente </button>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <button class="subscribe btn btn-default btn-block" type="button" id="btnreset"> Nueva busqueda </button>
                            </div>
                        </div> 
                    </form>
                </div> <!-- card-body.// -->
            </article> <!-- card.// -->


        </aside> <!-- col.// -->
        <aside class="col-sm-6">
            <p><strong>2. Forma de pago.</strong></p>

            <article class="card">
                <div class="card-body p-5">

                    <ul class="nav bg-light nav-pills rounded nav-fill mb-3" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="pill" href="#nav-tab-card">
                                <i class="fa fa-credit-card"></i> Tarjeta</a></li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="pill" href="#nav-tab-paypal">
                                <i class="fab fa-paypal"></i> Paypal</a></li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="pill" href="#nav-tab-bank">
                                <i class="fa fa-university"></i> Pago en tienda</a></li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="nav-tab-card">
                           
                            <form role="form">
                        <div class="form-group">
                            <label for="username"><font color="red">*</font> Nombre del titular de la tarjeta</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-user"></i></span>
                                </div>
                                <input type="text" class="form-control" name="username" placeholder="" required="" id="tarjetatitular">
                            </div> <!-- input-group.// -->
                        </div> <!-- form-group.// -->

                        <div class="form-group">
                            <label for="cardNumber"><font color="red">*</font> Número de la tarjeta</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-credit-card"></i></span>
                                </div>
                                <input type="text" class="form-control" name="cardNumber" placeholder="" id="numerotarjeta">
                            </div> <!-- input-group.// -->
                        </div> <!-- form-group.// -->

                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label><span class="hidden-xs"><font color="red">*</font> Vigencia</span> </label>
                                    <div class="form-inline">
                                        <select class="form-control" style="width:45%" id="tarjetames">
                                            <option>MM</option>
                                            <option>01 - Janiary</option>
                                            <option>02 - February</option>
                                            <option>03 - February</option>
                                        </select>
                                        <span style="width:10%; text-align: center"> / </span>
                                        <select class="form-control" style="width:45%" id="tarjetayear">
                                            <option>YY</option>
                                            <option>2018</option>
                                            <option>2019</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label data-toggle="tooltip" title=""
                                        data-original-title="3 digits code on back side of the card">CVV <i
                                            class="fa fa-question-circle"></i></label>
                                    <input class="form-control" required="" type="text" id="codigo">
                                </div> <!-- form-group.// -->
                            </div>
                        </div> <!-- row.// -->
                        <input type="hidden" name="numeroalumno" class="numeroalumno">
                        <input type="hidden" name="mespago" class="mespago">
                        <button class="subscribe btn btn-primary btn-block" type="button" id="btnpagartarjeta"> Confirmar pago </button>
                    </form>
                        </div> <!-- tab-pane.// -->
                        <div class="tab-pane fade" id="nav-tab-paypal">
                            <p>Paypal is easiest way to pay online</p>
                            <p>
                                <button type="button" class="btn btn-primary"> <i class="fab fa-paypal"></i> Log in my
                                    Paypal </button>
                            </p>
                            <p><strong>Note:</strong> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
                                eiusmod
                                tempor incididunt ut labore et dolore magna aliqua. </p>
                        </div>
                        <div class="tab-pane fade" id="nav-tab-bank">
                            <p>Bank accaunt details</p>
                            <dl class="param">
                                <dt>BANK: </dt>
                                <dd> THE WORLD BANK</dd>
                            </dl>
                            <dl class="param">
                                <dt>Accaunt number: </dt>
                                <dd> 12345678912345</dd>
                            </dl>
                            <dl class="param">
                                <dt>IBAN: </dt>
                                <dd> 123456789</dd>
                            </dl>
                            <p><strong>Note:</strong> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
                                eiusmod
                                tempor incididunt ut labore et dolore magna aliqua. </p>
                        </div> <!-- tab-pane.// -->
                    </div> <!-- tab-content .// -->

                </div> <!-- card-body.// -->
            </article> <!-- card.// -->


        </aside> <!-- col.// -->
    </div> <!-- row.// -->

</div>
<!--container end.//-->

<br><br>
<article class="bg-secondary mb-3">
    <div class="card-body text-center">

        <h3 class="text-white mt-3">Bootstrap 4 UI KIT</h3>
        <p class="h5 text-white">Components and templates <br> for Ecommerce, marketplace, booking websites
            and product landing pages</p> <br>
        <p><a class="btn btn-warning" target="_blank" href="http://bootstrap-ecommerce.com/"> Bootstrap-ecommerce.com
                <i class="fa fa-window-restore "></i></a></p>
    </div>
    <br><br>
</article>

<script>
       
         $(document).ready(function () { 
                $('#mespago').prop('disabled', 'disabled');
                $('#tarjetames').prop('disabled', 'disabled');
                $('#tarjetayear').prop('disabled', 'disabled');
                document.getElementById("nombrealumno").disabled = true;
                document.getElementById("tarjetatitular").disabled = true;
                document.getElementById("numerotarjeta").disabled = true;
                document.getElementById("codigo").disabled = true;
                document.getElementById("btnpagartarjeta").disabled = true;
                document.getElementById("btnsiguiente").disabled = true;
                    $('#btnbuscar').on('click', function () {
                                var matricula = $("#matricula").val();  
                                    $.ajax({
                                    type: "POST",
                                    url: "<?php echo site_url('Pagos/buscar'); ?>",
                                    data: "matricula=" + matricula,
                                    success: function (data) { 
                                        console.log(data); 
                                        var data_alumno = JSON.parse(data); 
                                        if(data_alumno.opcion == 1){
                                            $("#nombrealumno").val(data_alumno.nombre);
                                            $('#mespago').prop('disabled', false);
                                             document.getElementById("btnsiguiente").disabled = false;
                                             $('.numeroalumno').val(data_alumno.idalumno);
                                        }else{
                                             $(".print-error-msg").css('display','block');
                                             $(".print-error-msg").html(data_alumno.error);
                                             setTimeout(function() {$('.print-error-msg').fadeOut('fast');}, 3000);
                                        }
                                    }
                            });

                    });

                 $('#btnsiguiente').on('click', function () { 
                     var mespago = $('#mespago').val();
                     console.log(mespago);
                     if(mespago != ""){
                        $('.mespago').val(mespago);
                          //Deshabilar botones
                           document.getElementById("btnbuscar").disabled = true;
                           $('#mespago').prop('disabled', 'disabled');
                           document.getElementById("matricula").disabled = true;
                           document.getElementById("btnsiguiente").disabled = true;

                           //Fin deshabilitar botones

                           //Habilitar boton pago
                            document.getElementById("tarjetatitular").disabled = false;
                            document.getElementById("numerotarjeta").disabled = false;
                            document.getElementById("codigo").disabled = false;
                            document.getElementById("btnpagartarjeta").disabled = false;
                            $('#tarjetames').prop('disabled', false);
                            $('#tarjetayear').prop('disabled', false);
                            $("#tarjetatitular").focus();
                            //Fin habilitar 
                     }else{
                           $(".print-error-msg").css('display','block');
                           $(".print-error-msg").html("Seleccione el mes de pago.");
                           setTimeout(function() {$('.print-error-msg').fadeOut('fast');}, 3000);
                     }
                 });
                   $('#btnreset').on('click', function () { 
                     
                         //Habilar botones
                           document.getElementById("btnbuscar").disabled = false;
                           $('#mespago').prop('disabled', false);
                           document.getElementById("matricula").disabled = false;
                           document.getElementById("btnsiguiente").disabled = false;
                            $('#nombrealumno').val("");
                            $('#matricula').val("");
                            $("#matricula").focus();
                           //Fin habilitar botones

                           //Deshabilitar botones de pago
                            document.getElementById("tarjetatitular").disabled = true;
                            document.getElementById("numerotarjeta").disabled = true;
                            document.getElementById("codigo").disabled = true;
                            document.getElementById("btnpagartarjeta").disabled = true;
                            $('#tarjetames').prop('disabled', 'disabled');
                            $('#tarjetayear').prop('disabled', 'disabled');
                            $('#tarjetatitular').val("");
                            $('#numerotarjeta').val("");
                            $('#codigo').val("");
                            $('#tarjetames').val("");
                            $('#tarjetayear').val("");
                            //Fin de deshabilitar
                     
                 });

 });
</script>
    </body>
</html>