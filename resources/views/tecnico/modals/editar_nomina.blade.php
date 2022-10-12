@extends('template.main')
@section('contenedor_principal')
@php
$titulo="prueba";
$codigo_nomina=Str::random(40);//csrf_field()
$tamaño="173%";
$tamaño_label="20%";
if($movil==1){
$tamaño="100%";
$tamaño_label="100%";
}
$readonly="readonly";
                    if($id_usuario==1){
                    $readonly="";
}

@endphp

@include('tecnico.modals.gestionar_busqueda')
@include('tecnico.modals.ver_video_listas')
<div class="">
    <table id="2"  width="{{$tamaño}}" class="origen texto4"  border="1" cellspacing="0" cellpadding="0"  >
         <thead >
            <tr border="5"  >
               <th  ><h4><STRONG>#</STRONG></h4> </th>
              
          
                 <th  ><h4><STRONG>Detalles</STRONG></h4> 
                 </th>
              
    
            </tr>
         </thead>
         <tbody  >
             @foreach($orden as $rows)
           
                <tr border=4 >
                  <td> <h4>{{str_replace('OT-','',$rows->numero)}} </h4>
                        
                   </td>
                <td >
                    @php
                    $index=0;
                    
                    @endphp
                   @foreach($rows->ordenes_detalles as $rowsx)
                   @php

                    $nombre=$rowsx->descripcion;
                    $parte=$rowsx->parte;
                  
                   if($nombre=="sin descripcion"){
                       $nombre=$rowsx->nombre_servicio;
                   }
                
                    if(strpos($nombre, "RET") !== false){
                    
                       $parte="";
                   }else{
                   
                       $nombre=substr($nombre, 0,3);
                   }
                   @endphp
                 <label for="name" style="width:{{$tamaño_label}}"><h5>{{$nombre." ".$parte}}</h5></label>
                    
                             <input type="text" class="formatear_miles {{"for".$rowsx->id}} valores" id="{{$rowsx->id}}" name="valor_servicio[]" value="{{$rowsx->valor_tecnico}}" {{$readonly}}
                               >
                   @php
                   $index++
                   @endphp
                    @if($index < count($rows->ordenes_detalles))    
                     <hr style="background-color: white"/>
                   @endif
                 @endforeach
                  </td>
               
            @endforeach
            </tr>
                <tr>
                      <td > <h4>SUELDO</h4>  
                      </td>
                      
                      <td>
                      <input type="text" class="dias" 
                    minlength="1" maxlength="1" size="1" value="{{$nomina[0]->dias}}">
                   <input type="text" class="val_dia formatear_miles formultiplicar"  
                    minlength="4" maxlength="8" size="3" id="multiplicar" value="{{$nomina[0]->val_dia}}">
                      <input type="text" class="sueldo valores formatear_miles forsueldo"  name="sueldo" id="sueldo"  {{$readonly}}
                      value="{{$nomina[0]->sueldo_base}}" minlength="4" maxlength="10" size="5">
                      </td>
                  
                  </tr>
                 <tr>
                     <tr>
                  <td > <h4>DESCUENTOS</h4>  
                  </td>
                  
                  <td>
                       <label for="name" style="width:{{$tamaño_label}}"></label>
                  <input type="text" class="descuentos formatear_miles fordescuentos"  name="descuentos" id="descuentos" style="{{$tamaño}}"
                    minlength="4" maxlength="8" size="10" value="{{$nomina[0]->descuentos}}">
                  </td>
                  </tr>
                 <tr>
                  <td > <h4>TOTAL</h4>  
                  </td>
                  
                  <td>
                        <label for="name" style="width:{{$tamaño_label}}"></label>
                  <input type="text" class="total" readonly name="total" 
                    minlength="4" maxlength="8" size="10" value="{{$nomina[0]->total}}">
                  </td>
                  </tr>
                  
                </tr>
                  
                  <td colspan="2">
                  <textarea  class="estilotextarea mb-1 observaciones"  name="observacion"  placeholder="OBSERVACIONES" value="{{$nomina[0]->observaciones}}"></textarea>
                  </td>
                  </tr>
                @if($id_usuario==1)
             <tr> <td colspan=2>
                             <button  class="enviar_firma btn-block trigger_form texto mb-1" onclick='GuardarNomina()' >ACTUALIZAR</button> </td>
             </tr>
                @endif
         </tbody>
    </table>
