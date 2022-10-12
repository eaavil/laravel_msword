<div class="modal" id="modal-lgc" aria-hidden="true" style="display: none;">
   <div  style="width:40%; margin: 80px auto;">
      <div class="modal-content">
		  <div class="modal-header">
			 <h4 class="modal-title-comentario">Ingresar Comentario<span class="titulo_salida"></span></h4>
			 <button type="button" class="" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">×</span>
			 </button>
		  </div>
		  <div class="modal-body">
				<form action="{{ route('contrato.registrar') }}" method="post" class="frmc_0001">
					{{ csrf_field() }}
					
						<div class="form-group " contenteditable="true">
						     <textarea    rows="10"  width='100%' class=" form-control comentario_text" name="descripcion" autocomplete="off" value="" style=" text-align: justify; white-space: pre-line; -moz-text-align-last: left;text-align-last: left;"></textarea>
						</div>
				   <input type="hidden" class="id_comentario" name="id_comentario" />
       
			 	</form>
		  </div>
		  <div class="modal-footer justify-content-between">
			 <button type="button" class="btn btn-block btn-primary trigger_form_comentario" >Guardar comentario</button>
		  </div>
      </div>
      <!-- /.modal-content -->
   </div>
<!-- /.modal-dialog -->
</div>
