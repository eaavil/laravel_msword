<div class="modal fade" id="modal-lg" aria-hidden="true" style="display: none;">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Registrar persona</h4>
            <button type="button" enctype="multipart/form-data" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
         </div>
         <div class="modal-body container-fluid">
         <form method="POST" action="{{route('registrar_editar.empresa')}}" accept-charset="UTF-8" enctype="multipart/form-data">
  {{ csrf_field() }}
  <label for="archivo"><b>Archivo: </b></label><br>
  <input type="file" name="archivo" required>

  <a href="/storage/dQp3QQBzy4DgZjAyd9ylXj4puGe57wbL3EQ00SJC.docx" alt="image">descargar</a>
  <input class="btn btn-success" type="submit" value="Enviar" >
</form>
         </div>
         
         <div class="modal-footer justify-content-between">
            <span class="btn btn-block btn-primary trigger_formx" target="frm_0001">Guardar persona</span>
         </div>
      </div>
   </div>
</div>