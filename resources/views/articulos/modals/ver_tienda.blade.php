<div class="modal fade" id="mv" aria-hidden="true" style="display: none;">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
		  <div class="modal-header">
			 <h4 class="modal-title">Generar reporte de Inventario</h4>
			 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">×</span>
			 </button>
		  </div>
		  <form action="{{ route('tienda.registrar') }}"  target="_blank" method="post" class="frmr_0001" method="POST" enctype="multipart/form-data">
		  
		  <div class="modal-body">
				<div class="row">
					<div class="col-6">
					   
					   
					<li ><a href="#" class="ver" num="1">Imagen (1)</a></li>
						  <input type="file" name="c01" class="form-control"  accept="image/*"  multiple>
					</div>
					<div class="col-6">
					<div ><li ><a href="#" class="ver" num="2" >Imagen (2)</a></li></div>
						  <input type="file" name="c02"  class="form-control" accept="image/*"  multiple>
					</div>
					
				</div><hr/>
                <div class="row">
					<div class="col-6">
					   <div class="form-group">
					   <li><a href="#" class="ver" num="3" >Imagen (3)</a></li>
						  <input type="file" name="c03" class="form-control" accept="image/*"  multiple>
					   </div>
					</div>
					<div class="col-6">
					   <div class="form-group">
					   <li ><a href="#" class="ver" num="4" >Imagen (4)</a></li>
						  <input type="file" name="c04"  class="form-control" accept="image/*"  multiple>
					   </div>
					</div>
					
				</div><hr/>

				<label>Agregar caracteristica</label>
                  <div class="input-group">
                        <input  type="text" Class="form-control carac">
                          <button  class="btn btn-success agregar_caracteristicas" type="button" > 
                            <span class="fa fa-plus icon"></span> 
						</button>
					
                    </div><br>
					<div class="row tabla_articulos">
                  <table id="2" width="100%"  class="origen_caracteristicas" border="1"  style="color:black;font-size:90%; text-align: center; table-layout: fixed;">
                     <thead>
                        <tr border="1"  style="background:#ccc;" >
                           <th width="90%" >Item</th>
                           <th>Acciones</th>
                        </tr>
                     </thead>
                     <tbody >
                     </tbody>
                  </table>
               </div>
					<hr/>
					<label>Agregar relacionados</label>
                  <div class="input-group">
				  <select  class="form-group combo rel">
						<option  value="" > SELECCIONE ARTICULO PARA AGREGAR </option>
						  @foreach($articulos as $rows)
                           <option value="{{ $rows->id }}">{{ $rows->nombre }}</option>
                           @endforeach
                        </select>
                          <button  class="btn btn-success agregar_relacionados" type="button" > 
                            <span class="fa fa-plus icon"></span> 
						</button>
						
                    </div><br>
				<div class="row tabla_articulos">
                  <table id="2" width="100%"  class="origen_relacionados" border="1"  style="color:black;font-size:90%; text-align: center; table-layout: fixed;">
                     <thead>
                        <tr border="1"  style="background:#ccc;" >
                           <th width="90%" >Item</th>
                           <th>Acciones</th>
                        </tr>
                     </thead>
                     <tbody >
                     </tbody>
                  </table>
               </div>
               <hr/>
			 <div>
				<div class="form-group green-border-focus">
					<label for="exampleFormControlTextarea5">Descripcion general</label>
					<textarea class="form-control descripcion" id="exampleFormControlTextarea5" rows="3" name="descripcion"></textarea>
				</div>
			 </div>
			 <div class="row ">
				<div class="col-12">
					<div class="form-group">
					<li ><a href="#" class="ver" num="video">Video</a></li>
					<input type="text" class="form-control coe video " name="video"  autocomplete="off" style="text-transform:uppercase">
					</div>
				</div>
			</div>
		  </div>
		  <input type="hidden" class='id' name="id">
		  <div class="modal-footer justify-content-between">
			 <button type="submit" class="btn btn-block btn-primary">Procesar Registro</button>
			
		  </div>
		 </form>
      </div>
      <!-- /.modal-content -->
   </div>
<!-- /.modal-dialog -->
</div>
<script>
$(document).ready(function(){

	$('.pop1').popover({
		html: true,
		trigger: 'bottom',
		placement: 'left',
		content: function () { return '<img src="{{ asset("public/tienda") }}/1-' + $(".id").val() + '.png"   class="img-fluid"/>'; }
	});

	$('.pop2').popover({
		html: true,
		trigger: 'hover',
		placement: 'right',
		content: function () { return '<img src="{{ asset("public/tienda") }}/2-' + $(".id").val() + '.png"   class="img-fluid"/>'; }
	});

	$('.pop3').popover({
		html: true,
		trigger: 'hover',
		placement: 'left',
		content: function () { return '<img src="{{ asset("public/tienda") }}/3-' + $(".id").val() + '.png"   class="img-fluid"/>'; }
	});

	$('.pop4').popover({
		html: true,
		trigger: 'hover',
		placement: 'right',
		content: function () { return '<img src="{{ asset("public/tienda") }}/4-' + $(".id").val() + '.png"   class="img-fluid"/>'; }
	});
	
	
	 $(document).on('click','.ver',function(){
		let version=Math.random();
	     let num=$(this).attr('num');
	    
	    let ruta="";
	    if(num=="video"){
	         
	         ruta=$(".video").val();
	     }else{
	         ruta="https://www.polariauto.cl/tienda/"+$(".id").val()+".jpg?"+version;
	     }
     window.open(ruta,  'popup', 'top=100, left=200, width=670, height=500, toolbar=NO, resizable=NO, Location=NO, Menubar=NO,  Titlebar=No, Status=NO');
    });
})

</script>


