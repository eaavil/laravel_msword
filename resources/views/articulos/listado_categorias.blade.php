@extends('template.main')

@section('contenedor_principal')



<div class="col-12">
    <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
            
            <div class="row">
              
                 <div class="col-2">
                    <label>Categorias</label>
                        <select class="form-control combo prov categoria1" data-id="1">
                        <option value="-1" selected="true">Raiz</option>
                        @foreach($categoria as $rows)
                               <option value="{{ $rows->id }}">{{ $rows->nombre }}</option>
                        @endforeach
                        </select>
                </div>
                 <div class="col-2 ca2 pt-2" style="display: none" > 
                 
                 <label> </label>
                        
                        <select class="form-control combo prov categoria2 ">
                        <option value="-1" selected="true">Raiz</option>
                        </select>
                    
                 </div>
                 <div class="col-2 ca3 pt-4" style="display: none"> 
                 
                        <select class="form-control combo prov categoria3">
                        <option value="-1" selected="true">Raiz</option>
                        </select>
                </div>
                <div class="col-2 ca4 pt-4" style="display: none"> 
                 
                 <select class="form-control combo prov categoria4">
                 <option value="-1" selected="true">Raiz</option>
                 </select>
                </div>
                <div class="col-2 ca5 pt-4" style="display: none"> 
                 
                 <select class="form-control combo prov categoria5">
                 <option value="-1" selected="true">Raiz</option>
                 </select>
                </div>
                 <div class="form-group  pt-4">
                        <input type="text"  class="acat form-control" placeholder="Ingrese categoria" style="text-transform:uppercase">
                </div>
                <div class="col-2 pt-4">
                        <button class="btn btn-primary agregar">Agregar</button>
                </div>
             </div>
			  <br><br>
        <table id='main' class=" table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Nombre</th>
                  <th>Tienda</th>
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

    @include('giros_anticipos.modals.reporte_entradas_giros')</div>
    @include('giros_anticipos.modals.reporte_entradas_giros')
    @if(\App\Http\Controllers\AuthController::checkAccessModule('bancos.registrar',session('role_id')))
        @include('giros_anticipos.modals.registro')
    @endif
    @if(\App\Http\Controllers\AuthController::checkAccessModule('bancos.actualizar',session('role_id')))
        @include('articulos.modals.edicion')
    @endif
	@include('giros_anticipos.modals.reporte_giros')
    <style>
        .select2-drop li {
            white-space: pre;
        }
    </style>


@stop

@section('scripts-bottom')
    <script>

