<div id="m-ingreso" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
   <div class="modal-dialog" role="document">
       <div class="modal-content">
           <div class="modal-header">
               <h5 class="modal-title" id="my-modal-title">Registro de Ingreso</h5>
               <button class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
               </button>
           </div>
           <div class="modal-body">
               <form class="frm-ri" method="post" action="{{ route('ingreso_egreso.registro') }}">
               <div class="row">
                   <div class="col-4">
                       <label>Numero:</label>
                       <input class="form-control n_i" readonly type="text" name="c01">
                   </div>
                   <div class="col-4">
                       <div class="form-group">
                           <label>Fecha Operacion:</label>
                           <input type="date" class="form-control" name="c02" id="">
                       </div>
                   </div>
                   <div class="col-4">
                       <div class="form-group">
                           <label for="my-select">Forma de Pago:</label>
                           <select id="my-select" class="custom-select" name="c03">
                               <option>EFECTIVO</option>
                               <option>CHEQUE</option>
                               <option>TRANSFERENCIA</option>
                               <option>RECIBO</option>
                           </select>
                       </div>
                   </div>
               </div>
               <div class="row">
                   <div class="col-12">
                       <div class="form-group">
                           <label >Tercero:</label>
                           <select class="custom-select terceros combo" name="c04">
                           </select>
                       </div>
                   </div>
               </div>
               <div class="row">
                   <div class="col-12">
                       <div class="form-group">
                           <label >Cuentas Bancarias:</label>
                           <select class="custom-select cuentas combo" name="c05">
                           </select>
                       </div>
                   </div>
               </div>
               <div class="row">
                   <div class="col-6">
                       <label>Producto o Servicio:</label>
                       <input class="form-control" type="text" name="c06">
                   </div>
                   <div class="col-6">
                       <label>Numero Factura / Remision:</label>
                       <input class="form-control" type="text" name="c07">
                   </div>
               </div>
               <div class="row">
                   <div class="col-12">
                       <label>Total a Cobrar:</label>
                       <input class="form-control numero_entero" type="text" requered name="c08" >
                   </div>
               </div>
               <input type="hidden" name="modo" value="1">
               <div class="alert alert-danger my-3 e-i" style="display:none" role="alert">
               </div>
               <div class="row pt-2">
                   <div class="col-12">
                       <button class="btn btn-block btn-primary">Procesar Registro</button>
                   </div>
               </div>
               {{ csrf_field() }}
               </form>
           </div>
       </div>
   </div>
</div>