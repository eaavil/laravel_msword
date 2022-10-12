@extends('template.main')

@section('contenedor_principal')



<div class="col-12">
    <div class="card">
            <!-- /.card-header -->
            <div class="card-body">


              <table class="tableData table table-bordered table-striped">
                <thead>
                <tr>
                  <th>modulo</th>
                  <th with="20%">Parametro</th>
                  <th with="20%">Valor</th>
                  <th>Creado</th>
                  <th>Actualizado</th>
                  <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($settings as $data)
                        <tr>
                            <td>{{ $data->modulo }}</td>
                            <td>{{ $data->titulo }}</td>
                            <td>{{ $data->parametro }}</td>
                            <td>{{ ($data->created_at!=null)?date('d/m/Y h:i:s a',strtotime($data->created_at)):'' }}</td>
                            <td>{{ ($data->updated_at!=null)?date('d/m/Y h:i:s a',strtotime($data->updated_at)):'' }}</td>
                            <td>
                                <button style="width: 32px; padding: 3px 5px !important;" data-toggle="modal" data-target="#modal-lge" data-id="{{ $data->id }}" class="btn btn-info edit"><i class="fa fa-pencil-alt"></i></button>
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
    @include('settings.modals.edicion')
@stop

@section('scripts-bottom')
    <script>


        $('.edit').click(function(){
            var id= $(this).attr('data-id');
            
            $.get('{{ asset("settings/details") }}/'+id,function(d){
                $(".frme_0001 input[name='c00']").val(d.titulo);
                $(".frme_0001 input[name='c01']").val(d.parametro);
                $(".frme_0001 input[name='id']").val(d.id);
            },'json');
        });

        
        $('.delete').click(function(){
            if(confirm('Estas seguro que deseas eleminar el registro seleccionado?')){
                var id= $(this).attr('data-id');
                //window.location='{{ asset("bancos/eliminar") }}/'+id;
            }
        });

        $(function() {
            $('.combo').select2({  theme: 'bootstrap4' })
	    });
    </script>
@stop