</div>

<!-- cargar tecnicos a la busqueda-->
<datalist  id="empleados">
    @foreach($tecnicos as $rows)
        <option value="{{ $rows->nombre }}"></option>
    @endforeach
</datalist>

<div class="gestionar_listas row col-12 mb-2" style="display:none">
    <select class="form-control listas" >
    <option value="">Seleccione</option>
    </select>
</div> 
<hr>
<div class="gestionar_elementos row col-12 mb-2" style="display:none">
    <select class="form-control elementos">
    <option value="">Seleccione</option>
    </select>
</div>
<hr>

<form action="#" method="post" class="form_detalles" enctype="multipart/form-data">
            {{ csrf_field()}}
               
            <button style="display:none" class="act_form"></button>
</form> 
<div class="loading" style="display:none"><img src="dist/img/loader.gif" alt="loading" /><br/><h4>Un momento, por favor...</h4></div>

<div class="row mb-2 col-12 tabla_elementos" style="display:none">

</div>


@include('tecnico.modals.gestionar_comentario')
@include('tecnico.modals.ver_imagen')

<script>
var cliente="";
var orden="";
var empleado="";
var estado="";
var fecha_inicio="";
var fecha_fin="";
var id_orden;
var id_lista;
var id_elemento="";
var nombre;
var ruta="";//ruta de la imagen
var version_imagen;//para actualizar imagen en cache al recargar
var titulo=@json($titulo);
var texto="";
var ordenes=[];

$(function(){
    $(".observaciones").val(@json($nomina[0]->observaciones));
});

$(document).on('keyup',".formatear_miles",function (evt){
   let  id=$(this).attr("id");
                var num = $(".for"+id).val().replace(/\./g,'');
                num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
                num = num.split('').reverse().join('').replace(/^[\.]/,'');
                $(".for"+id).val(num);
             

            
      if(id=="multiplicar"){
        $(".sueldo").val(number_format(parseInt($(".dias").val().replace(/\./g,''))*parseInt($(".val_dia").val().replace(/\./g,'')),0,',','.'));
      
    
    }
        totalizar();  
        
    
});
  function totalizar(){
           let neto = 0;
           let descuentos=$(".descuentos").val().replace(/\./g,'');
       
            var tabla=$('.origen tbody tr');
          
            /*$.each(tabla,function(i,v){
                /*if($(this).find('input[name="servicio[]"]').val()==0){
                    crear_compra++;  
                }*/
                 
               /* neto+= parseInt($('.origen tbody tr').find('input[name="valor_servicio[]"]').val().replace(/\./g,''));//sumar totales eliminando punto
               
            });*/
           
           $(".valores").each(function(){
       		    neto+=parseInt($(this).val().replace(/\./g,''));
       		});
           
           if(descuentos==""){
               descuentos=0;
           }
            $('.total').val(number_format(neto-descuentos,0,',','.'));
        };
//cargar tabla al escribir campo input
$(document).on('keyup','.buscar_ot',function(){
    cargar_tabla();
});
$(document).on('keyup','.valores',function(){
    let id=$(this).attr("id");
    if(@json($id_usuario)==1 && id!="sueldo"){
    $.post('{{ asset("/registrar/base_datos") }}',{tipo_campo:"valores",valor:$(this).val(),id:id})
    }
});
function GuardarNomina(id){
if(@json($id_usuario)==1){
       $.post('{{ asset("/registrar/base_datos") }}',{id:@json($id_orden),
        total:$('.total').val(),
        sueldo:$('.sueldo').val(),
        empleado:$(".empleado").val(),
        ordenes:ordenes,
        tipo_campo:"actualizar_nomina",
        descuentos:$(".descuentos").val(),
        dias:$(".dias").val(), 
        val_dia:$(".val_dia").val(),
        observaciones:$(".observaciones").val()},function(result){
       alert("Nomina actualizada");
    })
}
}

function gestionar_listas(id){
    id_orden=id;
    $('.tabla_elementos').css('display','none');
    $('.gestionar_ordenes').css('display','none');
    $('.gestionar_listas').css('display','block');
    $.getJSON('{{ asset("consultar/listas") }}/'+id_orden,function(listas){
            $.each(listas, function(i,v){
                nombre=v.nombre;
                $(".listas").append('<option value="'+v.id_lista+'">'+v.nombre+'</option>');
    });
    //llenar elementos
       
});}

