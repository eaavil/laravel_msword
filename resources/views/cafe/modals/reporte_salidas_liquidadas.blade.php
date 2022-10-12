<div class="modal fade" id="modal-lgrs" aria-hidden="true" style="display: none;">
   <div class="modal-dialog modal-xs">
      <div class="modal-content">
      <div class="modal-header">
         <h4 class="modal-title">Generar Reporte de salidas liquidadas</h4>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
         </button>
      </div>
      <div class="modal-body">
         <form action="{{ route('cafe.salidas.reporte_liquidadas') }}"  target="_blank" method="post" class="frm_0001">
         {{ csrf_field() }}
			<div class="row">
				<div class="col-6">
				   <div class="form-group">
					  <label>Fecha Inicial</label>
					  <input type="date" name="c01" required autocomplete="c01"  min="1" max="50000" class="form-control">
				   </div>
				</div>     
				<div class="col-6">
				   <div class="form-group">
					  <label>Fecha Final</label>
					  <input type="date" name="c02" required autocomplete="c01"  min="1" max="50000" class="form-control">
				   </div>
				</div>     				
            </div>
			<hr/>
			<div class="row">
				<div class="col-12">
				   <div class="form-group">
					  <label>Proveedor</label>
					  <select class="form-control combo" name="c03" style="width: 100%;">
						 <option value="-1">Todos</option>
						 @foreach($proveedores as $rows)
							<option value="{{ $rows->id }}">{{ $rows->nit }}-{{ $rows->digito_verificacion_nit }} {{ $rows->nombre }}</option>
						 @endforeach
					  </select>
				   </div>
				</div>       				
            </div>	
			<hr/>
			<div class="row">
				<div class="col-12">
				   <div class="form-group">
				   <label>Seleccione reporte</label>
                                <select class="form-control combo" required name="c04" id="c11" style="width: 100%;">
                                    <option value="1">Salidas Liquidadas</option>
                                    <option value="2" selected="true">Salidas sin liquidar</option>
                                </select>
				   </div>
				</div>       				
            </div>
			</hr>
			<div class="row">
				<div class="col-12">
				   <div class="form-group">
				   <label>Tipo de archivo </label>
                                <select class="form-control combo" required name="c05" id="c11" style="width: 100%;">
                                    <option value="1">EXCEL</option>
                                    <option value="2" selected="true">HTML</option>
                                </select>
				   </div>
				</div>       				
            </div>
			</hr>
			<button style="display:none" class="act_form"></button>
         </form>
      </div>
      <div class="modal-footer justify-content-between">
         <button type="button" class="btn btn-block btn-primary trigger_form" target="frm_0001">Procesar Registro</button>
      </div>
      </div>
      <!-- /.modal-content -->
   </div>
<!-- /.modal-dialog -->
</div>