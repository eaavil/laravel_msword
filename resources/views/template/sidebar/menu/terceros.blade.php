@if(\App\Http\Controllers\AuthController::checkAccessModule('catalogo.listado.terceros',session('role_id')))
<li class="nav-item has-treeview">
   <a href="#" class="nav-link">
      <i class="nav-icon fas fa-address-book"></i>
      <p>
         Terceros
         <i class="fas fa-angle-left right"></i>
      </p>
   </a>
   <ul class="nav nav-treeview sub-item">
      <li class="nav-item">
         <a href="{{ asset('/catalogo/listado/terceros') }}" class="nav-link">
            <i class="fa fa-circle nav-icon"></i>
            <p>Gestionar Terceros</p>
         </a>
      </li>
      <!--
      <li class="nav-item">
         <a href="pages/layout/top-nav.html" class="nav-link">
            <i class="fas fa-file nav-icon"></i>
            <p>Informe por Tercero</p>
         </a>
      </li>
      <li class="nav-item">
         <a href="pages/layout/top-nav.html" class="nav-link">
            <i class="fas fa-file nav-icon"></i>
            <p>Informe Todos los Terceros</p>
         </a>
      </li>
      -->
   </ul>
</li>
@endif