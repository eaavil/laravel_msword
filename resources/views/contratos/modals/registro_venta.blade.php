<div class="modal fade" id="modal-lg" aria-hidden="true" style="display: none;">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
      <div class="modal-header">
         <h4 class="modal-title">Registrar Nuevo Contrato de Venta</h4>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
         </button>
      </div>
      <div class="modal-body">
         <form action="{{ route('contrato.registrar') }}" method="post" class="frm_0001">
         {{ csrf_field() }}
         <div class="row">
            <div class="col-3">
               <div class="form-group">
                  <label>Correlativo</label>
                  <input type="text" name="c01" value="{{ $correlativo }}" required autocomplete="c01"  class="form-control">
               </div>
            </div>
            <div class="col-2">
               <div class="form-group">
                  <label>Tipo de Producto</label>
                  <select class="form-control combo" required name="c02" style="width: 100%;">
                     @foreach($cafe as $rows)
                        <option value="{{ $rows->id }}">{{ $rows->tipo_cafe }}</option>
                     @endforeach
                  </select>
               </div>
            </div>
            <div class="col-3">
               <div class="form-group">
                  <label>Fecha Contrato</label>
                  <input type="date" name="c03" required class="form-control">
               </div>
            </div>
            <div class="col-4">
               <div class="form-group">
                  <label>Fecha Entrega</label>
                  <input type="month" name="c04" required class="form-control fecha_esp">
               </div>
            </div>
         </div>
         <div class="row">
            <div class="col-4">
               <div class="form-group">
                  <label>Compromiso en Kilogramos</label>
                  <input type="text" required name="c05" class="form-control calculator ck numero_entero">
               </div>
            </div>
            <div class="col-4">
               <div class="form-group">
                  <label>Precio Arroba</label>
                  <input type="text" name="c06" required autocomplete="c01" class="form-control calculator numero_entero pa">
               </div>
            </div>
            <div class="col-4">
               <div class="form-group">
                  <label>Precio Kilogramo</label>
                  <input type="text" name="c07" readonly autocomplete="c01" class="form-control pk numero_entero">
               </div>
            </div>
         </div>
         <div class="row">
            <div class="col-6">
               <div class="form-group">
                  <label>Factor Base</label>
                  <input type="text" value="{{ $factor->parametro }}" readonly name="c08" required autocomplete="c01" class="form-control">
               </div>
            </div>
            <div class="col-6">
               <div class="form-group">
                  <label>Valor Contrato</label>
                  <input type="text" name="c09" readonly value="0.00" autocomplete="c01" class="form-control res numero_entero">
               </div>
            </div>
         </div>
         <div class="row">
            <div class="col-6">
               <div class="form-group">
                  <label>Trilladora / Bodega</label>
                  <select class="form-control combo" name="c10" required style="width: 100%;">
                     @foreach($centros as $rows)
                        <option value="{{ $rows->id }}">{{ $rows->codigo }} - {{ $rows->descripcion }}</option>
                     @endforeach
                  </select>
               </div>
            </div>
            <div class="col-6">
               <div class="form-group">
                  <label>Cliente</label>
                  <select class="form-control combo" name="c11" required style="width: 100%;">
					 <option value="">Seleccione</option>
                     @foreach($clientes as $rows)
                        <option value="{{ $rows->id }}">{{ $rows->nit }}-{{ $rows->digito_verificacion_nit }} {{ $rows->nombre }}</option>
                     @endforeach
                  </select>
               </div>
            </div>
         </div>
         <button style="display:none" class="act_form"></button>
         </form>
      </div>
      <div class="modal-footer justify-content-between">
         <button type="button" class="btn btn-block btn-primary trigger_form_esp_entrada" target="frm_0001">Procesar Registro</button>
      </div>
      </div>
      <!-- /.modal-content -->
   </div>
<!-- /.modal-dialog -->
</div>
<style>
.modal-body{
  height: 100px;
  width: 100%;
  overflow-y: auto;
}
</style>

