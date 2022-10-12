<div class="modal fade" id="modal-lge" aria-hidden="true" style="display: none;">
   <div class="modal-dialog modal-xs">
      <div class="modal-content">
      <div class="modal-header">
         <h4 class="modal-title">Editar Cuenta anco</h4>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
         </button>
      </div>
      <div class="modal-body">
         <form action="{{ route('bancos.cuenta.actualizar') }}" method="post" class="frme_0001">
         {{ csrf_field() }}
         <div class="row">
            <div class="col-12">
               <div class="form-group">
                  <label>Cuenta</label>
                  <input type="text" name="c01" maxlength="20"  autocomplete="name-in" class="form-control input-number">
               </div>
            </div>
            <div class="col-6">
               <div class="form-group">
                  <label>Cliente</label>
                  <input type="text" name="c02" autocomplete="name-in" class="form-control">
               </div>
            </div>
            <div class="col-6">
               <div class="form-group">
                  <label>Nit</label>
                  <input type="text" name="c03" autocomplete="name-in" class="form-control">
               </div>
            </div>
            <div class="col-6">
               <div class="form-group">
                 <label for="">Banco</label>
                 <select class="form-control" name="c04" id="">
                   <option value="">Seleccione</option>
                    @foreach($bancos as $rows)
                        <option value="{{ $rows->id }}">{{ $rows->entidad }}</option>
                    @endforeach
                 </select>
               </div>
            </div>
            <div class="col-6">
               <div class="form-group">
                 <label for="">Tipo de Cuenta</label>
                 <select class="form-control" name="c05" id="">
                   <option value="">Seleccione</option>
                    @foreach($tipo_cuentas as $rows)
                        <option value="{{ $rows->id }}">{{ $rows->nombre }}</option>
                    @endforeach
                 </select>
               </div>
            </div>
         </div>
         <button style="display:none" class="act_form"></button>
         <input type="hidden" name="id" />
         </form>
      </div>
      <div class="modal-footer justify-content-between">
         <button type="button" class="btn btn-block btn-primary trigger_form" target="frme_0001">Actualizar Registro</button>
      </div>
      </div>
      <!-- /.modal-content -->
   </div>
<!-- /.modal-dialog -->
</div>

<script>
    $('.input-number').on('input', function () { 
    this.value = this.value.replace(/[^0-9]/g,'');
});
</script>
