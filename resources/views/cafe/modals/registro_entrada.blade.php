<div class="modal fade" id="modal-lg" aria-hidden="true" style="display: none;">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
      <div class="modal-header">
         <h4 class="modal-title">Registrar Nuevo Movimiento de Entrada</h4>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
         </button>
      </div>
      <div class="modal-body">
         <form action="{{ route('cafe.entrada.registrar') }}" method="post" class="frm_0001">
         {{ csrf_field() }}
			<div class="row">
                <div class="col-3">
                    <div class="form-group">
                       <label>Ticket</label>
                       <input type="text" value="{{ $consecutivo->parametro }}{{ str_pad($numeracion->parametro,3,'0',STR_PAD_LEFT) }}" readonly name="c02" required  min="1" max="50000" class="form-control">
                    </div>
                 </div>
				<div class="col-3">
				   <div class="form-group">
					  <label>Fecha</label>
					  <input type="date" name="c01" required  min="1" max="50000" class="form-control">
				   </div>
				</div>
				<div class="col-3">
				   <div class="form-group">
					  <label>Proveedor</label>
					  <select class="form-control combo" name="c03" required style="width: 100%;">
						 <option value="">Seleccione</option>
						 @foreach($proveedores as $rows)
							<option value="{{ $rows->id }}">{{ $rows->nombre }} NIT:{{ $rows->nit }}{{ $rows->digito_verificacion_nit }}</option>
						 @endforeach
					  </select>
				   </div>
				</div>
				<div class="col-3">
				   <div class="form-group">
					  <label>Trilladora / Bodega</label>
					  <select class="form-control combo" name="c04" required style="width: 100%;">
						 @foreach($centros as $rows)
							<option value="{{ $rows->id }}">{{ $rows->codigo }} - {{ $rows->descripcion }}</option>
						 @endforeach
					  </select>
				   </div>
				</div>
            </div>
			<div class="row">
				<div class="col-3">
				   <div class="form-group">
					  <label>Factor Base</label>
					  <input type="text" value="0" name="c05" class="form-control">
				   </div>
				</div>
				<div class="col-3">
				   <div class="form-group">
					  <label>Tipo de Producto</label>
					  <select class="form-control combo" required name="c06" style="width: 100%;">
						 @foreach($cafe as $rows)
							<option value="{{ $rows->id }}">{{ $rows->tipo_cafe }}</option>
						 @endforeach
					  </select>
				   </div>
				</div>
				<div class="col-3">
				   <div class="form-group">
					  <label>Sacos</label>
					  <input type="number" required value="0" name="c07"  max="52000000" class="form-control calculator ck">
				   </div>
				</div>
				<div class="col-3">
				   <div class="form-group">
					  <label>Tulas</label>
					  <input type="number" required value="0" name="c08"  max="52000000" class="form-control calculator ck">
				   </div>
				</div>
            </div>
			<div class="row">
				<div class="col-3">
				   <div class="form-group">
					  <label>Conductor</label>
					  <select class="form-control combo" required name="c09" style="width: 100%;">
						<option value="">Seleccione</option>
						 @foreach($transporte as $rows)
							<option value="{{ $rows->id }}">{{ $rows->nombre }} NIT:{{ $rows->nit }}-{{ $rows->digito_verificacion_nit }}</option>
						 @endforeach
					  </select>
				   </div>
				</div>
				<div class="col-3">
				   <div class="form-group">
					  <label>Placa Vehiculo</label>
					  <input type="text" name="c11" required class="form-control">
				   </div>
				</div>
				<div class="col-3">
				   <div class="form-group">
					  <label>Observaciones</label>
					  <input type="text" name="c12" class="form-control">
				   </div>
				</div>
            </div>
			<div class="row">
				<div class="col-2">
				   <div class="form-group">
					  <label>Peso Entrada</label>
					  <input type="text" name="c13" required class="form-control calc p1 numero_entero">
				   </div>
                </div>
                <div class="col-2">
                    <div class="form-group">
                       <label>Peso Salida</label>
                       <input type="text" name="c14" required class="form-control calc p2 numero_entero">
                    </div>
                 </div>
				<div class="col-3">
				   <div class="form-group">
					  <label>Peso Bruto</label>
					  <input type="text" name="c15" required class="form-control calc p3 numero_entero">
				   </div>
				</div>
				<div class="col-2">
				   <div class="form-group">
					  <label>Tara</label>
					  <input type="text" name="c16" required class="form-control calc p4 numero_entero">
				   </div>
				</div>
				<div class="col-3">
				   <div class="form-group">
					  <label>Peso Neto</label>
					  <input type="text" name="c17" required class="form-control calc p5 numero_entero">
				   </div>
				</div>
            </div>
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
