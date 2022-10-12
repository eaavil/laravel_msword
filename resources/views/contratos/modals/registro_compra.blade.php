<div class="modal" id="modal-lg" aria-hidden="true" style="display: none;">
   <div  style="width:70%; margin: 20px auto;">
      <div class="modal-content">
		  <div class="modal-header">
			 <h4 class="modal-title">Editar contrato de compra<span class="titulo_salida"></span></h4>
			 <button type="button" class="close recargar" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">×</span>
			 </button>
		  </div>
		  <div class="modal-body">
				<form action="{{ route('contratos.compra.registrar') }}" method="post" class="frm_0001c">
					{{ csrf_field() }}
		<div class="row">
			<div >
               <div class="form-group ">
			   <label><h6>Correlativo</h6>
                  <input type="text" name="cor"  required  readonly class="form-control cor">
				</label>
			   </div>
            </div>
            <div class="col-3 form-group agre_art ">
			<label style='width:100%'><h6>Proveedor</h6>
                 <select class="form-control  combo" required  name="p">
                 <option value="-1" selected="true">SELECCIONE PROVEEDOR</option>
                        @foreach($proveedores as $rows)
                               <option value="{{ $rows->id }}">{{ $rows->nombre }}</option>
                        @endforeach
                        </select>
			</label>
            </div>
			<div class="col-3 form-group  ">
			<label style='width:100%' ><h6>Cotizacion/factura</h6>
                  <input type="text" name="cc"  required  class="form-control" value="apertura de inventario">
				</label>
            </div>

            <div class="col-3 agre_art  " >
			<label style='width:100%'><h6>Agregar articulos</h6>
                 <select class=" form-group combo reset instalacion articulo" name='instalacion' >
                 <option value="" >SELECCIONE ARTICULO</option>
                        @foreach($articulos as $rows)
                               <option value="{{ $rows->id }}">{{ $rows->nombre }}</option>
                        @endforeach
                        </select>
			</label>
            </div>
        </div>
       
					<h6 class="origen">Articulos a Despachar</h6>
					<table width="100%"  class="origen_compra" border="1" width="100%" border="1"  style="color:black;font-size:90%; text-align: center; table-layout: fixed;" >
						<thead>
							<tr border="1"  style="background:#ccc; color:black;font-size:80%;">
								<td width="40%">NOMBRE</td>
								<td>CANTIDAD</td>
								<td>V. UNIDAD</td>
								<td>DESC.</td>
								<td>TOTAL</td>
								<td>ACCIONES</td>
								
							</tr>
						</thead>
						<tbody >
						</tbody>
					</table> <br>
					<div class="row">
						<div class="col-3 ">
							<div class="form-group">
							<h6 >Neto</h6>
							<input type="text" class="form-control tc1" name="neto"  readonly >
							</div>
						</div><br>
						<div class="col-3 ">
							<div class="form-group">
							<h6 >Iva</h6>
							<input type="text" class="form-control tc2 " name="iva"   >
							</div>
						</div><br>
						<div class="col-3 ">
							
							<h6 >Total</h6>
							<input type="text" class="form-control tc3 " name="total"   >
							
						</div>
					</div>
					<input type="hidden" class="weight" />
					<input type="hidden" class="limit" name="limit" />
					<input type="hidden" class="salida" name="id" />
					<input type="hidden"  readonly class="form-control" name="numero"/>
					<button style="display:none" class="act_form"></button>
			 	</form>
		  </div>
		  <h6 >Observaciones</h6>
		  <div class="form-group " contenteditable="true">
						     <textarea    rows="5"  width='80%' class=" form-control comentario_text" name="descripcion" autocomplete="off" value="" style=" text-align: justify; white-space: pre-line; -moz-text-align-last: left;text-align-last: left;"></textarea>
						</div>
		  <div class="modal-footer justify-content-between">
			 <button type="button" class="btn btn-block btn-primary trigger_formc" target="frm_0001c">Procesar Registro</button>
		  </div>
      </div>
      <!-- /.modal-content -->
   </div>
<!-- /.modal-dialog -->
</div>

<style>
</style>
