<div class="modal fade" id="modal-lge" aria-hidden="true" style="display: none;">
   <div class="modal-dialog modal-xs">
      <div class="modal-content">
      <div class="modal-header">
         <h4 class="modal-title">Editar Usuario</h4>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
         </button>
      </div>
      <div class="modal-body">
         <form action="{{ route('dashboard.users.update') }}" method="post" class="frme_0001">
         {{ csrf_field() }}
         <div class="row">
            <div class="col-4">
               <div class="form-group">
                  <label>Nombres</label>
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
                  <input type="text" disabled name="c03" required autocomplete="c03" class="form-control login">
                  <span class="error_nit" style="color:red; display:none"></span>
               </div>
            </div>
         </div>
         <div class="row">
            <div class="col-6">
               <div class="form-group">
                  <label>Email</label>
                  <input type="text" disabled name="c04" required class="form-control email"/>
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