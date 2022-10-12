@if(\App\Http\Controllers\AuthController::checkAccessModule('giros.listado',session('role_id')) or \App\Http\Controllers\AuthController::checkAccessModule('anticipos.listado',session('role_id')))
<li class="nav-item has-treeview">
   <a href="#" class="nav-link">
      <i class="nav-icon fas fa fa-cart-plus aria-hidden="true""></i>
      <p>
         Bodega
         <i class="fas fa-angle-left right"></i>
      </p>
   </a>
   <ul class="nav nav-treeview sub-item">
     @if(\App\Http\Controllers\AuthController::checkAccessModule('giros.listado',session('role_id')))
     <li class="nav-item">
         <a href="{{ asset('inventario/listado') }}" class="nav-link">
            <i class="fas fa-file-alt nav-icon"></i>
            <p>Inventario</p>
         </a>
      </li>
      @endif
      @if(\App\Http\Controllers\AuthController::checkAccessModule('anticipos.listado',session('role_id')))
    <li class="nav-item">
        <a href="{{ asset('servicios/listado') }}" class="nav-link">
            <i class="fas fa-dollar-sign nav-icon"></i>
            <p>Lista de precios</p>
         </a>
      </li>
      <li class="nav-item">
        <a href="{{ asset('servicios/comunes') }}" class="nav-link">
            <i class="fas fa-toilet-paper nav-icon"></i>
            <p>Servicios Comunes</p>
         </a>
      </li>
      @endif
      @if(\App\Http\Controllers\AuthController::checkAccessModule('anticipos.listado',session('role_id')))
    <li class="nav-item">
        <a href="{{ asset('categorias/listado') }}" class="nav-link">
            <i class="fas fa-bezier-curve nav-icon"></i>
            <p>Categorias</p>
         </a>
      </li>
      @endif
   </ul>
</li>
@endif
