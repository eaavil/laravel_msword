<div class="modal" id="modal-lg" aria-hidden="true" style="display: none;">
   <div  style="width:50%; margin: 20px auto;">
      <div class="modal-content">
		  <div class="modal-header">
			 <h4 class="modal-title" style="font-weight:bolder"><span class="titulo_salida"></span></h4>
			 <button type="button" class="close recargar" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">×</span>
			 </button>
		  </div>
		  <div class="modal-body">
				<form action="{{ route('servicio.registrar_editar') }}" method="post" class="frmc_0001" enctype="multipart/form-data">
					{{ csrf_field() }}
               
               <div class="row form-group">
               
                <h6><strong>Nombre</strong></h6>
                  <input type="text" required class="form-control c01 " name="c01" style="text-transform:uppercase">
               
               </div>
               <div class="row">
               <div class="col-2">
                     <div class="form-group">
                     <h6><strong>Codigo</strong></h6>
                        <input type="text" required class="form-control c03" name="c03"   >
                     </div>
               </div>
               <div class="col-10">
                <div class="form-group">
                <h6><strong>Categoria</strong></h6>
                     <select class=" form-group combo  instalacion articulo categoria" name='categoria' >
                        <option value="" >SELECCIONE</option>
                        @foreach($categorias as $rows)
                           <option value="{{ $rows->id }}">{{ $rows->nombre }}</option>
                        @endforeach
                     </select>
                </div>
               </div>
           
               
               <div class="row">
                   
               </div>
              	<h6 ><strong>Agregar modelo vehiculo</strong></h6>
                  <div class=" input-group">
                        <input  type="text" Class="form-control modelo_input">
                          <button  class="btn btn-success agregar_modelo" type="button" > 
                            <span class="fa fa-plus icon"></span> 
						</button>
					   <table id="2" width="100%"  class="modelo_tabla" border="1"  style="color:black;font-size:120%; text-align: center; table-layout: fixed;">
                     <thead>
                        <tr border="1"  style="background:#ccc;" >
                           <th width="90%" >Modelo</th>
                           <th>Acciones</th>
                        </tr>
                     </thead>
                     <tbody >
                     </tbody>
                  </table>
                </div> 
                <h6><br><strong>Agregar detalles</strong></h6>
                  <div class="  input-group">
                      <input  type="text" Class="form-control descripcion_input">
                          <button  class="btn btn-success agregar_descripcion" type="button" > 
                            <span class="fa fa-plus icon"></span> 
						         </button>
				 <table id="2" width="100%"  class="descripcion_tabla" border="1"  style="color:black;font-size:120%; text-align: center; table-layout: fixed;" enctype="multipart/form-data">
                     <thead>
                        <tr border="1"  style="background:#ccc;">
                           <th width="50%" >Detalle servicio</th>
                           <th width="15%">Precio</th>
                           <th>Alto</th>
                           <th>Ancho</th>
                           <th>Accion</th>
                        </tr>
                     </thead>
                     <tbody>
                     </tbody>
                  </table>
               </div>
             	<div class="row mx-2">
                  <a href="#" class="ver" num="1"><h6><br><strong>Imagen servicio</strong></h6></a>
					<input type="file" name="imagen" class="form-control"  accept="image/*"  multiple>
					
				</div><hr/>
				<input type="hidden" class="id" name="id" />
				 
				<button style="display:none" class="act_form"></button>
            </div>
			 	</form>
		  </div>
		  <div class="modal-footer justify-content-between">
			 <button type="button" class="btn btn-block btn-primary trigger_form" target="frmc_0001">Procesar Registro</button>
		  </div>
      </div>
      <!-- /.modal-content -->
   </div>
<!-- /.modal-dialog -->
</div>

<style>

</style>
<script>
 $(document).on('click','.ver',function(){
    ruta="{{asset('catalogo')}}"+'/'+$('.id').val()+".png?"+Math.random();
    window.open(ruta,'popup', 'top=100, left=200, width=453, height=240, toolbar=NO, resizable=NO, Location=NO, Menubar=NO,  Titlebar=No, Status=NO');
});

</script>