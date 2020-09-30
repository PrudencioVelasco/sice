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
<link rel="shortcut icon"
	href="<?php echo base_url(); ?>/assets/images/birrete.ico">


<!-- Firefox, Opera  -->
<link rel="icon"
	href="<?php echo base_url(); ?>/assets/images/birrete.ico">
<link rel="stylesheet"
	href="<?php echo base_url('assets/login/css/vendor.bundle.base.css'); ?>">
<link rel="stylesheet"
	href="<?php echo base_url('assets/login/css/vendor.bundle.addons.css'); ?>">
<link rel="stylesheet"
	href="<?php echo base_url('assets/login/css/style.css'); ?>">
<link rel="stylesheet"
	href="<?php echo base_url('assets/login/css/materialdesignicons.min.css'); ?>">
<script src="<?php echo base_url(); ?>/assets/js/jquery.min.js"></script>

<script src="<?php echo base_url(); ?>/assets/js/bootstrap.min.js"></script>
<script
	src="<?php echo base_url(); ?>/assets/js/sweetalert2/dist/sweetalert2.min.js"></script>
<link rel="stylesheet"
	href="<?php echo base_url(); ?>/assets/js/sweetalert2/dist/sweetalert2.min.css">
<style>
.cuadro {
	border: solid red 2px;
	padding-left: 20px;
	border-radius: 10px;
}
 .error{
 color:red;
 background-color:red;
 }
</style>
</head>

<body>
	<div class="container-scroller">
		<div class="container-fluid page-body-wrapper full-page-wrapper">
			<div class="content-wrapper auth p-0 theme-two">
				<div class="row d-flex align-items-stretch">
					<div
						class="col-md-4 banner-section d-none d-md-flex align-items-stretch justify-content-center">
						<div class="slide-content bg-1"></div>
					</div>
					<div class="col-12 col-md-8 h-100 bg-white">

						<div
							class="auto-form-wrapper d-flex align-items-center justify-content-center flex-column">


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
									<h3 align="center" class="txtinstituto">
										<strong>CAMBIAR CONTRASEÑA</strong>
									</h3>

									<hr>

									 
										<form method="POST"
											action="<?= base_url('welcome/cambiar_password') ?>">
											 
											<div class="form-group">
												<label><strong>Nueva Contraseña</strong></label>
												<input class="form-control" placeholder="******"
												 name="password" id="pass" type="password"> 
												 <small><em>Combine numero, letras y caracteres.</em></small><br>
													<input
													type="checkbox" onclick="docente()" /> <small>Mostrar/Ocultar
													contraseña</small>
													<br>
													<span id="passstrength"></span>
											</div>
											 
											<div class="form-group">
											<input type="hidden" name="data" value="<?php echo $id; ?>" >
												<button type="submit" id="btncambiar" class="btn btn-primary btn-block">
													Cambiar</button>
											</div>
											<!-- form-group// -->
										</form>
									 
								</article>
							</div>
							<!-- card.// -->



						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>
	$("#btncambiar").prop('disabled', true);
$('#pass').keyup(function(e) {
     var strongRegex = new RegExp("^(?=.{8,})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*\\W).*$", "g");
     var mediumRegex = new RegExp("^(?=.{7,})(((?=.*[A-Z])(?=.*[a-z]))|((?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))).*$", "g");
     var enoughRegex = new RegExp("(?=.{6,}).*", "g");
     if (false == enoughRegex.test($(this).val())) {
        $("#passstrength").css({"color": "black", "font-size": "14px"});
        $("#btncambiar").prop('disabled', true);
        	$("#passstrength").css({"color": "red", "font-size": "14px"});
             $('#passstrength').html('Escriba más caracteres.');
     } else if (strongRegex.test($(this).val())) {
             $('#passstrength').className = 'ok';
              $("#passstrength").css({"color": "#05B233", "font-size": "14px"});
             $('#passstrength').html('Seguridad: Fuerte!');
             $("#btncambiar").prop('disabled', false);
     } else if (mediumRegex.test($(this).val())) {
   			  $("#passstrength").css({"color": "#05B233", "font-size": "14px"});
             $('#passstrength').className = 'alert';
             $('#passstrength').html('Seguridad: Media!');
             $("#btncambiar").prop('disabled', false);
     } else {
     		$("#passstrength").css({"color": "red", "font-size": "14px"});
     		$("#btncambiar").prop('disabled', true);
             $('#passstrength').className = 'error';
             $('#passstrength').html('Seguridad: Débil!');
     }
     return true;
});
</script>
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
  var x = document.getElementById("pass");
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

</body>
</html>