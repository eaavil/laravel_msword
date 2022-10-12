@extends('template.main')

@section('contenedor_principal')

@if(\App\Http\Controllers\AuthController::checkAccessModule('contratos.compra.registrar',session('role_id')))
        @include('plantillas.modals.registro_edicion')
    @endif
  
    

<div class="col-12">
    <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
                 
                <button class="btn btn-info nuevo" style="float:right" data-toggle="modal" data-target="#modal-lg"><i class="fa fa-plus nuevo"></i>Nueva plantilla</button>
                <button  class="btn btn-secondary" style="float:left" data-toggle="modal" data-target="#modal-2"><i class="fas fa-file"></i> Reporte corte compras/ventas</button><br><br><br>
                <button  class="btn btn-secondary" style="float:left" data-toggle="modal" data-target="#modal-lgr"><i class="fas fa-file"></i> Reporte general</button>
              <table id="main" class="table table-bordered table-striped" width="100%">
                <thead>
                <tr>
                  <th>Nombre</th>
                  <th>Ruta</th>
                  <th >fecha</th>
                  <th >Acciones</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
                <div class="row">
                    <div class="col-4">
                        Resumen<br>
                        <b>Total Kilogramos:</b> <span class="dx1"></span><br>
                        <b>Total Valor Contrato:</b> <span class="dx2"></span>
                    </div>
                    <div class="col-4">
                        Filtrar por Fechas
                        <input type="text" class="form-control float-right" id="customDateFilter">
                    </div>
                </div>


            </div>
            <!-- /.card-body -->
            </div>
          <!-- /.card -->
    </div>
    <div>@include('contratos.003_contratos.modals.reporte_entradas_compra_venta')</div>
    @include('contratos.003_contratos.modals.reporte_entradas_compra')
   
   
   
@stop

@section('scripts-bottom')
<style>
@media(max-width:670px){
    .d{display:none}
}

