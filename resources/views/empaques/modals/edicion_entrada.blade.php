<div class="modal fade" id="modal-lge" aria-hidden="true" style="display: none;">
   <div class="modal-dialog modal-xs">
      <div class="modal-content">
      <div class="modal-header">
         <h4 class="modal-title">Editar Movimiento de Entrada</h4>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
         </button>
      </div>
      <div class="modal-body">
         <form action="{{ route('empaques.salida.registrar') }}" method="post" class="frme_0001">
         {{ csrf_field() }}
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
                  <input name="tipo_empaque" readonly class="form-control tipo_empaque">
                    
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
                  <label>Proveedor</label>
                  <input type="text" name="proveedor"  readonly class="form-control proveedor">

               </div>
            </div>
         </div>
         <button style="display:none" class="act_form"></button>
         <input type="hidden" name="id" />
         <input type="hidden" name="sacos_anterior" class="sacos_anterior" />
         <input type="hidden" name="tulas_anterior" class="tulas_anterior" />
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