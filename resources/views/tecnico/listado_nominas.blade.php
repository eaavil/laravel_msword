@extends('template.main')
@section('contenedor_principal')
@php
$titulo="prueba";
$codigo_nomina=Str::random(40);//csrf_field()
@endphp

@include('tecnico.modals.gestionar_busqueda')
@include('tecnico.modals.ver_video_listas')
<div class="gestionar_ordenes  container-fluid">
    <table id="2" width="100%" class="origen texto4" border=1 cellspacing="0" cellpadding="0"  >
         <thead >
            <tr border="1"  >
               <th  width="4%"><h4><STRONG>#</STRONG></h4> </th>
              
               <div>
                    <th class="principal_col"><h4><STRONG>Tecnico</STRONG></h4> </th>
                   <th class="principal_col"><h4><STRONG>Fecha</STRONG></h4> </th>
               </div>
               <th >
               <div class="row">
                    
                     <h4>&nbsp&nbsp<STRONG>ACCIONES</STRONG></h4> 
                        <a class="nav-link" href="#">
                          <i class="fas fa-question" style='font-size:140%;color:white' data-target="#modal-lgv" data-toggle="modal"></i>
                         </a>
                    
                    
                     <a class="nav-link" href="#">
                           <i class="fa fa-search" style='font-size:140%;color:white' data-target="#modal-lgb" data-toggle="modal"></i>
                    </a>
                    

                 </div>
               
              
        </th>
            </tr>
         </thead>
         <tbody  >
             @foreach($nominas as $rows)
            
                <tr>
                  <td> <h4>{{str_replace('N-','',$rows->numero)}} </h4>
                        
                   </td>
                
                    <td> <h4>{{$rows->empleado}} </h4>
                        
                   </td>
                   <td> <h4>{{substr($rows->created_at,5,-3)}} </h4>
                        
                   </td>
                  <td>	
                 <a role="button" href="{{asset('editar_nomina/'.$rows->id.'/0')}}"><i  style='font-size:35px;color:white' class="fas fa-pencil-alt"></i></a>
                
              
                   </td>
                </tr>
            @endforeach
             
                
         </tbody>
    </table>
</div>
<!-- cargar clientes a la busqueda-->
<datalist  id="clientes">
    @foreach($clientes as $rows)
        <option value="{{ $rows->nombre }}"></option>
    @endforeach
</datalist>
<!-- cargar tecnicos a la busqueda-->
<datalist  id="empleados">
    @foreach($tecnicos as $rows)
        <option value="{{ $rows->nombre }}"></option>
    @endforeach
</datalist>
<!-- cargar tecnicos a la busqueda-->
<datalist  id="ordenes">
    @foreach($nominas as $rows)
        <option value="{{ $rows->numero}}"></option>
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

/*cargar elementos de la busqueda
$(function(){
 
     
    $.each(@json($clientes), function(i,v){
                $(".cliente").append('<option value="'+v.id+'">'+v.nombre+'</option>');
        });
      
   })*/ 

