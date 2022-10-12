<div class="modal fade" id="m-entrada-reporte" aria-hidden="true" style="display: none;">
   <div class="modal-dialog modal-xs">
      <div class="modal-content">
		  <div class="modal-header">
			 <h4 class="modal-title">Generar reporte de Inventario</h4>
			 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">×</span>
			 </button>
		  </div>
		  <form action="{{ route('inventario.reporte') }}"  target="_blank" method="post" class="frmr_0001">
		  {{ csrf_field() }}
		  <div class="modal-body">
				<div class="row">
					<div class="col-6">
					   <div class="form-group">
						  <label>Fecha Inicial (*)</label>
						  <input type="date" name="c01" class="form-control">
					   </div>
					</div>
					<div class="col-6">
					   <div class="form-group">
						  <label>Fecha Final (*)</label>
						  <input type="date" name="c02"  class="form-control">
					   </div>
					</div>
				
					
				</div><hr/>
				<div class="row">
					<div class="col-6">
						<label for="my-select">Seleccione Categoria:</label>
							<select name="c03" class="combo form-control clasificar">
							<option value="" >SELECCIONE</option>
								@foreach($categorias as $rows)
								<option value="{{ $rows->id }}">{{ $rows->ruta }}</option>
								@endforeach
							</select>

					</div>
					<div class="col-6">
							<label>Selecccione Tipo de archivo:</label>
										<select class="form-control combo" required name="c04"  >
											<option value="2">HTML</option>
											<option value="1">EXCEL</option>
										</select>
					</div>

				</div>
				
			 
		  </div>
		  <div class="modal-footer justify-content-between">
			 <button type="submit" class="btn btn-block btn-primary">Procesar Registro</button>
		  </div>
		 </form>
      </div>
      <!-- /.modal-content -->
   </div>
<!-- /.modal-dialog -->
</div>