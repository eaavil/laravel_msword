<div class="modal fade" id="modal-lg" aria-hidden="true" style="display: none;">
   <div class="modal-dialog modal-xs">
      <div class="modal-content">
      <div class="modal-header">
         <h4 class="modal-title">Registrar Nueva Cuenta Banco</h4>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
         </button>
      </div>
      <div class="modal-body">
         <form action="{{ route('bancos.cuenta.registrar') }}" method="post" class="frm_0001">
         {{ csrf_field() }}
         <div class="row">
            <div class="col-12">
               <div class="form-group">
                  <label>Cuenta</label>
                  <input type="text" name="c01" maxlength="20" autocomplete="name-in" class="form-control">
               </div>
            </div>
            <div class="col-6">
               <div class="form-group">
                  <label>Cliente</label>
                  <input type="text" name="c02" autocomplete="name-in" class="form-control">
               </div>
            </div>
            <div class="col-6">
               <div class="form-group">
                  <label>Nit</label>
                  <input type="text" name="c03" autocomplete="name-in" class="form-control">
               </div>
            </div>
            <div class="col-6">
               <div class="form-group">
                 <label for="">Banco</label>
                 <select class="form-control" name="c04" id="">
                   <option value="">Seleccione</option>
                    @foreach($bancos as $rows)
                        <option value="{{ $rows->id }}">{{ $rows->entidad }}</option>
                    @endforeach
                 </select>
               </div>
            </div>
            <div class="col-6">
               <div class="form-group">
                 <label for="">Tipo de Cuenta</label>
                 <select class="form-control" name="c05" id="">
                   <option value="">Seleccione</option>
                    @foreach($tipo_cuentas as $rows)
                        <option value="{{ $rows->id }}">{{ $rows->nombre }}</option>
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
