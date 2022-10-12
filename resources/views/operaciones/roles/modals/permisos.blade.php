<div class="modal fade" id="modal-lgexx" aria-hidden="true" style="display: none;">
   <div class="modal-dialog modal-xs">
      <div class="modal-content">
      <div class="modal-header">
         <h4 class="modal-title">Permisos del Rol: <span class="titt"></span></h4>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
         </button>
      </div>
      <div class="modal-body">
         <form action="{{ route('dashboard.permissions.update') }}" method="post" class="frmp_0001">
         {{ csrf_field() }}
         <div class="row">
            <div class="col-12">
               <ul style="padding:0">
                  <li class="list-group-item" style="background: #007eff; color: white; font-size: 16px; font-weight: bold;"> 
                     <div class="row"> 
                           <div class="col-8">Modulos del Sistema</div> 
                           <div class="col-1"><i class="fas fa-eye" title="Consulta"></i></div> 
                           <div class="col-1"><i class="fa fa-plus" title="Registro"></i></div> 
                           <div class="col-1"><i class="fas fa-pencil-alt" title="Edicion"></i></div> 
                           <div class="col-1"><i class="fa fa-trash" title="Borrado"></i></div> 
                     </div> 
                  </li>
                  <span class="permisos"></span>
               </ul>
            </div>
         </div>
         <button style="display:none" class="act_form"></button>
         <input type="hidden" name="id" />
         </form>
      </div>
      <div class="modal-footer justify-content-between">
         <button type="button" class="btn btn-block btn-primary trigger_form" target="frmp_0001">Actualizar Registro</button>
      </div>
      </div>
      <!-- /.modal-content -->

   </div>
<!-- /.modal-dialog -->
</div>