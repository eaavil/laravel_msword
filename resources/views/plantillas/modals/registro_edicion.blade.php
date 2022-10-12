<div class="modal fade" id="modal-lg" aria-hidden="true" style="display: none;">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Registrar plantilla</h4>
            <button type="button" enctype="multipart/form-data" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
         </div>
         <div class="modal-body container-fluid">
            <form method="POST" action="{{route('registrar_editar.plantilla')}}" accept-charset="UTF-8" enctype="multipart/form-data">
               {{ csrf_field() }}
               <div class="row">
                  <div class="col-6">
                     <label for="archivo"><h4>Archivo: </h4></label><br>
                     <input  type="file" class="form-control archivo"  name="archivo" required value ='' selected="false"> <br>
                     <a href="/storage/dQp3QQBzy4DgZjAyd9ylXj4puGe57wbL3EQ00SJC.docx" alt="image"> <h5>descargar</h5></a>
                  </div>
                  <div class="col-6">
                     <label for="archivo"><h4>Nombre: </h4></label>
                     <input type="text" name="nombre" class="form-control" value=" ">
                  </div>
                 
               </div>
                  <hr>
                  <div class="row col-12">
                     <input class="btn btn-block btn-primary" type="submit" value="Enviar" >
                     <input type="hidden" class="id" value="">
                  </div>
            </form>
         </div>
      </div>
   </div>
</div>