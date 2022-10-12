<div class="modal" id="modal-lg" aria-hidden="true" style="display: none;">
   <div  style="width:70%; margin: 20px auto; ">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Registrar cotizacion de venta<span class="titulo_salida"></span></h4>
            <button type="button" class="close recargar" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
         </div>
         <div class="modal-body body-registro">
            <form action="{{ route('contrato.registrar') }}" method="post" class="frmc_0001">
               {{ csrf_field() }}
               <div class="row" >
                  <div class="col-3" >
                     
                        <h6>Correlativo</h6>
                        <div class="  form-group  ">
                           <input type="text"  name="c01" value="{{ $correlativo }}" required autocomplete="c01" class="form-control cor">
                        </div>
                     
                  </div>
                  <div class="col-3  ot" >
                    
                        <h6>Orden de trabajo</h6>
                        <select class=" form-control  combo orden" name="c02" >
                           <option value="" >SELECCIONE</option>
                           @foreach($ordenes as $rows)
                           <option value="{{ $rows->id }}">{{ $rows->numero}}</option>
                           @endforeach
                        </select>
                 
                  </div>
                  <div class="col-6 " >
                 
                        <h6>Cliente</h6>
                        <select class=" form-control  combo representante" name="representante" required >
                           <option value="" >SELECCIONE</option>
                           @foreach($clientes as $rows)
                           <option value="{{ $rows->id }}">{{ $rows->nombre }}</option>
                           @endforeach
                        </select>
                    
                  </div>
                  
                  
               </div>
               <div class="row col-12 mb-2">
                 
                 <h6>Tipo de obra</h6>
                 <input type="text" style='width:237%' name="c03"  class="form-control tipo_obra " required>
               </div>
            <div class="row ">
			        <div class="col-3 tip_servicio ">
                 
                        <h6>Agregar por articulo</h6>
                        <select  class="form-group combo todos" name="tipo_servicio"  >
						  <option  value="" > SELECCIONE ARTICULO PARA AGREGAR </option>
						  @foreach($todos as $rows)
                           <option value="{{ $rows->id }}">{{ $rows->nombre }}</option>
                           @endforeach
                        </select>
                 
                  </div>
                  
                  <div class="mx-2 col-3 tip_servicio style='width:230%'">
                     <label style='width:100%' >
                        <h6>Agregar por servicio</h6>
                        <select  class="form-group combo Tipo_servico Tipo_servico_2" name="tipo_servicio" >
                           <option value=" " >SELECCIONE SERVICIO</option>
                           <option value="1">Instalacion</option>
                           <option value="2">Mantencion</option>
                           <option value="3">Reparacion</option>
                        </select>
                     </label>
                  </div>
                  <div class="col-3 agre_art " style="display:none">
                     <label style='width:100%'>
                        <h6>Instalacion</h6>
                        <select class=" form-group combo  instalacion articulo reset " name='instalacion' >
                           <option value="" >SELECCIONE</option>
                           @foreach($categorias as $rows)
                           <option value="{{ $rows->id }}">{{ $rows->ruta }}</option>
                           @endforeach
                        </select>
                     </label>
                  </div>
                  <div class="col-3 rep " style="display:none">
                     <label  style='width:100%'>
                        <h6>Reparacion</h6>
                        <select class=" form-group combo   reparacion individual reset " name='reparacion' >
                           <option value="" >SELECCIONE</option>
                           @foreach($reparacion as $rows)
                           <option value="{{ $rows->id }}">{{ $rows->nombre }}</option>
                           @endforeach
                        </select>
                     </label>
                  </div>
                  <div class="col-3 man " style="display:none">
                     <label  style='width:100%'>
                        <h6>Mantencion:</h6>
                        <select class=" form-group combo  mantencion individual reset " name='mantencion' >
                           <option value="" >SELECCIONE</option>
                           @foreach($mantencion as $rows)
                           <option value="{{ $rows->id }}">{{ $rows->nombre }}</option>
                           @endforeach
                        </select>
                     </label>
                  </div>
               </div> <br>
               <div class="row tabla_articulos">
                  <h6 class="origen mx-2" >Articulos a cotizar</h6>
                  <table id="2" width="100%"  class="origen" border="1"  style="color:black;font-size:90%; text-align: center; table-layout: fixed;">
                     <thead >
                        <tr border="1"  style="background:#ccc;" >
                           <th width="40%" >NOMBRE</th>
                           <th> DISPONIBLE </th>
                           <th> CANTIDAD </th>
                           <th > V. UNIDAD </th>
                           <th> AUMENTO </th>
                           <th> TOTAL </th>
                           <th> ACCIONES </th>
                        </tr>
                     </thead>
                     <tbody>
                     </tbody>
                  </table>
               </div>
               <br>
               <div class="row">
                  <div class="col-3 origen">
                     <div class="form-group">
                        <h6 class="origen">Neto</h6>
                        <input type="text" class="form-control t1" name="neto" value="0" readonly >
                     </div>
                  </div>
                  <br>
                  <div class="col-3 origen">
                     <div class="form-group">
                        <h6 class="origen">Iva</h6>
                        <input type="text" class="form-control t2 " name="iva"  readonly >
                     </div>
                  </div>
                  <br>
                  <div class="col-3 origen">
                     <h6 class="origen">Total</h6>
                     <input type="text" class="form-control t3 " name="total_contrato"  readonly >
                  </div>
                  <div class="col-3 " style="display:none">
                     <h6 class="origen">Total uf</h6>
                     <input type="text" class="form-control t4 " name="total_uf"  readonly >
                  </div>
               </div>
               <input type="hidden" class="weight" />
               <input type="hidden" class="servicio" name="servicio" />
               <input type="hidden" class="salida" name="id" />
               <input type="hidden"  readonly class="form-control cor" name="numero"/>
               <input type="hidden"  readonly class="form-control cor_anexo" name="anexo"/>
               <button style="display:none" class="act_form"></button>
            </form>
         </div>
         <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-block btn-primary trigger_form" target="frmc_0001">Procesar Registro</button>
         </div>
      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>
<style>

.body-registro{
  overflow-y: auto;
}
</style>