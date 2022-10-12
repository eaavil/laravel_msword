@extends('template.main')

@section('contenedor_principal')

         

<div class="col-12">
    <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
            <div>
            <div class="form-group input-group w-full">
                <div class="row">
                   <div >
                   <label for="my-select">Clasificar: </label><br>
                    <select id="my-select" class="form-control combo clasificar">
                        <option value="-1">Todos</option>
                        <option value="1" selected>Ingresos</option>
                        <option value="2">Egresos</option>
                    </select>
                    </div>
                   <div class= "mx-3">
                   <label  for="my-select2">Bancos: </label><br>
                        <select id="my-select2" class="form-control clasificar combo">
                            <option value="-1">Seleccione</option>
                            @foreach($bancos as $rows)
                                <option value="{{ $rows->id }}" >{{ ($rows->entidad)}}</option>
                            @endforeach
                        </select>
                   </div>
                   <div >
                    <div class="form-group">
                        <label>Fecha Inicial</label>
                        <input type="date"   class="fi form-control">
                    </div>
                </div>
                <div >
                    <div class="form-group">
                        <label>Fecha Final</label>
                        <input type="date"  class="ff form-control">
                    </div>
                </div>
                <div class=" pt-2 mx-3 ">
                <br>
                    <button class=" consultar btn btn-primary">Consultar</button>
                </div>
                <div class=" pt-2 mx-5 "><br></div>
                <div class=" pt-2 mx-3 "><br></div>
                <div class=" pt-2 mx-5 ">
                <br>
                <button class="btn btn-info ml-2" style="float:right" data-toggle="modal" data-target="#m-ingreso"><i class="fa fa-plus"></i> Registrar Ingreso</button>
                 
                </div>
                <div class="pt-2">
                <br>
                <button class="btn btn-primary" style="float:right" data-toggle="modal" data-target="#m-egreso"><i class="fa fa-plus"></i> Registrar Egreso</button>
                 
                </div>
                 </div>
                    
                   
                    
                    
                </div>
                </div>
                <div class="form-group w-25">
                    
                </div>
                <button  class="btn btn-secondary" style="float:left" data-toggle="modal" data-target="#m-entrada-reporte"><i class="fas fa-file"></i> Reporte ingresos/egresos</button>
              <table id="example" class="table table-bordered table-striped" width="100%">
                <thead>
                <tr>
                  <th width="5%">Transaccion</th>
                  <th>Fecha</th>
                  <th>Nombre</th>
                  <th>Descripcion</th>
                  <th>Forma Pago</th>
                  <th>Factura</th>
                  <th>Banco</th>
                  <th>Cuenta</th>
                  <th>Valor</th>
                  <th>Acciones</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
              </table>
              <div class="row">
                    <div class="col-4">
                       <h5> <b>Total Valor:</b> <span class="dx2"></span></h5>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
            </div>
          <!-- /.card -->
    </div>
   <div>@include('ingresos_egresos.modals.entrada_reporte')</div> 
    @include('ingresos_egresos.modals.registro_ingreso')
    @include('ingresos_egresos.modals.registro_egreso')
@stop

