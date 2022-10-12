<div class="modal fade" id="modal-lg" aria-hidden="true" style="display: none;">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
      <div class="modal-header">
         <h4 class="modal-title">Registrar articulos o insumos</h4>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
         </button>
      </div>
      <div class="modal-body">
      <form action="{{ route('registrar_editar.articulo') }}" method="post" class="frmc_0001">
			{{ csrf_field() }}
         <div class="row">
            <div class="col-6">
                <div class="form-group">
                  <label for="">Nombre Tienda</label>
                  <input type="text" class="form-control nombre" style="text-transform:uppercase" name="nombre"  aria-describedby="helpId" autocomplete="off">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                  <label for="">Nombre Interno</label>
                  <input type="text" class="form-control nombre_interno" style="text-transform:uppercase" name="nombre_interno"  aria-describedby="helpId" autocomplete="off">
                </div>
            </div>
         </div>
         <div class="row ">
            <div class="col-6">
                <div class="form-group">
                  <label for="">Modelo</label>
                  <input type="text" class="form-control modelo" name="modelo" autocomplete="off" style="text-transform:uppercase" readonly>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                  <label for="">Cantidad</label>
                  <input type="text" class="form-control cantidad numero_entero" name="cantidad"  readonly autocomplete="off">
                </div>
            </div>
            
           
             
         </div>
         <div class="row">
         <div class="col-4">
                <div class="form-group">
                  <label for="">Valor Venta</label>
                  <input type="text" class="form-control valor_venta numero_entero" name="valor_venta"  aria-describedby="helpId" autocomplete="off">
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                  <label for="">Valor Compra</label>
                  <input type="text" class="form-control valor_compra numero_entero valor_compra" name="valor_compra"  aria-describedby="helpId" autocomplete="off">
                </div>
            </div>
            <div class="col-4" >
                  <label >Categoria</label>
                     <select class=" form-group combo  instalacion articulo categoria" name='categoria' >
                        <option value="" >SELECCIONE</option>
                        @foreach($categorias as $rows)
                        <option value="{{ $rows->id }}">{{ $rows->nombre}}</option>
                        @endforeach
                     </select>
                  
            </div>
         </div>
        
         <input type="hidden" class="id" name="id" value="0"/>
            <input type="hidden"  name="es_movil" value="0"/>
            <input type="hidden" class="es_escritorio" name="es_escritorio" value="1"/>
				<button style="display:none" class="act_form"></button>
         </form>
      </div>
      <div class="modal-footer justify-content-between">
      <button type="button" class="btn btn-block btn-primary trigger_form" target="frmc_0001">Procesar Registro</button>      </div>
      </div>
      <!-- /.modal-content -->
   </div>
<!-- /.modal-dialog -->
</div>
