<div class="modal fade" id="modal-lg" aria-hidden="true" style="display: none;">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
		  <div class="modal-header">
			 <h4 class="modal-title">Registrar Mezcla {{ $consecutivo->parametro }}{{ str_pad($numeracion->parametro,3,'0',STR_PAD_LEFT) }} <span class="titulo_salida"></span></h4>
			 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">×</span>
			 </button>
		  </div>
		  <div class="modal-body">
				<form action="{{ route('mezcla.registrar') }}" method="post" class="frmc_0001">
					{{ csrf_field() }}
                   <div class="row">
						<div class="col-6">
							<div class="form-group">
								<label>Seleccione Pergamino</label>
								<select class="form-control combo agregar" name="c03" required style="width: 100%;">
									<option value="">Seleccione</option>
									@foreach($pergamino as $rows)
									@if($rows->kilos_disponibles > 0)
										<option value="{{ $rows->id }}">{{ $rows->nombre }} - {{$rows->numero_ticket}} - {{ number_format($rows->kilos_disponibles,0,',','.') }} kg</option>
									@endif
									@endforeach
								</select>
							</div>
						</div>
						<div class="col-6">
							<div class="form-group">
								<label>Seleccione Inferiores</label>
								<select class="form-control combo agregar" name="c03" required style="width: 100%;">
									<option value="">Seleccione</option>
									
									@foreach($inferiores as $rows)
									@if($rows->kilos_disponibles > 0)
									<option value="{{ $rows->id }}">{{ $rows->nombre }} - {{$rows->numero_ticket}} - {{number_format($rows->kilos_disponibles,0,',','.')}} kg</option>
									@endif
									@endforeach
								</select>
							</div>
						</div>
				   </div>

					<h5>Entradas a Mezclar</h5>
					<table width="100%" class="destino table-containerfi" border="1" style="color:black; text-align: center; table-layout: fixed;">
						<thead  style="background:#ccc;">
							<tr>
								<td>Numero</td>
								<td>Factor</td>
								<td>Tipo cafe</td>
								<td>% Valor producido</td>
								<td width="40%">Proveedor</td>
								<td>Kilos Diponibles</td>
								<td>Kilos a Despachar</td>
								<td>Acciones</td>
							</tr>
						</thead>
						<tbody>
						<td colspan="7" class="fila1">sin datos</td>
						</tbody>
					</table> <br>
					<div class="row">
						<div class="col-3">
							<div class="form-group">
							<label >Total Cafe a mezclar</label>
							<input type="text" class="form-control t1 numero_entero" name="kilogramos" requered readonly>
							</div>
						</div>
						<div class="col-3">
							<div class="form-group">
							<label for="">Total % Factor</label>
							<input type="number" class="form-control t2" name="factor_promedio" step="0.01"  requered readonly>
							</div>
						</div>
						<div class="col-3">
							<div class="form-group">
							<label for="">Total sacos</label>
							<input type="number" class="form-control t3"  name="total_sacos"  >
							</div>
						</div>
						<div class="col-3">
							<div class="form-group">
							<label for="">Total tulas</label>
							<input type="number" class="form-control t4" name="total_tulas"  />
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
			 <button type="button" class="btn btn-block btn-primary trigger_form_esp" target="frmc_0001">Procesar Registro</button>
		  </div>
      </div>
      <!-- /.modal-content -->
   </div>
<!-- /.modal-dialog -->
</div>

<style>


</style>
