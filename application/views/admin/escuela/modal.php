<!--add modal-->
<modal v-if="addModal" @close="clearAll()">
    <h3 slot="head" >Agregar Escuela</h3>
    <div slot="body"  >
        <div style=" height: 200px; overflow-x: hidden; overflow-y: scroll;">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 ">
                <div class="text-danger" v-html="formValidate.msgerror"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> Clave</label>
                    <input type="text" v-model="newEscuela.clave" class="form-control"  :class="{'is-invalid': formValidate.clave}" name="po"> 
                           <div class="text-danger" v-html="formValidate.clave"></div>
                </div>
            </div>  
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> Nombre de la Escuela</label>
                    <input type="text" v-model="newEscuela.nombreplantel" class="form-control"  :class="{'is-invalid': formValidate.nombreplantel}" name="po"> 
                           <div class="text-danger" v-html="formValidate.nombreplantel"></div>
                </div>
            </div>
        </div>
        <div class="row">
             
            <div class="col-md-12 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> Dirección</label>
                    <input type="text" v-model="newEscuela.direccion" class="form-control"  :class="{'is-invalid': formValidate.direccion}" name="po"> 
                           
                            <small>Formato: Calle, Num, Colonia, CP, Ciudad, Estado.</small>
                            <div class="text-danger" v-html="formValidate.direccion"></div>
                </div>
            </div>  

        </div> 

         <div class="row">
              <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font>  Director</label>
                    <input type="text" v-model="newEscuela.director" class="form-control"  :class="{'is-invalid': formValidate.director}" name="po"> 
                           <div class="text-danger" v-html="formValidate.director"></div>
                </div>
            </div> 
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> Telefono</label>
                    <input type="text" v-model="newEscuela.telefono" class="form-control"  :class="{'is-invalid': formValidate.telefono}" name="po"> 
                           <div class="text-danger" v-html="formValidate.telefono"></div>
                </div>
            </div> 
        </div>
 
  
    </div>
    </div>
    <div slot="foot"> 
        <button class="btn btn-danger waves-effect waves-black" @click="clearAll"><i class='fa fa-ban'></i> Cancelar</button>
        <button class="btn btn-primary waves-effect waves-black" @click="addEscuela"><i class='fa fa-floppy-o'></i> Agregar</button>
    </div>
</modal>
<modal v-if="editModal" @close="clearAll()">
    <h3 slot="head" >Editar Escuela</h3>
    <div slot="body">
         <div style=" height: 200px;overflow-x: hidden; overflow-y: scroll;">
         <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 ">
                <div class="text-danger" v-html="formValidate.msgerror"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> Clave</label>
                    <input type="text" v-model="chooseEscuela.clave" class="form-control"  :class="{'is-invalid': formValidate.clave}" name="po"> 
                           <div class="text-danger" v-html="formValidate.clave"></div>
                </div>
            </div>  
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> Nombre de la Escuela</label>
                    <input type="text" v-model="chooseEscuela.nombreplantel" class="form-control"  :class="{'is-invalid': formValidate.nombreplantel}" name="po"> 
                           <div class="text-danger" v-html="formValidate.nombreplantel"></div>
                </div>
            </div>
        </div>
        <div class="row">
             
            <div class="col-md-12 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> Dirección</label>
                    <input type="text" v-model="chooseEscuela.direccion" class="form-control"  :class="{'is-invalid': formValidate.direccion}" name="po"> 
                           <div class="text-danger" v-html="formValidate.direccion"></div>
                            <small>Formato: Calle, Num, Colonia, CP, Ciudad, Estado.</small>
                </div>
            </div>  

        </div> 

         <div class="row">
              <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font>  Director</label>
                    <input type="text" v-model="chooseEscuela.director" class="form-control"  :class="{'is-invalid': formValidate.director}" name="po"> 
                           <div class="text-danger" v-html="formValidate.director"></div>

                </div>
            </div> 
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> Telefono</label>
                    <input type="text" v-model="chooseEscuela.telefono" class="form-control"  :class="{'is-invalid': formValidate.telefono}" name="po"> 
                           <div class="text-danger" v-html="formValidate.telefono"></div>
                </div>
            </div> 
        </div>
 
 
</div>
    </div>
    <div slot="foot">
        <button class="btn btn-danger waves-effect waves-black" @click="clearAll"><i class='fa fa-ban'></i> Cancelar</button>
        <button class="btn btn-primary waves-effect waves-black" @click="updateEscuela"><i class='fa fa-edit'></i> Modificar</button>
    </div>
</modal>

