
<div class="modal fade" id="modal-2" aria-hidden="true" style="display: none;">
   <div class="modal-dialog modal-xs">
      <div class="modal-content">
      <div class="modal-header">
         <h4 class="modal-title">Generar Reporte de ingresos/egresos</h4>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
         </button>
      </div>
      <div class="modal-body">
         <form action=" {{route ('contratos.reporte')}}"  target="_blank" method="post" class="frmr_0001">
		 <?php csrf_field() ?> 

			<div class="row">
				<div class="col-6">
				   <div class="form-group">
					  <label>Fecha Inicial</label>
					  <input type="date" name="fecha_inicial" required autocomplete="fecha_inicial"  min="1" max="50000" class="form-control">
				   </div>
				</div>
				<div class="col-6">
				   <div class="form-group">
					  <label>Fecha Final</label>
					  <input type="date" name="fecha_final" required autocomplete="fecha_final"  min="1" max="50000" class="form-control">
				   </div>
               
				</div> <br><div class="col-6">
					<label >Vendedora:</label>
                                <select class="form-control combo" required name="id_vendedora"  style="width: 100%;">
                                @foreach($vendedoras as $rows)
                                  <option value="{{$rows->id}}">{{ $rows->nombre }}</option>
                                    @endforeach
                                 </select>
               </div>
            <br><div class="col-6">
					<label >Tipo de archivo:</label>
                                <select class="form-control combo" required name="c03"  style="width: 100%;">
                                    <option value="1">HTML</option>
                                    <option value="2">EXCEL</option>
                                </select>
               </div>
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
