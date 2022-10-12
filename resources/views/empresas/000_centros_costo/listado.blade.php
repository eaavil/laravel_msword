@extends('template.main')

@section('contenedor_principal')



<div class="col-12">
    <div class="card">
            <!-- /.card-header -->
            <div class="card-body">

                <button class="btn btn-info" data-toggle="modal" data-target="#modal-lg"><i class="fa fa-plus"></i> Nuevo Centro de Costo</button>

              <table class="tableData table table-bordered table-striped">
                <thead>
                <tr>
                  <th width="15%">Empresa</th>
                  <th width="15%">Centro de Costo</th>
                  <th width="15%">Padre</th>
                  <th width="15%">Nivel</th>
                  <th width="15%">Creado</th>
                  <th>Actualizado</th>
                  <th width="15%">Acciones</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($registros as $data)
                        <tr>
                            <td>{{ $data->empresa_data->codigo_empresa }}<br>{{ $data->empresa_data->razon_social }}</td>
                            <td>{{ $data->codigo }}<br>{{ $data->descripcion }}</td>
                            <td>@if($data->padre==null) No Aplica @else {{ $data->padre_data->codigo }}<br>{{ $data->padre_data->descripcion }} @endif</td>
                            <td>{{ $data->nivel }}</td>
                            <td>{{ ($data->created_at!=null)?date('d/m/Y h:i:s a',strtotime($data->created_at)):'' }}</td>
                            <td>{{ ($data->updated_at!=null)?date('d/m/Y h:i:s a',strtotime($data->updated_at)):'' }}</td>
                            <td>
                                <button style="width: 32px; padding: 3px 5px !important;" data-toggle="modal" data-target="#modal-lge" data-id="{{ $data->id }}" class="btn btn-info edit"><i class="fa fa-pencil-alt"></i></button>
                                <button style="width: 32px; padding: 3px 5px !important;" class="btn btn-danger delete" data-id="{{ $data->id }}"><i class="fa fa-trash"></i></button>
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
    @if(\App\Http\Controllers\AuthController::checkAccessModule('empresas.centros_costo.registrar',session('role_id')))
        @include('empresas.000_centros_costo.modals.edicion')
    @endif
    @if(\App\Http\Controllers\AuthController::checkAccessModule('empresas.centros_costo.actualizar',session('role_id')))
        @include('empresas.000_centros_costo.modals.registro')
    @endif
@stop

@section('scripts-bottom')
    <script>

        $('.padr').on("change", function(e) {
            var nivel = $('option:selected',this).attr('data-nivel');
            if(isNaN(parseInt(nivel)+1)){
                $('.nivel').val(1);
            }else{
                $('.nivel').val(parseInt(nivel)+1);
            }
        })

        $('.padr_e').on("change", function(e) {
            var nivel = $('option:selected',this).attr('data-nivel');
            if(isNaN(parseInt(nivel)+1)){
                $('.nivel_e').val(1);
            }else{
                $('.nivel_e').val(parseInt(nivel)+1);
            }
        })

                
        $('.delete').click(function(){
            var id= $(this).attr('data-id');
            if(@json($session)==1){
                if(confirm('Estas Seguro de Eliminar el Registro Seleccionado?')){
                    window.location='{{ asset("empresas/centros_costo/eliminar") }}/'+id;
                }
            }else{
                alert('No tiene permisos para realizar esta accion');
            }
        });

        $('.edit').click(function(){
            var id= $(this).attr('data-id');
            
            $.get('{{ asset("empresas/centros_costo/detalle") }}/'+id,function(d){
                $(".frme input[name='c01']").val(d.codigo);
                $(".frme select[name='c02']").val(d.tipo).trigger('change');
                $(".frme input[name='c03']").val(d.descripcion);
                $(".frme input[name='c04']").val(d.responsable);
                $(".frme select[name='c05']").val(d.padre).trigger('change');
                $(".frme input[name='c06']").val(d.telefono);
                $(".frme input[name='id']").val(d.id);

                $('.padr_e').trigger('change');

            },'json');
        });

        $(function() {
            $('.combo').select2({  theme: 'bootstrap4' })
	    });
    </script>
@stop