

@extends('template.main')

@section('contenedor_principal')

    @if(\App\Http\Controllers\AuthController::checkAccessModule('bancos.registrar',session('role_id')))
        @include('servicios.modals.registro_edicion_servicio')
    @endif
   
<div class="col-12">
    <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
                <button class="btn btn-info nuevo" style="float:right" data-toggle="modal" data-target="#modal-lg"><i class="fa fa-plus "></i> Nuevo servicio</button>
               
                <table id='main' class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th >Nombre</th>
                  <th >Codigo</th>
                  <th>Imagen</th>
                  <th >Categoria</th>
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
    var cont_formulario=0;
    var id;
    var cont=0;
    var categoria;
    var item=0;
    var item_elementos=0;
    var tipo_tabla;
    var agregar_fila_modelo=0;
    var agregar_fila_descripcion=0;
    $(document).ready(function(){

      //  $.jGrowl("Hello world!",{ life : 2000});
                 
                $(".agre_art").css("display", "none");
                
    
    function cargar_tabla(texto,tipo_tabla){
    let valor=0;
    let alto=0;
    let ancho=0;
       let array='caracteristicas[]';
        
            if($('.fila1').attr('numero')==1 && tipo_tabla==1){
                $(".modelo_tabla tbody").html("");
              
            }
            
             if($('.fila2').attr('numero')==2  && tipo_tabla==2){
                $(".descripcion_tabla tbody").html("");
            }
             
             if(tipo_tabla==2){
                 array='elementos[]';
             }
            
            contenido_tabla=`
                <tr class="`+tipo_tabla+item+`">
                  
                    <td> 
                    <input type="hidden" readonly name="`+array+`" style="width:50%;background:#FBD03D;" value="`+texto+`"/> 
                    `+texto+`
                    </td>`;
              if(tipo_tabla==2){
                contenido_tabla+=`
                    <td> 
                    $ <input type="text" class="formatear_miles" name="valor[]"  aria-describedby="helpId" autocomplete="off" style="width:75%;background:#FBD03D; value="`+valor+`"">
                    </td>
                    <td> 
                    <input type="texto"  max="100" name="alto[]" style="width:50%;background:#FBD03D;" value="`+alto+`"/> mts
                    </td>
                    <td> 
                    <input type="texto"  max="100" name="ancho[]" style="width:50%;background:#FBD03D;" value="`+ancho+`"/> mts
                    </td>
                    `;
              }      
                   
              contenido_tabla+=`<td>
                        <button type="button" class="btn btn-danger Remover" title="Remover" data-id="`+tipo_tabla+item+`" >
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </button>
                        </td>
                        </tr>`;
    ; 
            
    return contenido_tabla;} 
     //formatear miles
     $(document).on('keyup',".formatear_miles",function (evt){
         //utilizar libreria input mask
        $(this).inputmask({ 'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'digits': 0, 'digitsOptional': false, 'placeholder':''});
     });
    
    $(document).on('click','.Remover',function(){
        let item= $(this).attr('data-id');
        $('.'+item).remove();
        
        /*if(tabla==1){
            if($(".modelo_tabla tbody tr").length==0){
                $('.modelo_tabla tbody').append(`<td colspan="2" class="fila1" numero="1">sin modelos</td>`);
            }
        }
        alert(tabla);
        if(tabla==2){
            if($(".descripcion_tabla tbody tr").length==0){
                $('.descripcion_tabla tbody').append(`<td colspan="4" class="fila2" numero="2">sin detalles</td>`);
            }
        }*/
    });
     
    function limpiar(){
         $(".id").val('');
           $(".c01").val('');
           $(".c02").val('');
           $(".c03").val('');
           $(".c04").val('');
           $(".c04").change();//actualizar select
     }

    $(document).on('click','.nuevo',function(){
    
        //$('.articulo').prop('selectedIndex',0);
        if($(".modelo_tabla tbody tr").length==0){
            $('.modelo_tabla tbody').html(`<td colspan="2" class="fila1" numero="1" >sin modelos</td>`);
            agregar_fila_modelo=1;
        }
          if($(".descripcion_tabla tbody tr").length==0){
            $('.descripcion_tabla tbody').html(`<td colspan="5" class="fila2" numero="2">sin detalles</td>`);
            agregar_fila_descripcion=1;
        }
        
        $(".modal-title").text("Registrar servicio");
        item=0;
        cont=0;
        limpiar();
        /*
        cont++;
        cont_formulario=0;
        */
        //verificar datos esten llenos con each
    });
        
      
      
        $(document).on('click',".edit",function(){
            $('.modelo_tabla tbody').html(`<td colspan="2" class="fila1" numero="1" >sin modelos</td>`);
      
            $('.descripcion_tabla tbody').html(`<td colspan="4" class="fila2" numero="2">sin detalles</td>`);
        
            
            $(".modal-title").text("Editar servicio");
            cont++;
             
            id= $(this).attr('data-id');
            valor= $(this).attr('data-valor');
            nombre= $(this).attr('data-nombre');
            codigo= $(this).attr('data-codigo');
            categoria= $(this).attr('data-categoria');
          
           $(".id").val(id);
           $(".c01").val(nombre);
           $(".c03").val(codigo);
           $(".categoria").val(categoria);
           $(".categoria").change();//actualizar select
           //actualizar tabla caracteristicas
           
            $.getJSON('{{ asset("inventario/modelos") }}/'+id,function(dx){
                $('.modelo_tabla tbody').html('');
                 
                   $.each(dx,function(i,v){
                            
                    if(dx.length!=0){
                             
                             $('.modelo_tabla tbody').append(`<tr class="`+v.id+`">
                             <td><input type="hidden" readonly name="caracteristicas[]" style="width:50%;background:#FBD03D;" value="`+v.nombre+`"/> 
                             `+v.nombre+`
                             </td>
                             <td>
                                <button type="button" class="btn btn-danger Remover" title="Remover" data-id="`+v.id+`" >
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </button>
                            </td>
                          </tr>`);
                    }        
                    });
            });
            
            $.getJSON('{{ asset("inventario/detalles") }}/'+id,function(dx){
                 
                $('.descripcion_tabla tbody').html('');
                   $.each(dx,function(i,v){
                           
                    if(dx.length!=0){
                             
                             $('.descripcion_tabla tbody').append(`<tr 
                             class="`+v.id+`">
                             <td><input type="hidden" readonly name="elementos[]" style="width:50%;background:#FBD03D;" value="`+v.descripcion+`"/> 
                             `+v.descripcion+`
                             </td>
                             <td> 
                                $ <input type="text" class="formatear_miles" name="valor[]"   style="width:75%;background:#FBD03D;" value="`+number_format(v.valor,0,',','.')+`">
                                
                                </td>
                                <td> 
                                <input type="texto"  max="100" name="alto[]" style="width:50%;background:#FBD03D;" value="`+v.alto+`"/> mts
                                </td>
                                <td> 
                                <input type="texto"  max="100" name="ancho[]" style="width:50%;background:#FBD03D;" value="`+v.ancho+`"/> mts
                                </td>
                             <td>
                                <button type="button" class="btn btn-danger Remover" title="Remover" data-id="`+v.id+`" >
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </button>
                            </td>
                          </tr>`);
                    }        
                    });
                
            });
            
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

        $(function() {
            $('.combo').select2({  theme: 'bootstrap4' })
	    });
	    
	    
	   $(document).on('click',".agregar_modelo",function(){
             tipo_tabla=1;
	        let texto=$('.modelo_input').val();
            if(texto!=''){
            item++;
            $('.modelo_tabla tbody').append(cargar_tabla(texto,tipo_tabla));
            $('.modelo_input').val("");
            }else{
                alert('ingrese modelo');
            }
        });

        $(document).on('click',".agregar_descripcion",function(){
            tipo_tabla=2;
            let texto=$(".descripcion_input").val();
            if(texto!=''){
            item++;
            item_elementos++;
            $('.descripcion_tabla tbody').append(cargar_tabla(texto,tipo_tabla));
            $('.descripcion_input').val("");
            }else{
                alert('ingrese elementos');
            }
        });
        /*$(document).on('click','.trigger_form',function(){ 
            alert(2);
            //<!-- <button style="display:none" class="act_form"></button>/para enviar directamente por formulario -->
            let id = $(this).attr('target');
           
            $('.'+id+' > .act_form').trigger('click');
            
        });*/
        var tabla=$('#main').DataTable({
                  serverSide: true,
                  paging: true,
			      pageLength: 20,
                    ajax: {
                        url:'{{asset("servicios/listado/data")}}',
                        dataSrc: 'data',
                        type:'post',
                    },
                    columns:[
                        {data: 'nombre','name':'nombre'},
                        {data: 'codigo','name':'codigo'},
                        {data:'id','name':'id',render: function (data) {
                            
                        return `<img src="{{asset("catalogo/`+data+`.png?123") }}" width="380" height="80">`;
                        }
                        },
                        {"data": 'nombre_categoria','name':'nombre_categoria'},
                                 {
                                    "data": null,'name':'id',
					                 "render": function (data) {
                                            return '<button style="width: 26px; height:26px; padding:0px" data-toggle="modal" data-target="#modal-lg" data-id="'+data.id+'" data-nombre="'+data.nombre+'" data-valor="'+data.valor+'" data-codigo="'+data.codigo+'" data-categoria="'+data.id_categoria+'" class="btn btn-info edit"><i class="fa fa-pencil-alt"></i></button> \
                                            <button style="width: 32px; padding: 3px 5px !important;" class="btn btn-danger delete" data-id="'+data.id+'"><i class="fa fa-trash"></i></button>';
                                        
                                    }
                                 }
                                 
                   ],
                   language: langDataTable,
                  
        });
       
      

     })
    </script>
@stop










