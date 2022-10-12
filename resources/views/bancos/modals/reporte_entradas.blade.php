<div class="modal fade" id="modal-lgr" aria-hidden="true" style="display: none;">
   <div class="modal-dialog ">
      <div class="modal-content">
		  <div class="modal-header">
			 <h4 class="modal-title">Generar Reporte movimientos</h4>
			 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">×</span>
			 </button>
		  </div>
		  <form action="{{ route('bancos.saldo.procesar.reporte')}}?modo=1"  target="_blank" method="post" class="frmr_0001">
		  {{ csrf_field() }}
		  <div class="modal-body">
				<div class="row">
					<div class="col-6">
					   <div class="form-group">
						  <label>Fecha Inicial</label>
						  <input type="date" name="c02" required class="form-control">
					   </div>
					</div>
					<div class="col-6">
					   <div class="form-group">
						  <label>Fecha Final</label>
						  <input type="date" name="c03" required class="form-control">
					   </div>
					</div>
				</div>
				<hr/>
				<div class="col-12">
                      
                            <label >Cuenta Bancaria</label>
                            <select  class="form-control combo" name="c01" style="width: 100%;">
                                @foreach ($cuentas as $item)
                                    <option value="{{ $item->id_cuenta }}" 
                                        @if ($valor==$item->id_cuenta)
                                        selected
                                        @endif
                                    >{{ $item->cuenta }} / {{ $item->cliente }} {{ $item->documento_cliente }} | {{ $item->entidad }} - {{ $item->nombre }}
									</option>
                                @endforeach
                            </select>
                        
                   
				</div>
				<hr/>
				<div class="col-6">
					<div class="form-group">
					<label>Tipo de archivo </label>
                                <select class="form-control combo" required name="c04" id="c11" style="width: 100%;">
                                    <option value="1">EXCEL</option>
                                    <option value="2" selected="true">HTML</option>
                                </select>
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