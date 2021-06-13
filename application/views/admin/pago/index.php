 <div class="right_col" role="main">

     <div class="">

         <div class="row">
             <div id="app">
                 <div class="col-md-7 col-xs-12">
                     <div class="x_panel">
                         <div class="x_title">
                             <h2><i class="fa fa-list"></i> Detalle de cobro </h2>
                             <div class="clearfix"></div>
                         </div>
                         <div class="x_content">
                             <div class="row">
                                 <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                                     <v-select :options="pagosalumno" :value="pagosalumno.idconcepto" placeholder="Buscar concepto" label="concepto" @input="changedAdd"></v-select>
                                 </div>
                             </div>
                             <div class="row">
                                 <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                                     <table class="table table-hover table-striped">
                                         <thead class="bg-teal">
                                             <th class="text-white">Concepto </th>
                                             <th class="text-white">Precio </th>
                                             <th class="text-white">Desc </th>
                                             <th class="text-white">Total </th>
                                             <th class="text-white"> </th>
                                         </thead>
                                         <tbody class="table-light">
                                             <tr v-for="(row, index) in array_pago_detalle" class="table-default">

                                                 <td>{{row.concepto}}</td>
                                                 <td>{{row.descuento | currency }}</td>
                                                 <td>{{row.descuentoporcentajeindividual + row.descuentoporcentajeglobal}}%</td>
                                                 <td>{{row.total | currency}}</td>
                                                 <td align="center">
                                                     <a href="#" @click="deleteItem(index);"><i class="fa fa-trash" style="color:red;"></i></a>
                                             </tr>

                                             <tr v-if="array_pago_detalle.length == 0">
                                                 <td align="center" colspan="5">Sin registros</td>
                                             </tr>
                                         </tbody>
                                     </table>
                                 </div>
                             </div>
                         </div>
                     </div>



                 </div>

                 <div class="col-md-5 col-xs-12">
                     <div class="x_panel">
                         <div class="x_title">
                             <h2><i class="fa fa-graduation-cap"></i> Alumno </h2>

                             <div class="clearfix"></div>
                         </div>
                         <div class="x_content">
                             <div v-if="divmensaje">
                                 <label class="col-red">{{mensaje}}</label>
                             </div>
                             <div class="container">
                                 <div class="row" v-if="inputalumno">
                                     <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                                         <v-select :options="alumnos" :value="alumnos.idalumno" placeholder="Buscar alumno(a)" label="alumno" @input="changedLabel">
                                         </v-select>
                                     </div>
                                 </div>
                                 <div class="container" v-if="perfil">
                                     <div class="row">
                                         <div class="panel panel-default">
                                             <div class="panel-body">
                                                 <div class="col-md-4 col-xs-12 col-sm-6 col-lg-4">
                                                     <img v-if="detalleAlumno.foto" v-bind:src="url_image+alumno.foto" alt="Imagen del Alumno" id="profile-image1" class="img-circle img-responsive" />
                                                     <img v-else src="<?php echo base_url(); ?>/assets/images/user2.png" id="profile-image1" class="img-circle img-responsive" />
                                                 </div>
                                                 <div class="col-md-8 col-xs-12 col-sm-6 col-lg-8">
                                                     <div class="container">
                                                         <h2>{{detalleAlumno.nombre}}
                                                             {{detalleAlumno.apellidop}}
                                                             {{detalleAlumno.apellidom}}
                                                         </h2>

                                                     </div>
                                                     <button type="button" @click=" quitarAlumno() " class="btn btn-danger btn-xs">Quitar</button>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="row">
                                     <div class="col-md-8 col-xs-12">Vendedor:</div>
                                     <div class="col-md-4 col-xs-12" align="right"><?php echo  $this->session->nombre; ?></div>
                                 </div>
                                 <div class="row">
                                     <div class="col-md-8 col-xs-12">Porcentaje de descuento:</div>
                                     <div class="col-md-4 col-xs-12" align="right">
                                         <a class="establecer" @click="abrirModalDescuentoPorcentaje()" href="#">{{establecer_porcentaje_descuento}}</a>
                                     </div>
                                 </div>
                                 <div class="row">
                                     <div class="col-md-8 col-xs-12">Monto fijo de descuento: </div>
                                     <div class="col-md-4 col-xs-12" align="right"> <a style="  border-bottom-style: dotted;   border-width: 1px;
   border-color: 660033; font-style:italic; color:red;" href="#" @click="abrirModalDescuentoFijo()">{{establecer_fijo_descuento}}</a></div>
                                 </div>
                                 <div class="row">
                                     <div class="col-md-12 col-xs-12">
                                         <table class="table">
                                             <tr class="active" v-for="(row3, index3) in array_descuento_fijo">
                                                 <td align="left">
                                                     <strong> {{row3.concepto}}</strong>
                                                 </td>
                                                 <td scope="row" align="right">
                                                     <span class="label bg-green"> {{row3.descuento | currency}}</span>
                                                 </td>
                                             </tr>
                                             <tr class="active" v-for="(row3, index3) in array_descuento_porcentaje">
                                                 <td align="left">
                                                     <strong> {{row3.concepto}}</strong>
                                                 </td>
                                                 <td scope="row" align="right">
                                                     <span class="label bg-blue"> {{row3.descuento | currency}}</span>
                                                 </td>
                                             </tr>
                                         </table>
                                     </div>
                                 </div>
                                 <!--<div class="row">
                                     <div style="background-color: #86fb86;" class="col-md-8 col-xs-12"><strong>SUBTOTAL:</strong> </div>
                                     <div style="background-color: #86fb86;" class="col-md-4 col-xs-12" align="right"><strong>$0.0</strong></div>
                                 </div>-->

                                 <div class="row" style="border-top-style: dotted;border-left-style: dotted;border-right-style: dotted;  border-width: 1px">
                                     <div class="col-md-6 col-xs-12"><strong>Total:</strong> </div>
                                     <div class="col-md-6 col-xs-12"><strong>Total a pagar:</strong></div>
                                 </div>
                                 <div class="row" style="border-bottom-style: dotted;border-left-style: dotted;border-right-style: dotted;  border-width: 1px">
                                     <div class="col-md-6 col-xs-12" style="color:#24bd24;"><strong>
                                             <h3 v-if="total == '$NaN'"> $0.0</h3>
                                             <h3 v-else-if="total == '-$NaN'"> $0.0</h3>
                                             <h3 v-else>{{total | currency}}</h3>
                                         </strong> </div>
                                     <div class="col-md-6 col-xs-12" style="color:#f69c0a;"><strong>
                                             <h3 v-if="totalapagar == '$NaN'"> $0.0</h3>
                                             <h3 v-else-if="totalapagar == '-$NaN'"> $0.0</h3>
                                             <h3 v-else>{{totalapagar | currency}}</h3>
                                         </strong></div>
                                 </div>
                                 <div>
                                     <div class="row" style="margin-top: 5px;">
                                         <div class="col-md-12  col-sm-12 col-xs-12">
                                             <table class="table" style="border-style: dotted;   border-width: 2px">
                                                 <tr v-for="(row2, index2) in array_forma_pago">
                                                     <td>
                                                         <i class="fa fa-close" style="color: red;" @click="deleteItemFormaPago(index2);"></i> {{row2.formapago}}
                                                     </td>
                                                     <td align="right">
                                                         <strong>{{row2.descuento | currency}}</strong>
                                                     </td>
                                                 </tr>
                                             </table>
                                         </div>
                                     </div>
                                 </div>
                                 <div>
                                     <div class="row">
                                         <div class="col-md-12  col-sm-12 col-xs-12">
                                             <div v-if="visiblemsgerror">
                                                 <label>{{msgerror}}</label>
                                             </div>
                                             <div class="invalid-feedback col-red">
                                                 {{errors.first('form1.descuento')}}
                                             </div>
                                             <div class="invalid-feedback col-red">
                                                 {{errors.first('form1.Forma de Pago')}}

                                             </div>
                                         </div>
                                     </div>
                                     <form data-vv-scope="form1">
                                         <div class="row">

                                             <div class="col-md-4  col-sm-12 col-xs-12">
                                                 <div class="form-group">
                                                     <input type="text" name="descuento" v-model="newFormaPago.descuento" v-validate="'required|decimal:2'" class="form-control2" placeholder="$0.0">

                                                 </div>
                                             </div>
                                             <div class="col-md-8  col-sm-12 col-xs-12">
                                                 <div class="form-group" style="">
                                                     <v-select :loading="true" :options="formapagos" name="Forma de Pago" v-validate="'required'" v-model="newFormaPago.idformapago" :value="formapagos.idtipopago" placeholder="Forma de Pago" label="nombretipopago">
                                                         <template #spinner="{ loading }">
                                                             <div v-if="loading" style="border-left-color: rgba(88,151,251,0.71)" class="vs__spinner">
                                                                 The .vs__spinner class will hide the text for me.
                                                             </div>
                                                         </template>
                                                     </v-select>

                                                 </div>
                                             </div>
                                         </div>
                                         <div class="row">
                                             <div class="col-md-4  col-sm-12 col-xs-12">
                                                 <div class="form-group">
                                                     <input type="text" name="descuento" v-model="newFormaPago.numautorizacion" class="form-control2" placeholder="Autorización">

                                                 </div>
                                             </div>
                                             <div class="col-md-8  col-sm-12 col-xs-12">
                                                 <button type="button" @click="agregarDetalleFormaPago" class="btn btn-default btn-sm  btn-block"><i class="fa fa-plus"></i> Agregar Detalle</button>
                                             </div>
                                         </div>
                                     </form>
                                 </div>
                                 <div v-if="divmesajeDetallePago" class="alert alert-danger">
                                     {{mensajeDetallePago}}
                                 </div>
                                 <div class="row">
                                     <div class="col-md-12  col-sm-12 col-xs-12">
                                         <div class="form-group">

                                             <label for="exampleFormControlTextarea1">Example textarea</label>
                                             <textarea style="border:solid #000 1px;" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                         </div>
                                     </div>
                                 </div>


                                 <div v-if="btnpagar">

                                     <div class="ln_solid"></div>
                                     <div class="row">
                                         <div class="form-group">
                                             <div class="col-md-12 col-sm-12 col-xs-12">
                                                 <button type="buttom" class="btn btn-primary waves-effect btn-block">PAGAR</button>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
                 <?php include 'modal.php'; ?>

             </div>

         </div>
     </div>

     <!-- footer content -->
     <footer>
         <div class="copyright-info">
             <p class="pull-right">SICE - Sistema Integral para el Control Escolar</a>
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
 <script src="<?php echo base_url(); ?>/assets/vue/vue2-filters.min.js"></script>
 <script src="<?php echo base_url(); ?>/assets/vue/select/vue-select.js"></script>
 <script src="<?php echo base_url(); ?>/assets/vue/validation/vee-validate.js"></script>
 <script src="<?php echo base_url(); ?>/assets/vue/validation/es.js"></script>
 <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/vue/select/vue-select.css">
 <script data-my_var_1="<?php echo base_url() ?>" src="<?php echo base_url(); ?>/assets/vue/appvue/administrador/cobros/apppagos.js"></script>