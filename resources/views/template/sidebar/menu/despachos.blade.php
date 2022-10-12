
@if(\App\Http\Controllers\AuthController::checkAccessModule('despachos.pendientes',session('role_id')))
<li class="nav-item has-treeview">
   <a href="#" class="nav-link">
      <i class="nav-icon fas fa-truck"></i>
      <p>
         Despachos
         <i class="fas fa-angle-left right"></i>
      </p>
   </a>
   <ul class="nav nav-treeview sub-item">
      <li class="nav-item">
            <a href="{{ route('despachos.pendientes') }}" class="nav-link">
            <i class="fas fa-circle nav-icon"></i>
            <p>Salidas Sin Despacho</p>
         </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('despachos') }}" class="nav-link">
            <i class="fas fa-circle nav-icon"></i>
            <p>Despachos Registrados</p>
         </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('despachos.culminados') }}" class="nav-link">
            <i class="fas fa-circle nav-icon"></i>
            <p>Despachos Culminados</p>
         </a>
      </li>
   </ul>
</li>
@endif
