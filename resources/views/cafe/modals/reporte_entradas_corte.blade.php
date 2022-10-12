<div class="modal fade" id="modal-2" aria-hidden="true" style="display: none;">
   <div class="modal-dialog modal-xs">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Generar Reporte de entradas/salidas cafe</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
         </div>
         <div class="modal-body">
            <form action=" {{route ('entradas_salidas.corte')}}"  target="_blank" method="post" class="frmr_0001">
               <?php csrf_field() ?> 
               <div class="row">
                  <div class="col-6">
                     <div class="form-group">
                        <label>Fecha Inicial Inicial</label>
                        <input type="date" name="c01" required autocomplete="c01"  min="1" max="50000" class="form-control">
                     </div>
                  </div>
                  <div class="col-6">
                     <div class="form-group">
                        <label>Fecha Final</label>
                        <input type="date" name="c02" required autocomplete="c01"  min="1" max="50000" class="form-control">
                     </div>
                  </div>
                  <br>
               </div>
               <div class="row">
                  <div class="col-6">
                     <label >Tipo de Reporte:</label>
                     <select class="form-control combo" required name="c04"  style="width: 100%;">
                        <option value="1">Todos</option>
                        <option value="2">Sin COFFEEWORLD</option>
                     </select>
                  </div>
               </div><br>
               <div class="row">
                  <div class="col-6">
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