<div class="modal fade" id="modal-lg" aria-hidden="true" style="display: none;">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
      <div class="modal-header">
         <h4 class="modal-title">Registrar Nuevo Giro</h4>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
         </button>
      </div>
      <div class="modal-body">
         <form action="{{ route('giros.registrar') }}" method="post" class="frm_0001">
         {{ csrf_field() }}
         <div class="row">
            <div class="col-12">
               <div class="form-group">
                   <label for="">Proveedor</label>
                   <select class="form-control combo"  required name="c01">
                     <option value="">Seleccione</option>
                     @foreach($proveedores as $rows)
                         <option value="{{ $rows->id }}">{{ $rows->nit }} - {{ $rows->digito_verificacion_nit }} {{ $rows->nombre }}  </option>
                     @endforeach
                   </select>
               </div>
            </div>
        </div>
         <div class="row">
            <div class="col-4">
                <div class="form-group">
                    <label for="">Cuenta</label>
                    <select class="form-control combo" required name="c03">
                      <option value="">Seleccione</option>
                      @foreach($cuentas as $rows)
                          <option value="{{ $rows->id }}">{{ $rows->banco->entidad }}  {{ $rows->cliente }} - {{ number_format($rows->cuenta,0,',','.') }}   </option>
                      @endforeach
                    </select>
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                  <label for="">Valor</label>
                  <input type="text" class="form-control numero_entero valor" required name="c04" aria-describedby="helpId" placeholder="">
                </div>
            </div>
            <div class="col-4">
               <div class="form-group">
                  <label>Facturador</label>
                  <select class="form-control combo" name="c08" required style="width: 100%;">
				     <option value="">Seleccione</option>
                     @foreach($facturador as $rows)
                        <option value="{{ $rows->id }}">{{ $rows->nit }}-{{ $rows->digito_verificacion_nit }} {{ $rows->nombre }}</option>
                     @endforeach
                  </select>
               </div>
            </div>
         </div>
         <div class="row">
            <div class="col-4">
               <div class="form-group">
                  <label>Fecha</label>
                  <input type="date" name="c05" autocomplete="name-in" required class="form-control">
               </div>
            </div>
            <div class="col-4">
               <div class="form-group">
                  <label>N° Cheque / Transaccion</label>
                  <input type="text" name="c06" maxlength="15" required autocomplete="name-in" class="form-control">
               </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                  <label for="">Forma de Pago</label>
                  <select class="form-control combo" name="c07">
                    <option value="CHEQUE">CHEQUE</option>
                    <option value="EFECTIVO">EFECTIVO</option>
                    <option value="TRANFERENCIA">TRANFERENCIA</option>
                    <option value="CONSIGNACION">CONSIGNACION</option>
                    <option value="RECIBO">RECIBO</option>
                    <option value="CRUCE">CRUCE</option>
                  </select>
                </div>
            </div>
         </div>
         <button style="display:none" class="act_form"></button>
         </form>
      </div>
      <div class="modal-footer justify-content-between">
         <button type="button" class="btn btn-block btn-primary trigger_form_esp" target="frm_0001">Procesar Registro</button>
      </div>
      </div>
      <!-- /.modal-content -->
   </div>
<!-- /.modal-dialog -->
</div>
