@if(\App\Http\Controllers\AuthController::checkAccessModule('catalogo.listado.facturadores',session('role_id')))
<li class="nav-item has-treeview">
   <a href="#" class="nav-link">
      <i class="nav-icon fas fa-user-tie"></i>
      <p>
         Facturadores
         <i class="fas fa-angle-left right"></i>
      </p>
   </a>
   <ul class="nav nav-treeview sub-item">
      <li class="nav-item">
         <a href="{{ asset('/catalogo/listado/facturadores') }}" class="nav-link">
            <i class="fa fa-circle nav-icon"></i>
            <p>Generar Facturadores</p>
         </a>
      </li>
      <!--
      <li class="nav-item">
         <a href="pages/layout/top-nav.html" class="nav-link">
            <i class="fas fa-file nav-icon"></i>
            <p>Listado Facturadores</p>
         </a>
      </li>
      <li class="nav-item">
         <a href="pages/layout/top-nav.html" class="nav-link">
            <i class="fas fa-file nav-icon"></i>
            <p>Informe Todos los Clientes</p>
         </a>
      </li>
      -->
   </ul>
</li>
@endif