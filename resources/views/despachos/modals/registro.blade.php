<div class="modal fade" id="modal-lg" aria-hidden="true" style="display: none;">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
		  <div class="modal-header">
			 <h4 class="modal-title">Registrar Despacho {{ $consecutivo->parametro }}{{ str_pad($numeracion->parametro,3,'0',STR_PAD_LEFT) }} para Salida <span class="titulo_salida"></span></h4>
			 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">×</span>
			 </button>
		  </div>
		  <div class="modal-body">
				<form action="{{ route('despachos.registrar') }}" method="post" class="frmc_0001">
					{{ csrf_field() }}
					<h5>Entradas Pendientes</h5>
					<table width="100%" class="origen table-containerfi" border="1">
						<thead>
							<tr>
								<td>Numero</td>
								<td>Factor</td>
								<td>Trilladora</td>
								<td>Proveedor</td>
								<td>Accion</td>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
					<h5>Entradas a Despachar</h5>
					<table width="100%" class="destino table-containerfi" border="1">
						<thead>
							<tr>
								<td>Numero</td>
								<td>Factor</td>
								<td>Factor Pro</td>
								<td>Trilladora</td>
								<td>Proveedor</td>
								<td>Kilos Diponibles</td>
								<td>Kilos a Despachar</td>
								<td>Acciones</td>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
					<div class="row">
						<div class="col-3">
							<div class="form-group">
							<label for="">Total Cafe a Despachar</label>
							<input type="text" class="form-control t1" name="kilogramos" value="0" readonly>
							</div>
						</div>
						<div class="col-3">
							<div class="form-group">
							<label for="">Total % Factor</label>
							<input type="text" class="form-control t2" name="factor_promedio" value="0" readonly>
							</div>
						</div>
						<div class="col-3">
							<div class="form-group">
							<label for="">Kilogramos Restantes</label>
							<input type="text" class="form-control t3 weight" readonly>
							<input type="hidden" class="form-control t3x weight"  name="valor_despacho" value="0" readonly>
							</div>
						</div>
						<div class="col-3">
							<div class="form-group">
							<label for="">Factor Despacho</label>
							<input type="number" class="form-control" step="0.01" required name="factor_promedio_referencia" />
							</div>
						</div>
					</div>
					<input type="hidden" class="weight" />
					<input type="hidden" class="limit" name="limit" />
					<input type="hidden" class="salida" name="id_salida" />
					<input type="hidden" value="{{ $consecutivo->parametro }}{{ str_pad($numeracion->parametro,3,'0',STR_PAD_LEFT) }}" readonly class="form-control" name="numero"/>
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

<style>

.table-containerfi {
    height: 15em;
}
table {
    display: flex;
    flex-flow: column;
    height: 100%;
    width: 100%;
}
table thead {
    /* head takes the height it requires,
    and it's not scaled when table is resized */
    flex: 0 0 auto;
    width: calc(100% - 0.9em);
}
table tbody {
    /* body takes all the remaining available space */
    flex: 1 1 auto;
    display: block;
    overflow-y: scroll;
}
table tbody tr {
    width: 100%;
}
table.table-containerfi tbody tr td {
    text-align: center;
}
table.table-containerfi thead tr td {
    text-align: center;
}
table tbody tr td {
    text-align: center;
}
table thead, table tbody tr {
    display: table;
    table-layout: fixed;
}


</style>
