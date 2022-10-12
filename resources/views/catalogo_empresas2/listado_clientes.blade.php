@extends('template.main')

@section('contenedor_principal')

<div class="col-12">
    <div class="card">
            <!-- /.card-header -->
            <div class="card-body">

                <button class="btn btn-info" style="float:right" data-toggle="modal" data-target="#modal-lg"><i class="fa fa-plus"></i> Agregar persona</button>
                <button  class="btn btn-secondary" style="float:left" data-toggle="modal" data-target="#modal-lgr"><i class="fa fa-file"></i> Reportes</button>
               
              <table id='main' class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th with="20%">Razon Social</th>
                   <th>Ciudad</th>
                  <th>Caracteristicas</th>
                  <th>Registrado</th>
                  <th>Acciones</th>
                </tr>
                </thead>
                <tbody><!--
                    @foreach($registros as $data)
                        <tr>
                            <td>{{ $data->nombre }}<br>Nit: {{ $data->nit }}-{{ $data->digito_verificacion_nit }}</td>
                            <td> </td>
                            <td>
                                @if($data->es_cliente)
                                    <span class="badge badge-primary" style="font-size:12px">Cliente</span>
                                @endif
                                @if($data->es_proveedor)
                                    <span class="badge badge-info" style="font-size:12px">Proveedor</span>
                                @endif
                                @if($data->es_propietario)
                                    <span class="badge badge-danger" style="font-size:12px">Facturador</span>
                                @endif
                                @if($data->es_tercero)
                                    <span class="badge badge-warning" style="font-size:12px">Tercero</span>
                                @endif                                
								@if($data->es_empresa_transporte)
                                    <span class="badge badge-warning" style="font-size:12px">Conductor</span>
                                @endif
                            </td>
                            <td>{{ ($data->created_at!=null)?date('d/m/Y h:i:s a',strtotime($data->created_at)):'' }}</td>
                            <td>{{ ($data->updated_at!=null)?date('d/m/Y h:i:s a',strtotime($data->updated_at)):'' }}</td>
                            <td>
                                <button style="width: 32px; padding: 3px 5px !important;" data-toggle="modal" data-target="#modal-lge" data-id="{{ $data->id }}" class="btn btn-info edit"><i class="fa fa-pencil-alt"></i></button>
                                <button style="width: 32px; padding: 3px 5px !important;" data-id="{{ $data->id }}" class="btn btn-danger delete"><i class="fa fa-trash"></i></button>
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
    @include('catalogo_empresas.modals.reporte_entradas')
    @if(\App\Http\Controllers\AuthController::checkAccessModule('catalogo.registrar',session('role_id')))
        @include('catalogo_empresas.modals.registro')
    @endif
    @if(\App\Http\Controllers\AuthController::checkAccessModule('catalogo.actualizar',session('role_id')))
        @include('catalogo_empresas.modals.edicion')
    @endif
@stop

@section('scripts-bottom')
    <script>

