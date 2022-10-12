<div class="modal fade" id="m-entrada-reporte" aria-hidden="true" style="display: none;">
   <div class="modal-dialog modal-xs">
      <div class="modal-content">
		  <div class="modal-header">
			 <h4 class="modal-title">Generar Reporte ingresos/egresos</h4>
			 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">×</span>
			 </button>
		  </div>
		  <form action="{{ route('ingresos/egresos.reporte') }}"  target="_blank" method="post" class="frmr_0001">
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
				
					
				</div><hr/>
				<div class="col-12">
				<label >Seleccione movimiento:</label>
                    <select name="c03" class="form-control clasificar combo">
                        <option value="-1">Todos</option>
                        <option value="1">Ingresos</option>
                        <option value="2">Egresos</option>
                    </select>

				</div>
				<hr/>
			  <div class="col-6">
					  <label>Tipo de archivo:</label>
                                <select class="form-control combo" required name="c04"  style="width: 50%;">
                                    <option value="1">HTML</option>
                                    <option value="2">EXCEL</option>
                                </select>
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