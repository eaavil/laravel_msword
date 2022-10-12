@extends('template.main')

@section('contenedor_principal')
 
 
 
   <select class="custom-select lisas" name="lista_1">
               
    </select>
    
  
     <select class="custom-select Lista_3" name="Lista_3">
 
    
    
 <form action="{{ route('registrar.lista') }}" method="post" class="frmc_0001" enctype="multipart/form-data">
     
     
         {{ csrf_field() }}
                        <div class="card border-0">
                            <div class="card-body pt-0">
       
         <br>
         <div class="form-row align-items-center">
	         <div class="col-md-12 mb-1">
	              <input type="text" class=" texto " name="documento" placeholder="RUT" required>
	      </div>
            <div class="col-md-5 mb-1">
                
               <input type="text"  class="texto" name="nombre" placeholder="CLIENTE"  required>
              
            </div>
             <div class="col-md-7 mb-1">
                  <input type="text" class="texto " name="direccion" placeholder="DIRECCION" required>
            </div>
            <div class="col-md-7 mb-1">
                  <input type="text" class="texto" name="correo" placeholder="E-MAIL" required>
            </div>
            <div class="col-md-7 mb-1">
               <input type="text" class="texto" name="representante" placeholder="REPRESENTANTE" required>
             
            </div>
            <div class="col-md-7 mb-1">
               <input type="number" class="texto" name="telefono" placeholder="TELEFONO" required>
             
            </div>
            <div class="col-md-7 mb-1">
            <input type="number" class="texto " name="cargo" placeholder="CARGO" required>
            </div>
         </div>  
         <div class="input-group mb-1">
            <div class="input-group-prepend  mb-1">
               <label class=" small  " for="inputGroupSelect01"> <h3 style='font-weight: bold;'> SERVICIO:</h3>
               </label>
            </div>
            <select class="custom-select forma_pago" name="forma_pago">
               <option value="">LISTA 1..</option>
               <option value="1">INSTALACION</option>
               <option value="2">REPARACION</option>
               <option value="1">CHEQUEO</option>
               <option value="1">REVISION GARANTIA</option>
               <option value="2">REVISION CONTRATO</option>
               <option value="1">AUTOMATIZACION</option>
               <option value="1">SELLOS</option>
               <option value="1">CODIGOS</option>
               <option value="1">OTROS</option>
               
            </select>
         </div>
        
         
         <p><textarea  class="estilotextarea texto"  name="descripcion"  placeholder="DESCRIPCION"></textarea></p>

                             <input type="hidden" class="salida" name="id" />
         <button style="display:none" class="act_form"></button>
         <button  class="texto btn-block trigger_form"  target="frmc_0001">verificar lista</button>
         
         <div class="row tabla_articulos">
               </div>
     
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
	 width:280px;
	 height:240px;
	 background-color:black;
	  display: inline-block;
 }

   </style>
   

   
@stop

<script>

    /* $(document).on('click','.trigger_form',function(){
      
          let id = $(this).attr('target');
        if(-1>0){
            $('.frmc_0001').attr('action', "{{ route('contrato.actualizar') }}");
        }
        $('.'+id+' > .act_form').trigger('click');
          
    });*/

</script>



