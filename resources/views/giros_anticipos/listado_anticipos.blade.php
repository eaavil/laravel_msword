@extends('template.main')

@section('contenedor_principal')

    @if(\App\Http\Controllers\AuthController::checkAccessModule('anticipos.registrar',session('role_id')))
        @include('giros_anticipos.modals.registro_anticipos')
    @endif
@include('giros_anticipos.modals.reporte_salidas_saldo')
<div class="col-12">
    <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
            <div class="row">
            
            <div class=" pt-2">
            <br>
            <button  class="btn btn-secondary" style="float:left" data-toggle="modal" data-target="#modal-lgr"><i class="fa fa-file"></i> Reporte resumen</button>
            
             </div>
            <div class=" pt-2">
            <br>
            <button  class="btn btn-secondary" style="float:left" data-toggle="modal" data-target="#modal-2"><i class="fas fa-file"></i> Reporte general</button><br>
            </div>
            <div class="pt-2">
                <br>
                <button  class="btn btn-secondary" style="float:left" data-toggle="modal" data-target="#modal-lgrs"><i class="fa fa-file"></i> Resumen saldo</button>
            </div> 
                    <div class="form-group col-2">
                        <label>Fecha Inicial</label>
                        <input type="date"   class="fi form-control">
                    </div>
                    <div class="form-group col-2">
                        <label>Fecha Final</label>
                        <input type="date"  class="ff form-control">
                    </div>
               
                <div class=" pt-2 ">
                <br>
                    <button class=" consultar btn btn-primary">Consultar</button>
                </div>
                <div class=" pt-2 mx-5 "><br></div>
                <div class=" pt-2 mx-5 "><br></div>
                <div class=" pt-2 mx-4"><br></div>
                <div class=" pt-2 mx-2" >
                <br>
                <button class="btn btn-info" style="float:right" data-toggle="modal" data-target="#modal-lg"><i class="fa fa-plus"></i> Nuevo Anticipo</button>
            </div>
                </div>
                <table id='main' class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Numero</th>
                  <th>Cliente</th>
                  <th>Valor</th>
                  <th>Fecha Giro</th>
                  <th>Forma Pago</th>
                  <th>Numero Cheque<br>Transaccion</th>
                  <th>Cuenta</th>
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
   <div>@include('giros_anticipos.modals.reporte_entradas_anticipos')</div>
	@include('giros_anticipos.modals.reporte_anticipos')

    <style>
        .select2-drop li {
            white-space: pre;
        }
    </style>


@stop

@section('scripts-bottom')
    <script>
     $(document).ready(function(){
        $(document).on('click',".edit",function(){
            var id= $(this).attr('data-id');

            $.get('{{ asset("bancos/detalle") }}/'+id,function(d){
                $(".frme_0001 input[name='c02']").val(d.entidad);
                $(".frme_0001 input[name='id']").val(d.id);
            },'json');
        });

        $('.trigger_form_esp').click(function(){
            let id = $(this).attr('target');
            $('.'+id+' > .act_form').trigger('click');
        })


        $(document).on('click',".delete",function(){
            if(@json($session)==1){
                if(confirm('Estas seguro que deseas eliminar el registro seleccionado?')){
                    var id= $(this).attr('data-id');
                    window.location='{{ asset("anticipos/eliminar") }}/'+id;
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
                        url:'{{asset("anticipos/listado/data")}}',
                        dataSrc: 'data',
                        type:'post',
                    },
                    columns:[
                                 {
					                 "data": 'id',name:'id',
					                 "render": function (data) {
                                         return 'ANT-'+('000' + data).slice(-4);
						             }
				                 },
                                 {
                                    "data": null,name:'000_catalogo_empresas.nombre',
					                "render": function (data) {
                                         return  data.nombre+'<br>'+'NIT:'+data.nit+'-'+data.digito_verificacion_nit;
                                    }     
                                 },
                                 {
                                    "data": 'valor',name:'valor',
					                 "render": function (data) {
                                         return  number_format(data, 2,',','.');
                                     }
                                 },
                                 {
                                    "data": 'fecha_giro',name:'fecha_giro',
					                "render": function (data) {
                                        return  data.substring(8,10)+'/'+data.substring(5,7)+'/'+data.substring(0,4)+' '+ data.substr(-8);
                                    }
                                 },
                                 {"data": 'forma_pago','name':'forma_pago'},
                                 {"data": 'numero_cheque','name':'numero_cheque'},
                                 {
                                    "data": null,name:'000_cuentas_bancos.cliente',name:'000_bancos.entidad',name:'000_cuentas_bancos.cuenta',
					                "render": function (data) {
                                        var html;
                                        if(data.cuenta!=null){
                                           html=data.cuenta+'<br>'+data.cliente+'<br>'+data.entidad
                                        }
                                        else{
                                           html='Sin Cuenta Asociada'
                                        }
                                        return  html;
                                    }
                                 },
                                 {
                                    "data": 'created_at',
					                "render": function (data) {
                                         return  data.substring(8,10)+'/'+data.substring(5,7)+'/'+data.substring(0,4)+' '+ data.substr(-8);
                                    }
                                 },
                                 {
                                    "data": 'updated_at',
					                 "render": function (data) {
                                         return data.substring(8,10)+'/'+data.substring(5,7)+'/'+data.substring(0,4)+' '+ data.substr(-8);
                                    }
                                 },
                                 {
                                    "data": 'id',
					                 "render": function (data) {
                                         return '<button style="width: 32px; padding: 3px 5px !important;" class="btn btn-danger delete" data-id="'+data+'"><i class="fa fa-trash"></i></button>'
                                    }
                                 }
                                 
                   ],
                   language: langDataTable,
        });
        $(document).on('click','.consultar',function(){ 
            let fecha_inicial=$('.fi').val();
			let fecha_final=$('.ff').val();
			if(fecha_inicial!=''&&fecha_final!=''){
				tabla.ajax.url('{{ route("anticipos.listado_data") }}?fecha_inicial='+fecha_inicial+'&fecha_final='+fecha_final+'&modo=0').load();
                
			}else{
				alert('Ingrese fechas');
			}
		});
     })
    </script>
@stop
