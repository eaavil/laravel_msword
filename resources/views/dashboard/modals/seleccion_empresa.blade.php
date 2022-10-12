<div class="modal fade" id="modal-selector-empresa" aria-hidden="true" style="display: none;">
   <div class="modal-dialog modal-xs">
      <div class="modal-content">
      <div class="modal-header">
         <h4 class="modal-title">Gestion de Api Key</h4>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
         </button>
      </div>
      <div class="modal-body">
         <div class="row">
            <div class="col-12">
               <div class="form-group">
                  <label>Empresas</label>
                  <span class="form-control key"> </span>
               </div>
            </div>
         </div>
      </div>
      <div class="modal-footer justify-content-between">
         <button type="button" class="btn btn-block btn-primary trigger_key" target="frmc_0001">Generar Nueva API KEY</button>
      </div>
      </div>
      <!-- /.modal-content -->
   </div>
<!-- /.modal-dialog -->
</div>

<script>
      $(document).on('click','.trigger_key',function(){
         alert()
         $.get('{{ asset("empresas/detalle") }}/'+id,function(d){
            console.log(d)
         },'json');
      });
$(function(){

})
</script>
