<main class="bs-main" style="margin-top: 0px;">
   <!---------------------------------------------------------->
   <!----------------------------------------------------------->
   <nav class="d-none d-md-block bs-breadcrumb" aria-label="breadcrumb">
      <ol class="breadcrumb container">
         <li class="breadcrumb-item">
            <a href="/" title="TKS Tecnologia y Seguridad Spa">INICIO</a>
         </li>
         <li class="breadcrumb-item">{{$categoria_articulo[0]['nombre']}}</li>
         <li class="breadcrumb-item active" aria-current="page">{{$articulo['nombre']}}</li>
      </ol>
   </nav>
   <div class="container bs-product">
      <div class="row">
         <div class="col-sm-6">
            <!----------------------------------------------------------------------------------------------------->
            <div class="row">
               <section class="col-12 relative">
                  <div id="bs-product-slider" data-bs="slider" data-info='{ "lazyLoad":"ondemand","asNavFor":"#bs-product-thumbnail","arrows":false,"fade":true,"draggable":false,"pauseOnFocus":true,"responsive":[{"breakpoint":768,"settings":{"nextArrow":"<divclass=\"slick-next\"><iclass=\"fasfa-arrow-circle-right\"></i></div>","prevArrow":"<divclass=\"slick-prev\"><iclass=\"fasfa-arrow-circle-left\"></i></div>","dots":true,"draggable":true}}] }'>
                     <div class="item" data-info=" ">
                        <div class="bs-img-square" data-bs="zoom">
                           <picture>
                               @php
                               $public="tienda/1-".$articulo['id'].".png";
                               $ruta=asset($public);
                               $nombre=$articulo['nombre'];
                               @endphp
                              <img
                                 src={{$ruta}}
                                 data-lazy={{$ruta}}
                                 onerror="this.onerror=null;this.src={{$ruta."?".rand(1, 90)}}"
                                 alt={{$nombre}}
                                 title={{$nombre}}
                                 >
                           </picture>
                        </div>
                     </div>
                     @php
                            $public="tienda/2-".$articulo['id'].".png";
                            $ruta=asset($public);
                     @endphp
                     @if(file_exists($public))
                     <div class="item" data-info=" ">
                        <div class="bs-img-square" data-bs="zoom">
                           <picture>
                              <img class="lazy"
                                 src={{$ruta}}
                                 data-lazy={{$ruta}}
                                 onerror="this.onerror=null;this.src={{$ruta."?".rand(1, 90)}}"
                                 alt={{$nombre}}
                                 title={{$nombre}}>
                           </picture>
                        </div>
                     </div>
                     @endif
                     @php
                     $public="tienda/3-".$articulo['id'].".png";
                            $ruta=asset($public);
                     @endphp
                     @if(file_exists($public))
                     <div class="item" data-info=" ">
                        <div class="bs-img-square" data-bs="zoom">
                           <picture>
                           <img class="lazy"
                                 src={{$ruta}}
                                 data-lazy={{$ruta}}
                                 onerror="this.onerror=null;this.src={{$ruta."?".rand(1, 90)}}"
                                 alt={{$nombre}}
                                 title={{$nombre}}>
                           </picture>
                        </div>
                     </div>
                     @endif
                     @php
                          $public="tienda/4-".$articulo['id'].".png";
                            $ruta=asset($public);
                     @endphp
                     @if(file_exists($public))
                     <div class="item" data-info=" ">
                        <div class="bs-img-square" data-bs="zoom">
                           <picture>
                           <img class="lazy"
                                 src={{$ruta}}
                                 data-lazy={{$ruta}}
                                 onerror="this.onerror=null;this.src={{$ruta."?".rand(1, 90)}}"
                                 alt={{$nombre}}
                                 title={{$nombre}}>
                           </picture>
                        </div>
                     </div>
                     @endif
                  </div>
                  <nav class="col-12 d-none d-md-block">
                     <div id="bs-product-thumbnail" data-bs="slider" data-info='{ "lazyLoad":"ondemand","asNavFor":"#bs-product-slider","nextArrow":"<divclass=\"slick-next\"><iclass=\"fasfa-arrow-circle-right\"></i></div>","prevArrow":"<divclass=\"slick-prev\"><iclass=\"fasfa-arrow-circle-left\"></i></div>","focusOnSelect":true,"slidesToShow":6,"centerMode":false,"infinite":true }'>
                        @php
                        $public="tienda/1-".$articulo['id'].".png";
                            $ruta=asset($public);
                        @endphp
                        @if(file_exists($public))
                       <div class="item">
                           <div class="bs-img-square">
                              <picture>
                              <img class="lazy"
                                 src={{$ruta}}
                                 data-lazy={{$ruta}}
                                 onerror="this.onerror=null;this.src={{$ruta."?".rand(1, 90)}}"
                                 alt={{$nombre}}
                                 title={{$nombre}}>
                              </picture>
                           </div>
                        </div>
                        @endif
                        @php
                        $public="tienda/2-".$articulo['id'].".png";
                            $ruta=asset($public);
                        @endphp
                        @if(file_exists($public))
                        <div class="item">
                           <div class="bs-img-square">
                              <picture>
                                 <img
                                 src={{$ruta}}
                                 data-lazy={{$ruta}}
                                 onerror="this.onerror=null;this.src={{$ruta."?".rand(1, 90)}}"
                                 alt={{$nombre}}
                                 title={{$nombre}}>
                                 
                              </picture>
                           </div>
                        </div>
                        @endif
                        @php
                        $public="tienda/3-".$articulo['id'].".png";
                            $ruta=asset($public);
                        @endphp
                        @if(file_exists($public))
                        <div class="item">
                           <div class="bs-img-square">
                              <picture>
                              <img
                                 src={{$ruta}}
                                 data-lazy={{$ruta}}
                                 onerror="this.onerror=null;this.src={{$ruta."?".rand(1, 90)}}"
                                 alt={{$nombre}}
                                 title={{$nombre}}>
                              </picture>
                           </div>
                        </div>
                        @endif
                        @php
                        $public="tienda/4-".$articulo['id'].".png";
                            $ruta=asset($public);
                        @endphp
                        @if(file_exists($public))
                        <div class="item">
                           <div class="bs-img-square">
                              <picture>
                              <img
                                 src={{$ruta}}
                                 data-lazy={{$ruta}}
                                 onerror="this.onerror=null;this.src={{$ruta."?".rand(1, 90)}}"
                                 alt={{$nombre}}
                                 title={{$nombre}}>
                              </picture>
                           </div>
                        </div>
                        @endif
                     </div>
                  </nav>
               </section>
            </div>
         </div>
         <div class="col-sm">
            <article >
               <h1>{{$articulo['nombre']}}</h1>
               <!------- marca -------------->
               <!----------- stock ---------------------->
               <div>
                  <!-- Button trigger modal -->
                  <!-- Modal -->
                  <div class="modal fade" id="modalStock" tabindex="-1" role="dialog" aria-labelledby="modalStockLabel" aria-hidden="true">
                     <div class="modal-dialog" role="document">
                        <div class="modal-content">
                           <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Stock por sucursal</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              </button>
                           </div>
                           <div class="modal-body">
                              <div  class="bs-table" data-info='{ 
                                 "0": "<span style=\"color:red;\">Sin stock</span>", 
                                 "5": "quedan muy pocos",
                                 "table": true,
                                 "tableTitle": ["Sucursal", "Stock" ]
                                 }'></div>
                           </div>
                           <div class="modal-footer">
                              <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div data-info='{ 
                     "0": "<span style=\" color: red; \">Agotado</span>",
                     "10": "Pocas unidades.",
                     "full": "Disponible."
                     }'></div>
               </div>
               <!-----------------price -------------------->
               <!-- define plantilla segun tipo de descuento -->
               <!-- donde se carga el precio --> 
               <div data-bs="product.completePrice" 
                  data-info='{
                  "progresive" : "        <div class=\"h5\"> Precio Normal {price}</div>        <div class=\"h3\">S贸lo {finalPrice}</div>        <small>Por compras sobre {discountCant} unidades</small>    ",
                  "single": "        <div>Antes <strong><del>{price}</del></strong></div>        <div> Ahora <span class=\"h2\">{finalPrice}<span></div>    "}'>
                  <!-- plantilla precio por defecto -->
                  <span class="h2" data-bs="product.finalPrice">$ {{number_format($articulo['valor_venta'],0,',','.')}}</span>
                  <!-- pantilla precio por defecto // fin --> 
               </div>
               <!------------------------form add to cart ------------------------------------------>
               <div class="row" >
                  <div class="col-12">
                     <!-- true = dibuja atributos, false = oculta atributos -->
                     <!-- para que se muestren siempre atributos dejar en 1, sino dejar en 2 -->
                     <!-- true = radio button, false = selector -->
                     <!--no modificar esta variable -->
                     <!---------------- select ------------------------>
                  </div>
                  <!------------------ cantidad ----------------------------->
                  @if($existencia > 0 )
                  <div class="col-12 col-md-6 form-group">
                     <div class="input-group">
                        <div class="input-group-prepend">
                           <button data-bs="product.quantity.minus" class="btn btn-secondary reducir_cantidad">
                           <i class="fas fa-minus"></i>
                           </button>
                        </div>
                        <input data-bs="product.quantity" class="form-control text-center cantidad_centro"  value="1" min="1">
                        <div class="input-group-append">
                           <button data-bs="product.quantity.plus" class="btn btn-secondary aumentar_cantidad">
                           <i class="fas fa-plus"></i>
                           </button>
                        </div>
                     </div>
                  </div>
                   @endif
                  <!-------------------- add to cart ------------------------>
                  <div class="col-12 col-md-6 form-group">
                     @if($existencia <=0 )
                     </button><span style=" color: red; ">Agotado</span>
                     <button class="btn btn-primary " onclick="location.href='https://api.whatsapp.com/send?phone=56979269732&text=Hola, me encantaria encargar: {{$articulo['nombre']}}'"  href="" > 
                     Encargar
                     </button>
                     @else
                     <button class="btn btn-primary" onclick="agregar_carro_cantidad({{$articulo['id']}},{{$articulo['valor_venta']}},'{{$articulo['nombre']}}')" data-toggle="modal" data-target="#modalAdd">
                        Agregar al carro
                        @endif
                  </div>
               </div>
               <section >
               <p style="text-align: justify;">{{$descripcion[0]['descripcion']}}</p>
               <ul>
                  @foreach($elementos as $rows)
               <li>{{$rows->item}}</li>
               @endforeach
               </ul>
               </section>
               <!-- Variables -->
               <!-- Botones -->
               <aside>  
               <small class="d-none d-md-inline-block"><h4>Compartir en:</h4></small> 
               <!-- facebook -->
               <a  class="btn btn-light" 
                  title="Compartir en Facebook"
                  href="https://www.facebook.com/sharer/sharer.php?u=https://www.tecnorlogistichkvision.cl/detallado/{{$articulo['id']}}" 
                  target="_blank"
                  style='font-size:30px;color:blue'
                  rel="nofollow noopener noreferrer">
               <i class="fab fa-facebook" aria-hidden="true"></i>
               </a>
               <!-- twitter -->
               <a  class="btn btn-light" 
                  title="Compartir en Twitter"
                  href="https://twitter.com/intent/tweet?text=Mira+lo+que+encontr%C3%A9+en+https://www.tecnorlogistichkvision.cl/+{{$articulo['nombre']}}+a $+{{number_format($articulo['valor_venta'],0,'','.')}}+www.tecnorlogistichkvision.cl/detallado/{{$articulo['id']}}" 
                  target="_blank" 
                  style='font-size:30px;color:#088eff'
                  rel="nofollow noopener noreferrer">
               <i class="fab fa-twitter" aria-hidden="true"></i>
               </a>
               <!-- pinterest -->
               <a  class="btn btn-light btn-pinterest"
                  title="Compartir en Pinterest"
                  data-media="https://dojiw2m9tvv09.cloudfront.net/59969/product/product_smokecloak_easy_600-45732.png?90"
                  data-description=""
                  target="_blank" 
                    style='font-size:30px;color:#b7081b'
                  rel="nofollow noopener noreferrer">
               <i class="fab fa-pinterest"></i>
               </a>
               <!-- tumblr -->
               <a  class="btn btn-light"  
                  title="Compartir en Tumblr" 
                  href="http://tumblr.com/widgets/share/tool?canonicalUrl=www.tecnorlogistichkvision.cl/detallado/{{$articulo['id']}}" 
                  target="_blank" 
                   style='font-size:30px;color:#001935'
                  rel="nofollow noopener noreferrer">
               <i class="fab fa-tumblr"></i>
               </a>
               <!-- linkedin -->
               <a  class="btn btn-light"  
                  title="Compatir en Linkedin" 
                  href="https://www.linkedin.com/cws/share?url=www.tecnorlogistichkvision.cl/detallado/{{$articulo['id']}}" 
                  target="_blank" 
                 style='font-size:30px;color:#0a66c2'
                  rel="nofollow noopener noreferrer">
               <i class="fab fa-linkedin"></i>
               </a>
               <!-- whatsapp --> 
               <a  class="btn btn-light"  
                  href="https://api.whatsapp.com/send?text=Mira+lo+que+encontr%C3%A9+en+https://www.tecnorlogistichkvision.cl/+{{$articulo['nombre']}}+a $+{{number_format($articulo['valor_venta'],0,'','.')}}+www.tecnorlogistichkvision.cl/detallado/{{$articulo['id']}}"
                  rel="nofollow noopener noreferrer"
                  target="_blank" 
                   style='font-size:30px;color:#28d244'
                  title="Compartir en Whatsapp">
               <i class="fab fa-whatsapp"></i>
               </a>
               </aside>
               <!-- Librerias -->
               <script async defer src="//assets.pinterest.com/js/pinit.js"></script>
               <script>
                  (function () {
                      // pinterest
                      var pinOneButton = document.querySelector('.btn-pinterest');
                      pinOneButton.addEventListener('click', function(e) {
                          PinUtils.pinOne({
                              media: e.target.getAttribute('data-media'),
                              description: e.target.getAttribute('data-description')
                          });
                      });
                      // whatsapp
                      try{
                          if(navigator.userAgent.toLowerCase().indexOf('firefox') > -1 && navigator.userAgent.toLowerCase().indexOf('mobile') < 0 ){
                              var firefox = document.querySelector('a[href^="https://api.whatsapp.com/send"]')
                              firefox.href = firefox.href.replace('api', 'web')
                          }
                      }catch(ex){console.log(ex.Message)}
                      })()
               </script>
            </article>
         </div>
      </div>
   </div>
   <div class="row mx-2">
   <div class="col-12">
   <div class="row">
   <section class="col-12 d-flex flex-wrap mt-2" id="bs-product-description" data-bs="product.descriptions">
   <div id="desVideo" class="w-100 my-3 order-1" data-parent="#bs-product-description">
   <div class="embed-responsive embed-responsive-16by9" data-bs="video" data-info="{{$video[0]['video']}}"><img title="youtube" src="https://img.youtube.com/vi/HOOYyjqBOvs/maxresdefault.jpg"><i class="icon fab fa-youtube" aria-hidden="true"></i></div>
   </div>
   <strong class="mt-2" data-target="#desVideo" data-parent="#bs-product-description" aria-expanded="true" aria-controls="desVideo">
   Video 
   </strong>
   </section>
   </div>  
   </div>
   <div class="col-12">
   <!-- configurar el slider -------------------------------------------------------------------->
   <!------------------------------------------------------------------------------------------------------>
   <section class="bs-product-related">
   <div class="col-12" style="display: none;">
   <span class="h2">TAMBIEN PODRIA INTERESARTE</span>
   <div data-bs="slider" data-info="{ &quot;lazyLoad&quot;: &quot;ondemand&quot;,&quot;infinite&quot;: true,&quot;nextArrow&quot;: &quot;<div class=\&quot;slick-next\&quot;><i class=\&quot;fas fa-angle-right\&quot;></i></div>&quot;,&quot;prevArrow&quot;: &quot;<div class=\&quot;slick-prev\&quot;><i class=\&quot;fas fa-angle-left\&quot;></i></div>&quot;,&quot;slidesToShow&quot;: 4,&quot;responsive&quot;: [{&quot;breakpoint&quot;: 768,&quot;settings&quot;: {&quot;slidesToShow&quot;: 3}},{&quot;breakpoint&quot;: 576,&quot;settings&quot;: {&quot;slidesToShow&quot;: 2}},{&quot;breakpoint&quot;: 384,&quot;settings&quot;: {&quot;slidesToShow&quot;: 1}}] }" class="bs-collection bs-horizontal-slider slider-left slick-initialized slick-slider">
   <!-- producto:start ---------------------------------------------------------------->
   <div class="slick-list draggable"><div class="slick-track" style="opacity: 1; width: 810px; transform: translate3d(0px, 0px, 0px);"><a class="d-flex slick-slide slick-current slick-active" href="/product/kit-sirena-20watts-con-gabinete-y-baliza-azul" data-slick-index="0" aria-hidden="false" style="width: 270px;" tabindex="0">
   <div class="bs-product" data-bs="product" data-info="167">
   <div class="bs-img-square hover">
   <!-- Etiqueta sin stock -->
   <picture>
   <!--------------------------------------------------->
   <img src="https://dojiw2m9tvv09.cloudfront.net/59969/product/M_sirena-20-watts-c-gabinete-blancobalizatamper9897.jpg?90" onerror="this.onerror=null;this.src='https://dojiw2m9tvv09.cloudfront.net/59969/product/sirena-20-watts-c-gabinete-blancobalizatamper9897.jpg';" alt="Kit sirena 20watts con gabinete y baliza azul" title="Kit sirena 20watts con gabinete y baliza azul" style="opacity: 1;">
   <!--------------------------------------------------->
   </picture>
   </div>
   <div class="bs-product-info">
   <h6 class="bs-trunc">
   Kit sirena 20watts con gabinete y baliza azul
   </h6>
   <small class="bs-product-brand">TKS</small>
   </div>
   <div class="bs-product-price">
   <div class="bs-product-final-price">
   $ 13.875
   </div>
   </div>
   </div>
   </a><a class="d-flex slick-slide slick-active" href="/product/transmisor-momentaneo-1ch-garrison" data-slick-index="1" aria-hidden="false" style="width: 270px;" tabindex="0">
   <div class="bs-product" data-bs="product" data-info="255">
   <div class="bs-img-square hover">
   <!-- Etiqueta sin stock -->
   <picture>
   <!--------------------------------------------------->
   <img src="https://dojiw2m9tvv09.cloudfront.net/59969/product/M_180126625.jpg?90" onerror="this.onerror=null;this.src='https://dojiw2m9tvv09.cloudfront.net/59969/product/180126625.jpg';" alt="TRANSMISOR MOMENTANEO 1CH GARRISON" title="TRANSMISOR MOMENTANEO 1CH GARRISON" style="opacity: 1;">
   <!--------------------------------------------------->
   </picture>
   </div>
   <div class="bs-product-info">
   <h6 class="bs-trunc">
   TRANSMISOR MOMENTANEO 1CH GARRISON
   </h6>
   <small class="bs-product-brand">TKS</small>
   </div>
   <div class="bs-product-price">
   <div class="bs-product-final-price">
   $ 11.437
   </div>
   </div>
   </div>
   </a><a class="d-flex slick-slide slick-active" href="/product/receptor-momentaneo-1ch-garrison" data-slick-index="2" aria-hidden="false" style="width: 270px;" tabindex="0">
   <div class="bs-product" data-bs="product" data-info="256">
   <div class="bs-img-square hover">
   <!-- Etiqueta sin stock -->
   <picture>
   <!--------------------------------------------------->
   <img src="https://dojiw2m9tvv09.cloudfront.net/59969/product/M_rx-garrison-1-canal6810.jpg?90" onerror="this.onerror=null;this.src='https://dojiw2m9tvv09.cloudfront.net/59969/product/rx-garrison-1-canal6810.jpg';" alt="RECEPTOR MOMENTANEO 1CH GARRISON" title="RECEPTOR MOMENTANEO 1CH GARRISON" style="opacity: 1;">
   <!--------------------------------------------------->
   </picture>
   </div>
   <div class="bs-product-info">
   <h6 class="bs-trunc">
   RECEPTOR MOMENTANEO 1CH GARRISON
   </h6>
   <small class="bs-product-brand">TKS</small>
   </div>
   <div class="bs-product-price">
   <div class="bs-product-final-price">
   $ 18.751
   </div>
   </div>
   </div>
   </a></div></div>
   <!-- producto:end ---------------------------------------------------------------->
   <!-- producto:start ---------------------------------------------------------------->
   <!-- producto:end ---------------------------------------------------------------->
   <!-- producto:start ---------------------------------------------------------------->
   <!-- producto:end ---------------------------------------------------------------->
   </div>
   </div>
   <section>
   <!------------------------------------------------------------------------------------------------------>
   </section></section></div>
   </div>
   </div>

  
