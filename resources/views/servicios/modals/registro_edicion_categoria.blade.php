<div class="modal" id="modal-lg" aria-hidden="true" style="display: none;">
   <div  style="width:50%; margin: 20px auto;">
      <div class="modal-content">
		  <div class="modal-header">
			 <h4 class="modal-title"><span class="titulo_salida"></span></h4>
			 <button type="button" class="close recargar" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">×</span>
			 </button>
		  </div>
		  <div class="modal-body">
				<form action="{{ route('categoria.registrar_editar') }}" method="post" class="frmc_0001">
					{{ csrf_field() }}
               
               <div class="row">
               <div class="col-2">
                     <div class="form-group">
                        <label for="">Codigo</label>
                        <input type="text" required class="form-control codigo" name="codigo"   >
                     </div>
               </div>
               <div class="col-6">
                <div class="form-group">
                  <label for="">Nombre</label>
                  <input type="text" required class="form-control nombre " name="nombre"   >
                </div>
               </div>
           
         

               <div class="col-4">
                <div class="form-group">
                  <label for="">Unidad de medida</label>
                    <select class=" form-group combo  instalacion articulo medida" name='medida' >
                        <option value="" >SELECCIONE</option>
                        <option value="METROS">METROS</option>
                        <option value="UNIDADES">UNIDADES</option>
                       
                     </select>
                </div>
            </div>
				<input type="hidden" class="id" name="id" />
				<button style="display:none" class="act_form"></button>
            </div>
			 	</form>
		  </div>
		  <div class="modal-footer justify-content-between">
			 <button type="button" class="btn btn-block btn-primary trigger_form" target="frmc_0001">Procesar Registro</button>
		  </div>
      </div>
      <!-- /.modal-content -->
   </div>
<!-- /.modal-dialog -->
</div>

<style>

</style>
