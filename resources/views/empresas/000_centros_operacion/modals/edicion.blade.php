<div class="modal fade" id="modal-lge" aria-hidden="true" style="display: none;">
   <div class="modal-dialog modal-xs">
      <div class="modal-content">
      <div class="modal-header">
         <h4 class="modal-title">Editar Centro de Operacion</h4>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
         </button>
      </div>
      <div class="modal-body">
         <form action="{{ route('empresas.centros_operacion.actualizar') }}" method="post" class="frme">
         {{ csrf_field() }}
         <div class="row">
            <div class="col-12">
               <div class="form-group">
                  <label>Descripcion</label>
                  <input type="text" name="c03" autocomplete="name-in" class="form-control">
               </div>
               <div class="form-group">
                  <label>Direccion Linea 1:</label>
                  <input type="text" name="c04" autocomplete="dir1-in" class="form-control">
               </div>
               <div class="form-group">
                  <label>Direccion Linea 2: (Opcional)</label>
                  <input type="text" name="c05" autocomplete="dir2-in" class="form-control">
               </div>
               <div class="form-group">
                  <label>Direccion Linea 3: (Opcional)</label>
                  <input type="text" name="c06" autocomplete="dir3-in" class="form-control">
               </div>
               <div class="form-group">
                  <label>Ubicacion</label>
                  <select class="form-control combo" name="c07" id="c08" style="width: 100%;">
                     @foreach($poblaciones as $rows)
                        <option value="{{ $rows->id_poblacion }}">{{ $rows->nombre_ciudad }}, {{ $rows->departamento }}</option>
                     @endforeach
                  </select>
               </div>
               <div class="form-group">
                  <label>PBX:</label>
                  <input type="text" name="c08" autocomplete="pbx-in" class="form-control onumbers" maxlength="8">
               </div>
               <div class="form-group">
                  <label>Telefono:</label>
                  <input type="text" name="c09" autocomplete="phone-in" class="form-control onumbers" maxlength="10">
               </div>
         </div>
         <button style="display:none" class="act_form"></button>
         <input type="hidden" name="id" />
         </form>
      </div>
      <div class="modal-footer justify-content-between">
         <button type="button" class="btn btn-block btn-primary trigger_form" target="frme">Procesar Registro</button>
      </div>
      </div>
      <!-- /.modal-content -->
   </div>
<!-- /.modal-dialog -->
</div>
</div>
