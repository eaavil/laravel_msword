

@extends('template.main')
@section('contenedor_principal')
<?php
  header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1//para que no guarde imagenes en meoria cache y me actualicen
  header("Expires: Sat, 1 Jul 2000 05:00:00 GMT"); // Fecha en el pasado
 
?>

<div class="container-fluid" >
                   <form action="{{ route('registrar.firma') }}" method="post" class="frmc_0001 mb-1" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            
                            <div class="mb-1">
                               <input type="text" list="personas" class="texto4 nombre" name="nombre" placeholder="CLIENTE" autocomplete="off" style="text-transform:uppercase" required>
                                
                                <datalist  id="personas">
                                   @foreach($personas as $rows)
                                   <option value="{{ $rows->nombre }}"></option>
                                   @endforeach
                                </datalist>
                              <i  class="fa fa-search" role="button" style='font-size:28px;color:black' onclick='buscar_persona()'></i>
                              </div>
                             
                             <div class=" mb-1">
                             <input type="text" class="texto requeridos"  name="rut" placeholder="RUT" autocomplete="off" required>
                             </div>
                           
                             <div class=" mb-1">
                                <input type="text" class="texto requeridos" name="correo" placeholder="E-MAIL"  autocomplete="off" style="text-transform:uppercase" required>
                             </div>
                             <div class="mb-1">
                                <input type="number" class="texto requeridos" name="telefono" placeholder="TELEFONO" autocomplete="off" required>
                             </div>
                             <div class="row mb-1 mx-1" >
                             
                                 <div class="col-6">
                                    <div class="form-check form-check-inline">
                                       <input class="form-check-input texto_check cliente" name="cliente" type="checkbox"><h5 style='font-weight: bold;'>CLIENTE</h5>
                                    
                                    </div>
                                 </div>
                                 <div class="col-6">
                                    <div class="form-check form-check-inline">
                                       <input class="form-check-input texto_check empleado" name="empleado" type="checkbox" onclick='visualizar_firma()'><h5 style='font-weight: bold;'>EMPLEADO</h5>
                                    </div>
                                 </div>
                           </div>
                           <div class="row mb-1 mx-1"> 
                                <div class="col-6">
                                    <div class="form-check form-check-inline">
                                       <input class="form-check-input texto_check proveedor" name="proveedor" type="checkbox"><h5 style='font-weight: bold;'>PROVEEDOR</h5>
                                    </div>
                                 </div>
                                 <div class="col-6">
                                    <div class="form-check form-check-inline">
                                       <input class="form-check-input texto_check tercero" name="tercero" type="checkbox"><h5 style='font-weight: bold;'>TERCERO</h5>
                                    </div>
                                 </div>
                           </div>  
                               @if($id_usuario==1)
                             <div class="row mb-1">
                             
                                @include('tecnico.modals.firma')
                             
                             <i class="fas fa-eraser borrar" role="button" style='font-size:40px;color:black' onclick='borrar_cambas()'>BORRAR FIRMA</i>

                            
                            </div>
                            @endif
                            <input type="hidden" class="salida" name="id"/>
                            <button  class="texto btn-block trigger_form" onclick='GuardarTrazado()' target="frmc_0001">CREAR ORDEN</button>
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
     width:91%;
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

   function visualizar_firma(){
     
         if ($('.empleado').is(':checked')) {
          //  $('.seccion_firma').css('display','block');no se puedo hacer por que la firma la envia negra
         }else{
           // $('.seccion_firma').css('display','none'); no se puedo hacer por que la firma la envia negra
         }
    };
   
   
   function buscar_persona(){
      $(".requeridos").attr('required', 'required');
     // $('.seccion_firma').css('display','none');no s epudo hacer por ue la firma la envia negra
      $("input[name=rut]").val('');
               $("input[name=representante]").val('');
               $("input[name=telefono]").val('');
               $("input[name=direccion]").val('');
               $("input[name=correo]").val('');
               $("input[name=cargo]").val('');
       $('#firma_actual').css('display','none');
       $(".cliente").prop("checked", false);
       $(".empleado").prop("checked", false);
       $(".proveedor").prop("checked", false);
       $(".recepcionista_OT").attr('checked',false);
      $.getJSON('{{ asset("buscar_persona") }}/'+$('.nombre').val(),function(dx){
        
       let version=Math.random();//generar numero aleatorio para que no me carge la imagen en cache
            $.each(dx,function(i,v){
               if(v.id!=""){
                  $(".requeridos").removeAttr("required");

               }
              
               $("input[name=rut]").val(v.nit);
               $("input[name=representante]").val(v.persona_contacto);
               $("input[name=telefono]").val(v.numero_telefono_1);
               $("input[name=direccion]").val(v.direccion);
               $("input[name=correo]").val(v.email_empresa);
               $("input[name=cargo]").val(v.cargo);
               
               if(v.firma){
                    $('#firma_actual').css('display','block');
                    $('#imagen_firma').attr('src','{{ asset("firmas") }}/'+v.id+".jpg?"+version);
               }else{
                   
               }
               if(v.es_empleado==1){
                  $(".empleado").prop("checked", true);
                 // $('.seccion_firma').css('display','block');no se pudo hacer por que la firma la envia negra
               }
               if(v.es_cliente==1){
                  $(".cliente").prop("checked", true);
               }
               if(v.es_proveedor==1){
                  $(".proveedor").prop("checked", true);
               }
               if(d.es_recepcionista==1){
                    $(".tercero").attr('checked',true);
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


               
              

