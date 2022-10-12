<div class="modal fade" id="modal-lgr" aria-hidden="true" style="display: none;">
   <div class="modal-dialog modal-xs">
      <div class="modal-content">
      <div class="modal-header">
         <h4 class="modal-title">Generar Reporte de Anticipos a Terceros</h4>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
         </button>
      </div>
      <div class="modal-body">
         <form action="{{ route('anticipos.transporte.reporte') }}"  target="_blank" method="post" class="frmr_0001">
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
            <div class="col-12">
                <div class="form-group">
                  <label for="">Tercero y/o Transportador</label>
                  <select class="form-control combo contrato" name="c03">
                    <option value="">Seleccione</option>
                    <option value="-1">Todos</option>
                    @foreach($facturadores as $rows)
                        <option value="{{ $rows->id }}">{{ $rows->nombre }} Nit: ${{ number_format($rows->nit,0,',','.') }}</option>
                    @endforeach
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
