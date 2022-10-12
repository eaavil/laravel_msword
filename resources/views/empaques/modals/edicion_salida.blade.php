<div class="modal fade" id="modal-lge" aria-hidden="true" style="display: none;">
   <div class="modal-dialog modal-xs">
      <div class="modal-content">
      <div class="modal-header">
         <h4 class="modal-title">Editar Movimiento de Salida</h4>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
         </button>
      </div>
      <div class="modal-body">
         <form action="{{ route('empaques.salidas.actualizar') }}" method="post" class="frme_0001">
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
                  <input type="text"  readonly class="form-control client">

               </div>
            </div>
         </div>
         <div class="row">
            <div class="col-12">
               <div class="form-group">
                  <label>Clientes</label>
                  <select class="form-control combo" name="c05" required style="width: 100%;">
                     @foreach($clientes as $rows)
                        <option value="{{ $rows->id }}">{{ $rows->nit }}-{{ $rows->digito_verificacion_nit }} {{ $rows->nombre }}</option>
                     @endforeach
                  </select>
               </div>
            </div>
         </div>
         <input type="hidden" name="sacos_anterior" class="sacos_anterior" />
         <input type="hidden" name="tulas_anterior" class="tulas_anterior" />
         <button style="display:none" class="act_form"></button>
         <input type="hidden" name="id" />
         </form>
      </div>
      <div class="modal-footer justify-content-between">
         <button type="button" class="btn btn-block btn-primary trigger_form" target="frme_0001">Actualizar Registro</button>
      </div>
      </div>
      <!-- /.modal-content -->
   </div>
<!-- /.modal-dialog -->
</div>