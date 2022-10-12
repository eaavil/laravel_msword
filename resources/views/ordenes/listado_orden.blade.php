
@extends('template.main')

@section('contenedor_principal')

    @if(\App\Http\Controllers\AuthController::checkAccessModule('bancos.registrar',session('role_id')))
        @include('ordenes.modals.registro_edicion')
    @endif
<div class="col-12">
    <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
                <button class="btn btn-info nuevo" style="float:right" data-toggle="modal" data-target="#modal-lg"><i class="fa fa-plus "></i> Nueva orden</button>
               
                <table id='main' class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th >Nombre</th>
                  <th >Cliente</th>
                  <th >Servicio</th>
                  <th >Estado</th>
                  <th >Contrato</th>
                  <th >Creado</th>
                  <th >P.</th>
                  <th >Acciones</th>
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

    <style>
  
    </style>


@stop

@section('scripts-bottom')
    <script>
    var cont_formulario=0;
    var id;
    var id_lista;
    var nombre_lista;
    var edicion=0;
    var categoria;
    var item=0;
    
    $(document).ready(function(){

      //  $.jGrowl("Hello world!",{ life : 2000});
                 
                $(".agre_art").css("display", "none");
                
    
    function cargar_tabla(elementos){
        let cantidades=0;
        let elementos_html="";
        let array_cantidades='cantidades[]';
        let valor_oculto="";
        //armamos la celda de elementos
        $.each(elementos,function(i,v){
            if(edicion!=0){
                nombre_lista=v.nombre;
                id_lista=v.id_servicio;
                cantidades=v.cantidades;
                valor_oculto=v.id_servicio+';'+v.id+';'+cantidades;
            }
            elementos_html+=`
                <input type="hidden" class="registrar_cantidad_oculto`+v.id+`"  name="`+array_cantidades+`" style="width:5%;background:#FBD03D;-webkit-appearance: none; margin:0" value="`+valor_oculto+`" /> 
                `+v.item+`
                <input type="text" class="registrar_cantidad" id_elemento="`+v.id+`" id_lista="`+id_lista+`" style="width:10%;background:#FBD03D;" value="`+cantidades+`"/> 
            `;
        });
        if(elementos_html==""){
            elementos_html='sin elementos';
        }
      
        if(item==1 && edicion==0){
                $(".elementos tbody").html("");
        }
             
           
            contenido_tabla=`
                <tr class="oc`+id_lista+`">
                    <td> 
                    `+nombre_lista+`
                    </td>
                    <td>
                    `+elementos_html+`
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger Remover" title="Remover" data-id="`+id_lista+`">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </button>
                    </td>
                    `
                ;
            
    return contenido_tabla;} 
    //alimentar elemento y cantidades por lista
   $(document).on('keyup','.registrar_cantidad',function(){
        let cantidad=$(this).val();
        let id_elemento=$(this).attr('id_elemento');
        let id_lista=$(this).attr('id_lista');
        $('.registrar_cantidad_oculto'+id_elemento).val(id_lista+';'+id_elemento+';'+cantidad);
           
    });

   $(document).on('click','.Remover',function(){
        let item= $(this).attr('data-id');
        $('.oc'+item).remove();
        if($(".elementos tbody tr").length==0){
            $('.elementos tbody').append(`<td colspan="3" class="fila1">sin listas</td>`);
        }
       
    });

    function limpiar(){
           $(".id").val('');
           $(".cliente").val('').trigger('change');
           $(".descripcion").val("");
           $(".requerimiento_inicial").val('');
           $(".servicio_2").val("").trigger('change');
      
    }

    $(document).on('click','.nuevo',function(){
         $(".elementos tbody").html("");
        $('.elementos tbody').append(`
            <td colspan="3" class="fila1">sin listas</td>
        `);
        $(".modal-title").text("Registrar orden");
        edicion=0;
        item=0;
        cont=0;
        limpiar();
        /*
        cont++;
        cont_formulario=0;
        */
        //verificar datos esten llenos con each
    });
    $(document).on('click','.close',function(){
        
        document.getElementById("#modal-lg").reset();
    });

   
        $(document).on('change',".listas",function (evt){
            
            id_lista=$(".listas option:selected").val();
            nombre_lista=$(".listas option:selected").text();
            if(id_lista!=''){
                edicion=0;
                item++;
                $.getJSON('{{ asset("listar/elementos") }}/'+0+'/'+id_lista,function(elementos){
                    $('.elementos tbody').append(cargar_tabla(elementos));

                });
            }
        });
      
        $(document).on('click','.habilitar',function(){
       
            var id= $(this).attr('data-id');
            //var orden= $(this).attr('data-orden');
            /*if(orden!=0){
            if(confirm('Esta seguro de habilitar el contrato seleccionado?')){
                
            }
            }else{
                alert("ingrese orden de trabajo");
            }*/
            if(confirm('Esta seguro de habilitar la orden seleccionada?')){
            window.location='{{ asset("habilitar_orden") }}/'+id;
            }
        });

        $(document).on('click','.terminar',function(){
                var id= $(this).attr('data-id');
                if(confirm('Esta seguro de deshabilitar la orden seleccionada?')){
                    window.location='{{ asset("deshabilitar_orden") }}/'+id;
                }
         });

         $(document).on('click','.print',function(){
                var id= $(this).attr('data-id');
                window.open('{{ asset("imprimir_orden") }}/'+id);
         });

        $(document).on('click',".edit",function(){
            $(".elementos tbody").html("");
            $(".modal-title").text("Editar orden");
           
            edicion++;
            item=0;
            let sin_listas=0;
            limpiar();
           
            id= $(this).attr('data-id');
            cliente= $(this).attr('data-cliente');
            servicio= $(this).attr('data-servicio');
            descripcion= $(this).attr('data-descripcion');
            let requerimiento_inicial= $(this).attr('data-requerimiento_inicial');
            let correlativo=$(this).attr('data-numero');
      
           if(descripcion=='null'){
            descripcion="";
           }
           $(".cor").val(correlativo);
           $(".cliente").val(cliente);
           $(".cliente").val(cliente);
           $(".cliente").change();
           $(".descripcion").val(descripcion);
           $(".requerimiento_inicial").val(requerimiento_inicial);
           $(".servicio_2").val(servicio);
           $(".servicio_2").change();
           $(".id").val(id);
           
           //consultar elementos
           $.getJSON('{{ asset("consultar/listas") }}/'+id,function(dx){
            
            $.each(dx,function(i,v){ 
                sin_listas++;
                //actualizar tabla elementos
                $.getJSON('{{ asset("listar/elementos") }}/'+id+'/'+v.id_lista,function(elementos){
                    $('.elementos tbody').append(cargar_tabla(elementos));
                })
            });
           if(sin_listas==0){
                $('.elementos tbody').append(`<td colspan="3" class="fila1">sin listas</td>`);
           }
           });
           
           
           
            
        });

        $(document).on('click',".destacar",function(){
           
            let id_orden= $(this).attr('id_orden');
         $.getJSON('{{ route("destacar.orden") }}?id_orden='+id_orden);
           //tabla.ajax.url('{{ route("articulo.destacar") }}?id_articulo='+id+'&id_articulo_categoria='+id_articulo_categoria).draw();
        });

        $(document).on('click',".delete",function(){
           
            if(@json($session)==1){
                
            var id= $(this).attr('data-id');
            //eliminar articulo
            if(cont==0){
                if(confirm('Estas seguro que deseas eliminar el registro seleccionado?')){
                    
                    tabla.ajax.url('{{ route("servicio.eliminar") }}?id_articulo='+id).load();
                }
                }else{//elimnar relacion con categoria
                   
                    if(cont==1){
                          categoria=$(".categoria1 option:selected").val();
                     }
                    if(cont==2){
                        categoria=$(".categoria2 option:selected").val();
                        
                    }
                    if(cont==3){
                        categoria=$(".categoria3 option:selected").val();
                    }
                    if(cont==4){
                        categoria=$(".categoria4 option:selected").val();
                    }
                    if(cont==5){
                        categoria=$(".categoria5 option:selected").val();
                    }
                    tabla.ajax.url('{{ route("articulo.eliminar") }}?id_categoria='+categoria+'&id_articulo='+id).load();
                }
            }else{
                alert('No tiene permisos para realizar esta accion');
            }
       
        });
        var tabla=$('#main').DataTable({
                  serverSide: true,
                  paging: true,
                  order:[ 0, 'desc' ],
			      pageLength: 20,
                    ajax: {
                        url:'{{asset("listar/ordenes/tabla")}}',
                        dataSrc: 'data',
                        type:'post',
                    },
                    columns:[
                        {data: 'numero','name':'numero'},
                        {data: 'cliente','name':'cliente'},
                        {data: null,'name':'servicio',
                            "render": function (data) {
                                if(data.servicio=='REVISION GARANTIA'){
                                    return '<span class="badge badge-danger" style="font-size:12px">'+data.servicio+'</span>';
                                }else{
                               
                                
                                 return '<span class="badge badge-success" style="font-size:12px">'+data.servicio+'</span>';
                                }
                               
                                    
                               
                            }
                        },
                        {data: null,'name':'recibido',
                            "render": function (data) {
                                if(data.recibido==null){
                                    return '<span class="badge badge-danger" style="font-size:12px">Sin firma</span>'
                                }else{
                                 return '<span class="badge badge-success" style="font-size:12px">Firmado</span>'
                                   
                                }
                               
                            }
                        },
                        {data: 'contrato','name':'contrato'},
                        {data: 'created_at','name':'created_at'},
                        {"data":null,name:'pendiente', "render": function (data){
                                    if(data.pendiente==0){
                                        return '<input class="destacar" type="checkbox" style="width: 26px; height:26px; padding:0px; "id_orden="'+data.id+'" >';
                                    }else{
                                        return '<input class="destacar" type="checkbox" style="width: 26px; height:26px; padding:0px;"  checked  id_orden="'+data.id+'" >';
                                    }
                        }
                                
                        },
                        {
                        "data": null,'name':'id',
                            "render": function (data) {
                                    let html='<button style="width: 26px; height:26px; padding:0px" data-id="'+data.id+'" class="btn btn-success habilitar" data-cliente="'+data.id_cliente+'" data-obra="'+data.id_cliente+'" title="Habilitar orden de trabajo"><i class="fa fa-check"></i></button>';
                                if(data.estado==3){
                                     html='<button style="width: 26px; height:26px; padding:0px" data-id="'+data.id+'" class="btn btn-danger terminar "  title="deshabilitar orden"><i class="fa fa-times"></i></button>';
                                }
                                return html+'\
                                <button style="width: 26px; height:26px; padding:0px" data-toggle="modal" data-target="#modal-lg" data-id="'+data.id+'" data-numero="'+data.numero+'" data-cliente="'+data.id_cliente+'"  title="ver y editar" data-descripcion="'+data.descripcion+'"  data-servicio="'+data.servicio+'" data-requerimiento_inicial="'+data.requerimiento_inicial+'" class="btn btn-info edit"><i class="fa fa-pencil-alt"></i></button> \
                                <button style="width: 32px; padding: 3px 5px !important;" class="btn btn-danger delete" data-id="'+data.id+'" title="eliminar"><i class="fa fa-trash"></i></button>\
                                <button style="width: 26px; height:26px; padding:0px" class="btn btn-success print" data-id="'+data.id+'" title="imprimir"><i class="fa fa-print"></i></button>\
                                <button style="width: 26px; height:26px; padding:0px" class="btn btn-info ver_informe" data-id="'+data.id+'" title="ver informe"><i  class="fas fa-file"></i></button>';
                            
                        }
                        }
                                 
                   ],
                   language: langDataTable,
                  
        });
       
      

     })
    </script>
@stop
