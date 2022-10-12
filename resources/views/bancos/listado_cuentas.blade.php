@extends('template.main')

@section('contenedor_principal')



<div class="col-12">
    <div class="card">
            <!-- /.card-header -->
            <div class="card-body">

                <button class="btn btn-info" data-toggle="modal" data-target="#modal-lg"><i class="fa fa-plus"></i> Nuevo Banco</button>

              <table id="main" class=" table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Codigo</th>
                  <th with="20%">Entidad</th>
                  <th with="20%">Tipo Cuenta</th>
                  <th with="20%">Cuenta</th>
                  <th with="20%">Cliente</th>
                  <th with="20%">Nit</th>
                  <th>Creado</th>
                  <th>Actualizado</th>
                  <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
            </div>
          <!-- /.card -->
    </div>
    @if(\App\Http\Controllers\AuthController::checkAccessModule('bancos.registrar',session('role_id')))
        @include('bancos.modals.registro_cuenta')
    @endif
    @if(\App\Http\Controllers\AuthController::checkAccessModule('bancos.actualizar',session('role_id')))
        @include('bancos.modals.edicion_cuenta')
    @endif
@stop

@section('scripts-bottom')
<script>
   $(document).ready(function(){
        $(document).on('click',".edit",function (evt) {
            var id= $(this).attr('data-id');
            $.get('{{ asset("bancos/cuentas/detalle") }}/'+id,function(d){
                $(".frme_0001 input[name='c01']").val(d.cuenta);
                $(".frme_0001 input[name='c02']").val(d.cliente);
                $(".frme_0001 input[name='c03']").val(d.documento_cliente);
                $(".frme_0001 select[name='c04']").val(d.id_banco);
                $(".frme_0001 select[name='c05']").val(d.id_tipo_cuenta);
                $(".frme_0001 input[name='id']").val(d.id);
            },'json');
        });
        $(document).on('click',".delete",function (evt) {
            if(@json($session)==1){
                if(confirm('Estas seguro que deseas eleminar el registro seleccionado?')){
                    var id= $(this).attr('data-id');
                    window.location='{{ asset("bancos/cuentas/eliminar") }}/'+id;
                }
            }else{
                alert('No tiene permisos para realizar esta accion'); 
            }
        });

        $(function() {
            $('.combo').select2({  theme: 'bootstrap4' })
        });
       // $.fn.dataTable.ext.errMode = 'throw';omitir el error
        var tabla=$('#main').DataTable({
			      serverSide:true,
                  paging: true,
			      pageLength: 20,
                    ajax: {
                        url:'{{ asset("bancos/cuentas/listado/data") }}',
                        dataSrc: 'data',
                        type:'post',              
                    },
                    columns:[
                                 {
					                 "data": null,name:'id',
					                 "render": function (data) {
                                         //return  '<td>{{str_pad('+data.id+',4,'+0+',STR_PAD_LEFT)}}</td>';
                                         return ('000' + data.id).slice(-4);
						             }
				                 },
                                 {
                                    "data": null,name:'000_bancos.entidad',
					                "render": function (data) {
                                         return  data.entidad;
                                    }
                                 },
                                 {data:'nombre',name:'000_tipos_cuentas.nombre'},
                                 {data:'cuenta',name:'cuenta'},
                                 {data:'cliente',name:'cliente'},
                                 {data:'documento_cliente',name:'documento_cliente'},
                                 {
                                    "data": null,name:'created_at',
					                "render": function (data) {
                                         return  data.created_at.substring(8,10)+'/'+data.created_at.substring(5,7)+'/'+data.created_at.substring(0,4)+' '+ data.created_at.substr(-8);
                                    }
                                 },
                                 {
                                    "data": null,name:'updated_at',
					                 "render": function (data) {
                                         return  data.updated_at.substring(8,10)+'/'+data.updated_at.substring(5,7)+'/'+data.updated_at.substring(0,4)+' '+ data.updated_at.substr(-8);
                                    }
                                 },
                                 {
                                    "data": null,name:'id',
					                 "render": function (data) {
                                         return  '<button style="width: 32px; padding: 3px 5px !important;" data-toggle="modal" data-target="#modal-lge" data-id='+data.id+'" class="btn btn-info edit"><i class="fa fa-pencil-alt"></i></button>'+' '+
                                         '<button style="width: 32px; padding: 3px 5px !important;" class="btn btn-danger delete" data-id="'+data.id+'"><i class="fa fa-trash"></i></button>'
                                    }
                                 }
                                 
                   ],
                   language: langDataTable,
                   
        });
    }) 
</script>
@stop
