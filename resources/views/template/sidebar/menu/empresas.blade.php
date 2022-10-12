@if(\App\Http\Controllers\AuthController::checkAccessModule('empresas.listado',session('role_id')) or \App\Http\Controllers\AuthController::checkAccessModule('empresas.centros_costo.listado',session('role_id')))
<li class="nav-item has-treeview">
   <a href="#" class="nav-link">
      <i class="nav-icon fas fa-building"></i>
      <p>
         Compañia
         <i class="fas fa-angle-left right"></i>
      </p>
   </a>
   <ul class="nav nav-treeview sub-item">
      @if(\App\Http\Controllers\AuthController::checkAccessModule('empresas.listado',session('role_id')))
      <li class="nav-item">
         <a href="{{ asset('empresas/listado') }}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Ver Listado Empresas</p>
         </a>
      </li>
      @endif
      <li class="nav-item">
         @if(\App\Http\Controllers\AuthController::checkAccessModule('empresas.centros_costo.listado',session('role_id')))
         <a href="pages/layout/fixed-topnav.html" class="nav-link has-treeview">
            <i class="fas fa-file-invoice-dollar nav-icon"></i>
            <p>Centros de Operacion y Costo</p>
            <i class="fas fa-angle-left right"></i>
         </a>
         <ul class="nav nav-treeview">
            <li class="nav-item">
               <a href="{{ asset('empresas/centros_operacion/listado')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Centros de Operacion</p>
               </a>
            </li>
         </ul>
         @endif
      </li>
   </ul>
</li>
@endif
