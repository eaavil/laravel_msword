<div class="modal fade" id="modal-lg" aria-hidden="true" style="display: none;">
   <div class="modal-dialog modal-xs">
      <div class="modal-content">
      <div class="modal-header">
         <h4 class="modal-title">Registrar Nuevo Usuario</h4>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
         </button>
      </div>
      <div class="modal-body">
         <form action="{{ route('dashboard.users.add') }}" method="post" class="frm_0001">
         {{ csrf_field() }}
         <div class="row">
            <div class="col-8">
               <div class="form-group">
                  <label>Persona</label>
                  <select class="form-control combo persona" name="persona" style="width: 100%;" required>
                      <option value="" >SELECCIONE..</option>
                     @foreach($clientes as $row)
                        <option value="{{ $row->id }}" >{{ $row->nombre}}</option>
                     @endforeach
                  </select>
               </div>
            </div>
           
            <div class="col-4">
               <div class="form-group">
                  <label>Login</label>
                  <input type="text" name="c03" class="form-control login ">
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
                     @foreach($roles as $row)
                        <option value="{{ $row->id }}" >{{ $row->nombre_rol }}</option>
                     @endforeach
                  </select>
               </div>
            </div>
         </div>
         <span style="display:none" target="frm_0001" class="trigger_form"></span>
          <input type="hidden" name="nombres"  class="form-control nombres">
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