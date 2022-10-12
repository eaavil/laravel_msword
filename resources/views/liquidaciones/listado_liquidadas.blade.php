@extends('template.main')

@section('contenedor_principal')

 @include('liquidaciones.modals.registro')

<div class="col-12">
    <div class="card">
            <!-- /.card-header -->
            
           
            <div class="card-body">
            <div class="row">
            <div class=" col-2 ">
                <span>Fecha Inicial</span>
                <input type="date"   class="fi form-control">
             </div>
            <div class="form-group col-2">
                <span>Fecha Final</span>
                <input type="date"  class="ff form-control">
            </div>
            <div>
            <br>
                <button class=" consultar btn btn-primary">Consultar</button>
            </div>
            <div class=" col-2 mx-3">
            </div>
            <div class="form-group col-4 mx-5">  
				<span style="float:right">Filtrar por Proveedor:<br>
				<select class="form-control combo prov">
					<option value="-1">Todos</option>
					@foreach($proveedores as $rows)
						<option value="{{ $rows->id }}">{{ $rows->nombre }}</option>
					@endforeach
				</select></span>
                </div>
            </div> 
			  <table id="main" class="table table-bordered table-striped" width="100%">
                <thead>
                <tr>
                  <th>Numero</th>
                  <th>Entrada</th>
                  <th>Fecha liquidacion</th>
                  <th>Contrato</th>
                  <th width="5%">Acciones</th>
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


    @include('liquidaciones.modals.reporte_entradas')

    @include('liquidaciones.modals.ver')





    <style>
        .select2-drop li {
            white-space: pre;
        }
    </style>



@stop

@section('scripts-bottom')
    <script>