$(document).on('change','.listas',function(){
    $('.tabla_elementos').css('display','none');	
    $(".gestionar_elementos select").html('<option value="">Seleccione</option>');

   id_lista=$(".listas option:selected").val();
  
   $.getJSON('{{ asset("listar/elementos") }}/'+id_orden+'/'+id_lista,function(elementos){
    if(elementos.length>0){
        $('.gestionar_elementos').css('display','block');
        $.each(elementos, function(i,v){
           
            for(let i=1; i <= v.cantidades; i++){ 
                $(".elementos").append('<option value="'+i+'">'+v.item+'-'+i+'</option>');

            } 
        });
    }else{
        alert('sin elementos')
    }
    
    });
    //llenar elementos

});

$(document).on('change','.elementos',function(){
    id_elemento=$(".elementos option:selected").val();
    
    $('.tabla_elementos').css('display','block');
    $('.tabla_elementos').html('');
    //consultar elementos
    $.getJSON('{{ asset("listar/elementos/detallado") }}/'+id_orden+'/'+id_lista+'/'+id_elemento,function(elementos){
    $.each(elementos, function(i,v){

        
        $('.tabla_elementos').append(`
        
            <hr>
            <div class="elemento1 row mx-2">
            <div class="col-12">
            <i style="font-size:36px;cursor:pointer; background-color:yellow;">`+v.item+`</i>
             </div>
             
            <div class="col-6 detalles">
                <label for="imagen`+v.item+'A'+v.id+`">
                <i class="fas fa-camera" style="font-size:36px;cursor:pointer;">A</i>
                </label>
                <img src="dist/img/loader.gif" alt="loading" / class="loading`+v.id+'A'+`" style="display:none">
                <input id="imagen`+v.item+'A'+v.id+`" name="`+v.id+'A'+`" class="imagen `+v.id+'A'+`"  type="file" accept="image/*" capture="camera" style="display:none" />
               
                <i class='far fa-image ver' style='font-size:36px'
                    ruta="https://tecnorlogistichkvision.cl/ordenes_imagenes/`+id_orden+'-'+id_lista+'-'+v.id+'A.jpg?'+`" 
                    titulo="`+v.item+'-'+v.numeracion+' ANTES'+`"
                  
                ></i>
               
                </div>
        
            <div class="col-6">
            <label for="imagen`+v.item+'D'+v.id+`">
            <i class="fas fa-camera" style="font-size:36px;cursor:pointer;">D</i>
            </label>
            <div class="loading`+v.id+'D'+`" style="display:none"><img src="dist/img/loader.gif" alt="loading" /></div>
            <input id="imagen`+v.item+'D'+v.id+`" name="`+v.id+'D'+`" class="imagen `+v.id+'D'+`" type="file" accept="image/*"  capture="camera" style="display:none"/>
                <i class='far fa-image ver' style='font-size:36px'
                    ruta="https://tecnorlogistichkvision.cl/ordenes_imagenes/`+id_orden+'-'+id_lista+'-'+v.id+'D.jpg?'+`" 
                    titulo="`+v.item+'-'+v.numeracion+' DESPUES'+`" 
                ></i>
            
            </div>
            
            <div class="col-6">
            <i class="fas fa-comments gestionar_comentario" id="`+v.id+'A'+`" titulo="`+v.item+'-'+v.numeracion+' ANTES'+`"  style="font-size:36px;cursor:pointer;" data-target="#modal-lgc" data-toggle="modal"
            >A</i>
            </div>
            
            <div class="col-6">
                
                <i class="fas fa-comments gestionar_comentario" id="`+v.id+'D'+`" titulo="`+v.item+'-'+v.numeracion+' DESPUES'+`"  style="font-size:36px;cursor:pointer;" data-target="#modal-lgc" data-toggle="modal"
                >D</i>
               
            </div>
        </div>
 
        `
        
        );
    });
});

});
/*$(document).on('change','.imagen',function(){
    var id= $(this).val();
   
    $.getJSON('{{ asset("/almacenar/detalles") }}/'+id,function(elementos){
   
      
    
    });
   // $('.form_detalles > .act_form').trigger('click');
});*/

 $(document).on('click','.print',function(){
        var id= $(this).attr('data-id');
        var modo=1;
        window.open('{{ asset("imprimir_orden") }}/'+id+"/"+modo);
});

 $(document).on('click','.print_escritorio',function(){
        var id= $(this).attr('data-id');
        var modo=2;
        window.open('{{ asset("imprimir_orden") }}/'+id+"/"+modo);
});

