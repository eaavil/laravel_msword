@extends('template.main')

@section('contenedor_principal')



<div class="col-12">
    <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
            <div class="row">
            <div class=" pt-2 ">
            <br>  	
               <button  class="btn btn-secondary" style="float:left" data-toggle="modal" data-target="#modal-lgr"><i class="fa fa-file"></i> Inventario</button>
           </div>
            <div class=" pt-2 ">
            <br>     
                <button  class="btn btn-secondary" style="float:left" data-toggle="modal" data-target="#modal-2"><i class="fas fa-file"></i> Corte entradas/salidas</button>
            </div>
            <div class=" pt-2">
            <br>      
                <button  class="btn btn-secondary" style="float:left" data-toggle="modal" data-target="#modal-lgrs"><i class="fa fa-file"></i> liquidadas/sin liquidar</button><br><br><br>
            </div>      <div class=" pt-2 mx-2 "><br></div>
            <div class="form-group ">
                        <label>Fecha Inicial</label>
                        <input type="date"   class="fi form-control">
             </div>
            <div class="form-group ">
                <label>Fecha Final</label>
                <input type="date"  class="ff form-control">
            </div>
            <div class=" pt-2 ">
            <br>
                <button class=" consultar btn btn-primary">Consultar</button>
            </div>
            <div class="form-group col-2  pt-2 mx-4">  
				<span style="float:right">Filtrar por Cliente:<br>
				<select class="form-control combo prov">
					<option value="">Todos</option>
					@foreach($proveedores as $rows)
						<option value="{{ $rows->id }}">{{ $rows->nombre }}</option>
					@endforeach
				</select></span>
                
            </div>
            <div class="pt-4">
            <button class="btn btn-info" style="float:right" data-toggle="modal" data-target="#modal-lg"><i class="fa fa-plus"></i> Nueva Salida</button>            
            </div>
            </div>
              <table id="example" class="table table-bordered table-striped" width="100%">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Detalles</th>
                        <th width="20%">Cliente</th>
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
    @include('cafe.modals.registro_salida')
    @include('cafe.modals.edicion_salida')
    @include('cafe.modals.reporte_salida')
    @include('cafe.modals.reporte_entradas_corte')
    @include('cafe.modals.reporte_salidas_liquidadas')
@stop

