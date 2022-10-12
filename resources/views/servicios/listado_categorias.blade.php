

@extends('template.main')

@section('contenedor_principal')

    @if(\App\Http\Controllers\AuthController::checkAccessModule('bancos.registrar',session('role_id')))
        @include('servicios.modals.registro_edicion_categoria')
    @endif
   
<div class="col-12">
    <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
                <button class="btn btn-info nuevo" style="float:right" data-toggle="modal" data-target="#modal-lg"><i class="fa fa-plus "></i>Nueva catgoria</button>
               
                <table id='main' class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th >Nombre</th>
                  <th >Codigo</th>
                  <th>Medida</th>
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
    var cont=0;
    var categoria;
    var item=0;
    var item_elementos=0;
    
    $(document).ready(function(){

      //  $.jGrowl("Hello world!",{ life : 2000});
                 
                $(".agre_art").css("display", "none");
                
    
    function cargar_tabla(texto,tipo_tabla){
       let array='caracteristicas[]';
       
            if(item==1){
                $(".caracteristicas tbody").html("");
              
            }
             if(item_elementos==1){
                $(".elementos tbody").html("");
            }
             
             if(tipo_tabla==2){
                 array='elementos[]';
             }
            contenido_tabla=`
                <tr class="oc`+item+`">
                  
                    <td> 
                    <input type="hidden" readonly name="`+array+`" style="width:50%;background:#FBD03D;" value="`+texto+`"/> 
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
    
    $(document).on('click','.Remover',function(){
        let item= $(this).attr('data-id');
        $('.oc'+item).remove();
        
         if($(".caracteristicas tbody tr").length==0){
            $('.caracteristicas tbody').append(`<td colspan="2" class="fila1">sin caracteristicas</td>`);
        }
          if($(".elementos tbody tr").length==0){
            $('.elementos tbody').append(`<td colspan="2" class="fila1">sin elementos</td>`);
        }
    });
    
    function limpiar(){
         $(".id").val('');
           $(".nombre").val('');
           $(".codigo").val('');
           $(".medida").val('');
           $(".medida").change();//actualizar select
    }

    $(document).on('click','.nuevo',function(){
    
        //$('.articulo').prop('selectedIndex',0);
        $(".caracteristicas tbody").html("");
        $('.caracteristicas tbody').append(`
            <td colspan="2" class="fila1">sin caracteristicas</td>
        `);
         $(".elementos tbody").html("");
        $('.elementos tbody').append(`
            <td colspan="2" class="fila1">sin elementos</td>
        `);
        $(".modal-title").text("Registrar Categoria");
        item=1;
        cont=0;
        limpiar();
        /*
        cont++;
        cont_formulario=0;
        */
        //verificar datos esten llenos con each
    });
        
      
      
        $(document).on('click',".edit",function(){
            limpiar();
            $(".caracteristicas tbody").html("");
            $(".elementos tbody").html("");
            $(".modal-title").text("Editar categoria");
            cont++;
             
            id= $(this).attr('data-id');
            valor= $(this).attr('data-valor');
            medida= $(this).attr('data-medida');
            nombre= $(this).attr('data-nombre');
            codigo= $(this).attr('data-codigo');
            
            servicio= $(this).attr('data-servicio');
            
           $(".id").val(id);
           $(".nombre").val(nombre);
           $(".valor").val(valor);
           $(".codigo").val(codigo);
           $(".medida").val(medida);
           $(".medida").change();//actualizar select
           //actualizar tabla caracteristicas
           
               $.getJSON('{{ asset("servicios/listado/data") }}/'+id,function(dx){
                   let caracteristicas=0;
                   let elementos=0;
                   $.each(dx,function(i,v){
                             
                             item=v.id;
                               if(v.tipo==1){
                                   $('.caracteristicas tbody').append(cargar_tabla(v.item,1));
                                   caracteristicas=1;
                                   
                               }else{
                                   $('.elementos tbody').append(cargar_tabla(v.item,2));
                                   elementos=1;
                               }
                               
                    });
                if(caracteristicas==0){
                 $('.caracteristicas tbody').append(`<td colspan="2" class="fila1">sin caracteristicas</td>`);
        
                }
                if(elementos==0){
                    $('.elementos tbody').append(`<td colspan="2" class="fila1">sin elementos</td>`); 
                }
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
	    
	    
	   $(document).on('click',".agregar_caracteristicas",function(){
	        
	        let texto=$(".carac ").val();
            if(texto!=''){
            item++;
            $('.caracteristicas tbody').append(cargar_tabla(texto,1));
            $('.carac').val("");
            }else{
                alert('ingrese caracteristica');
            }
        });

        $(document).on('click',".agregar_elementos",function(){
            let texto=$(".ele ").val();
            if(texto!=''){
            item_elementos++;
            $('.elementos tbody').append(cargar_tabla(texto,2));
            $('.ele').val("");
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
                        url:'{{asset("categorias/listado/data")}}',
                        dataSrc: 'data',
                        type:'post',
                    },
                    columns:[
                        {data: 'nombre','name':'nombre'},
                        {data: 'codigo','name':'codigo'},
                        {data: 'medida','name':'medida'},
                        {
                        "data": null,'name':'id',
                            "render": function (data){
                                return '<button style="width: 26px; height:26px; padding:0px" data-toggle="modal" data-target="#modal-lg" data-id="'+data.id+'" data-nombre="'+data.nombre+'" data-valor="'+data.valor+'" data-medida="'+data.medida+'" data-codigo="'+data.codigo+'" data-servicio="'+data.categoria+'" class="btn btn-info edit"><i class="fa fa-pencil-alt"></i></button> \
                                <button style="width: 32px; padding: 3px 5px !important;" class="btn btn-danger delete" data-id="'+data.id+'"><i class="fa fa-trash"></i></button>';
                            
                        }
                        }
                                 
                   ],
                   language: langDataTable,
                  
        });
       
      

     })
    </script>
@stop





