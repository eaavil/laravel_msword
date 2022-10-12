<div class="modal" id="modal-lge" aria-hidden="true" style="display: none;">
   <div  style="width:70%; margin: 20px auto;">
      <div class="modal-content">
		  <div class="modal-header">
			 <h4 class="modal-title">Editar contrato de compra<span class="titulo_salida"></span></h4>
			 <button type="button" class="close recargar" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">×</span>
			 </button>
		  </div>
		  <div class="modal-body">
				<form action="{{ route('contrato.compra.actualizar') }}" method="post" class="frm_0001">
					{{ csrf_field() }}
		<div class="row">
		
               <div class="form-group">
			   <label><h6>Correlativo</h6>
                  <input type="text" name="c01"  required  class="form-control cor">
				</label>
			 
            </div>
            <div class="col-3 form-group agre_art ">
			<label style='width:100%'><h6>Proveedor</h6>
                 <select class=" form-control  combo prov" required  name="c12">
                 <option value="-1" selected="true">SELECCIONE PROVEEDOR</option>
                        @foreach($proveedores as $rows)
                               <option value="{{ $rows->id }}">{{ $rows->nombre }}</option>
                        @endforeach
                        </select>
			</label>
            </div>
            
			<div class="col-3 form-group  ">
			<label><h6>Cotizacion</h6>
                  <input type="text" name="c02"  class="form-control cot">
				</label>
            </div>
            
             <div class="col-3 agre_art  " >
			<label style='width:100%'><h6>Agregar articulos</h6>
                 <select class=" form-group combo reset instalacion articulo edi" name='instalacion' >
                 <option value="" >SELECCIONE ARTICULO</option>
                        @foreach($articulos as $rows)
                               <option value="{{ $rows->id }}">{{ $rows->nombre }}</option>
                        @endforeach
                        </select>
			</label>
            </div>
        </div>
					<h6 class="origen_compra">Articulos a Despachar</h6>
					<table width="100%"   width="100%"  class="origen" border="1"  style="color:black;font-size:90%; text-align: center; table-layout: fixed">
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
						<div class="col-3 origen">
							<div class="form-group">
							<h6 class="origen">Neto</h6>
							<input type="text" class="form-control t1" name="neto"  readonly >
							</div>
						</div><br>
						<div class="col-3 origen ">
							<div class="form-group">
							<h6 class="origen">Iva</h6>
							<input type="text" class="form-control t2 " name="iva"   >
							</div>
						</div><br>
						<div class="col-3 origen">
							
							<h6 class="origen">Total</h6>
							<input type="text" class="form-control t3 " name="total"   >
							
						</div>
					</div>
					<h6 >Observaciones</h6>
		  <div class="form-group " contenteditable="true">
						     <textarea    rows="5"  width='80%' class=" form-control comentario_text" name="descripcion" autocomplete="off" value="" style=" text-align: justify; white-space: pre-line; -moz-text-align-last: left;text-align-last: left;"></textarea>
						</div>
					<input type="hidden" class="weight" />
					<input type="hidden" class="limit" name="limit" />
					<input type="hidden" class="salida" name="id" />
					<input type="hidden"  readonly class="form-control" name="numero"/>
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

<style>

</style>
