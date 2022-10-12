<div class="modal fade" id="modal-lg" aria-hidden="true" style="display: none;">
   <div class="modal-dialog modal-xs">
      <div class="modal-content">
      <div class="modal-header">
         <h4 class="modal-title">Registrar Nueva Ciudad</h4>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
         </button>
      </div>
      <div class="modal-body">
         <form action="{{ route('settings.ciudad.registro') }}" method="post" class="frm_0001">
         {{ csrf_field() }}
         <div class="row">
            <div class="col-12">
               <div class="form-group">
                  <label>Ciudad</label>
                  <input type="text" name="c01" autocomplete="code-in"  class="form-control">
               </div>
               <div class="form-group">
                  <label>Departamento</label>
                  <select class="form-control" name="c02">
					@foreach($departamentos as $rows)
						<option value="{{ $rows->id }}">{{ $rows->departamento }}</option>
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