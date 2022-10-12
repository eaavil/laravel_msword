<div class="modal fade" id="modal-lg" aria-hidden="true" style="display: none;">
   <div class="modal-dialog modal-xs">
      <div class="modal-content">
      <div class="modal-header">
         <h4 class="modal-title">Registrar Nuevo Centro de Operacion</h4>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
         </button>
      </div>
      <div class="modal-body">
         <form action="{{ route('empresas.centros_costo.registrar') }}" method="post" class="frm">
         {{ csrf_field() }}
         <div class="row">
            <div class="col-12">
            <div class="row">
                  <div class="col-6">               
                     <div class="form-group">
                        <label>Codigo</label>
                        <input type="text" name="c01" autocomplete="code-in"  maxlength="10" class="form-control">
                     </div>
                  </div>
                  <div class="col-6">
                     <div class="form-group">
                        <label>Padre</label>
                        <select class="form-control combo" name="c02" style="width: 100%;">
                           <option value="1">Titulo</option>
                           <option value="2">Detalle</option>
                        </select>
                     </div>
                  </div>
               </div>
               <div class="form-group">
                  <label>Descripcion</label>
                  <input type="text" name="c03" autocomplete="name-in" class="form-control">
               </div> 
               <div class="form-group">
                  <label>Responsable</label>
                  <input type="text" name="c04" autocomplete="name-in" class="form-control">
               </div>
               <div class="row">
                  <div class="col-6">
                     <div class="form-group">
                        <label>Padre</label>
                        <select class="form-control combo padr" name="c05" style="width: 100%;">
                           <option value="" selected>Ninguno</option>
                           @foreach($registros as $rows)
                              <option value="{{ $rows->id }}" data-nivel="{{ $rows->nivel }}">{{ $rows->codigo }} - {{ $rows->descripcion }}</option>
                           @endforeach
                        </select>
                     </div>
                  </div>
                  <div class="col-6">
                     <div class="form-group">
                        <label>Nivel:</label>
                        <input type="text" value="1" name="c06" readonly autocomplete="pbx-in" class="form-control onumbers nivel" maxlength="8">
                     </div>
                  </div>
               </div>
            </div>
            
         <button style="display:none" class="act_form"></button>
         </form>
      </div>
      <div class="modal-footer justify-content-between">
         <button type="button" class="btn btn-block btn-primary trigger_form" target="frm">Procesar Registro</button>
      </div>
      </div>
      <!-- /.modal-content -->
   </div>
<!-- /.modal-dialog -->
</div>