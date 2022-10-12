@extends('template.main')

@section('contenedor_principal')



<div class="col-12">
    <div class="card">
            <!-- /.card-header -->
            <div class="card-body">

                <button class="btn btn-info" data-toggle="modal" data-target="#modal-lg"><i class="fa fa-plus"></i> Nuevo Banco</button>

              <table class="tableData table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Ciudad</th>
                  <th>Departamento</th>
                  <th>Creado</th>
                  <th>Actualizado</th>
                  <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($registros as $data)
                        <tr>
                            <td>{{ $data->nombre_ciudad }}</td>
                            <td>{{ $data->departamento }}</td>
                            <td>{{ ($data->created_at!=null)?date('d/m/Y h:i:s a',strtotime($data->created_at)):'' }}</td>
                            <td>{{ ($data->updated_at!=null)?date('d/m/Y h:i:s a',strtotime($data->updated_at)):'' }}</td>
                            <td>
                                <button style="width: 32px; padding: 3px 5px !important;" data-toggle="modal" data-target="#modal-lge" data-id="{{ $data->id }}" class="btn btn-info edit"><i class="fa fa-pencil-alt"></i></button>
                                <button style="width: 32px; padding: 3px 5px !important;" class="btn btn-danger @if(\App\Http\Controllers\AuthController::checkAccessModule('bancos.eliminar',session('role_id'))) delete @endif" data-id="{{ $data->id }}"><i class="fa fa-trash"></i></button>
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
        @include('ciudades.modals.registro')
        @include('ciudades.modals.edicion')
@stop

@section('scripts-bottom')
    <script>


        $('.edit').click(function(){
            var id= $(this).attr('data-id');

            $.get('{{ asset("bancos/detalle") }}/'+id,function(d){
                $(".frme_0001 input[name='c02']").val(d.entidad);
                $(".frme_0001 input[name='id']").val(d.id);
            },'json');
        });


        $('.delete').click(function(){
            if(confirm('Estas seguro que deseas eleminar el registro seleccionado?')){
                var id= $(this).attr('data-id');
                window.location='{{ asset("bancos/eliminar") }}/'+id;
            }
        });

        $(function() {
            $('.combo').select2({  theme: 'bootstrap4' })
	    });
    </script>
@stop
