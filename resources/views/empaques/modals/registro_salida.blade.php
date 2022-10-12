<div class="modal fade" id="modal-lg" aria-hidden="true" style="display: none;">
   <div class="modal-dialog modal-xs">
      <div class="modal-content">
      <div class="modal-header">
         <h4 class="modal-title">Registrar Nuevo Movimiento de Salida</h4>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
         </button>
      </div>
      <div class="modal-body">
         <form action="{{ route('empaques.salida.registrar') }}" method="post" class="frm_0001">
         {{ csrf_field() }}
         <div class="row">
            <div class="col-12">
               <div class="form-group">
                  <label>Cliente</label>
                  <select class="form-control combo cliente" name="c04" required style="width: 100%;">
                  <option value="">SELECCIONE CLIENTE</option>
                     @foreach($clientes as $rows)
                     <option value="{{ $rows->id }}">{{ $rows->nit }}-{{ $rows->digito_verificacion_nit }} {{ $rows->nombre }}</option>
                     @endforeach
                  </select>
               </div>
            </div>
         </div>
         <div class="row">
         <div class="form-group col-6">
                  <label>Total sacos</label>
                  <input type="text" readonly name="total_sacos_prov" class="form-control total_sacos_prov numero_entero">
               </div>
               <div class="form-group col-6">
                  <label>Total tulas</label>
                  <input type="text" readonly name="total_tulas_prov"  class="form-control total_tulas_prov numero_entero">
               </div>
         </div>
         <div class="row">
         <div class="form-group col-6">
                  <label>Saldo sacos</label>
                  <input type="text" readonly name="saldo_sacos" class="form-control saldo_sacos numero_entero">
               </div>
               <div class="form-group col-6">
                  <label>Saldo tulas</label>
                  <input type="text" readonly name="saldo_tulas"  class="form-control saldo_tulas numero_entero">
               </div>
         </div>
         <div class="row">
            <div class="col-3">
               <div class="form-group">
                  <label>Cantidad</label>
                  <input type="text" name="c01" required autocomplete="c01"  min="1" max="50000" class="form-control numero_entero">
               </div>
            </div>
            <div class="col-4">
               <div class="form-group">
                  <label>Empaque</label>
                  <select class="form-control combo " required name="c02" style="width: 100%;">
                     @foreach($empaques as $rows)
                        <option value="{{ $rows->id }}">{{ $rows->tipo_empaque }}</option>
                     @endforeach
                  </select>
               </div>
            </div>
            <div class="col-5">
               <div class="form-group">
                  <label>Fecha Ingreso</label>
                  <input type="date" name="c03" required class="form-control"  value="<?php echo date('Y-m-d');?>">
               </div>
            </div>
         </div>
         <input type="hidden" name="total" class="total"/>
         <button style="display:none" class="act_form"></button>
         </form>
      </div>
      <div class="modal-footer justify-content-between">
         <button type="button" class="btn btn-block btn-primary trigger_form" target="frm_0001">Procesar Registro</button>
      </div>
      </div>
      <!-- /.modal-content -->
   </div>
<!-- /.modal-dialog -->
</div>