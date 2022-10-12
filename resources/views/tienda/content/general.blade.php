<section class="bs-collection">
      <nav class="d-none d-md-block bs-breadcrumb" aria-label="breadcrumb">
         <ol class="breadcrumb container">
            <li class="breadcrumb-item">
               <a href={{asset('/')}} title="TKS Tecnologia y Seguridad Spa">Inicio</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">    TECNOLOGIA</li>
         </ol>
      </nav>
      <div class="container">
         <div class="row">
          
            <aside class="col-lg-3">
               <div c----lass="bs-collection-filter" style="display:none">
                  <form id="bs-collection-filter-form">
                     <div class="row  mb-3">
                        <h3 class="col-12 d-none d-lg-block">
                           Filtros
                        </h3>
                        <div class="col-12 d-flex d-lg-block align-items-center justify-content-between">
                           <a  class="btn btn-secondary order-lg-2"
                              href="/collection/tecnologia">
                           <i class="fas fa-undo-alt"></i>
                           <span class="d-none d-sm-inline">Limpiar</span>
                           </a>
                           <a class="d-lg-none btn btn-link " href="#filter-toggle"  role="button" title="Filtros">
                              <h3 class="bs-filter-title">
                                 Filtros
                                 <i class="fas fa-caret-down"></i>
                              </h3>
                           </a>
                           <button class="btn btn-primary" type="submit">
                           <i class="d-none d-lg-inline fas fa-filter"></i>
                           Filtrar
                           </button>
                        </div>
                     </div>
                     <div class="collapse d-lg-block" id="filter-toggle">
                        <div>
                           <div class="panel-heading my-1">
                              <a
                                 class="btn btn-light d-flex justify-content-between align-items-center bs-filter-btn " 
                                 href="#bs-collection-filter-price">
                              Precio
                              <i class="fas fa-angle-down"></i>
                              </a>
                           </div>
                           <div id="bs-collection-filter-price" class="panel-collapse collapse my-1">
                              <ul class="list-group">
                                 <li class="list-group-item border-0">
                                    <div
                                       data-bs="filter.range"
                                       data-min="4900.0"
                                       data-max="109000.0"
                                       >
                                    </div>
                                 </li>
                              </ul>
                           </div>
                        </div>
                        <!-- elimina marca si esta en la url /brand/ -->
                        <!---------------------------->
                        <div>
                           <div class="panel-heading my-1">
                              <a
                                 class="btn btn-light d-flex justify-content-between align-items-center bs-filter-btn "
                                 href="#brand_static">
                              Marca<i class="fas fa-angle-down"></i>
                              </a>
                           </div>
                           <div id="brand_static" class=" my-1">
                              <ul class="list-group">
                                 <li class="list-group-item border-0">
                                    <div class="custom-control custom-checkbox">
                                       <input
                                          id="brand_static-1"
                                          class="custom-control-input bs-collection-filter-input"
                                          type="checkbox"
                                          value="Hikvision"
                                          data-filter="brand_static[]">
                                       <label class="custom-control-label" for="brand_static-1">
                                       Hikvision
                                       </label>
                                    </div>
                                 </li>
                                 <li class="list-group-item border-0">
                                    <div class="custom-control custom-checkbox">
                                       <input
                                          id="brand_static-2"
                                          class="custom-control-input bs-collection-filter-input"
                                          type="checkbox"
                                          value="TKS"
                                          data-filter="brand_static[]">
                                       <label class="custom-control-label" for="brand_static-2">
                                       TKS
                                       </label>
                                    </div>
                                 </li>
                              </ul>
                           </div>
                        </div>
                     </div>
                  </form>
               </div>
            </aside>
            <article class="col-lg-12">
               <div class="row pb-3">
                  <div class="col">
                     Mostrando {{$tomados}} de {{$total}}
                  </div>
                  <div class="col-md-3 col-sm-6 ">
                     <select class="custom-select" data-bs="collection.sort">
                        <option value="">Ordenar por</option>
                        <option value="/collection/tecnologia?limit=9&with_stock=0&order=name&way=ASC">Ordenar por nombre de A a Z</option>
                        <option value="/collection/tecnologia?limit=9&with_stock=0&order=name&way=DESC">Ordenar por nombre de Z a A</option>
                        <option value="/collection/tecnologia?limit=9&with_stock=0&order=price&way=DESC">Precio de mayor a menor</option>
                        <option value="/collection/tecnologia?limit=9&with_stock=0&order=price&way=ASC">Precio de menor a mayor</option>
                        <option value="/collection/tecnologia?limit=9&with_stock=0&order=id&way=ASC">Antiguos productos</option>
                        <option value="/collection/tecnologia?limit=9&with_stock=0&order=id&way=DESC">Nuevos productos</option>
                     </select>
                  </div>
               </div>
               <!-- Variable que activa o desactiva la funcionalidad de agregar al carro desde la coleccion 
                  true = activada
                  false = desactivada -->
               <div class id="bs-collection-summary"></div>
               <div class="row">
                  @foreach($inventario as $rows)
                  
                  
                  <div class="col-sm-6 col-md-4 text-center mb-4">
                     <div class="d-flex bs-borde">
                        <div class="bs-product" data-bs="product" data-info="287">
                           @if($rows->stock<=0)
                              <a href={{asset('detallado/'.$rows->id)}}>
                                 <div class="bs-img-square hover">
                                    <!-- Etiqueta sin stock -->
                                    <div class="bs-stock">Sin Stock</div>
                                     <picture>
                                       <!--------------------------------------------------->
                                       <img class="lazy entered loaded" src={{asset("tienda/1-".$rows->id.".png?".rand(1, 90))}}   alt="Fuente de poder 12V 5amp" title="Fuente de poder 12V 5amp" data-ll-status="loaded">
                                       <!--------------------------------------------------->
                                    </picture>
                                 </div>
                              </a>
                           @else()
                           <a href={{asset('detallado/'.$rows->id)}}>
                              <div class="bs-img-square hover">
                                 <!-- Etiqueta sin stock -->
                                 <picture>
                                    <!--------------------------------------------------->
                                    <img
                                       class="lazy"
                                       src={{asset("tienda/1-".$rows->id.".png?".rand(1, 90))}} 
                                       title={{$rows->id}}
                                       >
                                    @if(file_exists("tienda/2-".$rows->id.".png"))
                                    <img class="lazy"
                                       src={{asset("tienda/2-".$rows->id.".png?".rand(1, 90))}} 
                                       title="CARGADOR INALAMBRICO XTECH VSS-220"
                                       >
                                    <!--------------------------------------------------->
                                    @endif
                                 </picture>
                              </div>
                           </a>
                           @endif
                           <div class="bs-product-info">
                              <a href="/product/cargador-inalambrico-xtech-vss-220">
                                
                              </a>
                              <div class=" mb-2">
                                 <strong>{{$rows->nombre}}</strong>
                              </div>
                            
                           </div>
                           <div class="bs-product-price">
                              <div class="bs-product-final-price">
                              $ {{number_format($rows->valor_venta,0,',','.')}}
                              </div>
                           </div>
                           <!-- Boton agregar al carro desde colecci車n -->
                           <div class="bs-product-cart mt-auto">
                           @if($rows->stock>0)
                              <button class="btn btn-primary carro"  onclick="agregar_carro({{$rows->id}},{{$rows->valor_venta}},'{{$rows->nombre}}')" data-toggle="modal" data-target="#modalAdd"
                               
                                 >
                              Agregar al carro
                              </button>
                           @else
                           <button class="btn btn-primary carro"  onclick="location.href='https://api.whatsapp.com/send?phone=56979269732&text=Hola, me encantaria encargar: {{$rows->nombre}}'"  data-toggle="modal" data-target="#modalencargar"
                           >
                            Encargar
                            </button>
                           @endif

                           </div>
                        </div>
                     </div>
                  </div>
                  
                  @endforeach
               </div>
               </div>
               <nav>
                  <ul class="pagination justify-content-center">
                    
                  @for ($i = 1; $i <=$paginas; $i++)
                  @if($i==$pagina)
                  <li class="page-item active" >
                  @else
                  <li class="page-item " >
                  @endif
                  <a class="page-link" href={{asset("categoria/".$id."/".$i)}}>{{$i}}</a>
                     </li>
                  @endfor
                    
                  </ul>
               </nav>
            </article>
         </div>
      </div>
   </section>