<style>
	.row [class*='body'] {

		min-height: 160px;
	}

	.card .badge {
		position: absolute;
		top: -10px;
		right: -10px;
		padding: 10px 12px;
		border-radius: 50%;
		background: red;
		color: white;
	}
</style>
<!-- page content -->
<div class="right_col" role="main">

	<div class="">

		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<h2>
							<strong><i class="fa fa-book"></i> CLASES EN ESTE CURSO</strong>
						</h2>

						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<?php
						if (isset($materias) && !empty($materias)) {
							$i = 0;

							echo '<div class="row">';

							foreach ($materias as $item) {
								$i++;
								$imp = '<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
								<div class="card">';
								$resta = $item->totaltareaenviada  - $item->totaltareacontestada;

								$imp .= '<div class="body">
                                       <strong><i class="fa fa-book"></i> ' . $item->nombreclase . '</strong> <br>
                                       <small><i class="fa fa-user"></i> ' . $item->nombre . " " . $item->apellidop . " " . $item->apellidom . '</small>       
                                     </div>
										
											<div class="header">
										<small>';
								if ($item->opcion == 0) {
									$imp .= 'RECUPERACION';
								} else {
									$imp .= 'NORMAL';
								}
								$imp .= '</small><br/>
								Tareas: ';
								if ($item->totaltareaenviada  > 0 && $resta > 0) {
									$imp .= '<span style="color:#ff0033;"><strong>' .
										($item->totaltareaenviada  - $item->totaltareacontestada) . '</strong>
								</span><br/>';
								} else {
									$imp .= '<span style="color:#70d55c;"><strong>0</strong></span><br/>';
								}
								$imp .= 'Mensajes: ';
								if ($item->mensajesnovistos > 0) {
									$imp .= '<span style="color:#ff0033;"><strong>' . $item->mensajesnovistos . '</strong></span><br/>';
								} else {
									$imp .= '<span style="color:#70d55c;"><strong>0</strong></span><br/>';
								}
								$imp .= '		<ul class="header-dropdown m-r--5">
											 
											<li class="dropdown"><a href="javascript:void(0);"
												class="dropdown-toggle" data-toggle="dropdown" role="button"
												aria-haspopup="true" aria-expanded="false"> <i  style="color:#179ff5;"
													class="fa fa-align-justify"></i>
											</a>
												<ul class="dropdown-menu pull-right">
													<li><a href="' . site_url("Aalumno/asistencia/" . $controller->encode($item->idhorario) . "/" . $controller->encode($item->idhorariodetalle) . "/" . $controller->encode($item->idmateria)) . '"> Asistencias</a></li>
													<li><a href="' . site_url("Aalumno/tareas/" . $controller->encode($item->idhorario) . "/" . $controller->encode($item->idhorariodetalle) . "/" . $controller->encode($item->idmateria)) . '"> Tarea</a></li>
													<li><a href="' . site_url("Aalumno/mensajes/" . $controller->encode($item->idhorario) . "/" . $controller->encode($item->idhorariodetalle) . "/" . $controller->encode($item->idmateria)) . '"> Mensajes</a></li>
												  </ul></li>
										</ul>
									</div>
								</div>
							</div>';
								echo $imp;

								if ($i == 4) { // three items in a row. Edit this to get more or less items on a row
									echo '</div><div class="row">';
									$i = 0;
								}
							}
							echo '</div>';
						}

						?>


					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- footer content -->
	<footer>
		<div class="copyright-info">
			<p class="pull-right">
				SICE - Sistema Integral para el Control Escolar</a>
			</p>
		</div>
		<div class="clearfix"></div>
	</footer>
	<!-- /footer content -->

</div>
<!-- /page content -->
</div>

</div>

<div id="custom_notifications" class="custom-notifications dsp_none">
	<ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
	</ul>
	<div class="clearfix"></div>
	<div id="notif-group" class="tabbed_notifications"></div>
</div>