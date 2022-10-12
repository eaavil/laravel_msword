<div class="modal fade" id="modal-lgrs" aria-hidden="true" style="display: none;">
   <div class="modal-dialog modal-xs">
      <div class="modal-content">
		  <div class="modal-header">
			 <h4 class="modal-title">Generar Reporte de empaques proveedores</h4>
			 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">×</span>
			 </button>
		  </div>
		  <form action="{{ route('empaques.reporte.proveedores') }}"  target="_blank" method="post" class="frmr_0001">
		  {{ csrf_field() }}
		  <div class="modal-body">
		  <div class="row">
                 <div class="col-6">
                    <div class="form-group">
                       <label>Fecha Inicial</label>
                       <input type="date" name="c01" required class="form-control f1">
                    </div>
                 </div>
                 <div class="col-6">
                    <div class="form-group">
                       <label>Fecha Final</label>
                       <input type="date" name="c02" required class="form-control f2">
                    </div>
           </div>
             </div><hr/>
				<div class="col-12">
					<div class="form-group">
					  <label for="">Proveedor</label>
					  <select class="form-control combo" name="c03">
						<option value="-1">Todos</option>
						@foreach($proveedores as $rows)
							<option value="{{ $rows->id }}">{{ $rows->nombre }}</option>
						@endforeach
					  </select>
					</div>
				</div>
				<div class="col-6">
				            <div class="form-group">
                                <label>Tipo Reporte </label>
                                <select class="form-control combo tipo_reporte" required name="tipo_reporte">
                                    <option value="2">Resumido</option>
                                    <option value="1" selected="true">Detallado</option>
                                </select>
                            </div>
                </div>
				<div class="col-6">
				<div class="form-group">
                                <label>Tipo de archivo </label>
                                <select class="form-control combo" required name="c04">
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