@extends('template.main')

@section('contenedor_principal')



<div class="col-12">
    <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
            <div class="row">
                <!-- 
            <div class=" pt-2 ">
            <br>  
                <button  class="btn btn-secondary" style="float:left" data-toggle="modal" data-target="#modal-lgr"><i class="fa fa-file"></i> Inventario</button>
            </div>
            <div class=" pt-2 ">
            <br>  
                <button  class="btn btn-secondary" style="float:left" data-toggle="modal" data-target="#modal-2"><i class="fas fa-file"></i> Corte entradas/salidas</button>
            </div>
            <div class=" pt-2 ">
            <br>
                <button  class="btn btn-secondary" style="float:left" data-toggle="modal" data-target="#modal-lgrl"><i class="fa fa-file"></i> liquidadas/sin liquidar</button>
            </div> <div class=" pt-2 mx-2 "><br></div>
            <div >
                        <label>Fecha Inicial</label>
                        <input type="date"   class="fi form-control">
            </div>
            <div >
                <label>Fecha Final</label>
                <input type="date"  class="ff form-control">
            </div>
               
            <div class=" pt-2 ">
                <br>
                    <button class=" consultar btn btn-primary">Consultar</button>
            </div>
            <div class="form-group col-2  pt-2 mx-2">  
				<span style="float:right">Filtrar por Proveedor:<br>
				<select class="form-control combo prov">
					<option value="">Todos</option>
					@foreach($proveedores as $rows)
						<option value="{{ $rows->id }}">{{ $rows->nombre }}</option>
					@endforeach
				</select></span>
            </div>
            -->
            <div class="pt-4">
            <button class=" btn btn-info abrir_modal"  data-toggle="modal" data-target="#modal-lg"><i class="fa fa-plus"></i> Nueva Entrada</button>
            </div>
            </div>
               
                <table id="example" class="table table-bordered table-striped" width="100%">
                <thead>
                <tr>
                  <th>Numero</th>
                  <th>Fecha</th>
                  <th>Factor</th>
                  <th>Peso Neto</th>
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
    @include('cafe.modals.edicion_mezcla')
    @include('cafe.modals.registro_mezcla')
	@include('cafe.modals.reporte_entrada')
    @include('cafe.modals.reporte_entradas_corte')
    @include('cafe.modals.reporte_entradas_liquidadas')
@stop

