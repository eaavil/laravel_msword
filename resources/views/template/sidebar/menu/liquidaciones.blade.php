
@if(\App\Http\Controllers\AuthController::checkAccessModule('liquidaciones.entradas.listado',session('role_id')))
<li class="nav-item has-treeview">
   <a href="#" class="nav-link">
      <i class="nav-icon fas fa-arrow-down"></i>
      <p>
         Liquidaciones Entradas
         <i class="fas fa-angle-left right"></i>
      </p>
   </a>
   <ul class="nav nav-treeview sub-item">
      <li class="nav-item">
            <a href="{{ route('liquidaciones.entradas.listado') }}" class="nav-link">
            <i class="fas fa-circle nav-icon"></i>
            <p>Liquidar Entradas</p>
         </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('liquidaciones.entradas.liquidadas') }}" class="nav-link">
            <i class="fas fa-circle nav-icon"></i>
            <p>Liquidaciones Registradas</p>
         </a>
      </li>
	  <li class="nav-item">
        <a href="{{ route('liquidaciones.contratos.pendientes') }}" class="nav-link">
            <i class="fas fa-circle nav-icon"></i>
            <p>Contratos Sin Liquidaciones</p>
         </a>
      </li>
   </ul>
</li>
@endif

@if(\App\Http\Controllers\AuthController::checkAccessModule('liquidaciones.salidas.listado',session('role_id')))
<li class="nav-item has-treeview">
   <a href="#" class="nav-link">
      <i class="nav-icon fas fa-arrow-up"></i>
      <p>
         Liquidaciones Salidas
         <i class="fas fa-angle-left right"></i>
      </p>
   </a>
   <ul class="nav nav-treeview sub-item">
      <li class="nav-item">
         <a href="{{ route('liquidaciones.salidas.listado') }}" class="nav-link">
            <i class="fas fa-circle nav-icon"></i>
            <p>Liquidar Salidas</p>
         </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('liquidaciones.salidas.liquidadas') }}" class="nav-link">
            <i class="fas fa-circle nav-icon"></i>
            <p>Liquidaciones Registradas</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('liquidaciones.contratos.pendientes.salidas') }}" class="nav-link">
            <i class="fas fa-circle nav-icon"></i>
            <p>Contratos Sin Liquidaciones</p>
         </a>
      </li>
   </ul>
</li>
@endif
