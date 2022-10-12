<div class="modal fade" id="modal-lg" aria-hidden="true" style="display: none;">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
      <div class="modal-header">
         <h4 class="modal-title">Registrar articulo o servicio</h4>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
         </button>
      </div>
      <div class="modal-body">
      <form action="{{ route('agregar_editar.servicios.comunes') }}" method="post" class="frmc_0001">
			{{ csrf_field() }}
         <div class="row">
                <div class="form-group col-6">
                  <label for="">Nombre </label>
                  <input type="text" class="form-control nombre_interno" style="text-transform:uppercase" name="nombre_interno"  aria-describedby="helpId" autocomplete="off">
                </div>
                <div class="col-6">
                <div class="form-group">
                  <label for="">Valor Compra</label>
                  <input type="text" class="form-control valor_compra numero_entero valor_compra" name="valor_compra"  aria-describedby="helpId" autocomplete="off">
                </div>
            </div>
         </div>
      
        
        
         <input type="hidden" class="id" name="id" value="0"/>
            <input type="hidden"  name="es_movil" value="0"/>
            <input type="hidden" class="es_escritorio" name="es_escritorio" value="1"/>
				<button style="display:none" class="act_form"></button>
         </form>
      </div>
      <div class="modal-footer justify-content-between">
      <button type="button" class="btn btn-block btn-primary trigger_form" target="frmc_0001">Procesar Registro</button>      </div>
      </div>
      <!-- /.modal-content -->
   </div>
<!-- /.modal-dialog -->
</div>
