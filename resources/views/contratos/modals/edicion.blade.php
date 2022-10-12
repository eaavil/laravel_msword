<div class="modal" id="modal-lge" aria-hidden="true" style="display: none;">
   <div  style="width:70%; margin: 20px auto;">
      <div class="modal-content">
		  <div class="modal-header">
			 <h4 class="modal-title">Editar cotizacion de venta<span class="titulo_salida"></span></h4>
			 <button type="button" class="close recargar" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">×</span>
			 </button>
		  </div>
		  <div class="modal-body">
				<form action="{{ route('contrato.actualizar') }}" method="post" class="frm_0001">
					{{ csrf_field() }}
		<div class="row">
               <div class="form-group mx-4">
                  <input type="text" style='width:100%' name="c01"  required  readonly class="form-control cor">
               </div>
			   <div class="form-group mx-4 numeral_anexo" style="display:none">
                  <input type="text" style='width:100%' name="c01"  required  readonly class="form-control cor">
               </div>
            
            <div class="col-3 form-group agre_art ">
                 <select class=" form-control  combo articuloe">
                 <option value="-1" selected="true">SELECCIONE CATEGORIA</option>
                        @foreach($categorias as $rows)
                               <option value="{{ $rows->id }}">{{ $rows->ruta }}</option>
                        @endforeach
                        </select>
            </div>
			<div class="form-group mx-4 ">
                 <select class=" form-control  combo rep" name="representante">
                 <option value="-1" >SELECCIONE REPRESENTANTE</option>
                        @foreach($clientes as $rows)
                               <option value="{{ $rows->id }}">{{ $rows->nombre }}</option>
                        @endforeach
                        </select>
            </div>
        </div>
					<h5 class="origen">Articulos a Despachar</h5>
					<table width="100%"   class="origen b " border="1"  style="color:black;font-size:90%; text-align: center; table-layout: fixed;">
						<thead>
							<tr class="table-primary" width="100%"   >
								<td width="40%">NOMBRE</td>
								<td>CANTIDAD</td>
								<td>V. UNIDAD</td>
								<td>% AUMENTO</td>
								<td>TOTAL</td>
								<td>ACCIONES</td>
							</tr>
						</thead>
						<tbody >
						</tbody>
					</table>
					<div class="row">
						<div class="col-3 origen">
							<div class="form-group">
							<label for="">Neto</label>
							<input type="text" class="form-control t1" name="neto" value="0" readonly >
							</div>
						</div>
						<div class="col-3 origen">
							<div class="form-group">
							<h6 class="origen">Iva</h6>
							<input type="text" class="form-control t2 " name="iva"  readonly >
							</div>
						</div>
						<div class="col-3 origen">
							
							<h6 class="origen">Total</h6>
							<input type="text" class="form-control t3 " name="total"  readonly >
							
						</div>
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
.modal-body{
  height: 600px;
  width: 100%;
  overflow-y: auto;
}

</style>
