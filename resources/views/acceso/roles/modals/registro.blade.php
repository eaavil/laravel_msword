<div class="modal fade" id="modal-lg" aria-hidden="true" style="display: none;">
   <div class="modal-dialog modal-xs">
      <div class="modal-content">
      <div class="modal-header">
         <h4 class="modal-title">Registrar Nuevo Rol</h4>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
         </button>
      </div>
      <div class="modal-body">
         <form action="{{ route('dashboard.roles.add') }}" method="post" class="frm_0001">
         {{ csrf_field() }}
         <div class="row">
            <div class="col-6">
               <div class="form-group">
                  <label>Nombre Rol</label>
                  <input type="text" name="c01" required autocomplete="c01" class="form-control texto">
               </div>
            </div>
            <div class="col-6">
               <div class="form-group">
                  <label>Descripcion</label>
                  <input type="text" name="c02" required autocomplete="c02"   class="form-control texto">
               </div>
            </div>
         </div>
         <span style="display:none" target="frm_0001" class="trigger_form"></span>
         </form>
      </div>
      <div class="modal-footer justify-content-between">
         <button type="button" class="btn btn-block btn-primary trigger_formx" target="frm_0001">Procesar Registro</button>
      </div>
      </div>
      <!-- /.modal-content -->
   </div>
<!-- /.modal-dialog -->
</div>