@section('scripts-bottom')

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-html5-1.6.1/b-print-1.6.1/cr-1.5.2/fc-3.3.0/fh-3.1.6/kt-2.5.1/r-2.2.3/rg-1.1.1/rr-1.2.6/sc-2.0.1/sp-1.0.1/sl-1.3.1/datatables.min.css"/>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-html5-1.6.1/b-print-1.6.1/cr-1.5.2/fc-3.3.0/fh-3.1.6/kt-2.5.1/r-2.2.3/rg-1.1.1/rr-1.2.6/sc-2.0.1/sp-1.0.1/sl-1.3.1/datatables.min.js"></script>

    <script>
        var primera_fila=0;
        var editar=0;
		$(document).on('click','.terminar',function(){
			var id= $(this).attr('data-id');
			if(confirm('Esta seguro de terminar el registro seleccionado?')){
				window.location='{{ asset("cafe/registro/terminar") }}/'+id;
			}
		});
        
        $(document).on('click','.print',function(){
            var id= $(this).attr('data-id');
            window.open('{{ asset("cafe/entradas/comprobante") }}/'+id);
        });

        $(document).on('click','.delete',function(){
            if(@json($session)==1){
                if(confirm('Estas seguro que deseas eliminar el registro seleccionado?')){
                    var id= $(this).attr('data-id');
                    window.location='{{ asset("mezcla/eliminar") }}/'+id;
                }
            }else{
                alert('No tiene permisos para realizar esta accion');
            }
        });
        //formatear miles
        $(document).on('keyup',"[type='number']",function (evt){
            $.each($('.destino tbody tr'),function(i,v){
                var num = $(this).find('input[name="kilos[]"]').val().replace(/\./g,'');//formatear miles
                num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
                num = num.split('').reverse().join('').replace(/^[\.]/,'');
                
                $(this).find('input[name="kilos[]"]').val(num);
            });
        });
        //calcular factor mezcla
        $(document).on('change',"[type='number']",function () {
            totalizar();
        });

        $(document).on('click',".edit",function (evt) { 
            limpiar();
            let id = $(this).attr('data-id');
            $('.id').val(id);      
            $('.t1').val($(this).attr('data-peso_neto'));    
            $('.t2').val($(this).attr('data-factor'));  
            $('.t3e').val($(this).attr('data-tulas'));  
            $('.t4e').val($(this).attr('data-sacos'));  

            editar++;
            $('.titulo_salida').html('Editar Mezcla '+$(this).attr('data-numero') );
            $.get('{{ route("mezclas.detalle")}}?id='+id,function(dx){
                    $.each(dx,function(i,v){
                        if(v.id_tipo_cafe!=1){
                            $('.destino_edicion tbody').append(`
                                    <tr class="dc`+v.id_entrada+`">
                                        <td>`+v.numero_ticket+`<input type="hidden" name="entrada[]" value="`+v.id_entrada+`" /></td>
                                        <td>`+v.factor+`<input type="hidden" name="numero[]" value="`+v.numero+`" /></td>
                                        <td>`+v.tipo_cafe+`<input type="hidden" name="tipo_cafe[]" value="`+v.id_tipo_cafe+`" /></td>
                                        <td><input type="number" step="0.01" style="width:90%" class="v1" name="aprovechable[]" value="`+v.aprovechable+`" /></td>
                                        <td>`+v.nombre+`<input type="hidden" name="factor[]"  value="`+v.factor+`" /></td>
                                        <td>`+number_format(v.kilos_disponibles+v.peso_neto_detalle,0,',','.')+`<input type="hidden" name="peso_disponible[]" value="`+number_format(v.kilos_disponibles+v.peso_neto_detalle,0,',','.')+`" /></td>
                                        <td>
                                            <input type="number"  step="0.001"  min="1" style="width:90%"  name="kilos[]" value="`+v.peso_neto_detalle+`" /> 
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger remove-mezcla" title="Remover" data-id="`+v.id_entrada+`">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </button>
                                        </td>
                                    </tr>
                            `);
                       
                        }else{
                            $('.destino_edicion tbody').append(`
                                <tr class="dc`+v.id_entrada+`">
                                    <td>`+v.numero_ticket+`<input type="hidden" name="entrada[]" value="`+v.id_entrada+`" /></td>
                                    <td>`+v.factor+`<input type="hidden" name="numero[]" value="`+v.numero+`" /></td>
                                    <td>`+v.tipo_cafe+`<input type="hidden" name="tipo_cafe[]" value="`+v.id_tipo_cafe+`" /></td>
                                    <td>0<input type="hidden" style="width:90%" class="v1" name="aprovechable[]" value="N/A" /></td>
                                    <td>`+v.nombre+`<input type="hidden" name="factor[]" value="`+v.factor+`" /></td>
                                    <td>`+number_format(v.kilos_disponibles+v.peso_neto_detalle,0,',','.')+`<input type="hidden" name="peso_disponible[]" value="`+number_format(v.kilos_disponibles+v.peso_neto_detalle,0,',','.')+`" /></td>
                                    <td>
                                        <input type="number" step="0.001"  min="1" style="width:90%" name="kilos[]" value="`+v.peso_neto_detalle+`"  />
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger remove-mezcla" title="Remover" data-id="`+v.id_entrada+`">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </button>
                                    </td>
                                </tr>
                            `);
                        }
                    })
           })
        });

        $('.abrir_modal').click(function(){
            limpiar();
        });

        function limpiar(){
            $(".destino tbody").empty();
            $('.destino tbody').append(`
            <td colspan="7" class="fila1">sin datos</td> `);
            $(".destino_edicion tbody").empty();
            $(".agregar").val('');
            $('.agregar').change();//actualizar vista
            $(".t1").val('');
            $(".t2").val('');
            $(".t3").val('');
            $(".t4").val('');
            $(".t3e").val('');
            $(".t4e").val('');
            $('.titulo_salida').html("");
            editar=0;
            primera_fila=0;
        }

        function totalizar(){
            let constante_pergamino=300;
            let constante_inferiores=21000;
            let total_cafe=0;
            let total_pergamino=0;
            let total_inferiores=0;
            let factor_pergamino=0;
            let factor_inferiores=0;
            let tipo_cafe=0
            let porcentaje=0;
            let factor_mezcla=0;
            let excelso=0;
            let tabla='.destino tbody tr';
            let diferencia=0;
            if(editar==1){
              tabla='.destino_edicion tbody tr';
            }
            //calcular total a mezclar
            $.each($(tabla),function(){
                tipo_cafe=$(this).find('input[name="tipo_cafe[]"]').val();
                
                if(tipo_cafe==1){
                    total_pergamino+=parseInt($(this).find('input[name="kilos[]"]').val().replace(/\./g,''));
                    if(parseInt($(this).find('input[name="kilos[]"]').val().replace(/\./g,''))>parseInt($(this).find('input[name="peso_disponible[]"]').val().replace(/\./g,''))){
                        diferencia=$(this).find('input[name="numero[]"]').val(); 
                    }

                }else{
                    total_inferiores+=parseInt($(this).find('input[name="kilos[]"]').val().replace(/\./g,''));
                    if(parseInt($(this).find('input[name="kilos[]"]').val().replace(/\./g,''))>parseInt($(this).find('input[name="peso_disponible[]"]').val().replace(/\./g,''))){

                       diferencia=$(this).find('input[name="numero[]"]').val();
                    }
                }
               
            });
            //calcular factor promedio
            $.each($(tabla),function(){
                let tipo_cafe=$(this).find('input[name="tipo_cafe[]"]').val();
                
                if(tipo_cafe==1){
                    factor_pergamino+=parseInt($(this).find('input[name="kilos[]"]').val().replace(/\./g,''))/total_pergamino*$(this).find('input[name="factor[]"]').val();
                    
                }else{
                    factor_inferiores+=parseInt($(this).find('input[name="kilos[]"]').val().replace(/\./g,''))/total_inferiores*$(this).find('.v1').val()/100;
                }
                var num = $(this).find('input[name="kilos[]"]').val().replace(/\./g,'');//formatear miles
                total_cafe+=parseInt(num);
                num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
                num = num.split('').reverse().join('').replace(/^[\.]/,'');
               
                $(this).find('input[name="kilos[]"]').val(num);
            });
            if(diferencia!=0){
                alert('Los kilos a mezclar superan los kilos disponibles entrada '+diferencia);
            }else{
            excelso=constante_inferiores/factor_pergamino/constante_pergamino;
            porcentaje=((total_pergamino/total_cafe)*excelso)+((total_inferiores/total_cafe)*factor_inferiores);
            factor_mezcla=constante_inferiores/(constante_pergamino*porcentaje);
                $('.t1').val(total_cafe);
                $('.t2').val(factor_mezcla.toFixed(2));
            }
        }
        
        

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

            $(document).on('click','.remove-mezcla',function(){
                let id = $(this).attr('data-id');
                $('.dc'+id).remove();
                totalizar();
            });
             //enviar formulario registrar
           $('.trigger_form_esp').click(function(){
                let id = $(this).attr('target');
                if($('.t3').val()=="" &&  $('.t4').val()==""){
                    alert('Ingrese sacos o tulas');
                }else{
                    $('.'+id+' > .act_form').trigger('click');
                }

            });
              //enviar formulario editar
           $('.trigger_form_edicion').click(function(){
                let id = $(this).attr('target');
                if($('.t3e').val()=="" &&  $('.t4e').val()==""){
                    alert('Ingrese sacos o tulas');
                }else{
                    $('.'+id+' > .act_form_edicion').trigger('click');
                }

            });


            $('.agregar').change(function(){
                let id_prov=$('option:selected',this).val();
                
                if(id_prov!=""){
                    if(primera_fila==0){
                        $(".destino tbody").empty();
                        primera_fila++;
                    } 
                    let tabla=$('.destino tbody');
                    if(editar==1){
                    tabla=$('.destino_edicion tbody');
                    }
                    $.post('{{ route("cafe.mezclas.data")}}?modo=0&id_prov='+id_prov,function(dx){
                        $.each(dx,function(i,v){
                            if(v.id_tipo_cafe!=1){
                                
                            tabla.append(`
                                <tr class="dc`+v.id+`">
                                    <td>`+v.numero_ticket+`<input type="hidden" name="entrada[]" value="`+v.id+`" /></td>
                                    <td>`+v.factor+`<input type="hidden" name="numero[]" value="`+v.numero_ticket+`" /></td>
                                    <td>`+v.tipo_cafe+`<input type="hidden" name="tipo_cafe[]" value="`+v.id_tipo_cafe+`" /></td>
                                    <td><input type="number" step="0.01" style="width:90%" class="v1" name="aprovechable[]" value="`+v.valor_producido+`" /></td>
                                    <td>`+v.nombre+`<input type="hidden" name="factor[]"  value="`+v.factor+`" /></td>
                                    <td>`+number_format(v.kilos_disponibles,0,',','.')+`<input type="hidden" name="peso_disponible[]" value="`+v.kilos_disponibles+`" /></td>
                                    <td>
                                        <input type="number" step="0.001"   min="1" style="width:90%"  name="kilos[]"  />
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger remove-mezcla" title="Remover" data-id="`+v.id+`">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </button>
                                    </td>
                                </tr>
                        `);
                        
                            }else{
                                tabla.append(`
                                    <tr class="dc`+v.id+`">
                                        <td>`+v.numero_ticket+`<input type="hidden" name="entrada[]" value="`+v.id+`" /></td>
                                        <td>`+v.factor+`<input type="hidden" name="numero[]" value="`+v.numero_ticket+`" /></td>
                                        <td>`+v.tipo_cafe+`<input type="hidden" name="tipo_cafe[]" value="`+v.id_tipo_cafe+`" /></td>
                                        <td>0<input type="hidden" style="width:90%" class="v1" name="aprovechable[]" value="N/A" /></td>
                                        <td>`+v.nombre+`<input type="hidden" name="factor[]" value="`+v.factor+`" /></td>
                                        <td>`+number_format(v.kilos_disponibles,0,',','.')+`<input type="hidden" name="peso_disponible[]" value="`+v.kilos_disponibles+`" /></td>
                                        <td>
                                            <input type="number" step="0.001"  min="1" style="width:90%" name="kilos[]"  />
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger remove-mezcla" title="Remover" data-id="`+v.id+`">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </button>
                                        </td>
                                    </tr>
                            `);
                            }
                        })
                    })
                }
			});

           var tabla= $('#example').DataTable({
                serverSide: true,
                paging: true,
                order: false,
                ajax: { 
                    url: '{{ asset("cafe/listado/mezclas/data") }}',
                    dataSrc: 'data',
                    type:'post'
                },
                columnDefs: [
                    {
                    pageLength: 5,
                    lengthMenu: [[5, 10, 20, -1], [5, 10, 20, "Todos"]]
                    }
                ],
                "columns": [
                    {"data":'numero',name:'numero'},
                    {
                        "data": null,name:'created_at',
                        "render": function (data) {
                            return data.created_at.substring(8,10)+'/'+data.created_at.substring(5,7)+'/'+data.created_at.substring(0,4);
                        }
                    },
                    {"data":'factor',name:'factor'},
                    {"data":'peso_neto',name:'peso_neto',
                    "render": function (data) {
                            return data+' Kg';
                        }
                    },
                    {
                        "data": null,name:'id',
                        "render": function (data) {
                            return '<button style="width: 26px; height:26px; padding:0px" data-toggle="modal" data-target="#modal-lgme" data-id="'+data.id+'" data-peso_neto="'+data.peso_neto+'" data-factor="'+data.factor+'" data-sacos="'+data.cantidad_sacos+'" data-tulas="'+data.cantidad_tulas+'" data-numero="'+data.numero+'" class="btn btn-info edit "><i class="fa fa-pencil-alt "></i></button> \
                            <button style="width: 26px; height:26px; padding:0px" data-id="'+data.id+'"  class="btn btn-danger delete"><i class="fa fa-trash"></i></button>';
                        }
                    }
                ],
                /*"footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api(), data;
                    // Remove the formatting to get integer data for summation
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };
                    // Total over all pages
                    total = api
                        .column( 1 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                    // Total over this page
                    pageTotal = api
                        .column( 1, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                    // Update footer
                    $( api.column( 1 ).footer() ).html(
                        '$'+pageTotal +' de $'+ total +' total'
                    );
                }*/
            });
            $(document).on('click','.consultar',function(){ 
            let fecha_inicial=$('.fi').val();
			let fecha_final=$('.ff').val();
			if(fecha_inicial!=''&&fecha_final!=''){
				tabla.ajax.url('{{ route("cafe.mezclas.data") }}?fecha_inicial='+fecha_inicial+'&fecha_final='+fecha_final+'&modo=0').load();
                
			}else{
				alert('Ingrese fechas');
			}
		});

        $('.prov').change(function(){
            let fecha_inicial=$('.fi').val();
			let fecha_final=$('.ff').val();
			let id = $('option:selected',this).val();
			if(id!=-1){
				tabla.ajax.url('{{ asset("cafe/listado/entradas/data") }}?id_prov='+id).load();
			}else{
				tabla.ajax.url('{{ asset("cafe/listado/entradas/data") }}').load();
			}
            if(fecha_inicial!=''&&fecha_final!=''){
				tabla.ajax.url('{{ route("cafe.mezclas.data") }}?fecha_inicial='+fecha_inicial+'&fecha_final='+fecha_final+'&modo=0'+'&id_prov='+id).load();
                
			}
            tabla.draw();
		})

    
        
        });
         
        
        $(function() {
            $('.combo').select2({  theme: 'bootstrap4' })
	    });
    </script>
@stop
