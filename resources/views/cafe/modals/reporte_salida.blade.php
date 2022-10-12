<div class="modal fade" id="modal-lgr" aria-hidden="true" style="display: none;">
   <div class="modal-dialog modal-xs">
      <div class="modal-content">
      <div class="modal-header">
         <h4 class="modal-title">Inventario general de salidas</h4>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
         </button>
      </div>
      <div class="modal-body">
         <form action="{{ route('cafe.salidas.reporte') }}"  target="_blank" method="post" class="frm_0001">
         {{ csrf_field() }}
			<div class="row">
				<div class="col-6">
				   <div class="form-group">
					  <label>Fecha Inicial</label>
					  <input type="date" name="c01" required autocomplete="c01"  min="1" max="50000" class="form-control ini">
				   </div>
				</div>     
				<div class="col-6">
				   <div class="form-group">
					  <label>Fecha Final</label>
					  <input type="date" name="c02" required autocomplete="c01"  min="1" max="50000" class="form-control">
				   </div>
				</div>     				
            </div>
			<div class="row">
				<div class="col-12">
				   <div class="form-group">
					  <label>Proveedor</label>
					  <select class="form-control combo rep" name="c03" style="width: 100%;">
						 <option value="-1">Todos</option>
						 @foreach($proveedores as $rows)
							<option value="{{ $rows->id }}">{{ $rows->nit }}-{{ $rows->digito_verificacion_nit }} {{ $rows->nombre }}</option>
						 @endforeach
					  </select>
				   </div>
				</div>       				
            </div>		
			<div class="row">
				<div class="col-12">
				   <div class="form-group">
					  <label>Producto</label>
					  <select class="form-control combo rep" name="c04" style="width: 100%;">
						 <option value="-1">Todos</option>
						 @foreach($cafe as $rows)
							<option value="{{ $rows->id }}">{{ $rows->tipo_cafe }}</option>
						 @endforeach
					  </select>
				   </div>
				</div>       				
            </div>
			<div class="row">
				<div class="col-12">
				   <div class="form-group">
					  <label>Bodega</label>
					  <select class="form-control combo rep" name="c06" style="width: 100%;">
						 <option value="-1">Todos</option>
						 @foreach($centros as $rows)
							<option value="{{ $rows->id }}">{{ $rows->descripcion }}</option>
						 @endforeach
					  </select>
				   </div>
				</div>       				
            </div>
			<div class="row">
				<div class="col-12">
				   <div class="form-group existencia">
				   <label>Existencias pergamino e inferiores </label>
                                <select class="form-control combo"  name="c07" id="c11" style="width: 100%;">
								   <option value="-1" selected="true">Todos</option>
									<option value="1">Detallado</option>
                                    <option value="2" >Resumido</option>
                                </select>
				   </div>
				</div>       				
            </div>
			<div class="row">
				<div class="col-12">
				   <div class="form-group">
				   <label >Tipo de archivo </label>
                                <select class="form-control combo" required name="c05" id="c11" style="width: 100%;">
                                    <option value="1">EXCEL</option>
                                    <option value="2" selected="true" >HTML</option>
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