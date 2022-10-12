<div class="modal fade" id="modal-lg" aria-hidden="true" style="display: none;">
   <div class="modal-dialog modal-xs">
      <div class="modal-content">
      <div class="modal-header">
         <h4 class="modal-title">Registrar Nueva Entrada</h4>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
         </button>
      </div>
      <div class="modal-body">
         <form action="{{ route('dashboard.users.add') }}" method="post" class="frm_0001">
         {{ csrf_field() }}
         <div class="row">
            <div class="col-12">
               <label>Conductor</label>
               <div class="input-group mb-3">
                  <input type="text" class="form-control">
                  <div class="input-group-append">
                    <span class="input-group-text" style="cursor:pointer"><i class="fas fa-plus"></i></span>
                  </div>
                </div>
            </div>
         </div>
         <div class="row">
            <div class="col-4">
               <div class="form-group">
                  <label>Nombrexs</label>
                  <input type="text" name="c01" required autocomplete="c01" class="form-control texto">
               </div>
            </div>
            <div class="col-4">
               <div class="form-group">
                  <label>Apellidos</label>
                  <input type="text" name="c02" required autocomplete="c02"   class="form-control texto">
               </div>
            </div>
            <div class="col-4">
               <div class="form-group">
                  <label>Login</label>
                  <input type="text" name="c03" required autocomplete="c03" class="form-control login">
                  <span class="error_nit" style="color:red; display:none"></span>
               </div>
            </div>
         </div>
         <div class="row">
            <div class="col-6">
               <div class="form-group">
                  <label>Email</label>
                  <input type="text" name="c04" required class="form-control email"/>
                  <span class="error_email" style="color:red; display:none"></span>
               </div>
            </div>
            <div class="col-6">
               <div class="form-group">
                  <label>Rol</label>
                  <select class="form-control combo" name="c05" style="width: 100%;">

                  </select>
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