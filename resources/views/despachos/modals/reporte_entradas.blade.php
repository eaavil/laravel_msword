<div class="modal fade" id="modal-lgr" aria-hidden="true" style="display: none;">
   <div class="modal-dialog modal-xs">
      <div class="modal-content">
		  <div class="modal-header">
			 <h4 class="modal-title">Generar Reporte de Despachos </h4>
			 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">×</span>
			 </button>
		  </div>
		  <form action="{{ route('despachos.reporte') }}"  target="_blank" method="post" class="frmr_0001">
		  {{ csrf_field() }}
		  <div class="modal-body">
				<div class="row">
					<div class="col-6">
					   <div class="form-group">
						  <label>Fecha Inicial</label>
						  <input type="date" name="c01" required class="form-control">
					   </div>
					</div>
					<div class="col-6">
					   <div class="form-group">
						  <label>Fecha Final</label>
						  <input type="date" name="c02" required class="form-control">
					   </div>
					</div>
				</div>
				<hr/>
				<div class="col-12">
					<div class="form-group">
					  <label for="">Clientes</label>
					  <select class="form-control combo" name="c03">
						<option value="-1">Todos</option>
						@foreach($clientes as $rows)
							<option value="{{ $rows->id }}">{{ $rows->nombre }}</option>
						@endforeach
					  </select><br>
					  <label>Reporte </label>
                         <select class="form-control combo" required name="tipo_reporte"  style="width: 100%;">
                                    <option value="1">Salidas sin despacho</option>
                                    <option value="2">Despachos registrados</option>
                                    <option value="3">Despachos culminados</option>
						</select><br>
					</div>
				</div>
				<div class="col-9">
					<div class="form-group">
									<label>Tipo de archivo </label>
									<select class="form-control combo" required name="c04" id="c11" style="width: 100%;">
										<option value="1">EXCEL</option>
										<option value="2" selected="true">HTML</option>
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
