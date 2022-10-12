@extends('template.main')

@section('contenedor_principal')

<script type="text/javascript" src="jquery/jquery.number.min.js"></script>

<div class="col-12">
    <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
     
                
                <button  class="btn btn-secondary" style="float:left" data-toggle="modal" data-target="#modal-lgr"><i class="fas fa-file"></i> Reporte general</button>

              <table id="main" class="table table-bordered table-striped" >
                <thead>
                <tr>
                <th WIDTH="5%" >Cliente</th>
                <th>Celular</th>
                <th>Neto</th>
                <th>Iva</th>
                <th>Total</th>
                <th>Correo</th>
                <th>Estado</th>
                <th>Fecha</th>
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
    <div>
   
    </div>
    <div>
   
    </div>

 
   
@stop

@section('scripts-bottom')
<script>
var estado=1;
var cerrar=0;
var primera_fila=0;
var cont2=0;
var cont=0;
var cont_formulario=0;
var id_representante=0;
var neto=0;
var iva=0;
var total=0;
var seleccion_1="";
var seleccion_2="";
var seleccion_3="";
var desactivado="";
var dolar="";
var uf="";
var valor=0;
var contendio_tabla="";
var total=0;
var item=1;
    $(document).ready(function(){
	
    function cargar_tabla(v){
        seleccion_1="";
        seleccion_2="";
        seleccion_3="";
         desactivado="";
            if(item>=8){
                 $('.body-registro').css({'height':'600px'});
              }else{
                  
                  $('.body-registro').css({'height':'100%'});
              }
            //si existe aumento para editar
            let comentario=v.comentario;
            if(typeof comentario == 'undefined'){
                comentario="";
            }
            if(v.aumento==05){
                seleccion_1="selected";
            }
            if(v.aumento==08){
                seleccion_2="selected";
            }
              if(v.aumento==1){
                seleccion_3="selected";
            }

             //si es servicio no hay aumento          
           if(v.es_servicio==1){
                desactivado="hidden";
                
                if(typeof v.total == 'undefined'){
                    valor=0;
                    total=0; 
                }else{
                    //si es mantencion
                    if(v.categoria==2){
                    valor=v.valor_detalle;
                    total=v.valor_detalle;  
                    }else{
                        valor=number_format(v.valor_detalle,0,',','.');
                        total=number_format(v.valor_detalle,0,',','.');  
                    }
                }
                
                
            }else{
                valor=number_format(v.valor*1,0,',','.');
                total=number_format(v.total,0,',','.');
                desactivado="";
            }
            //cambiar al editar
           if(cont2!=0){
                valor=number_format(v.valor_detalle,0,',','.');
                total=number_format(v.total,0,',','.');
           }
          
            contenido_tabla=`
                <tr class="oc`+v.id+`">
                    <td width="41%">`+v.nombre+`<input type="hidden" name="entrada[]" value="`+v.id+`" </td>
                    <td> `+number_format(v.stock,0,',','.')+`  UN<input type="hidden"  name="disponible[]" readonly style="width:50%" value="`+number_format(v.stock,0,',','.')+`"/></td>
                    <td> <input type="text" name="cantidad[]" style="width:50%;background:#FBD03D;" value="`+number_format(v.cantidad,0,',','.')+`"/> UN</td>
                    <td>
                        <input type="hidden"  class="comentario`+v.id+item+`" max="100" name="comentario[]" style="width:50%" value="`+comentario+`"/> 
                        <input type="hidden"  max="100" name="ser_detalle[]" style="width:50%" value="`+number_format(v.es_servicio,0,',','.')+`"/>
                        <input type="hidden"  max="100" name="valor_compra[]" style="width:50%" value="`+number_format(v.valor_compra,0,',','.')+`"/>
                        `+dolar+` <input type="text"  max="100" name="valor[]" style="width:75%;background:#FBD03D;" value="`+valor+`"/>
                    </td>
                    <td><select type="text" required name="aumento[]" style="width:50%;background:#FBD03D;" >
                        <option `+seleccion_1+`  value="0.5" `+desactivado+`>50</option>
                        <option `+seleccion_2+`  value="0.8" `+desactivado+`>80</option>
                        <option  `+seleccion_3+`  value="1" `+desactivado+`>100</option>`
            ; 
             //si es servicio no hay aumento     
            if(v.es_servicio==1){
                contenido_tabla+=`<option value="0" selected>0</option>`;
            }
            contenido_tabla+=`</select> % </td>
            <td>`+dolar+` <input type="text"  readonly  name="total[]" style="width:75%;background:#FBD03D;" value="`+total+`"/>
            <input type="hidden"  readonly  name="uf[]" style="width:30%" value="`+v.total_uf+`"/> `+uf+` </td>
            <td>
                <button type="button" class="btn btn-warning comentario" data-toggle="modal" data-target="#modal-lgc" title="Comentario" data-id="`+v.id+`"  data-item="`+item+`">
                        <i class="fa fa-th-list" aria-hidden="true"></i>
                </button> 
                <button type="button" class="btn btn-danger remove-despacho" title="Remover" data-id="`+v.id+`">
                    <i class="fa fa-trash" aria-hidden="true"></i>
                </button>
            </td>
            </tr>`; 
    return contenido_tabla;}	

    $(document).on('click','.terminar',function(){
                var id= $(this).attr('data-id');
                if(confirm('Esta seguro de devolver el contrato seleccionado?')){
                    window.location='{{ asset("contratos/terminar") }}/'+id;
                }
    });

    $(document).on('click','.habilitar',function(){
       
			var id= $(this).attr('data-id');
            var orden= $(this).attr('data-orden');
           /*if(orden!=0){
			if(confirm('Esta seguro de habilitar el contrato seleccionado?')){
				
            }
            }else{
                alert("ingrese orden de trabajo");
            }*/
            window.location='{{ asset("contratos/habilitar") }}/'+id;
	});
    
    $(document).on('click','.edit',function(){
       item=1;
       estado= $(this).attr('data-estado');
       $('.representante').val($(this).attr('data-cliente'));
        $('.representante').change();
        $('.orden').val($(this).attr('data-orden'));
        $('.orden').change();
       limpiar();
       cont2++;
        $(".origen tbody").html("");
        $(".modal-title").text("Editar cotizacion de venta");
         
             var id= $(this).attr('data-id');
             $(".salida").val(id);
             var t_servicio=0;
             $.get('{{ route("contratos.ventas.data")}}?id='+id,function(dx){//cargar tabla
               
              $.each(dx,function(i,v){
                  $tipo_servicio=v.tipo_servicio;
                $('.Tipo_servico_2').removeClass('Tipo_servico');//apagar
                $('.Tipo_servico_2').val($tipo_servicio);
                $('.Tipo_servico_2').change();
                $('.Tipo_servico_2').addClass('Tipo_servico');//encender
               
                $('.tipo_obra').val(v.id_categoria);
                $('.cor').val(v.numero);
                neto=v.valor_neto;
                iva=v.valor_iva;
                total=v.valor_total;
                seleccion_1="";
                seleccion_2="";
                desactivado="";
                dolar="";
                uf="";
                if(v.tipo_servicio!=2){
                    dolar="$";
                    $('.t1').val(number_format(neto,0,',','.'));
                    $('.t2').val(number_format(iva,0,',','.'));
                    $('.t3').val(number_format(total,0,',','.'));
                }else{
                    uf="uf";
                    $('.t1').val(neto);
                    $('.t2').val(iva);
                    $('.t3').val(total);
                }
                
                   
              
                $('.origen tbody').append(cargar_tabla(v));
                   item++;
                   cont++;//contador para el change articulo
                   cont_formulario++;//contador para cambiar de ruta al enviar form
                   
              })
          },'json'
         )
        
    });    
    
    $(document).on('click','.comentario',function(){
        let id=$(this).attr('data-id');
        let item2=$(this).attr('data-item');
       $(".modal-title-comentario").text("Ingresar comentario");
       $('.comentario_text').val($('.comentario'+id+item2).val());
       $(".id_comentario").val(id+item2);
   
    });

    $(document).on('click','.anexo',function(){
         cont2++;
         cont_formulario=0;
          $(".origen tbody").html("");
          
             var id= $(this).attr('data-id');
             $(".salida").val(id);
             var t_servicio=0;
             $(".tip_servicio"). css("display", "none");
             $(".agre_art"). css("display", "block");
             $(".agre_art").removeClass("col-3")
             $(".agre_art").addClass("col-2");
             $(".agre_art").removeClass("col-3")
             $(".agre_art").addClass("col-2");

             $.get('{{ route("contratos.ventas.data")}}?id='+id,function(dx){//cargar datos
               
               $.each(dx,function(i,v){
                $(".modal-title").text("Realizar anexo al contrato "+v.numero);
                 $('.representante').val(v.id_catalogo_empresa_cliente);
                 $('.representante').change();//actualizar vista
                 $('.representante option:not(:selected)').attr('disabled', true);
                 $('.representante').prop('readonly', true);
                 $('.orden').val(v.orden_trabajo);
                 $('.orden').prop('readonly', true);
                 $('.tipo_obra').val(v.id_categoria);
                 $('.tipo_obra').prop('readonly', true);
                 $('.Tipo_servico').val(v.tipo_servicio);
                 $('.Tipo_servico').change();
                 if(v.cor_anexo!=null){
                    $('.cor').val(v.cor_anexo);
                    $('.cor_anexo').val(v.anexo);
                    $('.salida').val(v.id_contrato);
                    
                }
                 cont++;//contador para el change articulo
                    
               })
           },'json');

           $.get('{{ route("contrato.articulos")}}?modo=0&id_categoria='+1,function(dx){
                            $.each(dx,function(i,v){
                            $('.origen tbody').append(cargar_tabla(v));
            })
            },'json');
    });

    $(document).on('click','.trigger_form',function(){
        if(estado==1){
            let id = $(this).attr('target');
        if(cont_formulario>0){
            $('.frmc_0001').attr('action', "{{ route('contrato.actualizar') }}");
        }
        $('.'+id+' > .act_form').trigger('click');
        }else{
            alert('para actualizar debe deshabilitar el contrato');
        }    
    });

    $(document).on('click','.trigger_form_comentario',function(){
        let id=$('.id_comentario').val();//id + item para identificar los repetidos
        $('.comentario'+id).val($('.comentario_text').val());//cargar campo comentario en tabla
        $('#modal-lgc').modal('hide');
    });

    $(document).on('click','.close',function(){
        //$('.articulo').prop('selectedIndex',0);
        cerrar=1;
       
        $('.reparacion').val("");
        $(".reparacion").change();//actualizar vista
        $('.manutencion').val("");
        $('.manutencion').change();
        $('.representante').val("");
        $('.representante').change();//actualizar vista
        $('.articulo').val("");
        $(".articulo").change();
        $('.Tipo_servico').val("");
        $('.Tipo_servico').change();
        $('.cor').val(1);
        $('.orden').val("");
        $('.tipo_obra').val("");
        $('.t1').val("");
        $('.t2').val("");
        $('.t3').val("");
        cerrar=0;
        
    });
    function limpiar(){
        $(".rep"). css("display", "none");
        $(".agre_art"). css("display", "none");
        $(".man"). css("display", "none");
        $('.reset').val("");
        $(".reset").change();
    }
    $(document).on('click','.nuevo',function(){
        //$('.articulo').prop('selectedIndex',0);
        $(".origen tbody").html("");
        $('.origen tbody').append(`
            <td colspan="7" class="fila1">sin articulos</td>
        `);
        $(".modal-title").text("Registrar cotizacion de venta");
        limpiar();
        item=1;
        cont++;
        cont_formulario=0;
        cont2=0;
        //verificar datos esten llenos con each
    })

    $(document).on('click','.delete',function(){
        if(@json($session)==1){
            if(confirm('Estas seguro que deseas eliminar el registro seleccionado?')){
                var id= $(this).attr('data-id');
                window.location='{{ asset("contratos/eliminar") }}/'+id;
                tabla.ajax.url('{{route("contratos.ventas.data")}}');//actualizar ruta tabla
            }
        }else{
            alert('No tiene permisos para realizar esta accion');
        }
    });

    $(document).on('click','.print',function(){
        var id= $(this).attr('data-id');
        window.open('{{ asset("presupuesto/venta/comprobante") }}/'+id);
    });
    //agregar por servicio  
    $(document).on('change',".Tipo_servico",function (evt) {$option= $(".Tipo_servico option:selected").val();
                        $(".origen tbody").html("");
                        $(".agre_art").css("display", "block");
                        $(".rep").css("display", "none");
                        $(".man"). css("display", "none");
                        $('.reset').val("");
                        $(".reset").change();
                        if($option==2){
                                $(".origen tbody").html("");
                                $(".agre_art").css("display", "none");
                                $(".rep").css("display", "none");
                                $(".man"). css("display", "block");
                                $('.reset').val("");
                                $(".reset").change();
                                
                        }
                        if($option==3){
                            $(".origen tbody").html("");
                            $(".man"). css("display", "none");
                            $(".agre_art").css("display", "none");
                            $(".rep"). css("display", "block");
                            $('.reset').val("");
                            $(".reset").change();
                        }
                        if($option==4){
                            $(".origen tbody").html("");
                            $(".man"). css("display", "none");
                            $(".agre_art").css("display", "none");
                            $(".rep"). css("display", "none");
                            $('.reset').val("");
                            $(".reset").change();
                        }
                        if($option==""){
                            
                            $(".rep"). css("display", "none");
                            $(".agre_art"). css("display", "none");
                            $(".man"). css("display", "none");
                            $('.reset').val("");
                            $(".reset").change();
                            
                        }
    });
    //agregar instalacion
    $(document).on('change',".articulo",function (evt) {
        item=1;
        $(".origen tbody").html("");
        let id_categoria=$(".articulo option:selected").val();
        
         if(id_categoria!='' && cerrar==0){
        //cargar articulos del contrato
        $.get('{{ route("contrato.articulos")}}?id_categoria='+id_categoria,function(dx){
        
            $.each(dx,function(i,v){
                if(verificar_existencia(v.id)!=0&&cont>0){//si el articulo no esta cargado se ingresa y no se carga nuevamente al editar
                $('.origen tbody').append(cargar_tabla(v));
                item++;
                
            } 
            })
        },'json');
         //agregar mano de obra a la tabla
        $.get('{{ route("contrato.articulos")}}?modo=0&id_categoria='+1,function(dx){
            $.each(dx,function(i,v){
            $('.origen tbody').append(cargar_tabla(v));
    
        })}
        ,'json');
    }
    });
    //agregar mantencion
    $(document).on('change',".mantencion",function (evt) {
        item=1;
         $(".origen tbody").html("");
        let id_categoria=$(".mantencion option:selected").val();
        //cargar articulos del contrato
        if(id_categoria!='' && cerrar==0){
        $.get('{{ route("contrato.articulos")}}?modo=1&id_categoria='+id_categoria,function(dx){
        
            $.each(dx,function(i,v){
               //si el articulo no esta cargado se ingresa y no se carga nuevamente al editar
               
                $('.origen tbody').append(cargar_tabla(v));
                item++;
            })
            },'json');
        }
    }); //agregar todos, individual
    $(document).on('change',".todos",function (evt){
       cont2=0;
     
        if($('.fila1').text()=="sin articulos"){
            $(".origen tbody").html("");
        }
        let id_categoria=$(".todos option:selected").val();
            
       $.get('{{ route("contrato.articulos")}}?modo=1&id_categoria='+id_categoria,function(dx){
        
        $.each(dx,function(i,v){
            let tabla=cargar_tabla(v);
            $('.origen tbody').append(cargar_tabla(v));
        item++;
        })
        },'json');
    });
     //agregar reparacion
    $(document).on('change',".reparacion",function (evt) {
        item=1;
         $(".origen tbody").html("");
        let id_categoria=$(".reparacion option:selected").val();
        //cargar articulos del contrato
        if(id_categoria!='' && cerrar==0){
        $.get('{{ route("contrato.articulos")}}?modo=1&id_categoria='+id_categoria,function(dx){
            
        
            $.each(dx,function(i,v){
               
                if(verificar_existencia(v.id)!=0&&cont>0){
                    //si el articulo no esta cargado se ingresa y no se carga nuevamente al editar
                    
                
                $('.origen tbody').append(cargar_tabla(v));
                item++;
                
            } 
            })
        },'json');
        }
    });
     /*   //agregar anexo
    $(document).on('change',".reparacion",function (evt) {
        let id_categoria=$(".reparacion option:selected").val();
        //cargar articulos del contrato
        if(id_categoria!=''){
        $.get('{{ route("contrato.articulos")}}?modo=1&id_categoria='+id_categoria,function(dx){
        
            $.each(dx,function(i,v){
                if(verificar_existencia(v.id)!=0&&cont>0){//si el articulo no esta cargado se ingresa y no se carga nuevamente al editar
                $('.origen tbody').append(cargar_tabla(v));
              
            } 
            })
        },'json');
        }  
    });*/
    //formatear miles
    $(document).on('keyup',"[type='text']",function (evt){
        $.each($('.origen tbody tr'),function(i,v){
            if($('.Tipo_servico').val()!=2){
            var num = $(this).find('input[name="valor[]"]').val().replace(/\./g,'');
            num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
            num = num.split('').reverse().join('').replace(/^[\.]/,'');
            
            $(this).find('input[name="valor[]"]').val(num);
            }
        });
    });
 
     $(document).on('click',".destacar_cotizacion",function(){
           
            let id_cotizacion= $(this).attr('data-id');
         $.getJSON('{{ route("destacar.cotizacion") }}?id_cotizacion='+id_cotizacion);
           //tabla.ajax.url('{{ route("articulo.destacar") }}?id_articulo='+id+'&id_articulo_categoria='+id_articulo_categoria).draw();
    });
    
     $(document).on('click',".destacar_factura",function(){
           
        let id_cotizacion= $(this).attr('data-id');
         $.getJSON('{{ route("destacar.factura") }}?id_cotizacion='+id_cotizacion);
           //tabla.ajax.url('{{ route("articulo.destacar") }}?id_articulo='+id+'&id_articulo_categoria='+id_articulo_categoria).draw();
    });
        
    function verificar_existencia(id){
        let existencia=1;
        let num=0;
        let servicio=0;
        $.each($('.origen tbody tr'),function(i,v){
                if (typeof $(this).find('input[name="entrada[]"]').val() !== 'undefined'){//si la variable esta definida
                    num=$(this).find('input[name="entrada[]"]').val();
                    servicio=$(this).find('input[name="servicio[]"]').val();
                if(num==id && servicio!=1){//si el articulo ya esta agregado
                    existencia=0;
                }
                }
        })
        return existencia
    };
    //total general
    function totalizar(){
        let neto = 0;
        let iva = 0;
        let total = 0;
        let crear_compra=0;
        
        $.each($('.origen tbody tr'),function(i,v){
            
            if($(this).find('input[name="servicio[]"]').val()==0){
                crear_compra++;  
            }
            if($('.Tipo_servico').val()!=2){
            neto+= parseInt($(this).find('input[name="total[]"]').val().replace(/\./g,''));//sumar totales eliminando punto
           }else{
            neto+=parseFloat($(this).find('input[name="total[]"]').val()); 
           }
        });
        if($('.Tipo_servico').val()!=2){
            
            iva=parseInt(neto*0.19);
            total=parseInt(neto+iva);
            neto = neto.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
            neto = neto.split('').reverse().join('').replace(/^[\.]/,'');//formatar con punto
            iva = iva.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
            iva = iva.split('').reverse().join('').replace(/^[\.]/,'');//formatar con punto
            total = total.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
            total = total.split('').reverse().join('').replace(/^[\.]/,'');//formatar con punto
        }else{
            iva=neto*0.19;
            iva=parseFloat(iva.toFixed(2));
            total=parseFloat(neto+iva).toFixed(2);
        }
        //mostrar en input
        $('.t1').val(neto);
        $('.t2').val(iva);
        $('.t3').val(total);
        $('.servicio').val(crear_compra);
    };
  
        
    $(document).on('click','.remove-despacho',function(){
        let id = $(this).attr('data-id');
        $('.oc'+id).remove();
        totalizar();
    });
     

    var tabla = $('#main').DataTable({
        serverSide:true,
        paging: true,
        order:[[1, 'desc']],
        pageLength: 20,
        ajax: {
            url: '{{ route("tienda.data") }}',
            dataSrc: 'data',
            type:'post'
        },
        columns: [
            {data:'nombre',name:'nombre'},
            {data:'numero_telefono_1',name:'numero_telefono_1'},
            {data:'neto',name:'neto'},
            {data:'iva',name:'iva'},
            {data:'total',name:'total'},
            {data:'email_empresa',name:'email_empresa'},
            {
                "data": null,name:'estado',
                "render": function (data) {
                    var html='';
                    if(data.estado==0){
                            html=html+' <span class="badge badge-primary" style="font-size:12px">Creado</span>'
                    }
                    if(data.estado==1){
                        html=html+' <span class="badge badge-info" style="font-size:12px">Pendiente por revision</span>'
                    }
                    if(data.estado==2){
                        html=html+' <span class="badge badge-danger" style="font-size:12px">Finalizado</span>'
                    }
                  
                    return html;
                }
                },
            
            {
                data: null,name:'created_at',
                render: function (data) {
                    return data.created_at;
                }
            },
            {
                data: null,name:'id',
                "render": function (data){
                       
                        return '<button style="width: 26px; height:26px; padding:0px" data-target="#modal-lg" data-toggle="modal"  data-id="'+data.id+'" data-orden="'+data.id_orden_trabajo+'" data-estado="'+data.contrato_estado+'"  data-cliente="'+data.id_catalogo_empresa_cliente+'" class="btn btn-info edit"><i class="fa fa-pencil-alt"></i></button> \
                            <button style="width: 26px; height:26px; padding:0px" class="btn btn-danger delete" data-id="'+data.id+'"><i class="fa fa-trash"></i></button>\
                                <button style="width: 26px; height:26px; padding:0px" class="btn btn-success print" data-id="'+data.id+'"><i class="fa fa-print"></i></button>';
                }
            },
        ],language: langDataTable,
    });
    $(document).on('click','.recargar',function(){
        cont=0;
    });
    

});
</script>
<style>
</style>
@stop