//cargar tabla
function cargar_tabla(){
   
    $('.origen tbody').html("");
        cliente=$('.cliente').val();
        orden=$('.orden').val();
        empleado=$('.empleado').val();
        estado=$('.estado').val();
        fecha_inicio=$('.fecha_inicio').val();
        fecha_fin=$('.fecha_fin').val();
       $(".cantidades").css("width","98%")
        let contenido_tabla="";
         ordenes=[];
   $.post("{{ asset("buscar/orden")}}", {cliente:cliente,orden:orden,estado:estado,empleado:empleado,fecha_inicio:fecha_inicio,fecha_fin:fecha_fin}, function(elementos){
  
   
    $.each(elementos, function(i,v){
   
   if(v.existe==1){
    ordenes.push(v.id);
        contenido_tabla="";
            
        contenido_tabla=`
            <tr>
                  <td > <h4>`+v.numero.replace('OT-', '')+`</h4>  
                  <a role="button" href="{{asset('editar_orden/`+v.id+`/0')}}"><i  style='font-size:35px;color:white;display:none' class="fas fa-pencil-alt"></i></a> 
                  </td>
                  
                  <td>	
                  
                  `
            ; 
            var contador=0;
            $.each(v.ordenes_detalles, function(i,l){
                let linea="";
                var boton_guardar="";
                if(contador!=0){
                    linea=`<hr style="background-color: white" />`;
                    
                }else{
                    linea="";
                    contador=1;
                }
               if(l.descripcion!="sin descripcion" || l.id_elemento== 273 || l.id_elemento== 274 || l.id_elemento== 239 || l.id_elemento==240 || l.id_elemento==241 || 
               l.id_elemento==242){
                   
                   let nombre=l.descripcion;
                   let parte=l.parte;
                  
                   if(nombre=="sin descripcion"){
                       nombre=l.nombre_servicio;
                   }
                  
                    if(nombre.includes("RET")){
                       parte="";
                   }else{
                       nombre=nombre.substr(0,3);
                   }
                    contenido_tabla+=linea+ `<label for="name" style="width:353px"><h5>`+nombre+" "+parte+`</h5></label>
                    
                             <input type="text" class="formatear_miles for`+l.id+` valores" id="`+l.id+`" name="valor_servicio[]" value="`+l.valor_tecnico+`"
                               minlength="4" maxlength="8" size="10"> <br>
                               
                     
                      `;
               } 
            });
       
            contenido_tabla+=`</td></tr>
            `;
         
            
        
     
          $('.origen tbody').append(contenido_tabla);
        }
    });
 if(@json($id_usuario)==1){
                   boton_guardar= `<tr> <td colspan=2>
                             <button  class="enviar_firma btn-block trigger_form texto mb-1" onclick='GuardarNomina()' >GUARDAR</button> </td>
                            </tr>`;
                  
}
   $('.origen tbody').append(`
                 <tr>
                  <td width="30%"> <h4>DESCU.</h4>  
                  </td>
                  
                  <td>
                  <input type="text" class="descuentos formatear_miles fordescuentos"  name="descuentos" id="descuentos"
                    minlength="4" maxlength="8" size="10" value="0">
                  </td>
                  </tr>
                 <tr>
                  <tr>
                      <td width="30%"> <h4>SUELDO</h4>  
                      </td>
                      
                      <td>
                      <input type="text" class="dias" 
                    minlength="1" maxlength="1" size="1">
                   <input type="text" class="val_dia formatear_miles formultiplicar"  
                    minlength="4" maxlength="8" size="3" id="multiplicar">
                  <input type="text" class="sueldo valores formatear_miles forsueldo"  name="sueldo" id="sueldo"
                  minlength="4" maxlength="10" size="5">
                      </td>
                  
                  </tr>
                 <tr>
                  <td width="30%"> <h4>TOTAL</h4>  
                  </td>
                  
                  <td>
                  <input type="text" class="total" readonly name="total" 
                    minlength="4" maxlength="8" size="10">
                  </td>
                  <tr>
                  <td width="30%"> <h4>OBSERVACIONES</h4>  
                  </td>
                  
                  <td>
                  <p><textarea  class="estilotextarea mb-1 observaciones"  name="observacion"  placeholder="OBSERVACIONES"></textarea></p>
                  </td>
                  </tr>
                  </tr>`+boton_guardar);
});


 /* $.post({{asset("buscar/orden")}},{cliente:cliente,orden:orden,estado:estado,empleado:empleado,fecha_inicio:fecha_inicio,fecha_final:fecha_final},
    function(elementos){
        
        $.each(elementos, function(i,v){
            contenido_tabla=`
            <tr>
                  <td width="30%"> <h4>{{str_replace('OT-','', $rows->numero)}}-{{date('d/m',strtotime($rows->created_at))}}</h4> </td>
                  <td>	
                  
                  <a role="button" class="mostrar_listas" onclick="gestionar_listas({{$rows->id}})" style='font-size:35px;color:white'>
                  <i `
            ; 
   
            if(v.recibido==1){
                contenido_tabla+=`style='font-size:35px;color:green`;
            }

            if(v.requerimiento_inicial){
                 contenido_tabla+=`style=font-size:35px;color:yellow`;
            }
            contenido_tabla+= `class="fas fa-list-alt"></i></a>
                  <a role="button" href="{{asset('editar_orden/'.$rows->id.'/0')}}"><i  style='font-size:35px;color:white' class="fas fa-pencil-alt"></i></a>
                  <a role="button" href="{{asset('eliminar/orden/'.$rows->id)}}"><i  style='font-size:35px;color:white' class="fas fa-trash-alt"></i></a>
                  <a role="button" class="print" data-id="{{$rows->id}}"><i  style='font-size:35px;color:white' class="fas fa-print"></i></a>
                  <a role="button"  target="_blank" href="{{asset('editar_orden/'.$rows->id.'/documento_para_firmar')}}"><i  style='font-size:35px;color:white' class="fas fa-pen-nib"></i></a>
                      
                   </td>
             </tr>`;         

    });
});  */
  /*$.getJSON('{{ asset("buscar/orden") }}/'+cliente+'/'+orden+'/'+empleado+'/'+estado+'/'+fecha_inicio+'/'+fecha_fin,
        function(elementos){
        
        $.each(elementos, function(i,v){
            contenido_tabla=`
            <tr>
                  <td width="30%"> <h4>{{str_replace('OT-','', $rows->numero)}}-{{date('d/m',strtotime($rows->created_at))}}</h4> </td>
                  <td>	
                  
                  <a role="button" class="mostrar_listas" onclick="gestionar_listas({{$rows->id}})" style='font-size:35px;color:white'>
                  <i `
            ; 
   
            if(v.recibido==1){
                contenido_tabla+=`style='font-size:35px;color:green`;
            }

            if(v.requerimiento_inicial){
                 contenido_tabla+=`style=font-size:35px;color:yellow`;
            }
            contenido_tabla+= `class="fas fa-list-alt"></i></a>
                  <a role="button" href="{{asset('editar_orden/'.$rows->id.'/0')}}"><i  style='font-size:35px;color:white' class="fas fa-pencil-alt"></i></a>
                  <a role="button" href="{{asset('eliminar/orden/'.$rows->id)}}"><i  style='font-size:35px;color:white' class="fas fa-trash-alt"></i></a>
                  <a role="button" class="print" data-id="{{$rows->id}}"><i  style='font-size:35px;color:white' class="fas fa-print"></i></a>
                  <a role="button"  target="_blank" href="{{asset('editar_orden/'.$rows->id.'/documento_para_firmar')}}"><i  style='font-size:35px;color:white' class="fas fa-pen-nib"></i></a>
                      
                   </td>
             </tr>`;         

     });
    });*/
     
return contenido_tabla;}
//cargar tabla a buscar en campo text
$(document).on('change','.buscar_ot',function(){
    $(".principal_col").css('display','none');
    if($(this).attr('seleccion')){
       cargar_tabla();
    }
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
       $.post('{{ asset("/registrar/base_datos") }}',{token:@json($codigo_nomina),
        total:$('.total').val(),sueldo:$('.sueldo').val(),
        empleado:$(".empleado").val(),
        ordenes:ordenes,
        tipo_campo:"nomina", 
        descuentos:$(".descuentos").val(), 
        observaciones:$(".observaciones").val(), 
        dias:$(".dias").val(), 
        val_dia:$(".val_dia").val(),
        inicio:$('.fecha_inicio').val(),
        fin:$('.fecha_fin').val() },function(result){
       alert("Nomina registrada");
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
$(document).on('click','.editar',function(){
        var id= $(this).attr('data-id');
        var modo=2;
        window.open('{{ asset("imprimir_orden") }}/'+id+"/"+modo);
});
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
	 width:100%;
	 height:300px;
	 background-color:black;
     color:white; 
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