$(document).ready(function(){
    var cont=0;
    var id_categoria=0;
    var categoria;
    var id;
    var nombre;
    var select='.categoria1';
         
               // $(".filacontkilos").addClass("col-3");
               // $(".filacont").addClass("col-3");
              //  $(".c05").prop("readonly", true);
             
        
           //calcular valores al cargar el dom
          /* let $valor =$('#my-select option:selected').val();
        let $banco =$('#my-select2 option:selected').val();
        let fecha_inicial=$('.fi').val();
        let fecha_final=$('.ff').val();
        $.ajax({
            type: "get",
            url: ('{{ route("ingreso_egreso.listado.data") }}?banco='+$banco+'&valor='+$valor+'&modo=1'),
            dataType: "json",
            success: function (response) {
                $('.dx2').html('$'+number_format(response,2,',','.'));
            }
        });*/
        
        $('.categoria1').change(function(){
            id_categoria=$('.categoria1 option:selected').val();
            
            if(id_categoria==-1){
                cont=0;
                id_categoria=0;
                select='.categoria1';
                //cargar_tabla
                tabla.ajax.url('{{ route("categoria.editar") }}?id=0'+'&id_categoria='+id_categoria).load();
                //limpiar select
                $(select).empty();
                $(select).prepend("<option value='-1' >Ingrese categoria</option>");
                //cargar select
                $.ajax({
                        type: "get",
                        url: ('{{ route("categoria.registrar") }}?categoria=x'+'&id_categoria='+id_categoria),
                        dataType: "json",
                        success: function (response) {
                            $.each(response, function(id,value){
                                $(select).append('<option value="'+value.id+'">'+value.nombre+'</option>');
                            });
                        $('.acat').val('');
                        }
                });
                $(".ca2"). css("display", "none");
                $(".ca3"). css("display", "none");
                $(".ca4"). css("display", "none");
                $(".ca5"). css("display", "none");
            }else{
                cont=1;
                $(".ca2"). css("display", "block");
                $(".ca3"). css("display", "none");
                $(".ca4"). css("display", "none");
                $(".ca5"). css("display", "none");
                select='.categoria2';
                //limpiar select
                $(select).empty();
                $(select).prepend("<option value='-1' >Raiz</option>");
                //cargar_tabla
                tabla.ajax.url('{{ route("categoria.editar") }}?id=0'+'&id_categoria='+id_categoria).load();
                //cargar select
                $.ajax({
                        type: "get",
                        url: ('{{ route("categoria.registrar") }}?categoria=x'+'&id_categoria='+id_categoria),
                        dataType: "json",
                        success: function (response) {
                            $.each(response, function(id,value){
                                $(select).append('<option value="'+value.id+'">'+value.nombre+'</option>');
                            });
                        $('.acat').val('');
                        }
                });
            }
        });
        $('.categoria2').change(function(){
            id_categoria=$('.categoria2 option:selected').val();
            
            if(id_categoria==-1){
                cont=1;
                id_categoria=$('.categoria1 option:selected').val();;
                select='.categoria2';
                //cargar_tabla
                tabla.ajax.url('{{ route("categoria.editar") }}?id=0'+'&id_categoria='+id_categoria).load();
                //limpiar select
                $(select).empty();
                $(select).prepend("<option value='-1' >Raiz</option>");
                //cargar select
                $.ajax({
                        type: "get",
                        url: ('{{ route("categoria.registrar") }}?categoria=x'+'&id_categoria='+id_categoria),
                        dataType: "json",
                        success: function (response) {
                            $.each(response, function(id,value){
                                $(select).append('<option value="'+value.id+'">'+value.nombre+'</option>');
                            });
                        $('.acat').val('');
                        }
                });
                $(".ca3"). css("display", "none");
                $(".ca4"). css("display", "none");
                $(".ca5"). css("display", "none");
            }else{
                cont=2;
                $(".ca3"). css("display", "block");
                $(".ca4"). css("display", "none");
                $(".ca5"). css("display", "none");
                select='.categoria3';
                //limpiar select
                $(select).empty();
                $(select).prepend("<option value='-1' >Raiz</option>");
                //cargar_tabla
                tabla.ajax.url('{{ route("categoria.editar") }}?id=0'+'&id_categoria='+id_categoria).load();
                //cargar select
                $.ajax({
                        type: "get",
                        url: ('{{ route("categoria.registrar") }}?categoria=x'+'&id_categoria='+id_categoria),
                        dataType: "json",
                        success: function (response) {
                            $.each(response, function(id,value){
                                $(select).append('<option value="'+value.id+'">'+value.nombre+'</option>');
                            });
                        $('.acat').val('');
                        }
                });
            }
        });

        $('.categoria3').change(function(){
            id_categoria=$('.categoria3 option:selected').val();
           
            if(id_categoria==-1){
                cont=2;
                id_categoria=$('.categoria2 option:selected').val();;
                select='.categoria3';
                //cargar_tabla
                tabla.ajax.url('{{ route("categoria.editar") }}?id=0'+'&id_categoria='+id_categoria).load();
                //limpiar select
                $(select).empty();
                $(select).prepend("<option value='-1' >Raiz</option>");
                //cargar select
                $.ajax({
                        type: "get",
                        url: ('{{ route("categoria.registrar") }}?categoria=x'+'&id_categoria='+id_categoria),
                        dataType: "json",
                        success: function (response) {
                            $.each(response, function(id,value){
                                $(select).append('<option value="'+value.id+'">'+value.nombre+'</option>');
                            });
                        $('.acat').val('');
                        }
                });
                
                //ocultar select
                $(".ca4"). css("display", "none");
                $(".ca5"). css("display", "none");
                }else{
                    cont=3;
                    $(".ca4"). css("display", "block");
                    $(".ca5"). css("display", "none");
                    select='.categoria4';
                    //limpiar select
                    $(select).empty();
                    $(select).prepend("<option value='-1' >Raiz</option>");
                    //cargar_tabla
                    tabla.ajax.url('{{ route("categoria.editar") }}?id=0'+'&id_categoria='+id_categoria).load();
                    //cargar select
                    $.ajax({
                            type: "get",
                            url: ('{{ route("categoria.registrar") }}?categoria=x'+'&id_categoria='+id_categoria),
                            dataType: "json",
                            success: function (response) {
                                $.each(response, function(id,value){
                                    $(select).append('<option value="'+value.id+'">'+value.nombre+'</option>');
                                });
                            $('.acat').val('');
                            }
                    });
                }
        });
 
        $('.categoria4').change(function(){
            id_categoria=$('.categoria4 option:selected').val();
            
        if(id_categoria==-1){
            cont=3;
            id_categoria=$('.categoria3 option:selected').val();;
            select='.categoria4';
            //cargar_tabla
            tabla.ajax.url('{{ route("categoria.editar") }}?id=0'+'&id_categoria='+id_categoria).load();
            //limpiar select
            $(select).empty();
            $(select).prepend("<option value='-1' >Raiz</option>");
            //cargar select
            $.ajax({
                    type: "get",
                    url: ('{{ route("categoria.registrar") }}?categoria=x'+'&id_categoria='+id_categoria),
                    dataType: "json",
                    success: function (response) {
                        $.each(response, function(id,value){
                            $(select).append('<option value="'+value.id+'">'+value.nombre+'</option>');
                        });
                    $('.acat').val('');
                    }
            });
            
            $(".ca5"). css("display", "none");
        }else{
            cont=4;
            $(".ca5"). css("display", "block");
            select='.categoria5';
            //limpiar select
            $(select).empty();
            $(select).prepend("<option value='-1' >Raiz</option>");
            //cargar_tabla
            tabla.ajax.url('{{ route("categoria.editar") }}?id=0'+'&id_categoria='+id_categoria).load();
            //cargar select
            $.ajax({
                    type: "get",
                    url: ('{{ route("categoria.registrar") }}?categoria=x'+'&id_categoria='+id_categoria),
                    dataType: "json",
                    success: function (response) {
                        $.each(response, function(id,value){
                            $(select).append('<option value="'+value.id+'">'+value.nombre+'</option>');
                        });
                    $('.acat').val('');
                    }
            });
        }
        });

    
         
    
        $(document).on('click',".edit",function(){

            id= $(this).attr('data-id');
           
            nombre= $(this).attr('data-nombre');
            //tabla.ajax.url('{{ route("categoria.editar") }}?id='+id).load();
            $(".input_cat").val(nombre);
            $(".input_id").val(id);
        });


        $(document).on('click',".actualizar",function(){
            $(select).empty();
            $(select).prepend("<option value='-1' >Raiz</option>");
            tabla.ajax.url('{{ route("categoria.editar") }}?id='+$(".input_id").val()+'&nombre='+$(".input_cat").val()+'&id_categoria='+id_categoria).load();
            //actualizar select
            $.ajax({
                    type: "get",
                    url: ('{{ route("categoria.registrar") }}?categoria=x'+'&id_categoria='+id_categoria),
                    dataType: "json",
                    success: function (response) {
                        $.each(response, function(id,value){
                            $(select).append('<option value="'+value.id+'">'+value.nombre+'</option>');
                        });
                    $('.acat').val('');
                    }
            });
        });
        /*$('.trigger_form_esp').click(function(){
            id = $(this).attr('target');
            $('.'+id+' > .act_form').trigger('click');
        })*/
        //bscar raiz
        $(function() {
          
	    });
        $(document).on('click',".delete",function(){
            //verificar que el usuario sea administrador para eliminar
           
            if(@json($session)==1){
                if(confirm('Estas seguro que deseas eleminar el registro seleccionado?')){
                    var id= $(this).attr('data-id');
                    //eliminar registro y cargar tabla
                    tabla.ajax.url('{{ route("categoria.eliminar") }}?id='+id+'&id_categoria='+id_categoria).load();
                     //limpiar select
                    $(select).empty();
                    $(select).prepend("<option value='-1' >Raiz</option>");
                    //cargar select
                    $.ajax({
                        type: "get",
                        url: ('{{ route("categoria.registrar") }}?categoria=x'+'&id_categoria='+id_categoria),
                        dataType: "json",
                        success: function (response) {
                            $.each(response, function(id,value){
                                $(select).append('<option value="'+value.id+'">'+value.nombre+'</option>');
                            });
                        }
                    });
               }
            }else{
                alert('No tiene permisos para realizar esta accion');
            }
        });
        $(function() {
            $('.combo').select2({  theme: 'bootstrap4' })
	    });
        var tabla=$('#main').DataTable({
			      serverSide:true,
                  paging: true,
			      pageLength: 20,
                    ajax: {
                        url:'{{ asset("articulos/listado/data") }}',
                        dataSrc: 'data',
                        type:'post'
                    },
                    columns:[
                                {"data":'nombre',name:'nombre'},
                                {"data":'es_tienda',name:'es_tienda', "render": function (data) {
                                    if(data==0){
                                        return '<input type="checkbox" style="width: 26px; height:26px; padding:0px">';
                                    }else{
                                        return '<input type="checkbox" style="width: 26px; height:26px; padding:0px"  checked>';
                                    }
                                }
                                
                                },
                                 {
                                    "data": null,name:'id',
					                 "render": function (data) {
                                        return '<button style="width: 26px; height:26px; padding:0px" data-toggle="modal" data-target="#modal-lge" data-id="'+data.id+'" data-nombre="'+data.nombre+'" class="btn btn-info edit"><i class="fa fa-pencil-alt"></i></button> \
                                        <button style="width: 26px; height:26px; padding:0px" data-id="'+data.id+'" class="btn btn-danger delete"><i class="fa fa-trash"></i></button>';

                                    }
                                 }
                                 
                   ],
                   language: langDataTable,
                  
        });

        $(document).on('click','.agregar',function(){ 
            //var id= $(this).attr('data-id');
            //let $categoria =$('.categoria option:selected').val();
            if(cont==0){
                ruta=$('.acat').val();
            }
             if(cont==1){
                ruta=$(".categoria1 option:selected").text()+', '+$('.acat').val();
                
             }
             if(cont==2){
                ruta=$('.categoria1 option:selected').text() +', '+$('.categoria2 option:selected').text()+','+$('.acat').val();
             }
             if(cont==3){
                ruta=$('.categoria1 option:selected').text() +', '+$('.categoria2 option:selected').text()+','+$('.categoria3 option:selected').text()+','+$('.acat').val();
             }
             if(cont==4){
                ruta=$('.categoria1 option:selected').text() +', '+$('.categoria2 option:selected').text()+','+$('.categoria3 option:selected').text()+','+$('.categoria4 option:selected').text()+','+$('.acat').val();
             }
            let categoria_nueva=$('.acat').val();
            if(categoria_nueva!=''){
                //agrega el registro y carga la tabla
				tabla.ajax.url('{{ route("categoria.registrar") }}?categoria='+categoria_nueva+'&id_categoria='+id_categoria+'&ruta='+ruta).load();
                //limpiar select
                $(select).empty();
                $(select).prepend("<option value='-1' >Raiz</option>");
                //cargar select
                $.ajax({
                    type: "get",
                    url: ('{{ route("categoria.registrar") }}?categoria=x'+'&id_categoria='+id_categoria),
                    dataType: "json",
                    success: function (response) {
                        $.each(response, function(id,value){
                            $(select).append('<option value="'+value.id+'">'+value.nombre+'</option>');
                        });
                    $('.acat').val('');
                    }
                });
            }else{
				alert('Ingrese categoria');
			}
		});
    })

   
    </script>
@stop