</style>
<script>
		var cont=0;
		$(document).on('click','.terminar',function(){
			var id= $(this).attr('data-id');
		
            if(@json($session)==1){
                if(confirm('Estas seguro que deseas deshabilitar el registro seleccionado?')){
                    window.location='{{ asset("contratos/terminar") }}/'+id;
                }
            }else{
                alert('No tiene permisos para realizar esta accion');
            }
				
			
		});
        function verificar_existencia(id){
            let existencia=1;
            let num=0;
             let tabla='.origen_compra tbody';
            if(cont==1){
              tabla='.origen tbody';  
            }
                $.each($(tabla),function(i,v){
                    if (typeof $(this).find('input[name="entrada[]"]').val() !== 'undefined'){//si la variable esta definida
                        num=$(this).find('input[name="entrada[]"]').val();
                    if(num==id){//si el articulo ya esta agregado
                        existencia=0;
                    }
                    }
            })
            return existencia
        };
        $(document).on('change',".articulo",function (evt) {
            let tabla='.origen_compra tbody';
            let id_categoria=$(".articulo option:selected").val();
           
            if(cont==1){
              tabla='.origen tbody';  
              id_categoria=$(".edi option:selected").val();
            }
            //cargar articulos del contrato
            $.getJSON('{{ route("contrato.articulos")}}?modo=1&id_categoria='+id_categoria,function(dx){
				$.each(dx,function(i,v){
                    if(verificar_existencia(v.id)!=0){//si el articulo no esta cargado se ingresa y no se carga nuevamente al editar
                   
                    $(tabla).append(cargar_tabla(v));
                } 
				})
			});
        });
		$(document).on('click','.habilitar',function(){
			var id= $(this).attr('data-id');
            var proveedor=$(this).attr('data-proveedor');
           
            if(proveedor>0){
			if(confirm('Esta seguro de habilitar el contrato seleccionado?')){
				window.location='{{ asset("contratos/compra/habilitar") }}/'+id;
			}
            }else{
                alert('sin proveedor asociado');
            }
		});
         ////formatear miles
         $(document).on('keyup',"[type='text']",function (evt){
        if(cont==1){//editar
            $.each($('.origen tbody tr'),function(i,v){
                var num = $(this).find('input[name="valor[]"]').val().replace(/\./g,'');
                num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
                num = num.split('').reverse().join('').replace(/^[\.]/,'');
                $(this).find('input[name="valor[]"]').val(num);
                var num2 = $(this).find('input[name="descuento[]"]').val().replace(/\./g,'');
                num2 = num2.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
                num2 = num2.split('').reverse().join('').replace(/^[\.]/,'');
                $(this).find('input[name="descuento[]"]').val(num2);

            
            });
        }else{//crear
             $.each($('.origen_compra tbody tr'),function(i,v){
                var num = $(this).find('input[name="valor[]"]').val().replace(/\./g,'');
                num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
                num = num.split('').reverse().join('').replace(/^[\.]/,'');
                $(this).find('input[name="valor[]"]').val(num);
                 var num2 = $(this).find('input[name="descuento[]"]').val().replace(/\./g,'');
                num2 = num2.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
                num2 = num2.split('').reverse().join('').replace(/^[\.]/,'');
                $(this).find('input[name="descuento[]"]').val(num2);
            
            });   
        }
        });
        $('title').html('{{ $titulo }}');
        //totalizar item
        $(document).on('change',"[type='text']",function (evt) {
            //calcular total y sumar al+
         var total2=1;
         if(cont==1){
            $.each($('.origen tbody tr'),function(i,v){
                
				var temp =$(this).find('input[name="cantidad[]"]').val().replace(/\./g,'');//eliminar punto
                var temp2 =$(this).find('input[name="valor[]"]').val().replace(/\./g,'');
                var temp3 =$(this).find('input[name="descuento[]"]').val().replace(/\./g,'');
                var total=( temp * temp2-temp3);
                
               
                total = total.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
                total = total.split('').reverse().join('').replace(/^[\.]/,'');//formatear con punto
			
                if(cont==0){
                    $(this).find('input[name="articulo_total[]"]').val(total);//mostrar en input
                }else{
                    $(this).find('input[name="articulo_total[]"]').val(total);//mostrar en input
                }
               //$(this).find('input[name="uf[]"]').val(number_format(total_uf, 2));
               
 
            })
        }else{
            $.each($('.origen_compra tbody tr'),function(i,v){
                
				var temp =$(this).find('input[name="cantidad[]"]').val().replace(/\./g,'');//eliminar punto
                var temp2 =$(this).find('input[name="valor[]"]').val().replace(/\./g,'');
                var temp3 =$(this).find('input[name="descuento[]"]').val().replace(/\./g,'');
                var total=( temp * temp2-temp3);
                
               
                total = total.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
                total = total.split('').reverse().join('').replace(/^[\.]/,'');//formatear con punto
			
                if(cont==0){
                    $(this).find('input[name="articulo_total[]"]').val(total);//mostrar en input
                }else{
                    $(this).find('input[name="articulo_total[]"]').val(total);//mostrar en input
                }
               //$(this).find('input[name="uf[]"]').val(number_format(total_uf, 2));
               
 
            }) 
        }
        totalizar();
        });
        //totalizar general
        function totalizar(){

            let neto = 0;
            let iva = 0;
            let total = 0;
            let crear_compra=0;
            var tabla="";
            if(cont==1){
                tabla=$('.origen tbody tr');
            }else{
               tabla=$('.origen_compra tbody tr');
            }
            $.each(tabla,function(i,v){
                /*if($(this).find('input[name="servicio[]"]').val()==0){
                    crear_compra++;  
                }*/
              
                neto+= parseInt($(this).find('input[name="articulo_total[]"]').val().replace(/\./g,''));//sumar totales eliminando punto
               
            });
            iva=parseInt(neto*0.19);
            total=parseInt(neto+iva);
            neto = neto.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
            neto = neto.split('').reverse().join('').replace(/^[\.]/,'');//formatar con punto
            iva = iva.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
            iva = iva.split('').reverse().join('').replace(/^[\.]/,'');//formatar con punto
            total = total.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
            total = total.split('').reverse().join('').replace(/^[\.]/,'');//formatar con punto
           
            if(cont==0){
                $('.tc1').val(neto);//mostrar en input constrato stock
                $('.tc2').val(iva);
                $('.tc3').val(total);
            }else{
                $('.t1').val(neto);//mostrar en input contrato instalacion
                $('.t2').val(iva);
                $('.t3').val(total);
            }
            
            $('.servicio').val(crear_compra);
        };
        //remover despacho
        $(document).on('click','.remove-despacho',function(){
            let id = $(this).attr('data-id');
            $('.oc'+id).remove();
            totalizar();
        });
         //enviar formulario
         $(document).on('click','.trigger_formc',function(){
            let id = $(this).attr('target');
            $('.'+id+' > .act_form').trigger('click');
		})
        //limpiar campos al cambiar formulario
        $(document).on('click','.nuevo',function(){
            //$('.articulo').prop('selectedIndex',0);
            $(".origen tbody").html("");
            $('.prov').val(-1);
            $(".prov").change();
            $('.cor').val(@json($correlativo));
            $(".modal-title").text("Registrar plantilla");
            cont=0;
            //verificar datos esten llenos con each
		})
        //volver contador 0 al cerrar formulario
        $(document).on('click','.recargar',function(){
             cont=0;
             $('.prov').val(-1);
            $(".prov").change();
        });
        //cargar tabla
        function  cargar_tabla(v){
        let cantidad=0;
         let nombre=v.nombre;
        let valor=number_format(v.valor*@json($dolar),0,',','.');
        if(cont==1){//si es editar
            cantidad=number_format(v.disponible*-1,0,',','.');
            valor=number_format(v.disponible*-1*v.valor_compra,0,',','.');
         
        }else{
            valor=0;
        }
                           
        let  tabla=  `<tr class="oc`+v.id_articulo+`">
              <td width="41%">`+v.nombre+ `<input type="hidden" name="entrada[]" value="`+v.id_articulo+`" </td>
                <td> <input type="text" name="cantidad[]" style="width:50%" value="`+cantidad+`"/> UN</td>
                <td>$ <input type="text"  max="100" name="valor[]" style="width:50%" value="`+number_format(v.valor_compra,0,',','.')+`"/></td>
                <td>$ <input type="text"  max="100" name="descuento[]" style="width:50%" value="`+number_format(v.descuento,0,',','.')+`"/></td>
                <td>$ <input type="text"  readonly  name="articulo_total[]" style="width:50%" value="`+valor+`"/></td>
               
				<td>
					
					<button type="button" class="btn btn-danger remove-despacho" title="Remover" data-id="`+v.id_articulo+`">
						<i class="fa fa-trash" aria-hidden="true"></i>
					</button>
				</td>
          </tr> `;
                  
        return tabla};
        $(document).on('click','.edit',function(){ 
            // sumar contador para cambiar de ruta al enviar form
            cont=1;
            $(".origen tbody").html("");
            $(".modal-title").text("Editar Plantilla");
            var id_contrato= $(this).attr('data-id');
            var id= $(this).attr('data-id');
            if(id_contrato==0){
                id_contrato=id;
            }
             id_proveedor= $(this).attr('data-proveedor');
             let numero=$(this).attr('data-numero');
             let id_categoria=$(this).attr('data-id_categoria');
             let valor=$(this).attr('data-valor');
             $('.cot').val($(this).attr('data-cotizacion'));
             $(".c01").val(numero);
             $('.factura').val($(this).attr('data-factura'));
             if(id_proveedor!=null){
                 $('.prov').val(id_proveedor);
                 $(".prov").change();//actualizar vista
             }
             $(".salida").val(id);
             $(".cor").val(numero);
            let total=0;
            let neto=0;
            let iva=0;
            let total_general=0;
            $.getJSON('{{ route("contratos.compras.data")}}?id='+id_contrato,function(dx){//cargar tabla
             
              $.each(dx,function(i,v){
                if( v.disponible < 0 || v.id_catalogo_empresa_cliente==-1){
                  total=v.cantidad*v.valor_compra;
                  $('.origen tbody').append(cargar_tabla(v)); 
                };
         totalizar();  
        })
        
          });
        
       });
       $(document).on('click','.nuevo',function(){

        $('.nombre').val("");

        var input = $('.archivo');
        var clon = $('.archivo').clone();  // Creamos un clon del elemento original
        input.replaceWith(clon);
       
        });
       
        $(document).on('click','.print',function(){
            var id= $(this).attr('data-id');

            window.open("{{ asset('contratos/compra/imprimir') }}/"+id);
        });


        $('.calculator').keyup(function(){
            let pa = parseFloat($('.pa').val().replaceAll('.',''));
            
            let ck = parseFloat($('.ck').val().replaceAll('.',''));
          
            if(ck!='' && pa!=''){
                $('.res').val(Math.round(parseInt(ck)*(parseInt(pa)/12.5)))
                $('.pk').val(Math.round((parseInt(pa)/12.5)))
            }
        })

        $('.calculatorx').keyup(function(){
            let pa = parseFloat($('.pax').val().replaceAll('.',''));
            let ck = $('.ckx').val().replace('.','')
            if(ck!='' && pa!=''){
                $('.resx').val(Math.round(parseInt(ck)*(parseInt(pa)/12.5)))
                $('.pkx').val(Math.round((parseInt(pa)/12.5)))
            }
        })

        $(document).on('click','.delete',function(){
            if(@json($session)==1){
                if(confirm('Estas seguro que deseas eleminar el registro seleccionado?')){
                    var id= $(this).attr('data-id');
                    window.location='{{ asset("contratos/eliminar") }}/'+id;
                }
            }else{
                alert('No tiene permisos para realizar esta accion');
            }
        });

        var tabla = $('#main').DataTable({
            serverSide:true,
            paging: true,
            order:[[1, 'desc']],
            pageLength: 20,
            ajax: {
                url: '{{ route("contratos.compras.data") }}',
                dataSrc: 'data',
                type:'post'
            },
            columns: [
                {
                    data: null,name:'nombre',
                    render: function (data){
                        //return data.numero+"<br><br> Creado el:<br>"+data.fecha_contrato.substring(8,10)+'/'+data.fecha_contrato.substring(5,7)+'/'+data.fecha_contrato.substring(0,4)+"<br><br>Actualizado el:<br>"+data.updated_at.substring(8,10)+'/'+data.updated_at.substring(5,7)+'/'+data.updated_at.substring(0,4);
                        return data.nombre;
                    }
                },
                {
                    data: "plantilla",name:'plantilla',
                    render: function (data){
                 
                        //return data.numero+"<br><br> Creado el:<br>"+data.fecha_contrato.substring(8,10)+'/'+data.fecha_contrato.substring(5,7)+'/'+data.fecha_contrato.substring(0,4)+"<br><br>Actualizado el:<br>"+data.updated_at.substring(8,10)+'/'+data.updated_at.substring(5,7)+'/'+data.updated_at.substring(0,4);
                        return  "<a href="+data+">descargar</a>";
                    }
                },
                {
                    data: "created_at",name:'created_at',
                    render: function (data) {
                        return data.substring(8,10)+'/'+data.substring(5,7)+'/'+data.substring(0,4);
                    }
                    
                },
                {
                    "data": null,name:'id',
                    "render": function (data) {
							var html = '';
							if(parseInt(data.estado)==2){
                                html = '<button style="width: 26px; height:26px; padding:0px" data-id="'+data.id+'" class="btn btn-default terminar "  title="Culminar Registro"><i class="fa fa-times"></i></button> \ ';
								
							}else{
								html = '<button style="width: 26px; height:26px; padding:0px" data-id="'+data.id+'" data-proveedor="'+data.id_catalogo_empresa_proveedor+'" class="btn btn-default habilitar" title="Reactivar Registro"><i class="fa fa-check"></i></button> \ ';
							}
							
                            return html+'<button style="width: 26px; height:26px; padding:0px"  data-id="'+data.id+'" class="btn btn-success print"><i class="fa fa-print"></i></button> \
                                <button style="width: 26px; height:26px; padding:0px" data-target="#modal-lg" data-toggle="modal" data-id="'+data.id+'" data-id_contrato="'+data.id_contrato+'" data-numero="'+data.numero+'" data-cotizacion="'+data.cotizacion+'" data-factura="'+data.factura+'" data-proveedor="'+data.id_catalogo_empresa_proveedor+'" class="btn btn-info edit"><i class="fa fa-pencil-alt"></i></button> \
                                <button style="width: 26px; height:26px; padding:0px" class="btn btn-danger delete" data-id="'+data.id+'"><i class="fa fa-trash"></i></button>';
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

        $.fn.dataTable.ext.search.push(
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
        );
   
</script>
@stop
