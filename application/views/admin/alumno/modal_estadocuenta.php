<modal v-if="addModal" @close="clearAll()">
   <h3 slot="head" >Agregar Cobro</h3>
   <div slot="body">
      <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 ">
                <label style="color: red" v-html="formValidate.msgerror"></label>
            </div>
        </div>
        <div class="row">
     <div class="col-md-12 col-sm-12 col-xs-12 ">
          <input type="hidden" name="" v-model="chooseSolicitud.idamortizacion" > 
         <div class="form-group">
           <label><font color="red">*</font> Total a pagar</label>
              <input type="text" v-model="chooseSolicitud.descuento" class="form-control"  :class="{'is-invalid': formValidate.descuento}" name="po" disabled=""> 
         </div>
         <div class="form-group">
          <label><font color="red">*</font> Forma de Pago</label>
          <select v-model="newCobro.idformapago"  :class="{'is-invalid': formValidate.idperiodo}" class="form-control">
                   <option value="">--Seleccione Forma Pago--</option>
                   <option   v-for="option in formaspago" v-bind:value="option.idformapago">
                        {{ option.nombretipopago }} 
                  </option>
         </select>
           <div class="text-danger" v-html="formValidate.idformapago"></div>
         </div>
          <div class="form-group">
            <label>Número Autorización</label>
             <input type="text" v-model="newCobro.autorizacion" class="form-control"  :class="{'is-invalid': formValidate.autorizacion}" name="po"> 
              <div class="text-danger" v-html="formValidate.autorizacion"></div>
         </div> 
      </div>
     </div>
   </div>
   <div slot="foot"> 
    <button type="button" class="btn btn-danger"  @click="clearAll"> <i class="fa fa-times"></i> Cancelar</button>
      <button class="btn btn-primary" @click="addCobro" ><i class="fa fa-check-circle"></i> Cobrar</button>
   </div>
</modal>


<modal v-if="addPagoModal" @close="clearAll()">
   <h3 slot="head" >Agregar Cobro</h3>
   <div slot="body">
      <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 ">
                <label style="color: red" v-html="formValidate.msgerror"></label>
            </div>
        </div>
        <div class="row">
     <div class="col-md-12 col-sm-12 col-xs-12 "> 
         <div class="form-group">
           <label><font color="red">*</font> Total a pagar</label>
              <input type="text" v-model="newCobroInicio.descuento" class="form-control"  :class="{'is-invalid': formValidate.descuento}" name="po" > 
              <small>Ejemplo: 300.00, 500.50, etc.</small>
              <div class="text-danger" v-html="formValidate.descuento"></div>
         </div>
          <div class="form-group">
          <label><font color="red">*</font> Tipo de Pago</label>
          <select v-model="newCobroInicio.idtipopagocol"  :class="{'is-invalid': formValidate.idtipopagocol}" class="form-control">
                   <option value="">--Seleccione Tipo Pago--</option>
                   <option   v-for="option in tipospago" v-bind:value="option.idtipopagocol">
                        {{ option.concepto }} 
                  </option>
         </select>
           <div class="text-danger" v-html="formValidate.idtipopagocol"></div>
         </div>
         <div class="form-group">
          <label><font color="red">*</font> Forma de Pago</label>
          <select v-model="newCobroInicio.idformapago"  :class="{'is-invalid': formValidate.idperiodo}" class="form-control">
                   <option value="">--Seleccione Forma Pago--</option>
                   <option   v-for="option in formaspago" v-bind:value="option.idformapago">
                        {{ option.nombretipopago }} 
                  </option>
         </select>
           <div class="text-danger" v-html="formValidate.idformapago"></div>
         </div>
          <div class="form-group">
            <label>Número Autorización</label>
             <input type="text" v-model="newCobroInicio.autorizacion" class="form-control"  :class="{'is-invalid': formValidate.autorizacion}" name="po"> 
              <div class="text-danger" v-html="formValidate.autorizacion"></div>
         </div> 
      </div>
     </div>
   </div>
   <div slot="foot"> 
    <button type="button" class="btn btn-danger"  @click="clearAll"> <i class="fa fa-times"></i> Cancelar</button>
      <button class="btn btn-primary" @click="addCobroInicio" ><i class="fa fa-check-circle"></i> Cobrar</button>
   </div>
</modal>

<modal v-if="addPagoColegiaturaModal" @close="clearAll()">
   <h3 slot="head" >Agregar Cobro</h3>
   <div slot="body">
      <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 ">
                <label style="color: red" v-html="formValidate.msgerror"></label>
            </div>
        </div>
        <div class="row">
     <div class="col-md- col-sm-6 col-xs-12 "> 
         <div class="form-group">
           <label><font color="red">*</font> Total a pagar</label>
              <input type="text" v-model="newCobroColegiatura.descuento" class="form-control"  :class="{'is-invalid': formValidate.descuento}" name="po" > 
              <small>Ejemplo: 300.00, 500.50, etc.</small>
              <div class="text-danger" v-html="formValidate.descuento"></div>
         </div> 
</div>
         <div class="col-md-6 col-sm-6 col-xs-12 "> 
         <div class="form-group">
          <label><font color="red">*</font> Mes a pagar</label>
          <select v-model="newCobroColegiatura.idmes"  :class="{'is-invalid': formValidate.idmes}" class="form-control">
                   <option value="">--Seleccione Mes--</option>
                   <option   v-for="option in meses" v-bind:value="option.idmes">
                        {{ option.nombremes }} 
                  </option>
         </select>
           <div class="text-danger" v-html="formValidate.idmes"></div>
         </div>
         </div>
         </div>
         <div class="row">
              <div class="col-md-6 col-sm-6 col-xs-12 "> 
         <div class="form-group">
          <label><font color="red">*</font> Forma de Pago</label>
          <select v-model="newCobroColegiatura.idformapago"  :class="{'is-invalid': formValidate.idperiodo}" class="form-control">
                   <option value="">--Seleccione Forma Pago--</option>
                   <option   v-for="option in formaspago" v-bind:value="option.idformapago">
                        {{ option.nombretipopago }} 
                  </option>
         </select>
           <div class="text-danger" v-html="formValidate.idformapago"></div>
         </div>
</div>
  <div class="col-md-6 col-sm-6 col-xs-12 "> 
          <div class="form-group">
            <label>Número Autorización</label>
             <input type="text" v-model="newCobroColegiatura.autorizacion" class="form-control"  :class="{'is-invalid': formValidate.autorizacion}" name="po"> 
              <div class="text-danger" v-html="formValidate.autorizacion"></div>
         </div> 
      </div>
     </div>
   </div>
   <div slot="foot"> 
    <button type="button" class="btn btn-danger"  @click="clearAll"> <i class="fa fa-times"></i> Cancelar</button>
      <button class="btn btn-primary" @click="addCobroColegiatura" ><i class="fa fa-check-circle"></i> Cobrar</button>
   </div>
</modal>
