
@extends('template.main')

@section('contenedor_principal')

    @if(\App\Http\Controllers\AuthController::checkAccessModule('bancos.registrar',session('role_id')))
        @include('articulos.modals.registrar_editar_articulo')
       
    @endif
    @include('articulos.modals.ver_tienda')
<div class="col-12">
    <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
            
            <button class="btn btn-info nuevo" style="float:right" data-toggle="modal" data-target="#modal-lg"><i class="fa fa-plus"></i>Nuevo articulo</button>
            <button  class="btn btn-secondary" style="float:left" data-toggle="modal" data-target="#m-entrada-reporte"><i class="fas fa-file"></i> Reportes</button>

                <table id='main' class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th >Nombre</th>
                  <th >Valor venta</th>
                  <th >Valor compra</th>
                  <th >Stock</th>
                  <th >Categoria</th>
                  <th >Destacado</th>
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
   <div>@include('giros_anticipos.modals.reporte_entradas_anticipos')</div>
	@include('giros_anticipos.modals.reporte_anticipos')

    <style>
  
    </style>


@stop

@section('scripts-bottom')
    <script>
    var id;
    var cont=0;
    var categoria;
    var item=0;
    var item_c=0;
    var item_r=0;
    var es_car=0;
    var es_rel=0;
    var valor=0;

     $(document).ready(function(){

    $(document).on('click','.Remover',function(){
        let item= $(this).attr('data-id');
        $('.oc'+item).remove();
    }); 

    $(document).on('click','.close',function(){
        //$('.articulo').prop('selectedIndex',0);
        item=0;
        $('.rel').val("");
        $(".rel").change();//actualizar vista
        $('.carac').val("");
        $('.video').val("");
        $('.descripcion').val("");
        $(".origen_caracteristicas tbody").html("");
        $(".origen_relacionados tbody").html("");

    });

    function cargar_tabla(texto,id){
       
            if(id!=0){
                valor=id;
            }else{
                valor=texto;  
            }
            contenido_tabla=`
                <tr class="oc`+item+`">
                  
                    <td> 
                    <input type="hidden" readonly name="caracteristica[]" style="width:50%;background:#FBD03D;" value="`+valor+`"/> 
                    `+texto+`
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger Remover" title="Remover" data-id="`+item+`">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </button>
                    </td>
                    `
            ; 
            
    return contenido_tabla;} 

    $(document).on('click','.nuevo',function(){
        $(".id").val("");
            $(".nombre").val("");
            $(".nombre_interno").val("");
            $(".modelo").val("");
            $(".valor_venta").val("");
            $(".valor_compra").val("");
            
            $(".categoria").val("");
            $(".categoria").change();
            $(".cantidad").val("");
    })
        
      
  $(document).on('click',".edit",function(){
            $(".id").val($(this).attr('id'));
            $(".nombre").val($(this).attr('nombre'));
            $(".nombre_interno").val($(this).attr('nombre_interno'));
            $(".modelo").val($(this).attr('codigo'));
            $(".valor_venta").val($(this).attr('valor'));
            $(".valor_compra").val($(this).attr('valor_compra'));
            
            $(".categoria").val($(this).attr('categoria'));
            $(".categoria").change();
            $(".cantidad").val($(this).attr('stock'));
        
        });
       
        $(document).on('click',".agregar_caracteristicas",function(){
            let texto=$(".carac ").val();
            item++;
            $('.origen_caracteristicas tbody').append(cargar_tabla(texto,0));
            $('.carac').val("");
           
        });

        $(document).on('click',".agregar_relacionados",function(){
            let texto=$(".rel option:selected").text();
            let rel_id=$(".rel option:selected").val();
            item++;
            $('.origen_relacionados tbody').append(cargar_tabla(texto,rel_id));
            $('.rel').val("");
            $(".rel").change();//actualizar vista
        });

        $(document).on('click',".destacar",function(){
          
           let categoria= $(".categoria1 option:selected").val();
             id= $(this).attr('id_articulo');
            let id_articulo_categoria= categoria;
         $.getJSON('{{ route("articulo.destacar") }}?id_articulo='+id+'&id_articulo_categoria='+id_articulo_categoria);
         
        });

        $(document).on('click',".ver_tienda",function(){
           let id=$(this).attr('id');
           $(".modal-title").text($(this).attr('nombre'));
           $('.id').val(id);
           
           $.getJSON('{{ asset("cargar_detalle") }}/'+1+"/"+id,function(dx){
                            $.each(dx,function(i,v){
                            item++;
                             if(v.tipo==1){ //si es caracteristica
                            $('.origen_caracteristicas tbody').append(cargar_tabla(v.item,0));
                            } 
                            if(v.tipo==2){//es relacionado
                                $('.origen_relacionados tbody').append(cargar_tabla(v.nombre,v.relacionado));
                            } 
                            if(v.tipo==3){//es video
                                $('.video').val(v.video);        
                            }
                            if(v.tipo==4){//es descripcion
                                $('.descripcion').val(v.descripcion);  
                            }
                    });
            });
        });

        $(document).on('click',".delete",function(){
           
            if(@json($session)==1 && 3==1){
                
            var id= $(this).attr('data-id');
            //eliminar articulo
           
                if(confirm('Estas seguro que deseas eliminar el registro seleccionado?')){
                    $.getJSON('{{ route("articulo.eliminar") }}?modo=1'+'&id_articulo='+id);
                  

                    location.reload();
              
               }else{
                alert('No tiene permisos para realizar esta accion');
            }
        }else{
            alert('BLOQUEADO');
        }
        });

      

        $(function() {
            $('.combo').select2({  theme: 'bootstrap4' })
	    });

        var tabla=$('#main').DataTable({
                  serverSide: true,
                  paging: true,
			      pageLength: 20,
                  order: false,
                    ajax: {
                        url:'{{asset("inventario/listado/data")}}',
                        dataSrc: 'data',
                        type:'post',
                    },
                    columns:[
                        {"data": 'nombre','name':'nombre'},
                        {data: 'valor','name':'valor',render: function (data) {
                        return number_format(data,0,',','.');
                        }
                        },
                        {data: 'valor_compra','name':'valor_compra',render: function (data) {
                        return number_format(data,0,',','.');
                        }
                        },
                        {"data": 'stock','name':'stock'},
                        {"data": 'categoria','name':'categoria',
                            "render": function (data) {
                                if(data==""){
                                    return '<span class="badge badge-danger" style="font-size:12px">Sin categoria</span>'
                                }else{
                                    return '<span class="badge badge-info" style="font-size:12px">'+data+'</span>';
                                }
                            }
                        
                           
                        },
                        {"data":null,name:'es_destacado', "render": function (data) {
                                    if(data.es_destacado==0){
                                        return '<input class="destacar" type="checkbox" style="width: 26px; height:26px; padding:0px; "id_articulo="'+data.id+'" id_articulo_categoria="'+data.articulos_categorias_id+'">';
                                    }else{
                                        return '<input class="destacar" type="checkbox" style="width: 26px; height:26px; padding:0px;"  checked  id_articulo="'+data.id+'" id_articulo_categoria="'+data.articulos_categorias_id+'">';
                                    }
                                }
                                
                        },
                        {
                                    "data": null,'name':'id',
					                 "render": function (data) {

                              
                                            return '<button style="width: 26px; height:26px; padding:0px" data-toggle="modal" data-target="#modal-lg" id="'+data.id+'" nombre="'+data.nombre+'" nombre_interno="'+data.nombre_interno+'" valor="'+data.valor+'" valor_compra="'+data.valor_compra+'"  codigo="'+data.codigo+'" stock="'+data.stock+'" categoria="'+data.id_categoria+'" class="btn btn-info edit"><i class="fa fa-pencil-alt"></i></button> \
                                            <button style="width: 32px; padding: 3px 5px !important;" data-toggle="modal" data-target="#mv" class="btn btn-success ver_tienda" id="'+data.id+'" nombre="'+data.nombre+'"  ><i class="fa fa-eye"></i></button>\
                                            <button style="width: 32px; padding: 3px 5px !important;" class="btn btn-danger delete" data-id="'+data.id+'"><i class="fa fa-trash"></i></button>';
                                        
                                      
                                    }
                                 }
                                 
                   ],
                   language: langDataTable,
                  
        });
       
        $(document).on('click','.agregar',function(){ 
            //var id= $(this).attr('data-id');
            //let $categoria =$('.categoria option:selected').val();
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
            let articulo=$(".articulo_cat option:selected").val();
            if(articulo!=-1){
                //agrega el registro y carga la tabla
				tabla.ajax.url('{{ route("categoria.registrar") }}?modo=1&articulo='+articulo+'&categoria='+categoria).load();
               
            }else{
				alert('Ingrese categoria');
			}
		});

     })
    </script>
@stop





