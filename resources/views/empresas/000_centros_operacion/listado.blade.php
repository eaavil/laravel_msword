@extends('template.main')

@section('contenedor_principal')



<div class="col-12">
    <div class="card">
            <!-- /.card-header -->
            <div class="card-body">

                <button class="btn btn-info" data-toggle="modal" data-target="#modal-lg"><i class="fa fa-plus"></i> Nuevo Centro de Operacion</button>

              <table id="main" class=" table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Codigo</th>
                  <th>Razon Social</th>
                  <th>Nit</th>
                  <th>Ciudad</th>
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
    @include('empresas.000_centros_operacion.modals.edicion')
    @include('empresas.000_centros_operacion.modals.registro')

@stop

@section('scripts-bottom')
    <script>
        var tabla=$('#main').DataTable({
			       serverSide:true,
                   paging: true,
			       pageLength: 20,
                    ajax: {
                        url:'{{ asset("empresas/centros_operacion/listado/data") }}',
                        dataSrc: 'data',
                        type:'post',
                    },
                    columns:[
                                 {
					                 "data":'codigo_empresa',name:'codigo_empresa'
				                 },
                                 {
                                    "data": 'razon_social',name:'razon_social'
					               
                                 },
                                 {
                                    "data": 'nit',name:'nit'
                                 },
                                 {
                                    "data": null,name:'000_poblaciones.nombre_ciudad',
					                "render": function (data) {
                                         return data.nombre_ciudad+", "+data.departamento;
                                    }     
                                 },
                                 {
                                    data:'created_at',name:'created_at',
					                "render": function (data) {
                                         return  data.substring(8,10)+'/'+data.substring(5,7)+'/'+data.substring(0,4)+' '+ data.substr(-8);
                                    }
                                 },
                                 {
                                    "data": 'updated_at',name:'updated_at',
					                 "render": function (data) {
                                         return  data.substring(8,10)+'/'+data.substring(5,7)+'/'+data.substring(0,4)+' '+ data.substr(-8);
                                    }
                                 },
                                 {
                                    "data":null,name:'id',
					                 "render": function (data) {
                                         return  '<button style="width: 32px; padding: 3px 5px !important;" data-toggle="modal" data-target="#modal-lge" data-id='+data.id+'" class="btn btn-info edit"><i class="fa fa-pencil-alt"></i></button>'+' '+
                                         '<button style="width: 32px; padding: 3px 5px !important;" class="btn btn-danger delete" data-id="'+data.id+'"><i class="fa fa-trash"></i></button>'
                                    }
                                 }
                                 
                    ],
                   dom: 'Bfrtip',
                   language: langDataTable,
                   buttons: [
                     {
                     extend: 'copy',
                     text: '<i class="far fa-copy"></i> Copiar',
                     exportOptions: {
                     columns: [ 0,1,2,3,4],
                     modifier: {
                         page: 'current'
                        }
                     }
                    },
                    {
                        extend: 'excel',
                        text: '<i class="fas fa-file-excel"></i> Excel',
                        exportOptions: {
                            columns: [ 0,1,2,3,4],
                            modifier: {
                                page: 'current'
                            }
                        }
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="fas fa-file-pdf"></i> Pdf',
                        orientation: 'landscape',
                        footer: true,
                        exportOptions: {
                            columns: [ 0,1,2,3,4],
                            modifier: {
                                page: 'current'
                            }
                        }
                    },
                    {
                        extend: 'print',
                        text: '<i class="fas fa-print"></i> Imprimir',
                        exportOptions: {
                            columns: [ 0,1,2,3,4],
                            modifier: {
                                page: 'current'
                            }
                        }
                    }
                    ] 
        });

        $(document).on('click',".delete",function(){
            var id= $(this).attr('data-id');
            if(@json($session)==1){
                if(confirm('Estas Seguro de Eliminar el Registro Seleccionado?')){
                    window.location='{{ asset("empresas/centros_operacion/eliminar") }}/'+id;
                }
            }else{
                alert('No tiene permisos para realizar esta accion');
            }
        });

        $(document).on('click',".edit",function(){
            var id= $(this).attr('data-id');

            $.get('{{ asset("empresas/centros_operacion/detalle") }}/'+id,function(d){
                $(".frme input[name='c02']").val(d.codigo);
                $(".frme input[name='c03']").val(d.descripcion);
                $(".frme input[name='c04']").val(d.direccion1);
                $(".frme input[name='c05']").val(d.direccion2);
                $(".frme input[name='c06']").val(d.direccion3);
                $(".frme select[name='c07']").val(d.id_poblacion).trigger('change');
                $(".frme input[name='c08']").val(d.telefono);
                $(".frme input[name='c09']").val(d.fax);
                $(".frme input[name='id']").val(d.id);
            },'json');
        });

        $(function() {
            $('.combo').select2({  theme: 'bootstrap4' })
	    });
    </script>
@stop