</main>
<script>

$(document).on('click','.aumentar_cantidad',function(){
     
 $('.cantidad_centro').val(parseInt($('.cantidad_centro').val())+1);
});

$(document).on('click','.reducir_cantidad',function(){
     
     $('.cantidad_centro').val(parseInt($('.cantidad_centro').val())-1);
});
      
 //agregar productos al carro->utilice funcion de java script por que las librerias de jquery tiene problema y duplica la llamda
function agregar_carro_cantidad(id,valor,nombre){
     //obtener ip del cliente y alamcenar 
     //verificar existencia
     let cantidad=$(".cantidad_centro").val();
    
     $.getJSON('{{ asset("agregar_carro_cantidad") }}/'+ip+'/'+id+'/'+valor+'/'+cantidad, function(data){
    //mostrar cantidad en carro
       
            let valor2 = valor.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
            let num = valor2.split('').reverse().join('').replace(/^[\.]/,'');
            $.getJSON('{{ asset("agregar_carro") }}/'+ip+'/'+id+'/'+valor);
            
            //mostrar en el modal
            $('.nombre').text(nombre);
            $('.precio').text("$"+num);
            $('.cantidad_mensaje').text("Cantidad:"+cantidad);
            $('.cantidad_carro').text(parseInt($('.cantidad_carro').text())+parseInt(cantidad));
       
    });
     

}    
     

          

</script>

