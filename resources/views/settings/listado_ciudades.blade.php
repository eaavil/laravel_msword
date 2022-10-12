@extends('template.main')

@section('contenedor_principal')

<div class="col-12">
    <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
                <button class="btn btn-info" data-toggle="modal" data-target="#modal-lg"><i class="fa fa-plus"></i> Nueva Ciudad</button>

              <table class="tableData table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Ciudad</th>
                  <th>Departamento</th>
                  <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($settings as $data)
                        <tr>
                            <td>{{ $data->nombre_ciudad }}</td>
                            <td>{{ $data->departamentos->departamento }}</td>
                            <td>
                                <button style="width: 32px; padding: 3px 5px !important;" data-toggle="modal" data-target="#modal-lge" data-id="{{ $data->id }}" class="btn btn-info edit"><i class="fa fa-pencil-alt"></i></button>
                                <button style="width: 32px; padding: 3px 5px !important;" data-id="{{ $data->id }}" class="btn btn-danger delete edit"><i class="fa fa-trash"></i></button>
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
    @include('settings.modals.edicion_ciudad')
    @include('settings.modals.registro_ciudad')
@stop

@section('scripts-bottom')
    <script>

        $('.edit').click(function(){
            var id= $(this).attr('data-id');
            $.get('{{ asset("settings/cities/get") }}/'+id,function(d){
                $(".frme_0001 input[name='c01']").val(d.nombre_ciudad);
                $(".frme_0001 select[name='c02']").val(d.id_departamento).trigger('change');
                $(".frme_0001 input[name='id']").val(d.id);
            },'json');
        });

        
        $('.delete').click(function(){
            if(confirm('Estas seguro que deseas eleminar el registro seleccionado?')){
                var id= $(this).attr('data-id');
                window.location='{{ asset("settings/cities/delete") }}/'+id;
            }
        });

        $(function() {
            $('.combo').select2({  theme: 'bootstrap4' })
	    });
    </script>
@stop