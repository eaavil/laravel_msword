<div class="modal fade" id="modal-lg" aria-hidden="true" style="display: none;">
   <div class="modal-dialog modal-xs">
      <div class="modal-content">
      <div class="modal-header">
         <h4 class="modal-title">Registrar Nuevo Movimiento de Entrada</h4>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
         </button>
      </div>
      <div class="modal-body">
         <form action="{{ route('empaques.entrada.registrar') }}" method="post" class="frm_0001">
         {{ csrf_field() }}
         <div class="row">
            <div class="col-2">
               <div class="form-group">
                  <label>Cantidad</label>
                  <input type="number" name="c01" required autocomplete="c01"  min="1" max="50000" class="form-control">
               </div>
            </div>
            <div class="col-5">
               <div class="form-group">
                  <label>Empaque</label>
                  <select class="form-control combo" required name="c02" style="width: 100%;">
                     @foreach($empaques as $rows)
                        <option value="{{ $rows->id }}">{{ $rows->tipo_empaque }}</option>
                     @endforeach
                  </select>
               </div>
            </div>
            <div class="col-5">
               <div class="form-group">
                  <label>Fecha Ingreso</label>
                  <input type="date" name="c03" required class="form-control">
               </div>
            </div>
         </div>
         <div class="row">
            <div class="col-12">
               <div class="form-group">
                  <label>Cliente</label>
                  <select class="form-control combo" name="c04" required style="width: 100%;">
                     @foreach($clientes as $rows)
                        <option value="{{ $rows->id }}">{{ $rows->nit }}-{{ $rows->digito_verificacion_nit }} {{ $rows->nombre }}</option>
                     @endforeach
                  </select>
               </div>
            </div>
         </div>
         <div class="row">
            <div class="col-12">
               <div class="form-group">
                  <label>Proveedor</label>
                  <select class="form-control combo" name="c05" required style="width: 100%;">
                     @foreach($proveedores as $rows)
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
         <button type="button" class="btn btn-block btn-primary trigger_form" target="frm_0001">Procesar Registro</button>
      </div>
      </div>
      <!-- /.modal-content -->
   </div>
<!-- /.modal-dialog -->
</div>