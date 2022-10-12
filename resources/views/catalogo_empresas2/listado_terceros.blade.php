@extends('template.main')

@section('contenedor_principal')



<div class="col-12">
    <div class="card">
            <!-- /.card-header -->
            <div class="card-body">

                <button class="btn btn-info" data-toggle="modal" data-target="#modal-lg"><i class="fa fa-plus"></i> Agregar {{ $tipo_etiqueta }}</button>

              <table class="tableData table table-bordered table-striped">
                <thead>
                <tr>
                  <th with="20%">Razon Social</th>
                  <th>Nit</th>
                  <th>Ciudad</th>
                  <th>Creado</th>
                  <th>Actualizado</th>
                  <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($registros as $data)
                        <tr>
                            <td>{{ $data->nombre }}</td>
                            <td>{{ $data->nit }}-{{ $data->digito_verificacion_nit }}</td>
                            <td>{{ $data->poblacion[0]->nombre_ciudad }}, {{ $data->poblacion[0]->departamento }} </td>
                            <td>{{ ($data->created_at!=null)?date('d/m/Y h:i:s a',strtotime($data->created_at)):'' }}</td>
                            <td>{{ ($data->updated_at!=null)?date('d/m/Y h:i:s a',strtotime($data->updated_at)):'' }}</td>
                            <td>
                                <button style="width: 32px; padding: 3px 5px !important;" data-toggle="modal" data-target="#modal-lge" data-id="{{ $data->id }}" class="btn btn-info edit"><i class="fa fa-pencil-alt"></i></button>
                                <button style="width: 32px; padding: 3px 5px !important;" data-id="{{ $data->id }}" class="btn btn-danger delete"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
            </div>
          <!-- /.card -->
    </div>
    @if(\App\Http\Controllers\AuthController::checkAccessModule('catalogo.registrar.terceros',session('role_id')))
        @include('catalogo_empresas.000_catalogo_empresas.modals.registro')
    @endif
    @if(\App\Http\Controllers\AuthController::checkAccessModule('catalogo.actualizar.terceros',session('role_id')))
        @include('catalogo_empresas.000_catalogo_empresas.modals.edicion')
    @endif
@stop

@section('scripts-bottom')
    <script>


        $('.edit').click(function(){
            var id= $(this).attr('data-id');

            $.get('{{ asset("catalogo/detalle") }}/'+id,function(d){

                $(".frme_0001 input[name='c01']").val(d.nombre);
                $(".frme_0001 input[name='c02']").val(d.nit);
                $(".frme_0001 input[name='c03']").val(d.digito_verificacion_nit);
                $(".frme_0001 input[name='c04']").val(d.direccion);
                $(".frme_0001 select[name='c05']").val(d.id_poblacion).trigger('change');
                $(".frme_0001 input[name='c06']").val(d.numero_telefono_1);
                $(".frme_0001 input[name='c07']").val(d.email_empresa);
				if(d.es_cliente==1){
					$(".frme_0001 input[name='c08']").prop('checked',true);
				}
				if(d.es_proveedor==1){
					$(".frme_0001 input[name='c09']").prop('checked',true);
				}
				if(d.es_facturador==1){
					$(".frme_0001 input[name='c10']").prop('checked',true);
				}
                $(".frme_0001 input[name='id']").val(d.id);
            },'json');
        });


        $('.delete').click(function(){
            if(confirm('Estas seguro que deseas eleminar el registro seleccionado?')){
                var id= $(this).attr('data-id');
                window.location='{{ asset("catalogo/eliminar") }}/'+id;
            }
        });

        $(function() {
            $('.combo').select2({  theme: 'bootstrap4' })
	    });
    </script>
@stop
