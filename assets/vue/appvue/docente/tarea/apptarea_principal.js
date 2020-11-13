
var this_js_script = $('script[src*=apptarea_principal]');
var my_var_1 = this_js_script.attr('data-my_var_1');
if (typeof my_var_1 === "undefined") {
	var my_var_1 = 'some_default_value';
}

var my_var_2 = this_js_script.attr('data-my_var_2');
if (typeof my_var_2 === "undefined") {
	var my_var_2 = 'some_default_value';
}

var my_var_3 = this_js_script.attr('data-my_var_3');
if (typeof my_var_3 === "undefined") {
	var my_var_3 = 'some_default_value';
}
Vue.config.devtools = true;
Vue.use(VueCkeditor);
var vu = new Vue({
	components: { VueCkeditor },
	el: '#appplanificacion',
	data: {

		config: {
			//toolbar: [
			//  ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript']
			//],
			height: 200
		},
		url: my_var_1,
		idhorario: my_var_2,
		idhorariodetalle: my_var_3,
		addModal: false,
		editModal: false,
		cargando: false,
		error: false,
		tareas: [],
		documentos: {},
		reporte:[],
		grupos: [],
		filesSend: [],
		file: '',
		search: { text: '' },
		emptyResult: false,
		newTarea: {
			titulo: '',
			tarea: '',
			fechaentrega: '',
			horaentrega: '',

			smserror: ''
		},
		buscarRegistros: {
			fechainicio: '',
			fechafin: '',
			texto: ''
		},
		chooseTarea: {},
		formValidate: [],
		successMSG: '',

		//pagination
		currentPage: 0,
		rowCountPage: 10,
		totalTareas: 0,
		pageRange: 2,
		directives: { columnSortable }
	},
	created() {
		this.showAll();
		this.showAllGrupos();
	},
	methods: {
		orderBy(sortFn) {
			// sort e array data like this.userArray
			this.tareas.sort(sortFn);
		},
		abrirAddModal() {
			$("#addRegister").modal("show");
		},
		abrirEditModal() {
			$("#editRegister").modal("show");
		},
		abrirDocumentosModal() {
			$("#documentosTareas").modal("show");
		},
		showAll() {
			axios.get(this.url + "Tarea/showAll", {
				params: {
					idhorariodetalle: this.idhorariodetalle,
				}
			}).then(function(response) {
				if (response.data.tareas == null) {
					vu.noResult()
				} else {
					vu.getData(response.data.tareas);
				}
			})
		},
		showAllGrupos() {
			axios.get(this.url + "Planificacion/showAllGrupos/")
				.then(
					(response) => (this.grupos = response.data.grupos)
				);
		},
		searchTarea() {
			var formData = vu.formData(vu.buscarRegistros);
			axios.post(this.url + "Tarea/searchTarea", formData, {
				params: {
					idhorariodetalle: this.idhorariodetalle,
				}
			}).then(function(response) {
				if (response.data.error) {
					vu.formValidate = response.data.msg;
					vu.error = true; 
				} else { 
			vu.formValidate = false;
					if (response.data.tareas == null) {
						vu.noResult()
					} else {
						vu.getData(response.data.tareas);

					}
				}
			})
		},
		generarReporte() {
			var formData = vu.formData(vu.buscarRegistros);
			axios.post(this.url + "Tarea/reporteCalificaciones", formData, {
				params: {
					idhorariodetalle: this.idhorariodetalle,
				}
			}).then(function(response) {
				if (response.data.error) {
					vu.formValidate = response.data.msg;
					vu.error = true; 
				} else { 
					vu.error = false;
					vu.reporte = response.data;
					vu.exportExcel();
				}
			})
		},
		exportExcel: function () {
			let data = XLSX.utils.json_to_sheet(this.reporte)
			const workbook = XLSX.utils.book_new()
			const filename = 'Reporte de Calificaciones'
			XLSX.utils.book_append_sheet(workbook, data, filename)
			XLSX.writeFile(workbook, `${filename}.xlsx`)
		  },
		addTarea() {
			vu.cargando = true;
			vu.error = false;
			var formData = vu.formData(vu.newTarea);
			for (var i = 0; i < this.filesSend.length; i++) {
				let file = this.filesSend[i];
				formData.append('files[' + i + ']', file);
			}
			formData.append('idhorario', this.idhorario);
			formData.append('idhorariodetalle', this.idhorariodetalle);
			axios.post(this.url + "Tarea/addTarea", formData, {
				headers: {
					'Content-Type': 'multipart/form-dara'
				}
			}).then(function(response) {
				if (response.data.error) {
					vu.formValidate = response.data.msg;
					vu.error = true;
					vu.cargando = false;
				} else {
					swal({
						position: 'center',
						type: 'success',
						title: 'Registrado!',
						showConfirmButton: false,
						timer: 1500
					});

					vu.clearAll();
					vu.clearMSG();
				}
			});
		},
		onChangeFileUploadAdd(e) {
			var selectedFiles = e.target.files;
			for (let i = 0; i < selectedFiles.length; i++) {
				this.filesSend.push(selectedFiles[i]);
			}
		},
		onChangeFileUploadEdit(e) {
			var selectedFiles = e.target.files;
			for (let i = 0; i < selectedFiles.length; i++) {
				this.filesSend.push(selectedFiles[i]);
			}
		},
		removeElement: function(index) {
			this.filesSend.splice(index, 1);
			if (this.filesSend.length == 0) {
				this.$refs.fileadd.value == '';
			}
		},
		updateTarea() {
			vu.cargando = true;
			vu.error = false;
			var formData = vu.formData(vu.chooseTarea);
			for (var i = 0; i < this.filesSend.length; i++) {
				let file = this.filesSend[i];
				formData.append('files[' + i + ']', file);
			}
			formData.append('idhorario', this.idhorario);
			formData.append('idhorariodetalle', this.idhorariodetalle);
			axios.post(this.url + "Tarea/updateTarea", formData, {
				headers: {
					'Content-Type': 'multipart/form-dara'
				}
			}).then(function(response) {
				if (response.data.error) {
					vu.formValidate = response.data.msg;
					vu.error = true;
					vu.cargando = false;
				} else {
					//vu.successMSG = response.data.success;
					swal({
						position: 'center',
						type: 'success',
						title: 'Modificado!',
						showConfirmButton: false,
						timer: 1500
					});
					vu.clearAll();
					vu.clearMSG();

				}
			}).catch((error) => {
				swal("Información", "Ocurrio un error, intente mas tarde", "info");
			});
		},
		deleteTarea(id) {
			Swal.fire({
				title: '¿Eliminar Tarea?',
				text: "Realmente desea eliminar la Tarea.",
				type: 'question',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Eliminar',
				cancelButtonText: 'Cancelar'
			}).then((result) => {
				if (result.value) {

					axios.get(this.url + "Tarea/deleteTarea", {
						params: {
							id: id
						}
					}).then(function(response) {
						if (response.data.error == false) {
							swal({
								position: 'center',
								type: 'success',
								title: 'Eliminado!',
								showConfirmButton: false,
								timer: 3000
							});
							vu.clearAll();
							vu.clearMSG();
						} else {
							swal("Información", response.data.msg.msgerror, "info");
						}
					}).catch((error) => {
						swal("Información", "No se puede eliminar la Tarea", "info");
					});
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
		getData(tareas) {
			vu.emptyResult = false; // become false if has a record
			vu.totalTareas = tareas.length; //get total of user
			vu.tareas = tareas.slice(vu.currentPage * vu.rowCountPage, (vu.currentPage * vu.rowCountPage) + vu.rowCountPage); //slice the result for pagination

			// if the record is empty, go back a page
			if (vu.tareas.length == 0 && vu.currentPage > 0) {
				vu.pageUpdate(vu.currentPage - 1);
				vu.clearAll();
			}
		},

		selectTarea(tarea) {
			vu.chooseTarea = tarea;
		},
		selectDocumentos(idtarea) {
			axios.get(this.url + "Tarea/obtenerDocumentosTarea", {
				params: {
					idtarea: idtarea,
				}
			}).then(function(response) {
				if (response.data != null) {
					vu.documentos = response.data;
				}
			})
		},
		clearMSG() {
			setTimeout(function() {
				vu.successMSG = ''
			}, 3000); // disappearing message success in 2 sec
		},
		clearAll() {
			vu.cargando = false;
			vu.error = false;
			$("#editRegister").modal("hide");
			$("#addRegister").modal("hide");
			$("#documentosTareas").modal("hide");
			$("#fileadd").val(null);
			$("#fileedit").val(null);
			vu.newTarea = {
				titulo: '',
				tarea: '',
				fechaentrega: '',
				horaentrega: '',
				smserror: ''
			};
			vu.formValidate = false;
			vu.refresh();

		},
		noResult() {
			vu.emptyResult = true;  // become true if the record is empty, print 'No Record Found'
			vu.tareas = null;
			vu.totalTareas = 0; //remove current page if is empty 
		},

		pageUpdate(pageNumber) {
			vu.currentPage = pageNumber; //receive currentPage number came from pagination template
			vu.refresh();
		},
		refresh() {
			vu.search.text ? vu.searcTarea() : vu.showAll(); //for preventing

		}
	}
})
