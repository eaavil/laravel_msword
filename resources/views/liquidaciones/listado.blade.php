@extends('template.main')

@section('contenedor_principal')

 @include('liquidaciones.modals.registro')

<div class="col-12">
    <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
            <div class="row">
		
            <div class="mx-2 ">
            <br>
                <button  class="btn btn-secondary" style="float:left" data-toggle="modal" data-target="#modal-lgr"><i class="fa fa-file"></i> Reportes</button>
            </div>    
            <div class="mx-2">
            <br>
                <a target="__blank" href="{{ route('liquidaciones.entradas.reporte.resumen') }}"  class="btn btn-secondary" style="float:left"><i class="fa fa-file"></i> Generar Resumen</a>
            </div> 
            	
            <div class="form-group col-2 ">
                <span>Fecha Inicial</span>
                <input type="date"   class="fi form-control">
             </div>
            <div class="form-group col-2">
                <span>Fecha Final
                <input type="date"  class="ff form-control"></span>
            </div>
            <div>
            <br>
                <button class=" consultar btn btn-primary">Consultar</button>
            </div>
            <div class=" mx-4 "><br></div><div class=" mx-4 "><br></div><div class=" mx-4 "><br></div>
            <div class=" col-3 float-right">  
                <span style="float:right">Filtrar por Proveedor:<br>
				<select class="form-control combo prov">
					<option value="-1">Todos</option>
					@foreach($proveedores as $rows)
						<option value="{{ $rows->id }}">{{ $rows->nombre }}</option>
					@endforeach
				</select></span>
            </div>
            </div> 
			  <table id='main' class="table table-bordered table-striped" >
                <thead>
                <tr>
                  <th>Numero Entrada</th>
                  <th>Contacto</th>
                  <th>Detalles Carga</th>
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


    @include('liquidaciones.modals.reporte_entradas')

    @include('liquidaciones.modals.ver')

@stop

