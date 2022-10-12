

@extends('template.main')
@section('contenedor_principal')
<?php
  header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1//para que no guarde imagenes en meoria cache y me actualicen
  header("Expires: Sat, 1 Jul 2000 05:00:00 GMT"); // Fecha en el pasado
 
?>

<div class=" container-fluid " >
                   <form action="{{ route('registrar.firma') }}" method="post" class="frmc_0001" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            
                             <div class="col-md-12 mb-1">
                                <input type="text" class="nit texto4" list="rut" name="documento" placeholder="RUT" autocomplete="off" required>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                                <i  class="fas fa-user-alt " role="button" style='font-size:34px;color:black' onclick='buscar_persona()'></i>
                                 
                                <datalist  id="rut">
                                   @foreach($personas as $rows)
                                   <option value="{{ $rows->nit }}"></option>
                                   @endforeach
                                </datalist>
                             </div>
                             <div class="col-md-5 mb-1">
                                <input type="text"  class="texto" name="nombre" placeholder="CLIENTE" autocomplete="off"  required>
                             </div>
                              <div class="col-md-7 mb-1">
                                <input type="text" class="texto " name="ciudad" placeholder="CIUDAD" autocomplete="off" required>
                             </div>
                             <div class="col-md-7 mb-1">
                                <input type="text" class="texto " name="comuna" placeholder="COMUNA" autocomplete="off" required>
                             </div>
                             <div class="col-md-7 mb-1">
                                <input type="text" class="texto " name="direccion" placeholder="DIRECCION" autocomplete="off" required>
                             </div>
                             <div class="col-md-7 mb-1">
                                <input type="email" class="texto" name="correo" placeholder="E-MAIL"  autocomplete="off" required>
                             </div>
                           
                             <div class="col-md-7 mb-1">
                                <input type="number" class="texto" name="telefono" placeholder="TELEFONO" autocomplete="off" required>
                             </div>
                             <div class="col-md-12 mb-1">
                                <input type="text" class="nit texto caracteristica" list="caracteristicas" name="caracteristicas" placeholder="CARACTERISTICAS" value="EMPLEADO" autocomplete="off" required>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                             
                                 
                                <datalist  id="caracteristicas">
                                   
                                  <option value="CLIENTE"></option>
                                  <option value="EMPLEADO"></option>
                                  <option value="PROVEEDOR"></option>
                                </datalist>
                             </div>
                             @include('tecnico.modals.firma')
                             <i  class="fas fa-eraser borrar" role="button" style='font-size:40px;color:black' onclick='borrar_cambas()'></i>
                          
                            <input type="hidden" class="salida" name="id"/>
                                <button  class="texto btn-block trigger_form" onclick='GuardarTrazado()' target="frmc_0001">REGISTRAR PERSONA</button>
                            <div class="row tabla_articulos"></div>
                        </form>
                        </div>
                        
<style>


   ::placeholder {
   color: White;
   font-weight: bold;
   font-size: 1.2em;
   }
   .letra_cursiva{
   font-family: garamond; 
   src: url('garamond-italic.ttf'); 
   font-style: italic;
   }
   .estilotextarea {
        border-style:outset;
     font-size: 18pt; 
     color:white; 
     font-weight:bolder;
   width:100%;
   height:290px;
   background-color:black;
   display: inline-block;
   }
.texto3{    
    border-style:outset;
     font-size: 18pt; 
     color:red; 
     font-weight:bolder;
     height:40px; 
     width:100%;
     background-color:black;
    
 }
   .texto_check{    
   border-style:outset;
     font-size: 18pt; 
     color:red; 
     font-weight:bolder;
     height:40px;
     width:40px;
     background-color:black;
    
 }
      .texto{    
    border-style:outset;
     font-size: 18pt; 
     color:white; 
     font-weight:bolder;
     height:40px; 
     width:100%;
     background-color:black;
    
 }
 
.texto4{    
    border-style:outset;
     font-size: 18pt; 
     color:white; 
     font-weight:bolder;
     height:40px; 
     width:81%;
     background-color:black;
    
 }
 .prop_canvas{    
   
    border: 1px;
    solid: #CCC;
 }
 .container2 {
  max-width: 260px;
}
</style>
@stop
<script>

   
var intentos=1;
 
    
      
   /* $(document).on('click','.trigger_form',function(){
     
         let id = $(this).attr('target');
       if(-1>0){
           $('.frmc_0001').attr('action', "{{ route('contrato.actualizar') }}");
       }
       $('.'+id+' > .act_form').trigger('click');
         
   });*/
    $(document).on('change',".Tipo_servico",function (evt) {
        
        $option= $(".Tipo_servico option:selected").val();
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
   
   function buscar_persona(){
        $.getJSON('{{ asset("buscar_persona") }}/'+$('.nit').val(),function(dx){
        //generar numero al hacer para que no me carge la imagen en cache
       let version=Math. random();
            $.each(dx,function(i,v){
               
               $("input[name=nombre]").val(v.nombre);
               $("input[name=telefono]").val(v.numero_telefono_1);
               $("input[name=direccion]").val(v.direccion);
               $("input[name=correo]").val(v.email_empresa);
               if(v.firma){
                    $('#firma_actual').css('display','block');
                    $('#imagen_firma').attr('src','{{ asset("firmas") }}/'+v.id+".jpg?"+version);
               }else{
                    $('#prueba').css('display','none');
               }
               if(v.es_cliente){
                   $(".caracteristica").val('EMPLEADO');
               }
               if(v.es_cliente){
                   $(".caracteristica").val('CLIENTE');
               }
               if(v.es_proveedor){
                   $(".caracteristica").val('PROVEEDOR');
               }
            })
        });
   }
   
      function borrar_cambas(){
          location.reload();
       /* var canvas = document.getElementById("canvas");
        var ctx = canvas.getContext("2d");
        // Borramos el área que nos interese  css(propertyname, value);
        ctx.clearRect(0, 0,260 ,300);
        ctx.beginPath();
        ctx.clear(true);*/
      // $("#capa").load('{{ asset("/firma.php") }}');
         /* $("#capa").load({{ asset("/firma.php") }},{valor1:'primer valor', valor2:'segundo valor'}, function(response, status, xhr) {
        if (status == "error") {
          var msg = "Error!, algo ha sucedido: ";
          $("#capa").html(msg + xhr.status + " " + xhr.statusText);
        }
      });*/
      
      }
    
  
         
</script>


               
              

