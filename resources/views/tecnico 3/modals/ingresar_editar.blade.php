@extends('template.main')
@section('contenedor_principal')
<?php
  header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1//para que no guarde imagenes en meoria cache y me actualicen
  header("Expires: Sat, 1 Jul 2000 05:00:00 GMT"); // Fecha en el pasado
 $firma=file_exists('firmas_recibidos/'.$id_orden.'.jpg');
?>

<form action="{{ route('registrar_editar.orden.mobile') }}" method="post" class="frmc_0001" enctype="multipart/form-data">
         {{ csrf_field() }}
         
         
         @if($modo=='documento_para_firmar')
      
               
         <i role="button"  class="print mb-1" data-id="{{$id_orden}}">
               <div class="texto_imprimir"> CLICK AQUI PARA VER ORDEN</div>
         </i>
     
            
         @include('tecnico.modals.firma')
         <i  class="fas fa-eraser borrar" role="button" style='font-size:30px;color:black'  onclick='borrar_cambas()'>BORRAR FIRMA</i>
     @else
            <div class="input-group mb-1">
            <input type="text" class="texto3" style="text-align:center;" name="correlativo" value={{$correlativo}} required readonly>&nbsp
               <a role="button" class="doc_firma" target="_blank" href="{{asset('editar_orden/'.$id_orden.'/documento_para_firmar')}}"><i  style='font-size:30px;color:black' class="fas fa-pen-nib"></i></a>
            </div>
         
         <div class="input-group mb-1">
         <select class="cliente texto almacenar_base_datos" style = "color: # 009bdd;" name="cliente">
               <option value="">SELECCIONE CLIENTE</option>
               @foreach($personas as $rows)
               <option value="{{ $rows->id }}">{{ $rows->nombre}}</option>
               @endforeach
            </select>
         </div>
         <div class=" mb-1">
               <input type="text" class="texto requeridos modelo" name="modelo" placeholder="MODELO VEHICULO" autocomplete="off" style="text-transform:uppercase" required>
         </div>
         <div class=" mb-1">
               <input type="text" class="texto requeridos patente" name="patente" placeholder="PATENTETE" autocomplete="off" style="text-transform:uppercase" required>
         </div>
         <div class="input-group mb-1">
         <select class="cliente combo almacenar_base_datos" style = "color: # 009bdd;" name="tecnico">
               <option value="">SELECCIONE TECNICO</option>
               @foreach($personas as $rows)
               <option value="{{ $rows->id }}">{{ $rows->nombre}}</option>
               @endforeach
            </select>
        </div>
         <div class=" input-group">
                  
                  <select class="elemento texto5 combo"    >
                  <option value="">SELECCIONE ARTICULO</option>
                      @foreach($inventario as $rows)
                        <option value="{{ $rows->id }}">{{ $rows->nombre }}</option>
                        @endforeach
                  </select>

                  <a role="button" class="agregar_elemento" ><i  style='font-size:30px;color:black' class="fas fa-plus"></i></a>
   
                <table id="2" width="100%"  class="descripcion_tabla" border="1"  style="color:black;font-size:90%; text-align: center; table-layout: fixed;">
                  <thead>
                     <tr border="1"  style="background:#ccc;" >
                        <th width="70%">Item</th>
                        <th>Cant.</th>
                        <th >Valor</th>
                        <th width="10%" >Acciones</th>
                     </tr>
                  </thead>
                  <tbody >
                  </tbody>
               </table>
       
</div>
<div class="row">
   
                  <div class="col-4">
                     <div class="form-check form-check-inline">
                        <input type="text" class=" t1 texto neto" name="neto" value="0" placeholder="neto" readonly>&nbsp
                        <input class="form-check-input texto_check iva" id="iva" name="iva" type="checkbox" onclick='visualizar_firma()'><h5 style='font-weight: bold;'>IVA</h5>

                     </div>
                  </div>
                 
                  <br>
                  <div class="col-4 origen" >
                     <div class="form-group">
                     <select class="form-control  descuento texto"  name="porcentaje_iva" >
                  <option value="">% DES.</option>
                  
                        <option value="0.05">5%</option>
                        <option value="0.10">10%</option>
                        <option value="0.15">15%</option>
                        <option value="0.20">20%</option>
                        
                  </select>
                     </div>
                  </div>
                  <br>
                  <div class="col-4 origen " style="float:right">
                     <input type="text" class="neto_des texto" name="neto_des" placeholder="total/des" >
                  </div>
                 
               </div>


