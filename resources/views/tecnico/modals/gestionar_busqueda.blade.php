<div class="modal" id="modal-lgb" aria-hidden="true" style="display: none;">
<div  style="width:100%; margin: 80px auto;">
      <div class="modal-content">
	  <div class="modal-header">
		  <h4 class="titulo-imagen">BUSCAR OT POR:</h4>
			 <button type="button" class="" data-dismiss="modal" aria-label="Close" style="float:right">
				<span aria-hidden="true">×</span>
				
			 </button>
        </div>
         <div class="modal-body body-registro">
            <form action="{{ route('contrato.registrar') }}" method="post" class="frmc_0001">
              
             
			   <div class="mb-1">
				  		<input type="text" list="clientes" class="texto cliente buscar_ot" name="cliente" placeholder="CLIENTE" autocomplete="off" style="text-transform:uppercase">
				</div>
			    @if($id_usuario==1)
				<div class="mb-1 ">
				    <input type="text" list="empleados" class="texto empleado buscar_ot" name="empleados" placeholder="TECNICO" autocomplete="off" style="text-transform:uppercase">

			    </div>
			    @endif
				<div class="mb-1 ">
				    <input type="text" list="ordenes" class="texto orden buscar_ot" name="empleados" placeholder="ORDEN" autocomplete="off" style="text-transform:uppercase">

			    </div>
				  <div class="input-group  mb-1">
					<span class="input-group-addon texto col-6">FECHA INICIO</span>
					<input type="date" name="fecha_ot "   class="form-control texto_date buscar_ot fecha_inicio" seleccion="1">
				  </div>
				  <div class="input-group  mb-1">
					<span class="input-group-addon texto col-6">FECHA FIN</span>
					<input type="date" name="fecha_ot "  class="form-control texto_date buscar_ot fecha_fin" seleccion="1">
				  </div>
				  <div class="input-group mb-1 " style="display:none">
					<select class="cliente texto busqueda_tabla buscar_ot estado" name="cliente" seleccion="1">
							<option value="">SELECCIONE ESTADO</option>
							<option value="pendiente">PENDIENTE</option>
							<option value="ejecutada">EJECUTADA</option>
						
					</select>
			         </div>
               <button style="display:none" class="act_form"></button>
            </form>
         </div>
       
      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>
<style>

.body-registro{
  overflow-y: auto;
}
</style>