@section('scripts-bottom')

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-html5-1.6.1/b-print-1.6.1/cr-1.5.2/fc-3.3.0/fh-3.1.6/kt-2.5.1/r-2.2.3/rg-1.1.1/rr-1.2.6/sc-2.0.1/sp-1.0.1/sl-1.3.1/datatables.min.css"/>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-html5-1.6.1/b-print-1.6.1/cr-1.5.2/fc-3.3.0/fh-3.1.6/kt-2.5.1/r-2.2.3/rg-1.1.1/rr-1.2.6/sc-2.0.1/sp-1.0.1/sl-1.3.1/datatables.min.js"></script>

    <script>
        //calcular valores al cargar el dom
        let $valor =$('#my-select option:selected').val();
        let $banco =$('#my-select2 option:selected').val();
        let fecha_inicial=$('.fi').val();
        let fecha_final=$('.ff').val();
        $.ajax({
            type: "get",
            url: ('{{ route("ingreso_egreso.listado.data") }}?banco='+$banco+'&valor='+$valor+'&modo=1'),
            dataType: "json",
            success: function (response) {
                $('.dx2').html('$'+number_format(response,2,',','.'));
            }
        });

        $('.frm-ri').submit(function(e){
            e.preventDefault();
            let _data = $(this).serialize();
            let _url = $(this).attr('action');
            $.ajax({
                type: "post",
                url: _url,
                data: _data,
                dataType: "json",
                error: function (data) {
                    try{
                        $('.e-i').html('');
                        var info = data.responseJSON;
                        $.each(info.errors, function (key, value) {
                            $('.e-i').append(value+'<br>');
                        });
                        $('.e-i').show();
                    }catch(error){
                        $('.e-i').hide();
                        alert('Registro Exitoso')
                        window.location.reload()
                    }

                }
            });
        })
        $('.frm-re').submit(function(e){
            e.preventDefault();
            let _data = $(this).serialize();
            let _url = $(this).attr('action');
            $.ajax({
                type: "post",
                url: _url,
                data: _data,
                dataType: "json",
                error: function (data) {
                    try{
                        $('.e-e').html('');
                        var info = data.responseJSON;
                        $.each(info.errors, function (key, value) {
                            $('.e-e').append(value+'<br>');
                        });
                        $('.e-e').show();
                    }catch(error){
                        $('.e-e').hide();
                        alert('Registro Exitoso')
                        window.location.reload()
                    }

                }
            });
        })
        $.ajax({
            type: "get",
            url: "{{ route('settings.details.table',['table_index'=>1]) }}",
            dataType: "json",
            success: function (response) {
                $('.n_i').val('I{{ $numeracion_ingreso->parametro }}');
            }
        });
        $.ajax({
            type: "get",
            url: "{{ route('settings.details.table',['table_index'=>2]) }}",
            dataType: "json",
            success: function (response) {
                $('.n_e').val('E{{ $numeracion_egreso->parametro }}');
            }
        });
        $.ajax({
            type: "get",
            url: "{{ route('catalogo.ajax',['tipo'=>2]) }}",
            dataType: "json",
            success: function (response) {
                $.each(response.registros, function (indexInArray, valueOfElement) { 
                     $('.terceros').append('<option value="'+valueOfElement.id+'">'+valueOfElement.nombre+' nit: '+valueOfElement.nit+'</option>')
                });
            }
        });
        $.ajax({
            type: "get",
            url: "{{ route('bancos.cuentas.activas') }}",
            dataType: "json",
            success: function (response) {
                $.each(response.data, function (indexInArray, valueOfElement) { 
                    console.log(valueOfElement);
                     $('.cuentas').append('<option value="'+valueOfElement.id_cuenta+'">'+valueOfElement.entidad+' '+valueOfElement.nombre+' numero: '+valueOfElement.cuenta+'</option>')
                });
            }
        });
     
        $(document).on('click','.delete',function(){
            var id= $(this).attr('data-id');
            if(@json($session)==1){
                if(confirm('Estas Seguro de Eliminar el Registro Seleccionado?')){
                    window.location='{{ asset("ingreso-egreso/eliminar") }}/'+id;
                }
            }else{
                alert('No tiene permisos para realizar esta accion');
            }
        });


        $(document).on('click','.edit',function(){
            var id= $(this).attr('data-id');

            $.get('{{ asset("empaques/entrada/detalle") }}/'+id,function(d){
                $(".frme_0001 input[name='c01']").val(d.cantidad);
                $(".frme_0001 select[name='c02']").val(d.id_tipo_empaque).trigger('change');
                $(".frme_0001 input[name='c03']").val(d.fecha_ingreso.substring(0,10));
                $(".frme_0001 select[name='c04']").val(d.id_catalogo_empresas_cliente).trigger('change');
                $(".frme_0001 select[name='c05']").val(d.id_catalogo_empresas_proveedor).trigger('change');
                $(".frme_0001 input[name='id']").val(d.id);
            },'json');
        });


  

        $(document).ready(function(){

            function Padder(len, pad) {
                if (len === undefined) {
                    len = 1;
                } else if (pad === undefined) {
                    pad = '0';
                }

                var pads = '';
                while (pads.length < len) {
                    pads += pad;
                }

                this.pad = function(what) {
                    var s = what.toString();
                    return pads.substring(0, pads.length - s.length) + s;
                };
            }

            $('title').html('{{ $titulo }}');
            var tabla_datos = $('#example').DataTable({
                serverSide:true,
                  paging: true,
			      pageLength: 10,
                ajax: {
                    url: '{{ route("ingreso_egreso.listado.data") }}',
                    dataSrc: 'data',
                    type:'post'
                },
                columns:[
                    { 
                        "data": "numero",
                        name: "numero"
                    },
                    { 
                        "data": null, name: "fecha_operacion",
                        "render": function (data) {
                            dArr = data.fecha_operacion.substring(0,10).split("-");  // ex input "2010-01-18"
                            return dArr[2]+ "/" +dArr[1]+ "/" +dArr[0]; 
                        }
                    },
                    { 
                        "data": null,name:'nombre',
                        "render": function (data) {
                            return data.nombre+' NIT:'+data.nit;
                        }
                    },
                    { 
                        "data": "descripcion",
                        name: "descripcion"
                    },
                    { 
                        "data": "forma_pago",
                        name: "forma_pago"
                    },
                    
                    { 
                        "data": "numero_factura_remision",
                        name: "numero_factura_remision"
                    },
                    { 
                        "data": "entidad",
                        name: "entidad"
                    },
                    { 
                        "data": "cuenta",
                        name: "cuenta"
                    },
                    { 
                        "data": null,name:'valor',
                        "render": function (data) {
                            return number_format(data.valor,2,',','.');
                        }
                    },
                    {
                        "data": null,name:'id',
                        "render": function (data) {
                            return '<button style="width: 26px; height:26px; padding:0px" class="btn btn-danger delete" data-id="'+data.id+'"><i class="fa fa-trash"></i></button>';
                        }
                    }
                ],
            });
                 
		$(document).on('click','.consultar',function(){ 
            let $valor =$('#my-select option:selected').val();
            let $banco =$('#my-select2 option:selected').val();
            let fecha_inicial=$('.fi').val();
			let fecha_final=$('.ff').val();
			if(fecha_inicial!=''&&fecha_final!=''){
				tabla_datos.ajax.url('{{ route("ingreso_egreso.listado.fecha") }}?banco='+$banco+'&valor='+$valor+'&fecha_inicial='+fecha_inicial+'&fecha_final='+fecha_final+'&modo=0').load();
                //calcular valor total
                $.ajax({
                    type: "get",
                    url: ('{{ route("ingreso_egreso.listado.fecha") }}?banco='+$banco+'&valor='+$valor+'&fecha_inicial='+fecha_inicial+'&fecha_final='+fecha_final+'&modo=1'),
                    dataType: "json",
                    success: function (response) {
                        $('.dx2').html('$'+number_format(response,0,',','.'));
                    }
                });
			}else{
				alert('Ingrese fechas');
			}
		});
            $('.clasificar').change(function(){
               let $valor =$('#my-select option:selected').val();
               let $banco =$('#my-select2 option:selected').val();
               let fecha_inicial=$('.fi').val();
			   let fecha_final=$('.ff').val();
               if(fecha_inicial!=''&&fecha_final!=''){
                   tabla_datos.ajax.url('{{ route("ingreso_egreso.listado.fecha") }}?banco='+$banco+'&valor='+$valor+'&fecha_inicial='+fecha_inicial+'&fecha_final='+fecha_final+'&modo=0').load();
                   //calcular valor total con fechas
                    $.ajax({
                        type: "get",
                        url: ('{{ route("ingreso_egreso.listado.fecha") }}?banco='+$banco+'&valor='+$valor+'&fecha_inicial='+fecha_inicial+'&fecha_final='+fecha_final+'&modo=1'),
                        dataType: "json",
                        success: function (response) {
                            $('.dx2').html('$'+number_format(response,0,',','.'));
                        }
                    });
                }else{
                    tabla_datos.ajax.url('{{ route("ingreso_egreso.listado.data") }}'+'?banco='+$banco+'&valor='+$valor+'&modo=0').load();
                      //calcular valor total sin fechas
                      $.ajax({
                            type: "get",
                            url: ('{{ route("ingreso_egreso.listado.data") }}?banco='+$banco+'&valor='+$valor+'&modo=1'),
                            dataType: "json",
                            success: function (response) {
                                $('.dx2').html('$'+ number_format(response,0,',','.'));
                            }
                      });
                }
            });
        });

        $(function() {
            $('.combo').select2({  theme: 'bootstrap4' })
	    });
    </script>
@stop