function number_format (number, decimals, dec_point, thousands_sep) {
    // Strip all characters but numerical ones.
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}

        $('.contrato').change(function(){
            let elemento = $('option:selected',this);
			$('.c05').val(elemento.attr('data-value-min'));
            $('.saldo').val(elemento.attr('data-value')+'00');
            $('.ref-saldo').val(elemento.attr('data-value'));
        })

        $('.valor').keyup(function(){
            $('.valor-espejo').val($(this).val().substring(1));
        })


        $(document).on('click','.liquidar',function(){
            var id= $(this).attr('data-id');

            $.get('{{ asset("liquidaciones/entrada/detalle") }}/'+id,function(d){
				$('.contrato').html('<option value="" data-value="0" data-value-min="0">Seleccione</option>');
				$.get('{{ asset("liquidaciones/entrada/contratos/proveedor") }}/'+d[0].proveedor.id,function(dx){
					$.each(dx.data,function(i,v){
						$('.contrato').append('<option value="'+v.id+'" data-value="'+(v.valor_contrato-v.valor_pagado)+'" data-value-min="'+(v.precio_arroba)+'" >'+v.numero+' Valor: '+number_format(v.precio_arroba,0,'.')+'</option>');
					})
				},'json');

                let html = `
                    <div class="row">
                        <div class="col-4">
                            <b>Datos del Proveedor</b><br>
                            Nombre: `+d[0].proveedor.nombre+`<br>
                            NIT: `+d[0].proveedor.nit+`<br>
                            <b>Datos del Conductor</b><br>
                            Nombre: `+d[0].nombre_conductor+`<br>
                            Cedula: `+d[0].cedula_conductor+`<br>
                            Placa Vehiculo: `+d[0].placa+`<br>
                        </div>
                        <div class="col-4">
                                <div class="row">
                                    Entrada: `+d[0].numero_ticket+`<br>
                                    Fecha: `+d[0].created_at+`
                                    <div class="col-6">
                                        Peso Salida:
                                    </div>
                                    <div class="col-6">
                                        `+number_format(d[0].peso_salida,0,',','.')+`
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        Peso Entrada:
                                    </div>
                                    <div class="col-6">
                                        `+number_format(d[0].peso_entrada,0,',','.')+`
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        Peso Bruto:
                                    </div>
                                    <div class="col-6">
                                        `+number_format(d[0].peso_bruto,0,',','.')+`
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        Tara:
                                    </div>
                                    <div class="col-6">
                                        `+number_format(d[0].tara,0,',','.')+`
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        Peso Neto:
                                    </div>
                                    <div class="col-6">
                                        `+number_format(d[0].peso_neto,0,',','.')+`
                                    </div>
                                </div>
                        </div>
                        <div class="col-3">
                            Kilos Liquidados: `+number_format(d[0].liquidados,0,',','.')+`<br>
                            Kilos Pendientes: `+number_format(d[0].pendientes,0,',','.')+`
                        </div>
                    </div><br>
                `;
                $('.contenido').html(html);
                $('.limit').val(d[0].pendientes);
                $('.c01').attr('max',d[0].pendientes);
                $('.c02').val(d[0].factor);
                $('.entrada').val(d[0].id);
            },'json');
        });

		$(document).on('click','.ver_liquidaciones',function(){
            var id= $(this).attr('data-id');

            $.get('{{ asset("liquidaciones/entrada/detalle") }}/'+id,function(d){
				$('.contrato').html('<option value="" data-value="0" data-value-min="0">Seleccione</option>');
				$.get('{{ asset("liquidaciones/entrada/contratos/proveedor") }}/'+d[0].proveedor.id,function(dx){
					$.each(dx.data,function(i,v){
						$('.contrato').append('<option value="'+v.id+'" data-value="'+(v.valor_contrato-v.valor_pagado)+'" data-value-min="'+(v.precio_arroba)+'" >'+v.numero+' Valor: '+number_format(v.precio_arroba,0,'.')+'</option>');
					})
				},'json');

                let html = `
                    <div class="row">
                        <div class="col-4">
                            <b>Datos del Proveedor</b><br>
                            Nombre: `+d[0].proveedor.nombre+`<br>
                            NIT: `+d[0].proveedor.nit+`<br>
                            <b>Datos del Conductor</b><br>
                            Nombre: `+d[0].nombre_conductor+`<br>
                            Cedula: `+d[0].cedula_conductor+`<br>
                            Placa Vehiculo: `+d[0].placa+`<br>
                        </div>
                        <div class="col-4">
                                <div class="row">
                                    Entrada: `+d[0].numero_ticket+`<br>
                                    Fecha: `+d[0].created_at+`
                                    <div class="col-6">
                                        Peso Salida:
                                    </div>
                                    <div class="col-6">
                                        `+number_format(d[0].peso_salida,0,',','.')+`
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        Peso Entrada:
                                    </div>
                                    <div class="col-6">
                                        `+number_format(d[0].peso_entrada,0,',','.')+`
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        Peso Bruto:
                                    </div>
                                    <div class="col-6">
                                        `+number_format(d[0].peso_bruto,0,',','.')+`
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        Tara:
                                    </div>
                                    <div class="col-6">
                                        `+number_format(d[0].tara,0,',','.')+`
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        Peso Neto:
                                    </div>
                                    <div class="col-6">
                                        `+number_format(d[0].peso_neto,0,',','.')+`
                                    </div>
                                </div>
                        </div>
                        <div class="col-3">
                            Kilos Liquidados: `+number_format(d[0].liquidados,0,',','.')+`<br>
                            Kilos Pendientes: `+number_format(d[0].pendientes,0,',','.')+`
                        </div>
                    </div><br>
                `;
                $('.contenidox').html(html);

				/***************/





				/**************/

            },'json');
        });

        $('.x').keyup(function(){

            calcx();

        })


        $('.xx').change(function(){

            calcx();
            calcx();

        })

        function calcx(){
            let a1 = $('.c01');
            let a2 = $('.c02');
            let a3 = $('.c03');
            let a4 = $('.c04');
            let a5 = $('.c05');
            let a6 = $('.c06');
            let a7 = $('.c07');
            let a8 = $('.c08');
            let a9 = $('.c09');
            let a10 = $('.c10');
            let a11 = $('.c11');
            let a12 = $('.c12');
            let a13 = $('.c13');
            let a14 = $('.c14');
            let a15 = $('.c15');
            let a16 = $('.c16');

            let v1 = parseFloat($('.c01').val());
            let v2 = parseFloat($('.c02').val());
            let v3 = parseFloat($('.c03').val());
            let v4 = parseFloat($('.c04').val());
            let v5 = parseFloat($('.c05').val());
            let v6 = parseFloat($('.c06').val());
            let v7 = parseFloat($('.c07').val());
            let v8 = parseFloat($('.c08').val());
            let v10 = parseFloat($('.c10').val());
            let v12 = parseFloat($('.c12').val());
            let v14 = parseFloat($('.c14').val());


            let elemento = $('option:selected','.contrato');
			let vtemp = elemento.attr('data-value-min')

			let porcentaje = Math.abs(v2-v4)/100
			console.log(porcentaje);
			let valor_descuento = parseInt(vtemp)*porcentaje;
			console.log(valor_descuento);
			if(v3>0){
				a5.val(parseInt(vtemp)-parseFloat(valor_descuento));
				v5=parseInt(vtemp)-parseFloat(valor_descuento);
			}else{
				a5.val(parseInt(vtemp)+parseFloat(valor_descuento));
				v5=parseInt(vtemp)+parseFloat(valor_descuento);
			}



            oper1 = v2+v3; //descuento factor base
			if(isNaN(v3)){
				a4.val(0);
			}else{
				a4.val(oper1);
			}

            oper2 = Math.round(((v1/12.5)*v5),2);  //cafe bruto
            a6.val(oper2);

            if(v3==0 || v3==''){
                oper3 = (v1/12.5)*0; //valor del descuento
            }else{
                oper3 = Math.abs(((parseFloat(vtemp,2)-v5)/12.5)*v1); //descuento factor basee
            }
            a7.val(Math.round(oper3));

            oper4 = (oper2)*(v8/100); //cafe bruto
            a9.val(Math.round(oper4));

            oper5 = ((oper2-oper4)*v10)/1000; //cafe bruto
            a11.val(Math.round(oper5));

            oper6 = (oper2-oper4-oper5)*(v12/100); //cafe bruto
            a13.val(Math.round(oper6));

            oper7 = (oper2-oper4-oper5-oper6)*(v14/100); //cafe bruto
            a15.val(Math.round(oper7));

            a16.val((Math.round(oper2-(oper4+oper5+oper6+oper7))))
        }


        $('.trigger_form_esp').click(function(){
            let id = $(this).attr('target');
            console.log('.'+id+' > .act_form');
            $('.'+id+' > .act_form').trigger('click')
        })


        $('.delete').click(function(){
            if(@json($session)==1){
                if(confirm('Estas seguro que deseas eleminar el registro seleccionado?')){
                    var id= $(this).attr('data-id');
                    window.location='{{ asset("giros/eliminar") }}/'+id;
                }
            }else{
                alert('No tiene permisos para realizar esta accion');
            }
        });

        $(function() {
            $('.combo').select2({  theme: 'bootstrap4' })
	    });

		$('.prov').change(function(){
			let id = $('option:selected',this).val();
            let fecha_inicial=$('.fi').val();
			let fecha_final=$('.ff').val();
			if(id!=-1){
				tabla.ajax.url('{{ asset("liquidaciones/entrada/liquidada/data") }}?id_prov='+id).load();
			}else{
				tabla.ajax.url('{{ asset("liquidaciones/entrada/liquidada/data") }}').load();
			}
			if(fecha_inicial!=''&&fecha_final!=''){
				tabla.ajax.url('{{ route("liquidaciones.entradas.liquidadas.data") }}?fecha_inicial='+fecha_inicial+'&fecha_final='+fecha_final+'&modo=0'+'&id_prov='+id).load();
                
			}
            tabla.draw();
		})

		var tabla = $('#main').DataTable({
            serverSide:true,
            paging: true,
            ajax: {
                url: '{{ asset("liquidaciones/entrada/liquidada/data") }}',
                dataSrc: 'data',
                type:'post'
            },
            columns: [
                {
                    data: null,name:'numero_liquidacion',
                    render: function (data){
                        return `
                            <h2>`+data.numero_liquidacion+`</h2>
                            <p>Kilogramos: `+data.kilogramos+`<br/>
							Factor: `+data.factor_liquidacion+`<br/>
							Factor Descuento: `+data.factor_descuento+`<br/>
							Valor Arroba: `+data.valor_arroba+`<br/>
							Valor Bruta: `+data.valor_bruta+`<br/>
							Valor Descuento: `+data.valor_descuento+`<br/>
							% Retencion Fuente: `+data.porcentaje_retencion_fuente+`<br/>
							Retencion Fuente: `+data.valor_retencion+`<br/>
							% Retencion 4 x Mil: `+data.porcentaje_retencion_4_mil+`<br/>
							Valor Retencion 4 x Mil: `+data.valor_retencion_4_mil+`<br/>
							% Retencion Cooperativa: `+data.porcentaje_retencion_cooperativa+`<br/>
							Valor Retencion Cooperativa: `+data.valor_retencion_cooperativa+`<br/>
							% Retencion Tercero: `+data.porcentaje_retencion_tercero+`<br/>
							Valor Retencion Tercero: `+data.valor_retencion_tercero+`<br/>
							Total: `+data.total+`<br/>
						`;
                    }
                },
                {
                    data: null,name:'numero_ticket',
                    render: function (data){
                        return `
							<h3>`+data.numero_ticket+`</h3>
							<p>Proveedor: `+data.proveedor+`<br/>
							Nit: `+data.proveedor_nit+`<br/>
							Cafe: `+data.tipo_cafe+`<br/>
							Sacos: `+data.cantidad_sacos+`<br/>
							Tulas: `+data.catidad_tulas+`<br/>
							Peso Entrada: `+data.peso_entrada+`<br/>
							Peso Salida: `+data.peso_salida+`<br/>
							Peso Bruto: `+data.peso_bruto+`<br/>
							Tara: `+data.tara+`<br/>
							Peso Neto: `+data.peso_neto+`
						`;
                    }
                },{
					data: null,name:'fecha_liquidacion',
					render: function (data){
					return '<h5>'+data.fecha_liquidacion.substring(8,10)+'/'+data.fecha_liquidacion.substring(5,7)+'/'+data.fecha_liquidacion.substring(0,4)+'</h5>';
				 }
						
                },{
                    data: null,name:'numero',
                    render: function (data){
						try{
                        return `
							<h3>`+data.numero+`</h3>
							<p>Fecha: `+data.fecha_contrato+`<br/>
							Kilos Compromiso: `+data.kilos_compromiso+`<br/>
						`;
						}catch(error){
							return `
								<h3>sin contrato<h3>
							`;
						}
                    }
                },
                {
                    data: 'id_liquidacion',
                    render: function (data){
                        return `
							<button type="button" class="btn btn-danger eliminar" data-id="`+data+`"><i class="fa fa-trash" aria-hidden="true"></i></button>
						`;
                    }
                }
            ],
            language: langDataTable,
            footerCallback: function (row,data) {
                //totalizador
                var total = 0;
                var total_contrato = 0;
                $('#main').DataTable().rows({page:'current'}).data().each(function(el, index){
                    total += parseFloat(el.kilos_compromiso);
                    total_contrato += parseFloat(el.valor_contrato);
                });
                $('.dx1').html(number_format(total,0,',','.')+' Kgs.');
                $('.dx2').html('$'+number_format(total_contrato,2,',','.'));
            }
        });
        
        $(document).on('click','.consultar',function(){ 
            let fecha_inicial=$('.fi').val();
			let fecha_final=$('.ff').val();
            let id=$('.prov option:selected').val();
			if(fecha_inicial!=''&&fecha_final!=''){
				tabla.ajax.url('{{ route("liquidaciones.entradas.liquidadas.data") }}?fecha_inicial='+fecha_inicial+'&fecha_final='+fecha_final+'&modo=0'+'&id_prov='+id).load();
                
			}else{
				alert('Ingrese fechas');
			}
		});
        $(document).on('click','.eliminar',function(){
            if(confirm('Estas seguro que deseas eliminar el registro seleccionado?')){
                var id= $(this).attr('data-id');
                window.location='{{ asset("liquidaciones/entrada/eliminar") }}/'+id;
            }
        });
    </script>
@stop
