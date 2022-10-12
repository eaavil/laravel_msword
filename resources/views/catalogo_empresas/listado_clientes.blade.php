@extends('template.main')

@section('contenedor_principal')

<div class="col-12">
    <div class="card">
            <!-- /.card-header -->
            <div class="card-body">

                <button class="btn btn-info nuevo" style="float:right" data-toggle="modal" data-target="#modal-lg"><i class="fa fa-plus"></i> Agregar persona</button>
                <button  class="btn btn-secondary" style="float:left" data-toggle="modal" data-target="#modal-lgr"><i class="fa fa-file"></i> Reportes</button>
               
              <table id='main' class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th with="50%">Nombre Completo</th>
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
        @include('catalogo_empresas.modals.registro_edicion')
    @endif
    @if(\App\Http\Controllers\AuthController::checkAccessModule('catalogo.actualizar',session('role_id')))
      
    @endif
@stop

@section('scripts-bottom')
    <script>

$(document).ready(function(){

        $(document).on('change',".check_proveedor",function(){
            if(this.checked) {
                $('.proveedor').css('display','block');
        //I am checked
            }else{
                $('.proveedor').css('display','none');
            }

        });

        $(document).on('click',".check_cliente",function(){
            if(this.checked) {
                $('.cliente').css('display','block');
                
            }else{
                $('.cliente').css('display','none');
            }

        });
 

        $(document).on('click','.nuevo',function(){
        //$('.articulo').prop('selectedIndex',0);
        $('.id').val("");
        $('.c01').val("");
                $('.c02').val("");
                $('.c03').val("");
                $('.c04').val("");
                $('.c17').val("");
                $('.c05').val("");
                $('.c06').val("");
                $('.c07').val("");
                $('.c08').val("").trigger('change');
                $('.c09').val("").trigger('change');
                $('.c10').val("");
                $('.c11').val("").trigger('change');
                $('.giro').val("");
                $('.comuna').val("");

                $('.c12').attr('checked',false);
                $('.c13').attr('checked',false);
                $('.c14').attr('checked',false);
                $('.c15').attr('checked',false);

        $(".modal-title").text("Registrar persona");
        cont++;
        cont_formulario=0;
        cont2=0;
        //verificar datos esten llenos con each
    })
        $(document).on('click',".edit",function(){
            var id= $(this).attr('data-id');
            $(".id").val(id);
            $(".modal-title").text("Editar persona");
            $.getJSON('{{ asset("catalogo/detalle") }}/'+id,function(d){
               
                $('.c01').val(d.nombre);
                $(".c02").val(d.nit);
                $(".rep").val(d.representante);
                $(".c03").val(d.digito_verificacion_nit);
                $(".c04").val(d.direccion);
                $(".c17").val(d.persona_contacto);
                $('.c05').val(d.id_poblacion);
                $('.c06').val(d.numero_telefono_1);
                $('.c07').val(d.email_empresa);
                $('.c08').val(d.id_tipo_regimen).trigger('change');
                $('.c09').val(d.id_banco).trigger('change');
                $('.c10').val(d.numero_cuenta);
                $('.c11').val(d.tipo_cuenta).trigger('change');
                $('.giro').val(d.giro);
                $('.comuna').val(d.comuna);

                $('c12').attr('checked',false);
                $('c13').attr('checked',false);
                $('c14').attr('checked',false);
                $('c15').attr('checked',false);
                

                if(d.es_cliente==1){
                    $('.c12').attr('checked',true);
                }else{
                    $('.c12').attr('checked',false);
                }
                if(d.es_empleado==1){
                    $('.c13').attr('checked',true);
                }else{
                    $('.c13').attr('checked',false);
                }
                if(d.es_proveedor==1){
                    $('.c14').attr('checked',true);
                }else{
                    $('.c14').attr('checked',false);
                }
                if(d.es_tecnico==1){
                    $('.c15').attr('checked',true);
                }else{
                    $('.c15').attr('checked',false);
                }

               
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
                                        if(data.es_tercero==1){
                                            html=html+' <span class="badge badge-warning" style="font-size:12px">Tercero</span>'
                                        }    
                                         if(data.es_tecnico==1){
                                            html=html+' <span class="badge badge-warning" style="font-size:12px">Tecnico</span>'
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
                                         return  '<button style="width: 32px; padding: 3px 5px !important;" data-toggle="modal" data-target="#modal-lg" data-id='+data+'" class="btn btn-info edit"><i class="fa fa-pencil-alt"></i></button>'+' '+
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
