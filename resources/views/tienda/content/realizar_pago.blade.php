@include('tienda.head')
<!------------>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> 
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

<div class="navbar bs-nav-center">
         <div class="container">
            <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#menuPrincipal" aria-controls="menuPrincipal" aria-expanded="false" aria-label="Toggle navigation" enctype="multipart/form-data">
            <i class="fas fa-bars"></i>
            </button>
            <a class="navbar-brand py-0 mr-auto ml-3 ml-sm-n0" href="/">
            <img data-bs="header.logo"
               class="img-fluid d-print-block" src={{asset("/tienda/tecnor_logistic.png")}}
               title="TKS Tecnologia y Seguridad Spa" alt="TKS Tecnologia y Seguridad Spa">
            </a>
         </div>
      </div>
<div class=" container-fluid ">
    <div class="row justify-content-center ">
        <div class=" col-xl-10">
            <div class="card shadow-lg ">
                <div class="row justify-content-around">
                    <div class="col-md-5 ">
                    <form action="{{ route('realizar.pago') }}" method="post" class="frmc_0001" enctype="multipart/form-data">
         {{ csrf_field() }}
                        <div class="card border-0">
                            <div class="card-body pt-0">
                            <div class="card-header card-2">
                                <p class="card-text text-muted "> <strong>DATOS NECESARIOS PARA LA COMPRA</strong> </p>
                            </div>
       
         <br>
         <div class="form-row align-items-center">
         <div class="col-md-12 mb-1">
           
            <label class="small text-muted" for="nombre">Nombre completo</label>
               <input type="text" class="form-control " name="nombre" required>
              
        </div>
            <div class="col-md-5 mb-1">
            <label  class="small text-muted"  for="documento">Documento</label>
               <input type="text" class="form-control " name="documento" required>
              
            </div>
            <div class="col-md-7 mb-1">
               <label class="small text-muted mb-1" for="correo">Correo electronico</label>
               <div class="input-group">
                  <input type="text" class="form-control " name="correo" required>
               
               </div>
            </div>
            <div class="col-md-5 mb-1">
               <label  class="small text-muted mb-1" for="ciudad">Ciudad</label>
               <input type="text" class="form-control " name="ciudad"  required>
              
            </div>
            <div class="col-md-7 mb-1">
               <label class="small text-muted mb-1" for="telefono">Telefono</label>
               <input type="number" class="form-control " name="telefono" required>
             
            </div>
         </div> 
         <div class="input-group mb-1">
            <div class="input-group-prepend  mb-1">
               <label class="input-group-text small text-muted " for="inputGroupSelect01">Como quieres recibir tu pedido:</label>
            </div>
            <select class="custom-select recibir_pedido" name="recibir_pedido">
               <option value="">SELECCIONE..</option>
               <option value="1">RETIRO EN TIENDA</option>
               <option value="2">ENVIO A DOMICILIO</option>
            </select>
         </div>
         <div class="form-row domicilio " style="display:none">
                <div class="alert alert-danger col-md-12  mb-2 " role="alert" >
                Recuerde que al llegar el domicilio debera pagar el valor del flete
                </div>
            <div class="col-md-12 mb-1">
               <label  class="small text-muted mb-1" for="direccion">Direcccion domicilio</label>
               <input type="text" class="form-control " name="direccion"  >
              
            </div>
         
         </div>
         
         <div class="alert alert-danger  mb-2 retiro_tienda" role="alert"  style="display:none">
         Bella Vista 4283 con Paraguay 83 
         </div>
         <div class="input-group mb-1">
            <div class="input-group-prepend  mb-1">
               <label class="input-group-text small text-muted " for="inputGroupSelect01">Forma de pago:</label>
            </div>
            <select class="custom-select forma_pago" name="forma_pago">
               <option value="">SELECCIONE..</option>
               <option value="1">PAGAR EN TIENDA</option>
               <option value="2">CONSIGNACION A CUENTA </option>
            </select>
         </div>
         <div class="form-row consignacion_cuenta" style="display:none">
         <div class="alert alert-danger  mb-2" role="alert">
         Al consignar el total del carro en la cuenta 1110194501 del Banco de Chile le enviaremos su pedido<br>
      
          <!--Subir recibo de pago-->
         <input type="file" name="recibo_pago"  class="form-control" accept="image/*"  multiple style="display:none">
         </div>
         </div>
         <input type="hidden" class="id" name="id" value={{$id}}>
         <button style="display:none" class="act_form"></button>
         <button  class="btn btn-success btn-block trigger_form"  target="frmc_0001">Enviar compra</button>
     
      </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 ">
                        <div class="card border-0 ">
                            
                            <div class="card-body pt-0">
                            <div class="card-header card-2">
                                <p class="card-text text-muted space"><strong>TU CARRITO DE COMPRAS</strong></p>
                            </div>
                            <br>
                               @foreach($carro_detalle as $rows)
                                <div class="row justify-content-between">
                                    
                                    <div class="col-auto col-md-7">
                                        <div class="media flex-column flex-sm-row"> <img class=" img-fluid" src="{{asset("tienda/1-".$rows->id_articulo.".png")}}" width="62" height="62">
                                            <div class="media-body my-auto">
                                                <div class="row ">
                                                    <div class="col-auto">
                                                        <p class="mb-0">{{$rows->nombre}}</p><small class="text-muted">$ {{number_format($rows->valor,0,',','.')}}</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class=" pl-0 flex-sm-col col-auto my-auto">
                                        <p class="boxed-1">{{$rows->cantidad}}</p>
                                    </div>
                                    <div class=" pl-0 flex-sm-col col-auto my-auto ">
                                        <p><b>$ {{number_format($rows->valor*$rows->cantidad,0,',','.')}}</b></p>
                                    </div>
                                </div>
                                <hr class="my-2">
                                 @endforeach
                                 <div class="row ">
                                    <div class="col">
                                        <div class="row justify-content-between">
                                            <div class="col-4">
                                                <p class="mb-1"><b>Subtotal</b></p>
                                            </div>
                                            <div class="flex-sm-col col-auto">
                                                <p class="mb-1"><b>$ {{number_format($neto,0,',','.')}}</b></p>
                                            </div>
                                        </div>
                                        <div class="row justify-content-between">
                                            <div class="col">
                                                <p class="mb-1"><b>Iva</b></p>
                                            </div>
                                            <div class="flex-sm-col col-auto">
                                                <p class="mb-1"><b>$ {{number_format($iva,0,',','.')}}</b></p>
                                            </div>
                                        </div>
                                        <div class="row justify-content-between">
                                            <div class="col-4">
                                                <p><b>Total</b></p>
                                            </div>
                                            <div class="flex-sm-col col-auto">
                                                <p class="mb-1"><b>$ {{number_format($total,0,',','.')}}</b></p>
                                            </div>
                                        </div>
                                        <hr class="my-0">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
</div>
<style>
    .custom-file-label::after { content: ""}
</style>
<script>
  $('.trigger_form').click(function(){
            let id = $(this).attr('target');
            $('.'+id+' > .act_form').trigger('click')
  })

$(document).on('change','.forma_pago',function(){
     if($('option:selected',this).val()==2){
        $('.consignacion_cuenta').show();
        
     }else{
        $('.consignacion_cuenta').hide();
     }
   
   
  });

$(document).on('change','.recibir_pedido',function(){
    //retiro en tienda
     if($('option:selected',this).val()==1){
        $('.retiro_tienda').show();
        $('.domicilio').hide();
        $('.domicilio').attr("required", "false");
     }
     //envio a domicilio
     if($('option:selected',this).val()==2){
        $('.domicilio').show();
        $('.retiro_tienda').hide();
        $('.domicilio').attr("required", "true");
     }
     if($('option:selected',this).val()==""){
        $('.domicilio').hide();
        $('.retiro_tienda').hide();
        $('.domicilio').attr("required", "false");
     }
   
  });
</script>