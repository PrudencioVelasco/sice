<style>
	#lista li {
		float: left;
	}

	#lista li img {
		float: left;
		padding: 5px;
		margin: 85px;
	}
</style>
<div class="modal fade" id="editRegister" tabindex="-1" role="dialog">
	<div class="modal-dialog  modal-lg " role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="smallModalLabel">{{tarea.titulo}}</h4>
			</div>
			<div class="modal-body">
				<div style="padding-right: 15px;">
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12 ">
							<label class="col-red" v-html="formValidate.msgerror"></label>
						</div>
					</div>
					<div class="row">
						<div class="col-md-8 col-sm-12 col-xs-12 ">
							<div v-if="tarea.tarea" v-html="tarea.tarea"></div>
						</div>
						<div class="col-md-4 col-sm-12 col-xs-12 " align="right">
							<a v-if="tarea.iddocumento" v-bind:href="'https://drive.google.com/uc?export=download&id='+ tarea.iddocumento"><i class="fa fa-download"></i> DESCARGAR DOCUMENTO</a>

							<div v-for="file in documentosdelprofesor" :key="file.iddocumento">

								<a v-if="file.link !=''" v-bind:href="file.ligapreview" target="_blank"><i class="fa fa-cloud-eye"></i> DESCARGAR
									DOCUMENTO</a>
								<a v-else v-bind:href="'https://drive.google.com/uc?export=download&id='+ file.iddocumento" target="_blank"><i class="fa fa-cloud-download"></i> DESCARGAR
									DOCUMENTO</a>
							</div>
						</div>
					</div>
					<hr>
					<div v-for="row in detalletarea">

						<div class="row">
							<div class="col-md-8 col-sm-12 col-xs-12 ">
								<small><strong>De: {{row.apellidop}} {{row.apellidom}}
										{{row.nombre}}</strong></small>
								<div v-html="row.mensaje"></div>
							</div>
							<div class="col-md-4 col-sm-12 col-xs-12 " align="right">
								<span class="label label-default">Entega: {{row.fecharegistro}}</span><br>
								<span class="label label-info">Calificación :
									{{row.calificacion}}</span> <br> <br>
								<button @click="abrirModalSecundario(row)" class="btn  btn-primary  waves-effect waves-float">Calificar</button>
							</div>

						</div>
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12 " align="right">


								<div class="col-md-55" v-if="row.iddocumento">
									<div class="thumbnail">
										<div class="image view view-first">
											<img v-if="file.ext == 'jpg' || file.ext == 'jpeg' || file.ext == 'png'" style="width: 100%; display: block;" v-bind:src="'https://drive.google.com/thumbnail?id'+ row.iddocumento" alt="Archivo" />
											<img v-else alt="Archivo" v-bind:src="'https://drive.google.com/thumbnail?id'+ row.iddocumento" style="width: 100%; display: block;">
											<div class="mask">

												<div class="tools tools-bottom">
													<a v-bind:href="'https://drive.google.com/uc?export=download&id='+ row.iddocumento" target="_blank"><i class="fa fa-download"></i></a>
												</div>
											</div>
										</div>
									</div>
								</div>

								<div v-for="file in row.documentos">
									<div class="col-md-55">
										<div class="thumbnail">
											<div class="image view view-first">
												<img v-if="file.link != ''" style="width: 100%; display: block;" v-bind:src="file.link" alt="No se puede previsualizar el archivo" />
												<img v-else alt="Archivo" v-bind:src="'https://drive.google.com/thumbnail?id='+ file.file" style="width: 100%; display: block;">


												<div class="mask">

													<div class="tools tools-bottom">
														<a v-if="file.link !=''" v-bind:href="file.ligapreview" target="_blank"><i class="fa fa-eye"></i></a>
														<a v-else v-bind:href="'https://drive.google.com/uc?export=download&id='+ file.file" target="_blank"><i class="fa fa-download"></i></a>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>



							</div>
						</div>
						<hr />
					</div>


					<hr>

				</div>
			</div>
			<div class="modal-footer">
				<div class="row">
					<div class="col-md-6 col-sm-12 col-xs-12 " align="center">
						<div v-if="cargando">
							<img style="width: 50px;" src="<?php echo base_url() . '/assets/loader/pagos.gif' ?>" alt=""> <strong>Procesando...</strong>
						</div>
						<div v-if="error" align="left">
							<label class="col-red">*Corrija los errores en el formulario.</label>
						</div>
					</div>
					<div class="col-md-6 col-sm-12 col-xs-12 " align="right">
						<button class="btn btn-danger waves-effect waves-black" @click="clearAll">
							<i class='fa fa-ban'></i> Cerrar
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="addCalificacion" tabindex="-1" role="dialog">
	<div class="modal-dialog  " role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="smallModalLabel">REGISTRAR CALIFICACIÓN</h4>
			</div>
			<div class="modal-body">
				<div style="padding-right: 15px;">
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12 ">
							<label class="col-red" v-html="formValidate.msgerror"></label>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12 ">
							<label>
								<font color="red">*</font> Calificación
							</label> <input type="text" v-model="chooseTareaCalificar.calificacion" minlength="0.00" maxlength="10.00" name="calificacion" class="form-control" placeholder="0.0 a 10.0">
							<div class="col-red" v-html="formValidate.calificacion"></div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12 ">
							<label>Observaciones</label>
							<vue-ckeditor v-model="chooseTareaCalificar.observacionesdocente" :config="config" />
							<div class="col-red" v-html="formValidate.observacionesdocente"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<div class="row">
					<div class="col-md-6 col-sm-12 col-xs-12 " align="center">
						<div v-if="cargando">
							<img style="width: 50px;" src="<?php echo base_url() . '/assets/loader/pagos.gif' ?>" alt=""> <strong>Procesando...</strong>
						</div>
						<div v-if="error" align="left">
							<label class="col-red">*Corrija los errores en el formulario.</label>
						</div>
					</div>
					<div class="col-md-6 col-sm-12 col-xs-12 " align="right">
						<button class="btn btn-danger waves-effect waves-black" @click="cerrarModalSecundario()">
							<i class='fa fa-ban'></i> Cancelar
						</button>
						<button class="btn btn-primary waves-effect waves-black" @click="updateAlumnosTareas()">
							<i class='fa fa-check'></i> Calificar
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>