<div class="modal fade" id="modal-lgr" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-xs">
       <div class="modal-content">
       <div class="modal-header">
          <h4 class="modal-title">Generar Reporte de Liquidaciones</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">×</span>
          </button>
       </div>
       <div class="modal-body">
          <form action="{{ route('liquidaciones.salidas.reporte') }}"  target="_blank" method="post" class="frmr_0001">
          {{ csrf_field() }}
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
             <div class="row">
				<div class="col-12">
				   <div class="form-group">
					  <label>Clientes:</label>
					  <select class="form-control combo" name="c03" style="width: 100%;">
					  <option value="-1">Todos</option>
						@foreach($proveedores as $rows)
							<option value="{{ $rows->id }}">{{ $rows->nombre }} </option>
						@endforeach
					  </select><br>
                 <label>Reporte:</label>
                         <select class="form-control combo" required name="tipo_reporte"  style="width: 100%;">
                                    <option value="1">Salidas de Cafe para Liquidar</option>
                                    <option value="2">Salidas de Cafe liquidadas</option>
                                    <option value="3">Contratos de Venta sin Liquidar</option>
						</select><br>
                 
				   <div class="form-group">
					  <label>Tipo de Producto</label>
					  <select class="form-control combo" required name="c06" style="width: 100%;">
                 <option value=-1>Todos</option>
						 @foreach($cafe as $rows)
							<option value="{{ $rows->id }}">{{ $rows->tipo_cafe }}</option>
						 @endforeach
					  </select>
				   </div>
               
					  <label>Tipo de archivo:</label>
                                <select class="form-control combo" required name="c04"  style="width: 50%;">
                                    <option value="1">HTML</option>
                                    <option value="2">EXCEL</option>
                                </select>
              
				</div>
           
             <button style="display:none" class="act_form"></button>
          </form>
       </div>
       <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-block btn-primary trigger_form" target="frmr_0001">Procesar Registro</button>
       </div>
       </div>
       <!-- /.modal-content -->
    </div>
 <!-- /.modal-dialog -->
 </div>
