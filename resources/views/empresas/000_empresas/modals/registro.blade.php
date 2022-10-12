<div class="modal fade" id="modal-lg" aria-hidden="true" style="display: none;">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
      <div class="modal-header">
         <h4 class="modal-title">Registrar Nueva Empresa</h4>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
         </button>
      </div>
      <div class="modal-body">
         <form action="{{ route('empresas.registrar') }}" method="post" class="frm_0001">
         {{ csrf_field() }}
         <div class="row">
            <div class="col-6">
               <div class="form-group">
                  <label>Razon Social</label>
                  <input type="text" name="c02" autocomplete="name-in" class="form-control">
               </div>
               <div class="form-group">
                  <label>Nit</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                    <input type="text"  name="c03" class="form-control onumbers" maxlength="10">
                    </div>
                    <input type="tex" name="c04" class="form-control onumbers" maxlength="1">
                  </div>
               </div>
               <div class="form-group">
                  <label>Direccion Linea 1:</label>
                  <input type="text" name="c05" autocomplete="dir1-in" class="form-control">
               </div>
               <div class="form-group">
                  <label>Direccion Linea 2: (Opcional)</label>
                  <input type="text" name="c06" autocomplete="dir2-in" class="form-control">
               </div>
               <div class="form-group">
                  <label>Direccion Linea 3: (Opcional)</label>
                  <input type="text" name="c07" autocomplete="dir3-in" class="form-control">
               </div>
               <div class="form-group">
                  <label>Ubicacion</label>
                  <select class="form-control combo" name="c08" id="c08" style="width: 100%;">
                     @foreach($poblaciones as $rows)
                        <option value="{{ $rows->id_poblacion }}">{{ $rows->nombre_ciudad }}, {{ $rows->departamento }}</option>
                     @endforeach
                  </select>
               </div>
               <div class="form-group">
                  <label>PBX:</label>
                  <input type="text" name="c09" autocomplete="pbx-in" class="form-control onumbers" maxlength="8">
               </div>
               <div class="form-group">
                  <label>Telefono:</label>
                  <input type="text" name="c10" autocomplete="phone-in" class="form-control onumbers" maxlength="10">
               </div>
            </div>

            <div class="col-6">
               <div class="form-group">
                  <label>Email:</label>
                  <input type="email" name="c11" required autocomplete="email-in" class="form-control" data-inputmask='"mask": "(999) 999-9999"' data-mask>
               </div>
               <div class="form-group">
                  <label>Gran Contribuyente</label>
                  <select class="form-control combo" name="c12" id="c12" style="width: 100%;">
                     <option value="1">Si</option>
                     <option value="2">No</option>
                     <option value="9">No Aplica</option>
                  </select>
               </div>
               <div class="form-group">
                  <label>Retencion Renta Compra</label>
                  <select class="form-control combo" name="c13" id="c13" style="width: 100%;">
                     <option value="0">No Liquida</option>
                     <option value="1">Si Liquida y No la Contabiliza</option>
                     <option value="2">Si Liquida y Si la Contabiliza</option>
                     <option value="3">Autoretenedor</option>
                  </select>
               </div>
               <div class="form-group">
                  <label>Retencion Renta Venta</label>
                  <select class="form-control combo" name="c14" id="c14" style="width: 100%;">
                     <option value="0">No Liquida</option>
                     <option value="1">Si Liquida y No la Contabiliza</option>
                     <option value="2">Si Liquida y Si la Contabiliza</option>
                  </select>
               </div>
               <div class="form-group">
                  <label>Retencion CREE Ventas</label>
                  <select class="form-control combo" name="c15" id="c15" style="width: 100%;">
                     <option value="0">No Liquida</option>
                     <option value="1">Si Liquida y No la Contabiliza</option>
                     <option value="2">Si Liquida y Si la Contabiliza</option>
                     <option value="3">Autoretenedor</option>
                  </select>
               </div>
               <div class="form-group">
                  <label>Retencion IVA Compras</label>
                  <select class="form-control combo" name="c16" id="c16" style="width: 100%;">
                     <option value="0">No Liquida</option>
                     <option value="1">Si Liquida y No la Contabiliza</option>
                     <option value="2">Si Liquida y Si la Contabiliza</option>
                  </select>
               </div>
               <div class="form-group">
                  <label>Retencion IVA Ventas</label>
                  <select class="form-control combo" name="c17" id="c17" style="width: 100%;">
                     <option value="0">No Liquida</option>
                     <option value="1">Si Liquida y No la Contabiliza</option>
                     <option value="2">Si Liquida y Si la Contabiliza</option>
                  </select>
               </div>
               <div class="form-group">
                  <label>Retencion ICA Compras</label>
                  <select class="form-control combo" name="c18" id="c18" style="width: 100%;">
                     <option value="0">No Liquida</option>
                     <option value="1">Si Liquida y No la Contabiliza</option>
                     <option value="2">Si Liquida y Si la Contabiliza</option>
                  </select>
               </div>
               <div class="form-group">
                  <label>Retencion ICA Ventas</label>
                  <select class="form-control combo" name="c19"  id="c19" style="width: 100%;">
                     <option value="0">No Liquida</option>
                     <option value="1">Si Liquida y No la Contabiliza</option>
                     <option value="2">Si Liquida y Si la Contabiliza</option>
                     <option value="3">Autoretenedor</option>
                  </select>
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