@section('scripts-bottom')

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-html5-1.6.1/b-print-1.6.1/cr-1.5.2/fc-3.3.0/fh-3.1.6/kt-2.5.1/r-2.2.3/rg-1.1.1/rr-1.2.6/sc-2.0.1/sp-1.0.1/sl-1.3.1/datatables.min.css"/>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-html5-1.6.1/b-print-1.6.1/cr-1.5.2/fc-3.3.0/fh-3.1.6/kt-2.5.1/r-2.2.3/rg-1.1.1/rr-1.2.6/sc-2.0.1/sp-1.0.1/sl-1.3.1/datatables.min.js"></script>

    <script>

		$(document).on('click','.terminar',function(){
			var id= $(this).attr('data-id');
			if(confirm('Esta seguro de terminar el registro seleccionado?')){
				window.location='{{ asset("cafe/registro/terminar") }}/'+id;
			}
		});

		$(document).on('click','.habilitar',function(){
			var id= $(this).attr('data-id');
			if(confirm('Esta seguro de habilitar el registro seleccionado?')){
				window.location='{{ asset("cafe/registro/habilitar") }}/'+id;
			}
		});

        $('.contrato').change(function(){
            let elemento = $('option:selected',this);
            $('.contrato_detalle').show();
            $('.c_a').html('<br>'+elemento.attr('data-weight'));
            $('.c_b').html('<br>'+elemento.attr('data-weight2'));
            $('.c_d').html('<br>'+elemento.attr('data-client'));
            $('.c_e').html('<br>'+(parseFloat(elemento.attr('data-weight'))-parseFloat(elemento.attr('data-weight2'))));
            $('.c_f').html('<br>'+elemento.attr('data-amount'));
        });
        $(document).on('click','.edit',function(){
            var id= $(this).attr('data-id');

            $.get('{{ asset("cafe/salida/detalle") }}/'+id,function(d){
                $(".frme_0001 input[name='c01']").val(d.fecha_ticket.substring(0,10));
                $(".frme_0001 input[name='c02']").val(d.numero_ticket)
                $(".frme_0001 select[name='c03']").val(d.id_catalogo_proveedor).trigger('change');
                $(".frme_0001 select[name='c04']").val(d.id_centro_costo).trigger('change');
                $(".frme_0001 input[name='c05']").val(d.factor);
				$(".frme_0001 select[name='c06']").val(d.id_tipo_cafe).trigger('change');
                $(".frme_0001 input[name='c07']").val(d.cantidad_sacos);
                $(".frme_0001 input[name='c08']").val(d.catidad_tulas);
                $(".frme_0001 input[name='sacos_anterior']").val(d.cantidad_sacos);
                $(".frme_0001 input[name='tulas_anterior']").val(d.catidad_tulas);
                $(".frme_0001 select[name='c09']").val(d.id_catalogo_conductor).trigger('change');
                $(".frme_0001 input[name='c11']").val(d.placa);
				$(".frme_0001 input[name='c12']").val(d.observaciones);
                $(".frme_0001 input[name='c13']").val(d.peso_entrada);
                $(".frme_0001 input[name='c14']").val(d.peso_salida);
                $(".frme_0001 input[name='c15']").val(d.peso_bruto);
                $(".frme_0001 input[name='c16']").val(d.tara);
                $(".frme_0001 input[name='c17']").val(d.peso_neto);
                $(".frme_0001 input[name='c18']").val(d.telefono_conductor);
                $(".frme_0001 select[name='c19']").val(d.id_catalogo_cliente).trigger('change');
                $(".frme_0001 input[name='c20']").val(d.empresa_transportadora);
                $(".frme_0001 input[name='c21']").val(d.direccion_destino);
                $(".frme_0001 input[name='c22']").val(d.lugar_destino);
                $(".frme_0001 input[name='c23']").val(d.kilometros);
                $(".frme_0001 input[name='id']").val(d.id);
                $(".frme_0001 input[name='id']").val(d.id);
            },'json');
        });

		$('.frm_0001 .calc').keyup(function(){
			console.log('a');
			let p1 = $('.frm_0001 .p1');
			let p2 = $('.frm_0001 .p2');
			let p3 = $('.frm_0001 .p3');
			let p4 = $('.frm_0001 .p4');
			let p5 = $('.frm_0001 .p5');

			p3.val(Math.abs(p1.val().replace('.','')-p2.val().replace('.','')));
			p5.val(Math.abs(p3.val().replace('.','')-p4.val().replace('.','')));
		})

        $('.existencia').change(function(){
            if($('option:selected',this).val()==2){
                $(".ini").prop('disabled',true);
                $(".ini").prop('required',false);
                $(".rep").prop("disabled",true);
            }
            if($('option:selected',this).val()==-1){
                $(".ini").prop('disabled',false);
                $(".ini").prop('required',true);
                $(".rep").prop("disabled",false);
               
            }
            if($('option:selected',this).val()==1){
                $(".ini").prop('disabled',false);
                $(".ini").prop('required',true);
                $(".rep").prop("disabled",true);
               
            }
        });
		$('.frme_0001 .calc').keyup(function(){
			console.log('aa');
			let p1 = $('.frme_0001 .p1');
			let p2 = $('.frme_0001 .p2');
			let p3 = $('.frme_0001 .p3');
			let p4 = $('.frme_0001 .p4');
			let p5 = $('.frme_0001 .p5');

			p3.val(Math.abs(p2.val().replace('.','')-p1.val().replace('.','')));
			p5.val(Math.abs(p3.val().replace('.','')-p4.val().replace('.','')));
		})

		$('.frm_0001 .calc').keyup(function(){
			console.log('a');
			let p1 = $('.frm_0001 .p1');
			let p2 = $('.frm_0001 .p2');
			let p3 = $('.frm_0001 .p3');
			let p4 = $('.frm_0001 .p4');
			let p5 = $('.frm_0001 .p5');

			p3.val(Math.abs(p1.val().replace('.','')-p2.val().replace('.','')));
			p5.val(Math.abs(p3.val().replace('.','')-p4.val().replace('.','')));
		})


        $(document).on('click','.delete',function(){
            if(@json($session)==1){
            if(confirm('Estas seguro que deseas eliminar el registro seleccionado?')){
                var id= $(this).attr('data-id');
                window.location='{{ asset("cafe/salida/eliminar") }}/'+id;
               }
            }else{
                alert('No tiene permisos para realizar esta accion');
            }
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
            var tabla= $('#example').DataTable({
                serverSide:true,
                paging: true,
				order: false,
                ajax: {
                    url: '{{ asset("cafe/listado/salidas/data") }}',
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
                    {
                        "data": null,name:'fecha_ticket',name:'numero_ticket',
                        "render": function (data) {
                            return data.fecha_ticket.substring(8,10)+'/'+data.fecha_ticket.substring(5,7)+'/'+data.fecha_ticket.substring(0,4)+'<br><br><b>Ticket: </b><br><h5>'+data.numero_ticket+'</h5>';
                        }
                    }, 
                    {
                        "data": null,name:'000_tipos_cafe.tipo_cafe',
                        "render": function (data) {
                            let html = `
                                <div class="row">
                                    <div class="col-6">
                                        Conductor:<br>`+data.conductor+`<br>Placa:<br>`+data.placa+`<br>Factor:<br>`+data.factor+`<br>Tipo de Cafe:<br>`+data.tipo_cafe+`
                                    </div>
                                    <div class="col-6">
                                        Sacos:<br>`+data.cantidad_sacos+`<br>Tulas:<br>`+data.catidad_tulas+`<br>Peso Neto:<br>Kg. `+number_format(data.peso_neto,0,',','.')+`
                                    </div>
                                </div>
                            `;
                            return html;
                        }
                    },
					{"data":'nombre',name:'cp.nombre'},
                    {
                        "data": null,name:'003_entradas_salidas_cafe.id',
                        "render": function (data) {
							var html = '';
							if(parseInt(data.terminada)==1){
								html = '<button style="width: 26px; height:26px; padding:0px" data-id="'+data.entradas_salidas_cafe_id+'" class="btn btn-default habilitar" title="Reactivar Registro"><i class="fa fa-redo"></i></button>';
							}else{
								html = '<button style="width: 26px; height:26px; padding:0px" data-id="'+data.entradas_salidas_cafe_id+'" class="btn btn-default terminar "  title="Culminar Registro"><i class="fa fa-times"></i></button>';
							}

                            return html+'<button style="width: 26px; height:26px; padding:0px" data-toggle="modal" data-target="#modal-lge" data-id="'+data.entradas_salidas_cafe_id+'" class="btn btn-info edit"><i class="fa fa-pencil-alt"></i></button> \
                                    <button style="width: 26px; height:26px; padding:0px" data-id="'+data.entradas_salidas_cafe_id+'" class="btn btn-danger delete"><i class="fa fa-trash"></i></button> \
                                    <button style="width: 26px; height:26px; padding:0px" class="btn btn-success print" data-id="'+data.entradas_salidas_cafe_id+'"><i class="fa fa-print"></i></button>';
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
				tabla.ajax.url('{{ route("cafe.salidas.data") }}?fecha_inicial='+fecha_inicial+'&fecha_final='+fecha_final+'&modo=0').load();
                
			}else{
				alert('Ingrese fechas');
			}
		});
        
        $('.prov').change(function(){
            let fecha_inicial=$('.fi').val();
			let fecha_final=$('.ff').val();
			let id = $('option:selected',this).val();
			if(id!=null){
				tabla.ajax.url('{{ asset("cafe/listado/salidas/data") }}?id_prov='+id).load();
			}else{
				tabla.ajax.url('{{ asset("cafe/listado/salidas/data") }}').load();
			}
            alert(id);
            if(fecha_inicial!=''&&fecha_final!=''){
                
				tabla.ajax.url('{{ route("cafe.salidas.data") }}?fecha_inicial='+fecha_inicial+'&fecha_final='+fecha_final+'&modo=0'+'&id_prov='+id).load();
                
			}
            tabla.draw();
		})

        });
         
        $(document).on('click','.print',function(){
            var id= $(this).attr('data-id');
            window.open('{{ asset("cafe/salidas/comprobante") }}/'+id);
        });

        $(function() {
            $('.combo').select2({  theme: 'bootstrap4' })
	    });
    </script>
@stop
