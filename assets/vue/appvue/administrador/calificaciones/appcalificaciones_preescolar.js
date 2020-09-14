
var this_js_script = $('script[src*=appcalificaciones_preescolar]');
var my_var_1 = this_js_script.attr('data-my_var_1');
if (typeof my_var_1 === "undefined") {
	var my_var_1 = 'some_default_value';
}

Vue.config.devtools = true;
var v = new Vue({
	el: '#app',
	components: {
		Multiselect: window.VueMultiselect.default
	},
	data: {
		url: my_var_1,
		cargando: false,
		error: false,
		//deleteModal:false,
		periodos: [],
		idperiodo: '',
		idgrupo: '',
		idmes: '',
		idalumno: '',
		grupos: [],
		alumnos: [],
		materias: [], 
		materias_registradas: [],
		materias_seleccionadas: [],
		calificaciones_registradas:[],
		meses: [],
		value: [],
		idtipocalificacion: '',
		tiposcalificacion: [],
		search: { text: '' },
		emptyResult: false,
		newBoleta: {
			idhorario: '',
			idprofesor: '',
			idmateriapreescolar: '',
			idtipocalificacion: '',
			idmes: '',
			observacion: '',
			smserror: ''
		},
		newFaltas: {
			totalfaltas: ''
		},
		chooseCalificacion: {},
		chooseAsistencia: {},
		formValidate: [],
		successMSG: '',

		directives: { columnSortable }
	},
	created() {
		this.showAll();
		//this.showAllMaterias();
		this.showAllTiposCalificacion();
		this.showAllPeriodos();
		this.showAllGrupos();
		this.showAllMeses();

	},
	methods: {
		onSelect(option, id) {

		},
		orderBy(sortFn) {
			this.alumnos.sort(sortFn);
		},
		abrirAddModal() {
			$('#abrirModal').modal('show');
			v.showAllMaterias(this.idgrupo);
		},
		abrirDetalleModal() {
			$('#abrirDetalleModal').modal('show');
		},
		abrirEditModal() {
			$('#abrirEditModal').modal('show');
		},
		abrirAddFaltasModal() {
			$('#abrirAddFaltasModal').modal('show');
		},
		abrirEditFaltasModal() {
			$('#abrirEditFaltasModal').modal('show');
		},
		showAll() { },
		showAllMaterias(idgrupo) {

			axios.get(this.url + "Calificacion/showAllMaterias/", {
				params: {
					idgrupo: idgrupo

				}
			})
				.then(response => (this.materias = response.data.materias));

		},
		showAllTiposCalificacion() {

			axios.get(this.url + "Calificacion/showAllTiposCalificacionPreescolar/")
				.then(response => (this.tiposcalificacion = response.data.tiposcalificacion));

		},
		showAllPeriodos() {

			axios.get(this.url + "Calificacion/showAllPeriodos/")
				.then(response => (this.periodos = response.data.periodos));

		},
		showAllGrupos() {

			axios.get(this.url + "Calificacion/showAllGrupos/")
				.then(response => (this.grupos = response.data.grupos));

		},
		showAllMeses() {

			axios.get(this.url + "Calificacion/showAllMeses/")
				.then(response => (this.meses = response.data.meses));

		},
		seleccionarAlumno(idalumno) {
			this.idalumno = idalumno;
		},
		selectAlumnoAsistencia(alumno) {
			v.chooseAsistencia = alumno;

		},
		seleccionarAlumnoCalificacion(idalumno){
			this.idalumno = idalumno;
			axios.get(this.url + "Calificacion/showCalificacionesDetalle/", {
				params: {
					idmes: this.idmes,
					idperiodo: this.idperiodo,
					idgrupo: this.idgrupo,
					idalumno: idalumno

				}
			}).then(function(response) {
				if (response.data.calificaciones_registradas != null) {
					v.calificaciones_registradas = response.data.calificaciones_registradas; 

				} 
			});
		},
		seleccionarAlumnoEditar(idalumno) {
			this.idalumno = idalumno;
			axios.get(this.url + "Calificacion/showMateriasYaRegistradas/", {
				params: {
					idmes: this.idmes,
					idperiodo: this.idperiodo,
					idgrupo: this.idgrupo,
					idalumno: idalumno

				}
			}).then(function(response) {
				if (response.data.materias_registradas != null) {
					v.materias_registradas = response.data.materias_registradas;

					v.materias_registradas.forEach(item => {
						v.materias.forEach(function(car, index, object) {
							if (car.idmateriapreescolar === item.idmateriapreescolar) {
								object.splice(index, 1);
							}
						});
					});

				} else {
					swal({
						position: 'center',
						type: 'success',
						title: 'Exito!',
						showConfirmButton: false,
						timer: 2000
					});


				}
			});
		},
		registrarFaltas() {
			v.error = false;
			v.cargando = true;
			var formData = v.formData(v.newFaltas);
			formData.append('idperiodo', v.idperiodo);
			formData.append('idgrupo', v.idgrupo);
			formData.append('idmes', v.idmes);
			formData.append('idalumno', v.idalumno);
			axios.post(this.url + "Calificacion/addFaltas", formData).then(function(response) {
				if (response.data.error) {
					v.formValidate = response.data.msg;
					v.error = true;
					v.cargando = false;
				} else {
					swal({
						position: 'center',
						type: 'success',
						title: 'Exito!',
						showConfirmButton: false,
						timer: 1500
					});

					v.clearAll();
					v.clearMSG();
				}
			});
		},
		agregarMateria() {
			if (this.value.length > 0 && this.idtipocalificacion != '') {

				this.value.forEach(item => {
					var resultado = this.materias_seleccionadas.find(clase => clase.idmateria === item.idmateriapreescolar);
					if (resultado == null) {
						var objeto = {
							// Le agregas la fecha
							idmateria: item.idmateriapreescolar,
							nombremateria: item.nombremateria,
							idcalificacion: this.idtipocalificacion,
						}

						//Lo agregas al array.
						this.materias_seleccionadas.push(objeto);
						//${item.id} ${item.name} - ${(item.price / 100).toFixed(2)} 
					}
				});

				//Limpiamos el arreglo
				this.value = [];
				v.modificarArregloMateria();
				this.idtipocalificacion = '';
				this.materias_seleccionadas.sort();
			} else {
				swal("NOTIFICACION", "SELECCIONE EL Y LOS CURSOS Y LA CALIFICACION. ", "info")
			}
		},
	    updateAsistencia() {
	      v.error = false;
	      v.cargando = true;
	      var formData = v.formData(v.chooseAsistencia);
	      axios
	        .post(this.url + "Calificacion/updateFaltas", formData)
	        .then(function (response) {
	          if (response.data.error) {
	            v.formValidate = response.data.msg;
	            v.cargando = false;
	            v.error = true;
	          } else {
	            //v.successMSG = response.data.success;
	            v.clearAll();
	            v.clearMSG();
	            swal({
	              position: "center",
	              type: "success",
	              title: "Modificado!",
	              showConfirmButton: false,
	              timer: 1500,
	            });
	          }
	        });
	    },
		eliminarMateria(idmateria) { 
			this.materias_seleccionadas.forEach(function(car, index, object) {
				if (car.idmateria === idmateria) {
					object.splice(index, 1);
				}
			});
			this.materias_seleccionadas.sort();
			v.modificarArregloMateria();
		},
		modificarArregloMateria() {
			if (this.materias_seleccionadas.length > 0) {
				this.materias_seleccionadas.forEach(item => {
					this.materias.forEach(function(car, index, object) {
						if (car.idmateriapreescolar === item.idmateria) {
							object.splice(index, 1);
						}
					});
				});
			}
			this.materias_seleccionadas.sort();
		},
		searchAlumnos() {
			var idmes = this.$refs.idmes.value;
			var idperiodo = this.$refs.idperiodo.value;
			var idgrupo = this.$refs.idgrupo.value;
			if (idmes != '' && idperiodo != '' && idperiodo != '') {
				this.idperiodo = idperiodo;
				this.idgrupo = idgrupo;
				this.idmes = idmes;
				axios.get(this.url + "Calificacion/searchAlumnos/", {
					params: {
						idmes: idmes,
						idperiodo: idperiodo,
						idgrupo: idgrupo

					}
				}).then(response => (this.alumnos = response.data.alumnos));
				v.showAllMaterias(idgrupo);
			} else {
				swal("NOTIFICACION", "SELECCIONE EL PERIODO, GRUPO Y MES. ", "info")
			}
		},
		registrarCalificacion() {
			if (v.materias_seleccionadas.length > 0) {
				v.error = false;
				v.cargando = true;
				var formData = v.formData();
				formData.append('materias_calificacion', JSON.stringify(v.materias_seleccionadas));
				formData.append('idperiodo', v.idperiodo);
				formData.append('idgrupo', v.idgrupo);
				formData.append('idmes', v.idmes);
				formData.append('idalumno', v.idalumno);
				axios.post(this.url + "Calificacion/addCalificacion", formData).then(function(response) {
					if (response.data.error) {
						v.formValidate = response.data.msg;
						v.error = true;
						v.cargando = false;
					} else {
						swal({
							position: 'center',
							type: 'success',
							title: 'Exito!',
							showConfirmButton: false,
							timer: 1500
						});

						v.clearAll();
						v.clearMSG();
					}
				});
			} else {
				swal("NOTIFICACION", "SELECCIONE LAS ASIGNATURAS PARA CALIFICAR. ", "info")
			}
		},
		eliminarMateriaAlumno(row) {

			Swal.fire({
				title: 'Eliminar Calificacion?',
				text: "Realmente desea eliminar la Calificacion.",
				type: 'question',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Eliminar',
				cancelButtonText: 'Cancelar'
			}).then((result) => {
				if (result.value) {

					axios.get(this.url + "Calificacion/deleteCalificacion", {
						params: {
							id: row.idcalificacionpreescolar
						}
					}).then(function(response) {
						if (response.data.error == false) {
							swal({
								position: 'center',
								type: 'success',
								title: 'Eliminado!',
								showConfirmButton: false,
								timer: 1500
							});

							axios.get(v.url + "Calificacion/showMateriasYaRegistradas/", {
								params: {
									idmes: v.idmes,
									idperiodo: v.idperiodo,
									idgrupo: v.idgrupo,
									idalumno: row.idalumno

								}
							}).then(function(response) {
								if (response.data.materias_registradas != null) {
									v.materias_registradas = response.data.materias_registradas;
									var objeto = {
										// Le agregas la fecha
										idmateria: row.idmateriapreescolar,
										nombremateria: row.nombremateria,
										idcalificacion: row.idtipocalificacion,
									}

									//Lo agregas al array.
									v.materias.push(objeto);



								}
							});

						} else {
							swal("Información", response.data.msg.msgerror, "info")
							v.cargando = false;
						}
					}).catch((error) => {
						swal("Información", "No se puedo Eliminar la Calificacion..", "info")
						v.cargando = false;
					})
				}
			})

		},
		formData(obj) {
			var formData = new FormData();
			for (var key in obj) {
				formData.append(key, obj[key]);
			}
			return formData;
		},

		selectTutor(tutor) {
			v.chooseTutor = tutor;
			//console.log(alumno);
		},
		clearMSG() {
			setTimeout(function() {
				v.successMSG = ''
			}, 3000); // disappearing message success in 2 sec
		},
		clearAll() {
			$('#abrirModal').modal('hide');
			$('#abrirEditModal').modal('hide');
			$('#abrirDetalleModal').modal('hide');
			$('#abrirAddFaltasModal').modal('hide');
			$('#abrirEditFaltasModal').modal('hide');
			v.newBoleta = {
				idhorario: '',
				idprofesor: '',
				idmateriapreescolar: '',
				idtipocalificacion: '',
				idmes: '',
				observacion: '',
			};
			v.newFaltas = {
				totalfaltas: ''
			};
			v.formValidate = false;
			v.value = [];
			v.materias_seleccionadas = [];
			v.showAllMaterias(this.idgrupo);
			v.searchAlumnos();
			v.cargando = false;
			v.error = false;
			//v.searchAlumnos();

		}
	}
})
