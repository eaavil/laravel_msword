<div class="modal fade" id="modal-lge" aria-hidden="true" style="display: none;">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
      <div class="modal-header">
         <h4 class="modal-title">Editar articulo</h4>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
         </button>
      </div>
      <div class="modal-body">
      <form action="{{ route('articulo.actualizar') }}" method="post" class="frm_0001">
         {{ csrf_field() }}
         
         <div class="row">
         
            <div class="col-12">
                <div class="form-group">
                  <label for="">Nombre</label>
                  <input type="text" class="form-control e01" name="e01"  aria-describedby="helpId" autocomplete="off">
                </div>
            </div>
            </div>
            <div class="row ">
            <div class="col-4">
                <div class="form-group">
                  <label for="">Modelo</label>
                  <input type="text" class="form-control coe " name="codigo"  autocomplete="off" style="text-transform:uppercase">
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                  <label for="">Cantidad</label>
                  <input type="text" class="form-control cae numero_entero " name="cantidad" autocomplete="off" >
                </div>
            </div>
           
            <div class="col-4">
                <div class="form-group">
                  <label for="">Unidad de medida</label>
                    <select class=" form-group combo  instalacion articulo unidad_e" name='unidad_e' >
                        <option value="" >SELECCIONE</option>
                        <option value="METROS">METROS</option>
                        <option value="UNIDADES">UNIDADES</option>
                       
                     </select>
                </div>
            </div>
         </div>
         <div class="row">
           <div class="col-4">
                <div class="form-group">
                  <label for="">Valor venta</label>
                  <input type="text" class="form-control e02 numero_entero " name="e02" step="0.01" aria-describedby="helpId" autocomplete="off">
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                  <label for="">Valor compra</label>
                  <input type="text" class="form-control e02 numero_entero valor_compra_e " name="valor_compra_e" step="0.01" aria-describedby="helpId" autocomplete="off">
                </div>
            </div>
            <div class="col-4" >
                  <label >Categoria</label>
                     <select class=" form-group combo  instalacion articulo categoria_e" name='categoria_e' >
                        <option value="" >SELECCIONE</option>
                        @foreach($categorias as $rows)
                        <option value="{{ $rows->id }}">{{ $rows->id }}</option>
                        @endforeach
                     </select>
                  
            </div>
         </div>
         <input type="hidden" class="id" name="id" >
         
         <button style="display:none" class="act_form"></button>
         </form>
      </div>
      <div class="modal-footer justify-content-between">
         <button type="button" class="btn btn-block btn-primary modal_editar " data-dismiss="modal" target="frm_0001">Procesar Registro</button>
      </div>
      </div>
      <!-- /.modal-content -->
   </div>
<!-- /.modal-dialog -->
</div>