@section('scripts-bottom')
    <script>
    
    $(document).ready(function(){
     var tipo_cafe='';
     var id_proveedor_actual='';
     var temporal=1;
  
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
            $('.c01').val("");
            /*$('.c03').val(0);
            $('.c06').val(0);
            $('.c07').val(0); 
            $('.c08').val(0);
            $('.c09').val(0);
            $('.c10').val(0);
            $('.c11').val(0);
            $('.c12').val(0);
            $('.c13').val(0); 
            $('.c14').val(0); 
            $('.c15').val(0);
            $('.c16').val(0); */
        })

        $('.valor').keyup(function(){
            $('.valor-espejo').val($(this).val().substring(1));
        })


        $(document).on('click','.liquidar',function(){
            var id= $(this).attr('data-id');
            tipo_cafe=$(this).attr('data-tipo_cafe');
            if(tipo_cafe!='PERGAMINO'){
                $(".descuentos"). css("display", "none");
                $(".contrato2"). css("display", "none");
                $(".arroba_pasilla"). css("display", "block");
                $(".filacontkilos").addClass("col-3");
                $(".filacont").addClass("col-3");
                $(".c05").prop("readonly", true);
             
                
            }else{
                $(".descuentos"). css("display", "block");
                $(".contrato2"). css("display", "block");
                $(".arroba_pasilla").css("display", "none");
                $(".filacontkilos").addClass("col-3");
                $(".filacont").addClass("col-2");
                $(".c05").prop("readonly", false);
            }

            $.get('{{ asset("liquidaciones/entrada/detalle") }}/'+id,function(d){
				$('.contrato').html('<option value="" data-value="0" data-value-min="0">Seleccione</option>');
				$.get('{{ asset("liquidaciones/entrada/contratos/proveedor") }}/'+d[0].proveedor.id,function(dx){
					$.each(dx.data,function(i,v){
						$('.contrato').append('<option value="'+v.id+'" data-value="'+(v.valor_contrato-v.valor_pagado)+'" data-value-min="'+(v.precio_arroba)+'" >'+v.numero+' Valor: '+number_format(v.precio_arroba,0,'.')+' Pendientes: '+number_format(v.kilos_compromiso-v.kilos_entregados,0,'.')+'</option>');
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
                //$('.c02').val(d[0].factor);
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

				var tablax = $('#mainxc').DataTable({
					processing: true,
					paging: true,
					destroy: true,
					scrollX:true,
					ajax: {
						url: '{{ asset("liquidaciones/entrada/listado/detalle/data") }}/'+id,
						dataSrc: 'data'
					},
					columns: [
						{
							data: null,
							render: function (data){
								return data.numero;
							}
						},
						{
							data: null,
							render: function (data){
								return data.fecha_liquidacion;
							}
						},
												{
							data: null,
							render: function (data){
								return data.kilogramos;
							}
						},
												{
							data: null,
							render: function (data){
								return data.valor_arroba;
							}
						},
												{
							data: null,
							render: function (data){
								return data.valor_bruta;
							}
						},
												{
							data: null,
							render: function (data){
								return data.valor_descuento;
							}
						},
												{
							data: null,
							render: function (data){
								return data.porcentaje_retencion;
							}
						},
												{
							data: null,
							render: function (data){
								return data.valor_retencion_fuente;
							}
						},
												{
							data: null,
							render: function (data){
								return data.valor_retencion_4_mil;
							}
						},
												{
							data: null,
							render: function (data){
								return data.valor_retencion_4_mil;
							}
						},
												{
							data: null,
							render: function (data){
								return data.valor_retencion_cooperativa;
							}
						},
												{
							data: null,
							render: function (data){
								return data.valor_retencion_tercero;
							}
						},
												{
							data: null,
							render: function (data){
								return data.total;
							}
						},
												{
							data: null,
							render: function (data){
								return data.numero;
							}
						},
												{
							data: null,
							render: function (data){
								return data.numero;
							}
						},
						{
							data: null,
							render: function (data){
								return `
									<button type="button" class="btn btn-danger" data-id="`+data.id+`"><i class="fa fa-trash" aria-hidden="true"></i></button>
								`;
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
								columns: [ 0,1,2,3],
								modifier: {
									page: 'current'
								}
							}
						},
						{
							extend: 'excel',
							text: '<i class="fas fa-file-excel"></i> Excel',
							exportOptions: {
								columns: [ 0,1,2,3],
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
								columns: [ 0,1,2,3],
								modifier: {
									page: 'current'
								}
							}
						},
						{
							extend: 'print',
							text: '<i class="fas fa-print"></i> Imprimir',
							exportOptions: {
								columns: [ 0,1,2,3],
								modifier: {
									page: 'current'
								}
							}
						}
					],
				});




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

            let v1 = parseFloat($('.c01').val().replaceAll('.',''));
            let v2 = parseFloat($('.c02').val());
            let v3 = parseFloat($('.c03').val());
            let v4 = parseFloat($('.c04').val());
            let v5 = parseFloat($('.c05').val().replaceAll('.',''));
            let v6 = parseFloat($('.c06').val());
            let v7 = parseFloat($('.c07').val());
          
            let v8 = parseFloat($('.c08').val());
            let v10 = parseFloat($('.c10').val());
            let v12 = parseFloat($('.c12').val());
            let v14 = parseFloat($('.c14').val());
            let v15 = parseFloat($('.v01').val().replaceAll('.',''));
            let v16 = parseFloat($('.v02').val());
            if(isNaN(v8)){
                v8=0;  
            }
            if(isNaN(v10)){
                v10=0;  
            }
            if(isNaN(v12)){
                v12=0;  
            }
            if(isNaN(v14)){
                v14=0;  
            }
            if(isNaN(v4)){
                v4=0;
            }
            let porcentaje = Math.abs(v2-v4)/100
            let elemento;
            let vtemp=0;
            let valor_descuento;

            if (tipo_cafe=="PERGAMINO") {
                elemento = $('option:selected','.contrato');
                vtemp = elemento.attr('data-value-min');
                valor_descuento = parseInt(vtemp)*porcentaje;
                if(v3>0){
                    a5.val(parseInt(vtemp)-parseFloat(valor_descuento));
                    v5=parseInt(vtemp)-parseFloat(valor_descuento);
                }else{
                    a5.val(parseInt(vtemp)+parseFloat(valor_descuento));
                    v5=parseInt(vtemp)+parseFloat(valor_descuento);
                }
                         
            }else{
                if(v15==''||v16==''){
                  v15=0;
                  v16=0;
                }
                if(v15*v16>=0){
                    a5.val(v15*v16); 
                }
                
               vtemp=v5;
               valor_descuento = parseInt(vtemp)*porcentaje;
               if(v3>0){
                   v5=parseInt(vtemp)-parseFloat(valor_descuento);
                }else{
                    v5=parseInt(vtemp)+parseFloat(valor_descuento);
                }
                        
            }
            
            oper1 = v2+v3; //descuento factor base
            if(isNaN(v3)){
                a4.val(94);
            }else{
                a4.val(oper1);
            }
           if(tipo_cafe!="PERGAMINO"){
                oper2 = Math.round(((v5/12.5)*v1),2); 
            }else{
                oper2 = Math.round(((v1/12.5)*v5),2); 
            }
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

        $('.trigger_form_esp_entrada').click(function(){
            let id = $(this).attr('target');
            let cont=0;
            let v1entero=isNaN(parseInt($('.c01').val().replaceAll('.','')));
            let v5entero=isNaN(parseInt($('.c05').val().replaceAll('.','')));
            
            if(parseInt($('.c01').val().replaceAll('.',''))>parseInt($('.'+id+' > .limit').val())){
            alert('el monto a liquidar es mayor al pendiente, verifique e intente de nuevo');
            cont++;
            };
            if(parseInt($('.c01').val().replaceAll('.',''))==0||v1entero){
            alert('ingrese el monto a liquidar');
            cont++;
            };
            if(parseInt($('.c05').val().replaceAll('.',''))==0||v5entero){
            alert('ingrese el valor de la arroba');
            cont++;
            };
            if(cont==0){
                $('.'+id+' > .act_form').trigger('click')
            }
           
        })


        $('.delete').click(function(){
            if(confirm('Estas seguro que deseas eleminar el registro seleccionado?')){
                var id= $(this).attr('data-id');
                window.location='{{ asset("giros/eliminar") }}/'+id;
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
				tabla.ajax.url('{{ asset("liquidaciones/entrada/listado/data") }}?id_prov='+id).load();
			}else{
				tabla.ajax.url('{{ asset("liquidaciones/entrada/listado/data") }}').load();
			}
            if(fecha_inicial!=''&&fecha_final!=''){
				tabla.ajax.url('{{ route("liquidaciones.entradas.listado.data") }}?fecha_inicial='+fecha_inicial+'&fecha_final='+fecha_final+'&modo=0'+'&id_prov='+id).load();
                
			}
		});
        
        var tabla = $('#main').DataTable({
            serverSide:true,
            paging: true,
            ajax: {
                url: '{{ asset("liquidaciones/entrada/listado/data") }}',
                dataSrc: 'data',
                type:'post'
            },
            columns: [
                {
                    data: null,name:'tipo_cafe',name:'numero_ticket',
                    render: function (data){
                        return `
						        <h5>`+data.numero_ticket+`</h5><br><br>
                                Fecha:<br>
                                `+data.fecha_ticket.substring(8,10)+'/'+data.fecha_ticket.substring(5,7)+'/'+data.fecha_ticket.substring(0,4)+' '+ data.fecha_ticket.substr(-8)+`<br><br>
                                Actualizada el:<br>
                                `+data.updated_at.substring(8,10)+'/'+data.updated_at.substring(5,7)+'/'+data.updated_at.substring(0,4)+' '+ data.updated_at.substr(-8)+`<br>
								Tipo de Cafe:<br><br>
								`+data.tipo_cafe+`
								`;
                    }
                },
                {
                    data:null,name:'000_catalogo_empresas.nombre',name:'placa',
                    render: function (data){
						let html = `<h5>Proveedor</h5>`;

                                if(data.proveedor!=null){
                                    html +=data.proveedor+`<br>`+data.proveedor_nit+`-`+data.proveedor_digito_verificacion_nit+`<br><br>`;
                                }
                                html +=`<h5>Conductor</h5>`;

								if(data.conductor!=null){
                                    html +=data.conductor+`<br>`+data.conductor_nit+`-`+data.conductor_digito_verificacion_nit+`<br><br>`;
                                }
                                html +=`Placa Vehiculo: `+data.placa;
								return html;
                    }
                },
                {
					data: null,
                    render: function (data){
						let html = `
						        <div class="row">
                                    <div class="col-6">
                                        Peso Entrada:
                                    </div>
                                    <div class="col-6">
                                        `+number_format(data.peso_salida,0,',','.')+`
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        Peso Salida:
                                    </div>
                                    <div class="col-6">
										`+number_format(data.peso_entrada,0,',','.')+`
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        Peso Bruto:
                                    </div>
                                    <div class="col-6">
										`+number_format(data.peso_bruto,0,',','.')+`
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        Tara:
                                    </div>
                                    <div class="col-6">
                                        `+number_format(data.tara,0,',','.')+`
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        Peso Neto:
                                    </div>
                                    <div class="col-6">
										`+number_format(data.peso_neto,0,',','.')+`
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        Factor:
                                    </div>
                                    <div class="col-6">
                                        `+number_format(data.factor,0,',','.')+`
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        Sacos:
                                    </div>
                                    <div class="col-6">
										`+number_format(data.cantidad_sacos,0,',','.')+`
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        Tulas:
                                    </div>
                                    <div class="col-6">
										`+number_format(data.catidad_tulas,0,',','.')+`
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <b>Liquidado:</b>
                                    </div>
                                    <div class="col-6">
										`+number_format(data.liquidados,0,',','.')+`
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <b>Pendiente:</b>
                                    </div>
                                    <div class="col-6">
										`+number_format(data.pendientes,0,',','.')+`
                                    </div>
                                </div>`;

								return html;
                    }
                },
                {
                    data:null,name:'id',
                    render: function (data){
                             return  `
							<button type="button" class="btn btn-primary liquidar" data-tipo_cafe="`+data.tipo_cafe+`" data-id="`+data.id+`" data-proveedor_id="`+data.proveedor_id+`" data-toggle="modal"  data-target="#modal-lg"><i class="fa fa-money-bill" aria-hidden="true"></i></button>
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
        //cargar tabla con el proveedor despues de liquidar un proveedor
        $(function() {
            if(@json($id)!=0){
                let id=@json($id);
                alert(id);
                tabla.ajax.url('{{ asset("liquidaciones/entrada/listado/data")}}?id_prov='+id).load();
                $(".prov option[value="+ id +"]").attr("selected",true);
                $('.prov').change();
            }
        });

        $(document).on('click','.consultar',function(){ 
            let fecha_inicial=$('.fi').val();
			let fecha_final=$('.ff').val();
            let id=$('.prov option:selected').val();
			if(fecha_inicial!=''&&fecha_final!=''){
				tabla.ajax.url('{{ route("liquidaciones.entradas.listado.data") }}?fecha_inicial='+fecha_inicial+'&fecha_final='+fecha_final+'&modo=0'+'&id_prov='+id).load();
                
			}else{
				alert('Ingrese fechas');
			}
		});
    //cargar tabla con el ultimo liquidado

    /*$.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex) {
                                                        //indice de la columna
                var columna_timestamp = new Date(data[1].substring(6,10)+'-'+data[1].substring(3,5)+'-'+data[1].substring(0,2)).getTime();
                if (timeInit && !isNaN(timeInit)) {
                    if(columna_timestamp < timeInit){
                        return false;
                    }
                }
                if (timeEnd && !isNaN(timeEnd)) {
                    if(columna_timestamp > timeEnd){
                        return false;
                    }
                }
                return true;
            }
        );*/
     

     /*   $('#customDateFilter').daterangepicker(
            {
                showDropdowns:true,
                locale: configDatepicker
            },
            function(start,end,label)
            {
                console.log(start);
                timeInit = new Date(start).getTime();
                timeEnd = new Date(end).getTime();
                tabla.draw();
            }
        );*/
    });
        
    </script>
@stop
