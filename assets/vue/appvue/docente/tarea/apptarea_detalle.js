
var this_js_script = $('script[src*=apptarea_detalle]');
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
var my_var_4 = this_js_script.attr('data-my_var_4');
if (typeof my_var_4 === "undefined") {
	var my_var_4 = 'some_default_value';
}
var my_var_5 = this_js_script.attr('data-my_var_5');
if (typeof my_var_5 === "undefined") {
	var my_var_5 = 'some_default_value';
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
		idtarea: my_var_2,
		idhorario: my_var_3,
		idmateria: my_var_4,
		idprofesormateria: my_var_5,
		addModal: false,
		editModal: false,
		cargando: false,
		error: false,
		alumnostareas: [],
		estatustarea: [],
		documentos: [],
		//PRUDENCIO
		detalletarea: [],
		tarea: [],
		documentosdelprofesor: [],
		documentosdelalumno: [], 
		search: { text: '' },
		emptyResult: false,
		success: false,
		loading: false,
		newTarea: {
			titulo: '',
			tarea: '',
			fechaentrega: '',
			horaentrega: '',
			smserror: ''
		},
		newCalificar: {
			idestatustarea: ''
		},
		chooseAlumnosTareas: {},
		chooseTareaCalificar:{},
		formValidate: [],
		successMSG: '',

		//pagination
		currentPage: 0,
		rowCountPage: 15,
		totalAlumnosTareas: 0,
		pageRange: 2,
		directives: { columnSortable }
	},
	created() {
		this.showAll();
		this.showAllEstatusTarea();
	},
	 
	methods: {
		orderBy(sortFn) {
			// sort e array data like this.userArray
			this.alumnostareas.sort(sortFn);
		},
		abrirAddModal() {
			$("#addRegister").modal({backdrop:'static',keyboard:false});
		},
		abrirEditModal() {
			$("#editRegister").modal({backdrop:'static',keyboard:false});
		},
		abrirModalSecundario(tarea){
			vu.chooseTareaCalificar = tarea;
			$("#editRegister").modal("hide");
			$("#addCalificacion").modal({backdrop:'static',keyboard:false});
		},
		showAll() {
			this.loading = true;
			axios.get(this.url + "Tarea/showAllAlumnosTarea", {
				params: {
					id: this.idtarea,
					idhorario: this.idhorario,
					idmateria: this.idmateria,
					idprofesormateria: this.idprofesormateria
				},
			}).then(function(response) {
				this.loading = false;
				if (response.data.alumnostareas == null) {
					vu.noResult()
				} else {
					vu.getData(response.data.alumnostareas);
				}
			}).catch((error) => {
				vu.error = true;
				vu.loading = false;
			}).finally(() => {
				vu.loading = false
			});
		},
		reset() {
			this.success = false;
			this.error = false;
		},
		showAllEstatusTarea() {
			axios.get(this.url + "Tarea/showAllEstatusTarea/")
				.then((response) => (this.estatustarea = response.data.estatustarea));
		},

		//PRUDENCIO
		tareasEnvidasPorAlumno(alumno) {
			axios.get(this.url + "Tarea/tareasEnvidasPorAlumno", {
				params: {
					idtarea: this.idtarea,
					idalumno: alumno.idalumno,
				}
			}).then((response) => (vu.detalletarea = response.data));

		},

		detalleTarea(alumno) {
			axios.get(this.url + "Tarea/showDetalleTarea", {
				params: {
					idtarea: this.idtarea
				}
			}).then((response) => (vu.tarea = response.data.tarea));
		},
		showDocumentosTareaProfesor() {
			this.documentosdelprofesor = [];
			axios.get(this.url + "Tarea/documentosTareaProfesor", {
				params: {
					idtarea: this.idtarea
				}
			}).then((response) => (vu.documentosdelprofesor = response.data));
		},
		//PRUDENCIO
		/* showDocumentosTarea(alumno) {
			 this.documentos = [];
			 axios.get(this.url + "Tarea/obtenerDocumentosTareaRevisar", {
				 params: {
					 idtarea: this.idtarea,
					 idalumno: alumno,
				 }
			 }).then((response) => (vu.documentos = response.data.documentos));
		 },*/
		searchAlumnosTareas() {
			var formData = vu.formData(vu.search);
			axios.post(this.url + "Tarea/searchAllAlumnosTarea", formData, {
				params: {
					id: this.idtarea,
					idhorario: this.idhorario,
					idmateria: this.idmateria,
					idprofesormateria: this.idprofesormateria,
				},
			}).then(function(response) {
				if (response.data.alumnostareas == null) {
					vu.noResult()
				} else {
					vu.getData(response.data.alumnostareas);

				}
			})
		},
		updateAlumnosTareas() {
			vu.cargando = true;
			vu.error = false;
			var formData = vu.formData(vu.chooseTareaCalificar);
			formData.append('pcalificacion', this.calificacion);
			formData.append('pobservacion', this.observacionmaestro);
			axios.post(this.url + "Tarea/calificarTareaAlumno", formData).then(function(response) {
				if (response.data.error) {
					vu.formValidate = response.data.msg;
					vu.error = true;
					vu.cargando = false;
				} else {
					//vu.successMSG = response.data.success;
					swal({
						position: 'center',
						type: 'success',
						title: 'Calificado!',
						showConfirmButton: false,
						timer: 1500
					});
					vu.cerrarModalSecundario();
					vu.clearMSG();
					vu.tareasEnvidasPorAlumno(vu.chooseTareaCalificar);

				}
			}).catch((error) => {
				swal("Información", "Ocurrio un error, intente mas tarde", "info");
			});
		},

		formData(obj) {
			var formData = new FormData();
			for (var key in obj) {
				formData.append(key, obj[key]);
			}
			return formData;
		},
		getData(alumnostareas) {
			vu.emptyResult = false; // become false if has a record
			vu.totalAlumnosTareas = alumnostareas.length; //get total of user
			vu.alumnostareas = alumnostareas.slice(vu.currentPage * vu.rowCountPage, (vu.currentPage * vu.rowCountPage) + vu.rowCountPage); //slice the result for pagination

			// if the record is empty, go back a page
			if (vu.alumnostareas.length == 0 && vu.currentPage > 0) {
				vu.pageUpdate(vu.currentPage - 1);
				vu.clearAll();
			}
		},

		selectAlumnosTareas(tarea) {
			vu.chooseAlumnosTareas = tarea;
		},
		clearMSG() {
			setTimeout(function() {
				vu.successMSG = ''
			}, 3000); // disappearing message success in 2 sec
		},
		cerrarModalSecundario(){
			$("#addCalificacion").modal("hide")
			$("#editRegister").modal({backdrop:'static',keyboard:false});
			vu.cargando = false;
			vu.error = false;
			//vu.showAll();
			vu.formValidate = false;
			vu.refresh();
			vu.calificacion = '';
			vu.observacionmaestro = '';
		},
		clearAll() {
			vu.cargando = false;
			vu.error = false;
			$("#editRegister").modal("hide");
			$("#addRegister").modal("hide");
			//vu.showAll()
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
			vu.alumnostareas = null;
			vu.totalAlumnosTareas = 0; //remove current page if is empty 
		},
		pageUpdate(pageNumber) {
			vu.currentPage = pageNumber; //receive currentPage number came from pagination template
			vu.refresh();
		},
		refresh() {
			vu.search.text ? vu.searcAlumnosTareas() : vu.showAll(); //for preventing
		}
	}
})