function readAsBase64(fileBlob){

return new Promise((res, rej) => {

    const fileReader = new FileReader;
        
    fileReader.onload = ev =>{
        res(ev.target.result);
    };

    fileReader.onerror = e => {
        rej(e);
    }

    fileReader.readAsDataURL(fileBlob);

});

}


$(document).on('change','.imagen',function(){
    let nombre=$(this).attr('name');
    var files = $('.'+nombre)[0].files[0];
    $('.loading'+nombre).css('display','block');
    readAsBase64(files).then(fileInBase64 =>{
    $.post('{{ asset("almacenar/detalles") }}',{imagen:fileInBase64,id_orden:id_orden,id_lista:id_lista,id_elemento:nombre},function(result){
       $('.loading'+nombre).css('display','none');
    }
    
    );
        
    })
       
});

$(document).on('click','.ver',function(){
    version_imagen=Math.random();
    titulo=$(this).attr('titulo');
    
    $(".titulo-imagen").text('IMAGEN DE '+titulo);
    ruta=$(this).attr('ruta');
    ruta=ruta+ version_imagen; 
    $(".imagen_elemento").prop("src",ruta);

    $.getJSON('{{ asset("consultar_movil") }}',function(movil){
        //generar numero al hacer para que no me carge la imagen en cache
    if(movil){
        $("#modal-lgi").modal("show");
    }else{
        window.open(ruta,  'popup', 'top=100, left=200, width=653, height=440, toolbar=NO, resizable=NO, Location=NO, Menubar=NO,  Titlebar=No, Status=NO');
    }
      
    });
    
   });

   $(document).on('click','.gestionar_comentario',function(){
    $("textarea[name=comentario_text]").val("");
    id_elemento=$(this).attr('id');
    titulo=$(this).attr('titulo');
    $(".titulo-comentario").text('COMENTARIO DE '+titulo);
    //consular comentario en base de datos
    $.get('{{ asset("/consultar/comentario") }}/'+id_elemento,function(comentario){//si coloca getJSON sale error por que intenta reconocer json array en una cadena
        $("textarea[name=comentario_text]").val(comentario);
    });
   });

   $(document).on('change','.almacenar_base_datos',function(){
   
    texto=$(this).val();
    id_orden=$(this).attr("id_orden");
    tipo_campo="tecnico_check_orden";
    /*if(confirm('Esta seguro de chekear esta orden?')){
    }*/
        if(tipo_campo=="tecnico_check_orden"){
          
           $.get('{{ asset("/registrar/base_datos") }}/'+id_orden+'/'+texto+'/'+tipo_campo);
           if(2==3){
              alert("No pueden haber mas de dos ordenes abiertas")
           }
           if($(this).is(':checked')==false){
            window.location.reload();
           }
        }
        
        
   
    //registrar en base de datos al copiar
    
   });
/*
$(document).on('click','.trigger_form',function(){
  
    let id = $(this).attr('target');
$('.'+id+' > .act_form').trigger('click');
         
});*/

</script>
<style>
::placeholder {
  	color: White;
	font-weight: bold;
	font-size: 1.5em;
}
.letra_cursiva{
	font-family: garamond; 
	src: url('garamond-italic.ttf'); 
	font-style: italic;
 
}

 .estilotextarea {
	 width:90%;
	 height:300px;
	 background-color:black;
	 color:white; 
	 font-size: 15pt; 
 }
 
 

   .texto{
     border-style:outset;
     font-size: 15pt; 
     color:white; 
     font-weight:bolder;
     height:40px; 
     width:100%;
     background-color:black;
 }
 
 .texto4{    
     color:white; 
     background-color:black;
     text-align: center;
     font-size:15pt;
     /*-webkit-text-stroke: 1px white; PARA CAMBIAR EL ESILO DE LETRA */
    
    
 }
 
 .texto3{    
    border-style:outset;
     font-size: 18pt; 
     color:red; 
     font-weight:bolder;
     height:40px; 
     width:280px;
    }

    
   </style>
   @stop
