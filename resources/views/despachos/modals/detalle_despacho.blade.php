<div class="modal fade" id="modal-lg-despacho" aria-hidden="true" style="display: none;">
   <div class="modal-dialog modal-md">
      <div class="modal-content">
		  <div class="modal-header">
			 <h4 class="modal-title">Detalle Despacho <span class="titulo_despacho"></span></h4>
			 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
         </button>
		  </div>
		  <div class="modal-body">
				<form action="{{route('despachos.datax') }}" method="post" class="frmc_0001">
					{{ csrf_field() }}
					<div class="row">
						<div class="col-4">
							<div class="form-group">
								<label for="">Kilogramos</label>
								<span class="dt1"></span>
							</div>
						</div>
						<div class="col-4">
							<div class="form-group">
								<label for="">Factor Promedio</label>
								<input type="text" name="porcentaje_factor" style="width:40%; border:none" readonly class="dt2">
							</div>
						</div>
						<div class="col-4">
							<div class="form-group">
								<label for="">Factor Despacho</label>
								<input type="text" name="porcentaje_factor_referencia" class="dt4 form-control">
								<span ></span>
							</div>
						</div>
					</div>
					<table class="tabla_detalle_despacho" width="100%" border="1" style="text-align:center">
						<thead>
							<tr>
								<th>Entrada</th>
								<th>Proveedor</th>
								<th>Kilogramos</th>
								<th>Factor</th>
								<th>Tentativo</th>
								<th>Factor %</th>
							</tr>
						</thead>
						<tbody class="detalle_despacho">
						</tbody>
					</table>
					<input type="hidden" class="id" name="id_despacho" />
					<input type="hidden" class="idx" name="type" />
					<button style="display:none" class="act_form"></button>
			 	</form>
		  </div>
		  <div class="modal-footer justify-content-between">
			 <button type="button" class="btn btn-block btn-primary trigger_form_esp_entrada" target="frmc_0001">Procesar Registro</button>
		  </div>
      </div>
      <!-- /.modal-content -->
   </div>
<!-- /.modal-dialog -->
</div>
