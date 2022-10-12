<div class="modal fade" id="modal-lge" aria-hidden="true" style="display: none;">
   <div class="modal-dialog modal-xl">
      <div class="modal-content">
      <div class="modal-header">
         <h4 class="modal-title">Ver Liquidaciones</h4>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
         </button>
      </div>
      <div class="modal-body">
         <form action="{{ route('liquidaciones.entradas.registrar') }}" method="post" class="frm_0001">
         {{ csrf_field() }}
         <h5>Informacion de la Entrada</h5>
         <div class="contenidox">

         </div>
         <h5>Liquidaciones Registradas</h5>
		  <table id="mainxc" class="table table-bordered table-striped" width="100%">
			<thead>
			<tr>
			  <th>Numero</th>
			  <th>Fecha</th>
			  <th>Kgs</th>
			  <th>Factor</th>
			  <th>Descuento</th>
			  <th>Factor Descuento</th>
			  <th>Valor Arroba</th>
			  <th>Valor Bruto</th>
			  <th>Valor Descuento</th>
			  <th>% Reten.</th>
			  <th>% Reten. Fuente</th>
			  <th>% Reten. 4 x 1000</th>
			  <th>% Reten. Cooperativa</th>
			  <th>% Reten. Tercero</th>
			  <th>Total</th>
			  <th>Acciones</th>
			</tr>
			</thead>
			<tbody>
				

			</tbody>
		  </table>
      </div>
      </div>
      <!-- /.modal-content -->
   </div>
<!-- /.modal-dialog -->
</div>
