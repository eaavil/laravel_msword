@extends('template.main')

@section('contenedor_principal')



<div class="col-12">
    <div class="card">
            <!-- /.card-header -->
            <div class="card-body">

              <button class="btn btn-info" data-toggle="modal" data-target="#modal-lg"><i class="fa fa-plus"></i> Nueva Empresa</button>

              <table id='main' class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Codigo</th>
                  <th with="20%">Razon Social</th>
                  <th width="15%">Nit</th>
                  <th width="15%">Ciudad</th>
                  <th>Creado</th>
                  <th>Actualizado</th>
                  <th width="15%">Acciones</th>
                </tr>
                </thead>
                <tbody ><!--
                    @foreach($registros as $data)
                        <tr>
                            <td>{{ str_pad($data->id,5,'0',STR_PAD_LEFT) }}</td>
                            <td>{{ $data->razon_social }}</td>
                            <td>{{ $data->nit }}-{{ $data->digito_verificacion }}</td>
                            <td>{{ $data->poblacion[0]->nombre_ciudad }}, {{ $data->poblacion[0]->departamento }} </td>
                            <td>{{ ($data->created_at!=null)?date('d/m/Y h:i:s a',strtotime($data->created_at)):'' }}</td>
                            <td>{{ ($data->updated_at!=null)?date('d/m/Y h:i:s a',strtotime($data->updated_at)):'' }}</td>
                            <td>
                                <button style="width: 32px; padding: 3px 5px !important;" data-toggle="modal" data-target="#modal-lge" data-id="{{ $data->id }}" class="btn btn-info edit"><i class="fa fa-pencil-alt"></i></button>
                                <button style="width: 32px; padding: 3px 5px !important;" class="btn btn-danger delete" data-id="{{ $data->id }}"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                    @endforeach-->
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
            </div>
          <!-- /.card -->
    </div>
    @if(\App\Http\Controllers\AuthController::checkAccessModule('empresas.registrar',session('role_id')))
        @include('empresas.000_empresas.modals.registro')
    @endif
    @if(\App\Http\Controllers\AuthController::checkAccessModule('empresas.actualizar',session('role_id')))
        @include('empresas.000_empresas.modals.edicion')
    @endif
@stop

@section('scripts-bottom')
    <script>

        var tabla=$('#main').DataTable({
			       serverSide:true,
                   paging: true,
			       pageLength: 20,
                    ajax: {
                        url:'{{ asset("empresas/listado/data") }}',
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
                    window.location='{{ asset("empresas/eliminar") }}/'+id;
                }
            }else{
                alert('No tiene permisos para realizar esta accion');
            }
        });

        $(document).on('click',".edit",function(){
            var id= $(this).attr('data-id');
           
            $.get('{{ asset("empresas/detalle") }}/'+id,function(d){

                console.log(d)

                $(".frme_0001 input[name='c01']").val(d.codigo_empresa);
                $(".frme_0001 input[name='c02']").val(d.razon_social);
                $(".frme_0001 input[name='c03']").val(d.nit);
                $(".frme_0001 input[name='c04']").val(d.digito_verificacion);
                $(".frme_0001 input[name='c05']").val(d.direccion1);
                $(".frme_0001 input[name='c06']").val(d.direccion2);
                $(".frme_0001 input[name='c07']").val(d.direccion3);
                $(".frme_0001 select[name='c08']").val(d.id_poblacion).trigger('change');
                $(".frme_0001 input[name='c09']").val(d.telefono1);
                $(".frme_0001 input[name='c10']").val(d.telefono2);
                $(".frme_0001 input[name='c11']").val(d.correo_electronico);
                $(".frme_0001 select[name='c12']").val(d.gran_contribuyente).trigger('change');
                $(".frme_0001 select[name='c13']").val(d.retencion_renta_compras).trigger('change');
                $(".frme_0001 select[name='c14']").val(d.retencion_renta_ventas).trigger('change');
                $(".frme_0001 select[name='c15']").val(d.retencion_cree_ventas).trigger('change');
                $(".frme_0001 select[name='c16']").val(d.retencion_iva_compras).trigger('change');
                $(".frme_0001 select[name='c17']").val(d.retencion_iva_ventas).trigger('change');
                $(".frme_0001 select[name='c18']").val(d.retencion_ica_compras).trigger('change');
                $(".frme_0001 select[name='c19']").val(d.retencion_ica_ventas).trigger('change');
                $(".frme_0001 input[name='id']").val(d.id);
            },'json');
        });

        $(function() {
            $('.combo').select2({  theme: 'bootstrap4' })
	    });
    </script>
@stop
