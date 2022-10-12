<div class="modal fade" id="modal-lgrs" aria-hidden="true" style="display: none;">
   <div class="modal-dialog modal-xs">
      <div class="modal-content">
		  <div class="modal-header">
			 <h4 class="modal-title">Generar Reporte de saldo anticipos/liquidaciones</h4>
			 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">×</span>
			 </button>
		  </div>
		  <form action="{{ route('liquidaciones.salidas.reporte.resumen_saldo') }}"  target="_blank" method="post" class="frmr_0001">
		  {{ csrf_field() }}
		  <div class="modal-body">
				
				<div class="col-12">
					<div class="form-group">
					  <label for="">Cliente</label>
					  <select class="form-control combo" name="c01">
						<option value="-1">Todos</option>
						@foreach($clientes as $rows)
							<option value="{{ $rows->id }}">{{ $rows->nombre }}</option>
						@endforeach
					  </select>
					</div>
				</div><hr/>
				<div class="col-6">
				<div class="form-group">
                                <label>Tipo de archivo </label>
                                <select class="form-control combo" required name="c02">
                                    <option value="2">EXCEL</option>
                                    <option value="1" selected="true">HTML</option>
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