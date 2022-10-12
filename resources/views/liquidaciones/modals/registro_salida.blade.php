<div class="modal fade" id="modal-lg" aria-hidden="true" style="display: none;">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
      <div class="modal-header">
         <h4 class="modal-title">Registrar Liquidacion {{ $consecutivo->parametro }}{{ str_pad($numeracion->parametro,3,'0',STR_PAD_LEFT) }}</h4>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
         </button>
      </div>
      <div class="modal-body">
         <form action="{{ route('liquidaciones.salidas.registrar') }}" method="post" class="frm_0001">
         {{ csrf_field() }}
         <h5>Informacion de la Salida</h5>
         <div class="contenido">

         </div>
         <h5>Datos para la Liquidacion</h5>
         <div class="row">
            <div class="contrato2 col-3">
                <div class="form-group">
                    <label for="">Contrato</label>
                    <select  class="form-control combo contrato" name="contrato">
                    <option value="-2">Seleccione</option>
                    @foreach($contratos_listado as $rows)
                        <option value="{{ $rows->id }}" data-value="{{ ($rows->valor_contrato-$rows->valor_pagado) }}">{{ $rows->numero }} Valor: ${{ number_format($rows->valor_contrato,2,',','.') }}</option>
                    @endforeach
                    </select>
                </div>
            </div>
             <div class="filacont">
                <div class="form-group">
                  <label for="">Kilos a Liquidar</label>
                  <input type="text"  required class="numero_entero form-control c01 x" name="c01"/>
                </div>
             </div>
               <div class="fb filacont">
                  <div class="form-group">
                    <label for="">Factor Base</label>
                    <input type="text" readonly class="form-control c02 x" name="c02"/>
                  </div>
              </div>
              <div class="fd filacontkilos">
                  <div class="form-group">
                    <label for="">Factor Descuento</label>
                    <input type="text" class="form-control c03 x" name="c03"/>
                  </div>
              </div>
              <div class="fbd filacont">
                  <div class="form-group">
                    <label for="">F.B. con Descuentos</label>
                    <input type="text" class="form-control c04" readonly name="c04"/>
                  </div>
              </div>
           
         </div>
         <div class="row">
            <div class="col-3">
                <div class="form-group">
                  <label for="">Fecha Liquidacion</label>
                  <input type="date" required class="form-control" name="c17"/>
                </div>
             </div>
             <div class="col-3">
                <div class="form-group">
                  <label for="">Valor Arroba</label>
                  <input type="text" class="numero_entero form-control c05 x" name="c05"/>
                </div>
             </div>
             <div class="col-3">
                 <div class="form-group">
                   <label for="">Cafe Bruto</label>
                   <input type="text" class="numero_entero form-control c06" readonly name="c06"/>
                 </div>
             </div>
             <div class="col-3">
                <div class="form-group">
                  <label for="">Valor Descuento</label>
                  <input type="text" class="numero_entero form-control c07" readonly name="c07"/>
                </div>
             </div>
         </div>
         <h5>Retenciones</h5>
        <div class="row">
            <div class="col-3">
                <div class="form-group">
                  <label for="">Retencion Fuente</label>
                  <input type="number" min="0" max="100" step="0.01" class="form-control c08 x" name="c08"/>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                  <label for="">Total Retencion Fuente</label>
                  <input type="text" class="numero_entero form-control c09" readonly name="c09"/>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                  <label for="">Retencion 4 x 1000</label>
                  <input type="number"  min="0" max="100" step="0.01" class="form-control c10 x" name="c10"/>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                  <label for="">Total Retencion 4 x 1000</label>
                  <input type="text" class="numero_entero form-control c11" readonly name="c11"/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-3">
                <div class="form-group">
                  <label for="">Retencion Cooperativa</label>
                  <input type="number"  min="0" max="100" step="0.01" class="form-control c12 x" name="c12"/>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                  <label for="">Total Retencion Cooperativa</label>
                  <input type="text" class="numero_entero form-control c13" readonly name="c13"/>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                  <label for="">Retencion Aporte a Tercero</label>
                  <input type="number"  min="0" max="100" step="0.01" class="form-control c14 x" name="c14"/>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                  <label for="">Total Retencion Aporte a Tercero</label>
                  <input type="text" class="numero_entero form-control c15 x" readonly name="c15" />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                <label for="">Total Liquidacion</label>
                <input type="text" class="numero_entero form-control c16" value="0" readonly name="c16">
                </div>
            </div>
        </div>
        <input type="hidden" class="limit" name="limit" />
        <input type="hidden" class="entrada" name="id_entrada" />
        <input type="hidden" value="{{ $consecutivo->parametro }}{{ str_pad($numeracion->parametro,3,'0',STR_PAD_LEFT) }}" readonly class="form-control" name="numero"/>
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
