<div class="modal fade" id="modal-lge" aria-hidden="true" style="display: none;">
   <div class="modal-dialog modal-xs">
      <div class="modal-content">
      <div class="modal-header">
         <h4 class="modal-title">Editar Parametro</h4>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
         </button>
      </div>
      <div class="modal-body">
         <form action="{{ route('settings.update') }}" method="post" class="frme_0001">
         {{ csrf_field() }}
         <div class="row">
            <div class="col-12">
               <div class="form-group">
                  <label>Parametro</label>
                  <input type="text" name="c00" readonly autocomplete="code-in"  maxlength="10" class="form-control">
               </div>
               <div class="form-group">
                  <label>Valor</label>
                  <input type="text" name="c01" autocomplete="name-in" class="form-control">
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