$(document).ready(function(){
    
    
    $(document).on('click','.ver',function(){
	     let width=453;
	     let height=345;
	     let num=$(this).attr('num');
	    let ruta="https://polariauto.000webhostapp.com/firmas/"+$(".id").val()+".jpg?"+Math.random();
	    
	    if(num=="hoja_de_vida"){
	        ruta="https://polariauto.000webhostapp.com/hojas_de_vida/"+$(".id").val()+".pdf";
	         width=550;
	      height=600;
	     }
     window.open(ruta,  'popup', 'top=100, left=200, width=width, height=height, toolbar=NO, resizable=NO, Location=NO, Menubar=NO,  Titlebar=No, Status=NO');
    });  
    
    
        $(document).on('click',".edit",function(){
             $(".es_cliente").attr('checked',false);
            $(".es_empleado").attr('checked',false);
            $(".es_proveedor").attr('checked',false);
            $(".es_tercero").attr('checked',false);
            var id= $(this).attr('data-id');
            $(".id").val(id);
            $.getJSON('{{ asset("catalogo/detalle") }}/'+id,function(d){
                 
                
                
                 if(d.es_cliente==1){
                    $(".es_cliente").attr('checked',true);
                }else{
                    $(".es_cliente").attr('checked',false);
                }
                if(d.es_empleado==1){
                    $(".es_empleado").attr('checked',true);
                }else{
                    $(".es_empleado").attr('checked',false);
                }
                if(d.es_proveedor==1){
                    
                    $(".es_proveedor").attr('checked',true);
                }else{
                    $(".es_proveedor").attr('checked',false);
                }
                if(d.es_tercero==1){
                    $(".es_tercero").attr('checked',true);
                }else{
                    $(".es_tercero").attr('checked',false);
                }
                
                $(".frme_0001 input[name='c01']").val(d.nombre);
                $(".frme_0001 input[name='c02']").val(d.nit);
                $(".frme_0001 input[name='comuna']").val(d.comuna);
                $(".frme_0001 input[name='c05']").val(d.id_poblacion);
                
                 $(".frme_0001 input[name='giro']").val(d.giro);
                 $(".frme_0001 input[name='c07']").val(d.email_empresa);
                 $(".frme_0001 input[name='c06']").val(d.numero_telefono_1);
                 $(".frme_0001 input[name='c17']").val(d.persona_contacto);
                 $(".frme_0001 select[name='c08']").val(d.id_tipo_regimen).trigger('change');
                  
               $(".frme_0001 input[name='c04']").val(d.direccion);
                
            });
        });

		

        $('.trigger_formx').click(function(){ 
			let form = $(this).attr('target');
			let nit = $('.nit').val();
			let dv = $('.dv').val();
			let email = $('.email').val();
			$('.'+form+' > .act_form').trigger('click');
			
		});
		
		
		$(document).on('click',".delete",function(){
            if(confirm('Estas seguro que deseas eleminar el registro seleccionado?')){
                var id= $(this).attr('data-id');
                window.location='{{ asset("catalogo/eliminar") }}/'+id;
            }
        });

        $(function() {
            $('.combo').select2({  theme: 'bootstrap4' })
	    });

        var tabla=$('#main').DataTable({
			       serverSide:true,
                   paging: true,
			       pageLength: 20,
                    ajax: {
                        url:'{{ asset("catalogo/listado/clientes/data") }}',
                        dataSrc: 'data',
                        type:'post',
                    },
                    columns:[
                                 {
					                 "data": null,name:'nombre',
					                 "render": function (data) {
                                         //return  '<td>{{str_pad('+data.id+',4,'+0+',STR_PAD_LEFT)}}</td>';
                                         return data.nombre+'<br>'+data.nit;
						             }
				                 },
                                 {
                                    "data": null,name:'id_poblacion',
					                "render": function (data) {
                                         return data.id_poblacion;
                                    }     
                                 },
                                 {
                                    "data": null,name:'es_cliente',name:'es_proveedor',name:'es_propietario',name:'es_tercero',name:'es_empresa_transporte',
					                "render": function (data) {
                                        var html='';
                                        if(data.es_cliente==1){
                                               html=html+' <span class="badge badge-primary" style="font-size:12px">Cliente</span>'
                                        }
                                        if(data.es_proveedor==1){
                                            html=html+' <span class="badge badge-info" style="font-size:12px">Proveedor</span>'
                                        }
                                        if(data.es_empleado==1){
                                            html=html+' <span class="badge badge-danger" style="font-size:12px">Empleado</span>'
                                        }
                                        if(data.es_propietario==1){
                                            html=html+' <span class="badge badge-danger" style="font-size:12px">Facturador</span>'
                                        }
                                        if(data.es_tercero==1){
                                            html=html+' <span class="badge badge-warning" style="font-size:12px">Tercero</span>'
                                        }                               
                                        if(data.es_empresa_transporte==1){
                                            html=html+' <span class="badge badge-warning" style="font-size:12px">Conductor</span>'
                                        }
                                        return html;
                                    }
                                 },
                                 {
                                    data:'created_at',name:'created_at',
					                "render": function (data) {
                                         return  data.substring(8,10)+'/'+data.substring(5,7)+'/'+data.substring(0,4)+' '+ data.substr(-8);
                                    }
                                 },
                                 {
                                    "data":'id',
					                 "render": function (data) {
                                         return  '<button style="width: 32px; padding: 3px 5px !important;" data-toggle="modal" data-target="#modal-lge" data-id="'+data+'" class="btn btn-info edit"><i class="fa fa-pencil-alt"></i></button>'+' '+
                                         '<button style="width: 32px; padding: 3px 5px !important;" class="btn btn-danger delete" data-id="'+data+'"><i class="fa fa-trash"></i></button>'
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
})
    </script>
@stop
