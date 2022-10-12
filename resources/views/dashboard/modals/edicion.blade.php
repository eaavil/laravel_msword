<div class="modal fade" id="modal-lge" aria-hidden="true" style="display: none;">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
      <div class="modal-header">
         <h4 class="modal-title">Editar Empresa</h4>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
         </button>
      </div>
      <div class="modal-body">
         <form action="{{ route('dashboard.clients.update') }}" method="post" class="frm_edit">
         {{ csrf_field() }}
         <div class="row">
            <div class="col-6">
               <div class="form-group">
                  <label>Cliente</label>
                  <input type="text" name="c01" required autocomplete="code-in"  maxlength="10" class="form-control">
               </div>
               <div class="form-group">
                  <label>Login del Cliente</label>
                  <input type="text" name="c02" required autocomplete="name-in" class="form-control">
               </div>
               <div class="row">
                  <div class="col-6">
                     <div class="form-group">
                     <label>Email:</label>
                  <input type="email" name="c03" required required autocomplete="email-in" class="form-control" data-inputmask='"mask": "(999) 999-9999"' data-mask>
                     </div>
                  </div>
                  <div class="col-6">
                     <div class="form-group">
                        <label>Telefono Celular:</label>
                        <input type="text" name="c04" required autocomplete="phone-in" class="form-control onumbers" maxlength="10">
                     </div>
                  </div>
               </div>
            </div>
            
            <div class="col-6">
               <div class="row">
                  <div class="col-6">
                     <div class="form-group">
                        <label>Host o Direccion IP</label>
                        <input type="text" name="c05" required autocomplete="code-in"   class="form-control p1">
                     </div>
                  </div>
                  <div class="col-6">
                     <div class="form-group">
                        <label>Puerto</label>
                        <input type="text" name="c06" required autocomplete="code-in"  maxlength="5" class="form-control p2">
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-6">
                     <div class="form-group">
                        <label>Usuario</label>
                        <input type="text" name="c07" required autocomplete="code-in"  class="form-control p3">
                     </div>
                  </div>
                  <div class="col-6">
                     <div class="form-group">
                        <label>Clave</label>
                        <input type="text" name="c08" required autocomplete="code-in" class="form-control p4">
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-6">
                     <div class="form-group">
                        <label>Base de Datos</label>
                        <input type="text" name="c09" required autocomplete="code-in" class="form-control p5">
                     </div>
                  </div>
                  <div class="col-6">
                     <div class="form-group">
                        <label style="color:white">Base de Datos</label>
                        <span class="btn btn-success testce">Probar Conexion</span>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <button style="display:none" class="act_form"></button>
         <input type="hidden" name="id" />
         </form>
      </div>
      <div class="modal-footer justify-content-between">
         <button type="button" class="btn btn-block btn-primary trigger_form" target="frm_edit">Procesar Registro</button>
      </div>
      </div>
      <!-- /.modal-content -->
   </div>
<!-- /.modal-dialog -->
</div>