<div class="input-group mb-1">
<select class="form-control  listas texto forma_pago"  name="forma_pago" >
                  <option value="">FORMA DE PAGO...</option>
                  
                        <option value="EFECTIVO">EFECTIVO</option>
                        <option value="TRANSFERENCIA">TRANSFERENCIA</option>
                        <option value="T_CREDITO">T. CREDITO</option>
                        <option value="OTRO">OTRO</option>
                        
                  </select>
      </div>


<div class=" input-group mb-2">
                  
                  <select class="detalle texto5 combo"    >
                  <option value="">SELECCIONE DETTALLE</option>
                      
                        <option value="CAPO">CAPO</option>
                        <option value="MALETERO">MALETERO</option>
                        <option value="PUERTA DERECHA DELANTERA">PUERTA DERECHA DELANTERA</option>
                        <option value="PUERTA DERECHA TRASERA">PUERTA DERECHA TRASERA</option>
                        <option value="PUERTA IZQUIERDA TRASERA">PUERTA IZQUIERA TRASERA</option>
                        <option value="PUERTA IZQUIERDA DELANTERA">PUERTA IZQUIERA DELANTERA</option>
                        <option value="FOCO IZQUIERDO TRASERO">FOCO IZQUIERO TRASERO</option>
                        <option value="FOCO IZQUIERDO DELANTERO">FOCO IZQUIERO DELANTERO</option>
                        <option value="FOCO DERECHO TRASERO">FOCO DERECHO TRASERO</option>
                        <option value="FOCO DERECHO DELANTERO">FOCO DERECHO DELANTERO</option>
                        <option value="VENTANA IZQUIERDA TRASERO">VENTANA IZQUIERDA TRASERA</option>
                        <option value="VENTANA IZQUIERDA DELANTERO">VENTANA IZQUIERDA DELANTERA</option>
                        <option value="VENTANA DERECHA TRASERA">VENTANA DERECHA TRASERA</option>
                        <option value="VENTANA DERECHA DELANTERA">VENTANA DERECHA DELANTERA</option>
                        <option value="RETROVISOR IZQUIERDO">RETROVISOR IZQUIERDO</option>
                        <option value="RETROVISOR DERECHO">RETROVISOR DERECHO</option>
                        <option value="COSTADO DERECHO">COSTADO DERECHO</option>
                        <option value="COSTADO IZQUIERDO">COSTADO IZQUIERDO</option>
                        <option value="GUARDA BARRO DERECHO">GUARDA BARRO DERECHO</option>
                        <option value="GUARDA BARRO IZQUIERDO">GUARDA BARRO IZQUIERDO</option>
                  </select>

                  <a role="button" class="agregar_detalle" ><i  style='font-size:30px;color:black' class="fas fa-plus"></i></a>
   
                <table id="2" width="100%"  class="detalle_tabla" border="1"  style="color:black;font-size:90%; text-align: center; table-layout: fixed;">
                  <thead>
                     <tr border="1"  style="background:#ccc;">
                        <th width="60%">Item</th>
                        <th width="40%" >Acciones</th>
                     </tr>
                  </thead>
                  <tbody >
                  </tbody>
               </table>
       
</div>
<p><textarea  class="estilotextarea almacenar_base_datos_text mb-1"  name="observacion"  placeholder="OBSERVACIONES"></textarea></p>
      @endif
         <input type="hidden" class="salida" name="id"/>
         <input type="hidden" class="id" name="id" value="{{$id_orden}}"/>
         <input type="hidden"  name="es_movil" value="1"/>
         <button  class="enviar_firma btn-block trigger_form texto_aviso mb-1" onclick='GuardarTrazado()' target="frmc_0001">ENVIAR ORDEN</button>
      
   </form>
  @include("tecnico.modals.gestionar_comentario")              

<script>


/*$(function() {//como ejecutar una funcion al cargar dom
   $('.cliente_2').val("0");
});*/

