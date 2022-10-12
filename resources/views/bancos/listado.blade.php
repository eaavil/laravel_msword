@extends('template.main')

@section('contenedor_principal')



<div class="col-12">
    <div class="card">
            <!-- /.card-header -->
            <div class="card-body">

                <button class="btn btn-info" data-toggle="modal" data-target="#modal-lg"><i class="fa fa-plus"></i> Nuevo Banco</button>

                <table id='main' class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Codigo</th>
                  <th with="20%">Entidad</th>
                  <th>Creado</th>
                  <th>Actualizado</th>
                  <th>Acciones</th>
                </tr>
                </thead>
                <tbody><!--
                    @foreach($registros as $data)
                        <tr>
                            <td>{{ str_pad($data->id,4,'0',STR_PAD_LEFT) }}</td>
                            <td>{{ $data->entidad }}</td>
                            <td>{{ ($data->created_at!=null)?date('d/m/Y h:i:s a',strtotime($data->created_at)):'' }}</td>
                            <td>{{ ($data->updated_at!=null)?date('d/m/Y h:i:s a',strtotime($data->updated_at)):'' }}</td>
                            <td>
                                <button style="width: 32px; padding: 3px 5px !important;" data-toggle="modal" data-target="#modal-lge" data-id="{{ $data->id }}" class="btn btn-info edit"><i class="fa fa-pencil-alt"></i></button>
                                <button style="width: 32px; padding: 3px 5px !important;" class="btn btn-danger @if(\App\Http\Controllers\AuthController::checkAccessModule('bancos.eliminar',session('role_id'))) delete @endif" data-id="{{ $data->id }}"><i class="fa fa-trash"></i></button>
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
    @if(\App\Http\Controllers\AuthController::checkAccessModule('bancos.registrar',session('role_id')))
        @include('bancos.modals.registro')
    @endif
    @if(\App\Http\Controllers\AuthController::checkAccessModule('bancos.actualizar',session('role_id')))
        @include('bancos.modals.edicion')
    @endif
@stop

@section('scripts-bottom')
<script>
    $(document).ready(function(){
       $(document).on('click','.edit',function(){
            var id= $(this).attr('data-id');

            $.get('{{ asset("bancos/detalle") }}/'+id,function(d){
                $(".frme_0001 input[name='c02']").val(d.entidad);
                $(".frme_0001 input[name='id']").val(d.id);
            },'json');
        });


        $(document).on('click','#delete',function(){
            if(@json($session)==1){
                if(confirm('Estas seguro que deseas eleminar el registro seleccionado?')){
                    var id= $(this).attr('data-id');
                    window.location='{{ asset("bancos/eliminar") }}/'+id;
                }
            }else{
                alert('No tiene permisos para realizar esta accion');
            }
        });

        $(function() {
            $('.combo').select2({  theme: 'bootstrap4' })
	    });
    var tabla=$('#main').DataTable({
                  serverSide: true,
                  paging: true,
			      pageLength: 20,
                    ajax: {
                        url:'{{ asset("bancos/listado/data") }}',
                        dataSrc: 'data',
                        type:'post'
                    },
                  columns:[
                                 {
					                 data: null,name:'id',
					                 render: function (data) {
                                         //return  '<td>{{str_pad('+data.id+',4,'+0+',STR_PAD_LEFT)}}</td>';
                                         return ('000' + data.id).slice(-4);
						             }
				                 },
                                 {
                                    data:'entidad',name:'entidad'
                                 },
                                 {
                                    data:null,name:'created_at',
                                    render:function(data){
                                    return data.created_at.substring(8,10)+'/'+data.created_at.substring(5,7)+'/'+data.created_at.substring(0,4);}
                                 },
                                 {
                                    data:null,name:'updated_at',
                                    render:function(data){
                                    return data.updated_at.substring(8,10)+'/'+data.updated_at.substring(5,7)+'/'+data.updated_at.substring(0,4);}
                                 },
                                 {
                                    data: null, name:'id',
                                    render: function(data) {
                                        var html;
                                        /*if(){
                                            //(\App\Http\Controllers\AuthController::checkAccessModule('bancos.eliminar',session('role_id')) delete  
                                        }*/
                                        return html= '<button style="width: 32px; padding: 3px 5px !important;" data-toggle="modal" data-target="#modal-lge" data-id="'+data.id+'" class="btn btn-info edit"><i class="fa fa-pencil-alt"></i></button>'+
                                       '<button id="delete" style="width: 32px; padding: 3px 5px !important;" class="btn btn-danger" data-id="'+data.id+'"><i class="fa fa-trash"></i></button>';
                                    }
                                 }
                 ],
            }); 
    })     
</script>
@stop
