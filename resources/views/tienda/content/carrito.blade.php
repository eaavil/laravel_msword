<main class="bs-main">
  
   <main class="bs-cart">
      <nav class="d-none d-md-block bs-breadcrumb" aria-label="breadcrumb">
         <ol class="breadcrumb container">
            <li class="breadcrumb-item">
               <a href={{asset("/")}} title="TKS Tecnologia y Seguridad Spa">Inicio</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Carro</li>
         </ol>
      </nav>
      <div class="container">
         <h1 class="h3">
            Carro de compras <span class="cantidad_total_2"></span>
         </h1>
         <div class="row">
            <!--------------------------------------------------------------------------------------->
            <div  class="col-12 d-none m-4">
               <div class=" rounded-0">
                  <div class="container">
                     <p class="lead">Tu carro de compras está vacío.</p>
                     <p class="lead">
                        <a href="/" class="btn btn-primary">Agrega productos ahora</a>
                     </p>
                  </div>
               </div>
            </div>
            <!------------------------------------------------------------------------------------------------------>
            @php
              $total=0;                
            @endphp
            @foreach($carro_detalle as $rows)
            <section  data-info="246" class="col-12 position-relative">
               <!--descuento -->
               <!-- end:descuento -->
              
               <div class="row align-items-center bs-cart-item">
                  <div class="col-11 col-md-6">
                     <div class="row my-3">
                        <div class="col col-md-4">
                           <div class="bs-img-square">
                              <div class="bs-discount ovalado d-none"  style="opacity: 1;">
                                 <span >
                                 -0%
                                 </span>
                              </div>
                              <picture>

                                 <img src={{asset("tienda/1-".$rows->id_articulo.".png")}}>
                              </picture>
                           </div>
                        </div>
                        <div class="col-8 col-md-8">
                           <a href="/product/camara-ip-husky-air-c3w" title={{$rows->nombre}}>
                              <h3 class="h5 ">{{$rows->nombre}}</h3>
                           </a>
                           <strike class="d-none" >
                           $ 48.900
                           </strike>
                           <div >
                           $ {{number_format($rows->valor,0,',','.')}}
                           </div>
                        </div>
                     </div>
                     <!--row-->
                    
                  </div>
                 
                  <!--------precio --------->
                
                  <div class="col-12 col-md-6">
                     <div class="row align-items-center">
                        <!-- quantity -->
                        <div class="col-6">
                           <div class="input-group">
                              <div class="input-group-prepend">
                                 <button class="btn btn-secondary reducir" id='{{$rows->id}}' valor='{{$rows->valor}}' id_articulo='{{$rows->id_articulo}}'>
                                 <i class="fas fa-minus" aria-hidden="true"></i>
                                 </button>
                              </div>
                              <input class="form-control text-center {{'cantidad_centro'.$rows->id}}" id='{{$rows->id}}' id_articulo='{{$rows->id_articulo}}' type="number" value={{$rows->cantidad}} min="1">
                              <div class="input-group-append ">
                                 <button class="btn btn-secondary aumentar" id='{{$rows->id}}' valor='{{$rows->valor}}' id_articulo='{{$rows->id_articulo}}'>
                                 <i class="fas fa-plus" aria-hidden="true"></i>
                                 </button>
                              </div>
                           </div>
                        </div>
                        
                        <!---- quantity:end ------>
                        <div class="col-6 d-flex align-items-center justify-content-end"> 
                           <strong class="mr-3 {{'precio_final'.$rows->id}}">
                              @php
                              $total+=$rows->cantidad*$rows->valor;
                              @endphp
                          $ {{number_format($rows->cantidad*$rows->valor,0,',','.')}}
                           </strong>
                           <button class="btn btn-secondary eliminar" id={{$rows->id}}>
                           <i class="fas fa-trash-alt" aria-hidden="true"></i>
                           </button>
                        </div>
                     </div>
                  </div>
                  <!-- precio -->
               </div>
            </section>
            @endforeach
            <div class="col-12" >
               <div class="row justify-content-between align-items-center text-center text-sm-right">
                  <div class="col-12 text-right mt-3">
                     <h3>
                        Subtotal: <span class="subtotal" Sub_total={{$total}}>$ {{number_format($total,0,',','.')}}</span>
                        
                     </h3>
                  </div>
                  <div class="col-12 text-right mt-3">
                     <h3>
                      
                        Iva: <span class="iva" iva={{$total}}>$ {{number_format($total*0.19,0,',','.')}}</span>
                       
                     </h3>
                  </div>
                  <div class="col-12 text-right mt-3">
                     <h3>
                       
                        Total: <span class="total" total={{$total}}>$ {{number_format($total+$total*0.19,0,',','.')}}</span>

                     </h3>
                  </div>

                  <div class="col-12">
                     <div class="row">
                        <div class="col-12 mb-2 text-right">
                           <div class="custom-control custom-checkbox">
                              <input id="bs-cart-checkout-check" class="custom-control-input aceptar_terminos" type="checkbox" >
                              <label class="custom-control-label" for="bs-cart-checkout-check">
                              Acepto 
                              </label>
                              <button class=" btn btn-link p-0" title="ver terminos y condiciones" data-toggle="modal" data-target="#termsandconditions">términos y condiciones</button>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="modal fade" id="termsandconditions" tabindex="-1">
                     <div class="modal-dialog modal-dialog-scrollable">
                        <div class="modal-content">
                           <div class="modal-header">
                              <h5 class="modal-title"></h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                              </button>
                           </div>
                           <div class="modal-body">
                              <h4 class="text-center">Términos y condiciones</h4>
                              <p class="text-center">El uso de nuestros servicios, así como la compra de nuestros productos implica que usted ha leído y aceptado los Términos y Condiciones de Uso que aquí se describen.
                                 Para adquirir los productos que son ofrecidos por nuestro sitio web será necesario el registro por parte del usuario de sus datos personales fidedignos como correo electrónico, teléfono y dirección de despacho.
                              </p>
                              <p class="text-center">Todas las compras y transacciones que se lleven a cabo por medio de este sitio web, están sujetas a un proceso de confirmación y verificación, el cual podría incluir la verificación del stock y disponibilidad de producto, validación de la forma de pago y el cumplimiento de las condiciones requeridas por el medio de pago seleccionado. En algunos casos puede que se requiera una verificación por medio de correo electrónico.</p>
                              <p class="text-center">Los precios de los productos ofrecidos en esta Tienda Online son válidos solamente en las compras realizadas en este sitio web.</p>
                           </div>
                           <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-12 col-sm-auto my-2">
                     <button class="btn btn-primary" title="Seguir Comprando" >
                     Agregar mas productos
                     </button>
                  </div>
                  <div class="col-12 col-sm-auto my-2">
                     <div class="row">
                        <div class="col-12">
                           <button class="btn btn-primary pagar" title="Continuar" >
                           Ir a pagar
                           <i class="fas fa-arrow-right ml-2" aria-hidden="true"></i>
                           </button>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </main>
</main>