var intentos=1;
/* $(document).on('click','.trigger_form',function(){
     
         let id = $(this).attr('target');
       if(-1>0){
           $('.frmc_0001').attr('action', "{{ route('contrato.actualizar') }}");
       }
       $('.'+id+' > .act_form').trigger('click');
         
});*/
 
  var id_orden=@json($id_orden);
  var texto="";
  var id_articulo=0;
  var nombre_lista="";
  var edicion=0;
  var neto=0;
  var id_comentario=0;
  var detalle="";
  //actualizar al editar
  
  $(function(){
   if(@json($id_usuario)==1){
      $('.tecnico_1').removeAttr('disabled');
      $('.tecnico_2').removeAttr('disabled');
      $('.tecnico_3').removeAttr('disabled');
      $('.tecnico_3').removeAttr('disabled');
      $("textarea[name=requerimiento_inicial]").prop('readonly', false);
   }
   $('.enviar_firma').text('GUARDAR');
      $('.navbar').css('display','block');
      $('.main-sidebar').css('display','block');
      
      if(@json($modo)=='registrar'){
         $('.cliente').val(@json($id_persona)).trigger('change');
      }
      //si es editar
      if(@json($id_orden)!=0){
         if(@json($modo)=='documento_para_firmar'){
            $('.enviar_firma').text('ENVIAR FIRMA');
         }
         let version=Math.random();
         //buscar 0rden
     
        //generar numero al hacer para que no me carge la imagen en cache
       
        $.each(@json($orden),function(i,v){
            $('.id').val(@json($id_orden));
            $('.cliente').val(v.id_cliente).trigger('change');
            $('.modelo').val(v.modelo);
            $('.patente').val(v.patente);
            $('.tecnico').val(v.tecnico).trigger('change');
            $('.forma_pago').val(v.forma_pago).trigger('change');
            $('.neto').val(v.total).trigger('change');
           
            if(v.es_iva==1){
               $(".iva").prop("checked", true);
            }
            
            if(v.descuento!=0){
            $('.descuento').val(v.descuento).trigger('change');
            }
            $('.neto_des').val(v.total_des).trigger('change');
            
            //si existe la firma en el servidor
            if(@json($firma)){
               
                 $('#firma_actual').css('display','block');
                 $('#imagen_firma').attr('src','{{ asset("firmas_recibidos") }}/'+v.id+".jpg?"+version);
            }
            
            if(v.observacion!='sin_texto'){
            $("textarea[name=observacion]").val(v.observacion);
            }
            //cargar detalles
            $.each(@json($orden_detalle),function(i,v){
               
               $('.descripcion_tabla tbody').append(
                        `<tr class="oc`+v.id_elemento+`">
                       <td width="41%"><strong>`+v.nombre+`</strong><input type="hidden" name="entrada[]" value="`+v.id_elemento+`"/> </td>
                       <td> <input type="text" name="cantidad[]" carro="1" style="width:50%;background:#FBD03D;" value="1" /> UN</td>
                       <td>$ <input type="text" class="formatear_miles" carro="1"  max="100" name="valor[]" style="width:75%;background:#FBD03D;" value="`+v.valor+`" readonly /></td>
                       <td>
                          <input type="hidden"  class="comentario`+v.id_elemento+`" max="100" name="comentario[]" style="width:50%" value="`+v.comentario+`" /> 
                          
                          <button type="button" class="btn btn-warning comentario" data-toggle="modal" data-target="#modal-lgc" title="Comentario" data-id="`+v.id_elemento+`">
                                <i class="fas fa-comments" aria-hidden="true"></i>
                          </button> 
                          <button type="button" class="btn btn-danger  remover" title="Remover" data-id="`+v.id_elemento+`">
                             <i class="fa fa-trash" aria-hidden="true"></i>
                          </button>
                       </td>
                    
                    </tr>`
               )
            })
            //cargar_chekeos
            $.each(@json($orden_chekeo),function(i,v){
  
               $('.detalle_tabla tbody').append(
                  `<tr class="oc`+v.item.replace(/ /g, "")+`">
                              <td width="41%"><strong>`+v.item+`</strong><input type="hidden" name="entrada_detalle[]" value="`+v.item+`"/> </td>
                              <td>
                                 <input type="hidden"  class="comentario`+v.item+`" max="100" name="comentario_detalle[]" style="width:50%" value="`+v.comentario+`"/> 
                                 
                                 <button type="button" class="btn btn-warning comentario" data-toggle="modal" data-target="#modal-lgc" title="Comentario" data-id="`+v.item+`">
                                       <i class="fas fa-comments" aria-hidden="true"></i>
                                 </button> 
                                 <input type="hidden" class="imagen_base64`+v.item+`" name="imagen_base64[]" />
                                 <label for="imagen`+v.item+`" >
                                    <i class="fas fa-camera mb-2"  style="font-size:30px;cursor:pointer;"></i>
                                 </label>
                                   
                                    <input id="imagen`+v.item+`" name="`+v.item+`" class="imagen `+v.item+`"  type="file" accept="image/*" capture="camera" style="display:none" />
                                    <img src="dist/img/loader.gif" alt="loading"  class="loading`+v.item+`" style="display:none">
                                    <i class='far fa-image ver' style='font-size:30px'
                                       ruta="https://polariauto.000webhostapp.com/chekeos/`+id_orden+'-'+v.item+'.jpg?'+`" 
                                       
                                       
                                    ></i>
                                 <button type="button" class="btn btn-danger remover" title="Remover"  data-id="`+v.item.replace(/ /g, "")+`">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                 </button>
                              </td>
                           
                           </tr>`
                );
            })
      })
     
      
      
      //si es un documento para firmar bloqueo todo los campos
     
      if(@json($modo)=="documento_para_firmar"){
            $('.navbar').css('display','none');
            $('.main-sidebar').css('display','none');
            $('.cliente').prop('readonly', true);
            $('.servicio').prop('readonly', true);
            $('.tecnico_1').prop('readonly', true);
            $('.tecnico_2').prop('readonly', true);
            $('.tecnico_3').prop('readonly', true);
            $(".tecnico_1_check").prop('readonly', true);
            $(".tecnico_2_check").prop('readonly', true);
            $(".tecnico_3_check").prop('readonly', true);
            $("textarea[name=descripcion]").prop('readonly', true);
            
      }
      //ocultar nav bar
      }
	});
   $(document).on('change','.imagen',function(){
      let nombre=$(this).attr('name');
      var files = $('.'+nombre)[0].files[0];
     
      //$('.loading'+nombre).css('display','block');
      readAsBase64(files).then(fileInBase64 =>{
         $(".imagen_base64"+nombre).val(fileInBase64);
      /*$.post('{{ asset("almacenar/detalles") }}',{imagen:fileInBase64,id_orden:id_orden,id_elemento:nombre},function(result){
         $('.loading'+nombre).css('display','none');
      }
      
      );*/
         
      })
       
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
   $(document).on('click','.remover',function(){
        let id = $(this).attr('data-id');
        $('.oc'+id).remove();
        totalizar();
    });
  $(document).on('click','.agregar_elemento',function(){
   id_articulo=$(".elemento option:selected").val();
            nombre_articulo=$(".elemento option:selected").text();
            if(id_articulo!='' && verificar_existencia(id_articulo,2)!=0){
                edicion=0;
               
                $.getJSON('{{ asset("/buscar/articulo") }}/'+id_articulo,function(articulo){
                  

                   $.each(articulo,function(i,v){
                      contenido_tabla=`<tr class="oc`+v.id+`">
                              <td width="41%"><strong>`+v.nombre+`</strong><input type="hidden" name="entrada[]" value="`+v.id+`"/> </td>
                              <td> <input type="text" name="cantidad[]" carro="1" style="width:50%;background:#FBD03D;" value="1" /> UN</td>
                              <td>$ <input type="text" class="formatear_miles" carro="1"  max="100" name="valor[]" style="width:75%;background:#FBD03D;" value="`+v.valor+`" readonly /></td>
                              <td>
                                 <input type="hidden"  class="comentario`+v.id+`" max="100" name="comentario[]" style="width:50%" /> 
                                 
                                 <button type="button" class="btn btn-warning comentario" data-toggle="modal" data-target="#modal-lgc" title="Comentario" data-id="`+v.id+`">
                                       <i class="fas fa-comments" aria-hidden="true"></i>
                                 </button> 
                                 <button type="button" class="btn btn-danger remover" title="Remover" data-id="`+v.id+`">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                 </button>
                              </td>
                           
                           </tr>`
                           ;
                  });
                  
                  
                  $('.descripcion_tabla tbody').append(contenido_tabla);
                  totalizar();  
                });
                
                
              
      }
});
function verificar_existencia(id,tipo_tabla){
        let existencia=1;
      
        
        if(tipo_tabla==1){
         $.each($('.detalle_tabla tbody tr'),function(i,v){
                if (typeof $(this).find('input[name="entrada_detalle[]"]').val() !== 'undefined'){//si la variable esta definida
                   
                  num=$(this).find('input[name="entrada_detalle[]"]').val();
                if(num==id ){//si el articulo ya esta agregado
                    existencia=0;
                }
                }
        })
         
        }else{
         $.each($('.descripcion_tabla tbody tr'),function(i,v){
                if (typeof $(this).find('input[name="entrada[]"]').val() !== 'undefined'){//si la variable esta definida
                   
                  num=$(this).find('input[name="entrada[]"]').val();
                if(num==id ){//si el articulo ya esta agregado
                    existencia=0;
                }
                }
        })
        }
        
        
        return existencia
    };
$(document).on('click','.agregar_detalle',function(){
  
   detalle=$(".detalle option:selected").val();
            if(detalle!=''  && verificar_existencia(detalle,1)!=0){
                $('.detalle_tabla tbody').append(
                  `<tr class="oc`+detalle.replace(/ /g, "")+`">
                              <td width="41%"><strong>`+detalle+`</strong><input type="hidden" name="entrada_detalle[]" value="`+detalle+`"/> </td>
                              <td>
                                 <input type="hidden"  class="comentario`+detalle+`" max="100" name="comentario_detalle[]" style="width:50%" /> 
                                 
                                 <button type="button" class="btn btn-warning comentario" data-toggle="modal" data-target="#modal-lgc" title="Comentario" data-id="`+detalle+`">
                                       <i class="fas fa-comments" aria-hidden="true"></i>
                                 </button> 
                                 <input type="hidden" class="imagen_base64`+detalle+`" name="imagen_base64[]" />
                                 <label for="imagen`+detalle+`" >
                                    <i class="fas fa-camera mb-2"  style="font-size:30px;cursor:pointer;"></i>
                                 </label>
                                   
                                    <input id="imagen`+detalle+`" name="`+detalle+`" class="imagen `+detalle+`"  type="file" accept="image/*" capture="camera" style="display:none" />
                                    <img src="dist/img/loader.gif" alt="loading"  class="loading`+detalle+`" style="display:none">
                                    <i class='far fa-image ver' style='font-size:30px'
                                       ruta="https://polariauto.000webhostapp.com/chekeos/`+id_orden+'-'+detalle+'.jpg?'+`" 
                                       
                                       
                                    ></i>
                                 <button type="button" class="btn btn-danger remover" title="Remover"  data-id="`+detalle.replace(/ /g, "")+`">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                 </button>
                              </td>
                           
                           </tr>`
                );
      }
   });
$(document).on('change',".descuento",function (evt){
   totalizar();

});

$(document).on('click',".comentario",function (evt){
   
   id_comentario=$(this).attr("data-id");
   $(".almacenar_comentario").val($(".comentario"+id_comentario).val());

});

$(document).on('keyup',"[type='text']",function (evt){
   totalizar();
      
});
   
   function totalizar(){
   
      neto=0;
      var num=0;
      var cant=0;
      $.each($('.descripcion_tabla tbody tr'),function(i,v){
         
         num = $(this).find('input[name="valor[]"]').val().replace(/\./g,'');
         cant=$(this).find('input[name="cantidad[]"]').val().replace(/\./g,'');
         neto+=parseInt(cant*num);
         if(document.getElementById('iva').checked){
            neto=neto+parseFloat(neto*0.19);
         }

         
         $('.neto').val(neto);
         $('.neto').inputmask({ 'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'digits': 0, 'digitsOptional': false, 'placeholder':''});  
         if($('.neto').val()!=""){
            let descuento=$('.neto').val().replace(/\./g,'')*parseFloat($(".descuento option:selected").val());
            let total=parseInt($('.neto').val().replace(/\./g,''))-descuento;
   
           $('.neto_des').val(total);
           $('.neto_des').inputmask({ 'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'digits': 0, 'digitsOptional': false, 'placeholder':''});  
         }else{
            $('.neto_des').val("");
         }
    });
   };
   //valor espejo para comentario
   $(document).on('keyup','.almacenar_comentario',function(){
   $(".comentario"+id_comentario).val($(this).val());
   
  });
//formatear miles
$(document).on('keyup',".formatear_miles",function (evt){
         //utilizar libreria input mask
        $(this).inputmask({ 'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'digits': 0, 'digitsOptional': false, 'placeholder':''});
});
//

$(document).on('change',".iva",function (evt){
        
         totalizar()
       
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

   function cargar_tabla(articulo){
      
        //armamos la celda de elementos
       
        if(elementos_html==""){
            elementos_html='sin elementos';
        }else{

        }
   return contenido_tabla;} 
  //actualizar al editar
  /*$(function(){
   if(@json($id_usuario)==1){
      $('.tecnico_1').removeAttr('disabled');
      $('.tecnico_2').removeAttr('disabled');
      $('.tecnico_3').removeAttr('disabled');
      $('.tecnico_3').removeAttr('disabled');
      $("textarea[name=requerimiento_inicial]").prop('readonly', false);
   }
   $('.enviar_firma').text('GUARDAR');
      $('.navbar').css('display','block');
      $('.main-sidebar').css('display','block');
      if(@json($modo)=='registrar'){
         $('.cliente').val(@json($id_persona)).trigger('change');
      }
      if(@json($id_orden)!=0){
         if(@json($modo)=='documento_para_firmar'){
            $('.enviar_firma').text('ENVIAR FIRMA');
         }
         let version=Math.random();
         //buscar 0rden
         $.getJSON('{{ asset("consultar_orden") }}/'+@json($id_orden),function(dx){
        //generar numero al hacer para que no me carge la imagen en cache
        
        $.each(dx,function(i,v){
            $('.id').val(@json($id_orden));
            $('.cliente').val(v.id_cliente).trigger('change');
            $('.servicio').val(v.servicio).trigger('change');
            $('.tecnico_1').val(v.tecnico_1).trigger('change');
            $('.tecnico_2').val(v.tecnico_2).trigger('change');
            $('.tecnico_3').val(v.tecnico_3).trigger('change');
            $("."+v.tecnico_firma+"_check").prop("checked", true);
            $(".recepcion").val(v.recibido);
            
            //si existe la firma en el servidor
            if(@json($firma)){
               
                 $('#firma_actual').css('display','block');
                 $('#imagen_firma').attr('src','{{ asset("firmas_recibidos") }}/'+v.id+".jpg?"+version);
            }
            if(v.cargo!='sin_texto'){
                $(".cargo_recepcion").val(v.cargo);
            }
            if(v.requerimiento_inicial!='sin_texto'){
            $("textarea[name=requerimiento_inicial]").val(v.requerimiento_inicial);
            }
            if(v.descripcion!='sin_texto'){
            $("textarea[name=descripcion]").val(v.descripcion);
            }
            })
        });
      //si es un documento para firmar bloqueo todo los campos
     
      if(@json($modo)=="documento_para_firmar"){
            $('.navbar').css('display','none');
            $('.main-sidebar').css('display','none');
            $('.cliente').prop('readonly', true);
            $('.servicio').prop('readonly', true);
            $('.tecnico_1').prop('readonly', true);
            $('.tecnico_2').prop('readonly', true);
            $('.tecnico_3').prop('readonly', true);
            $(".tecnico_1_check").prop('readonly', true);
            $(".tecnico_2_check").prop('readonly', true);
            $(".tecnico_3_check").prop('readonly', true);
            $("textarea[name=descripcion]").prop('readonly', true);
            
      }
         
      
      //ocultar nav bar
      
         
      }
	});*/


   
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



      
      
$(document).on('click','.print',function(){
        var id= $(this).attr('data-id');
        window.open('{{ asset("imprimir_orden") }}/'+id);
});


</script>
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

   .estilotextarea_requerimiento_inicial{
      border-style:outset;
      font-size: 18pt; 
      color:white; 
      font-weight:bolder;
      width:100%;
      height:140px;
      background-color:black;
      display: inline-block;

   }
   .texto_imprimir{    
    border-style:outset;
     font-size: 18pt; 
     color:red; 
     font-weight:bolder;
     height:40px; 
     width:100%;
     background-color:black;
     text-align: center;
    
 }
.texto3{    
    border-style:outset;
     font-size: 18pt; 
     color:red; 
     font-weight:bolder;
     height:40px; 
     width:95%;
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
 .texto5{    
    border-style:outset;
     font-size: 18pt; 
     color:white; 
     font-weight:bolder;
     height:40px; 
     width:90%;
     background-color:black;
    
 }
 .texto_aviso{    
    border-style:outset;
     font-size: 17pt; 
     color:red; 
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
     width:100%;
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