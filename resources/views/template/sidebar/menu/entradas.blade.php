@if(\App\Http\Controllers\AuthController::checkAccessModule('cafe.entradas',session('role_id')))
<li class="nav-item has-treeview">
   <a href="#" class="nav-link">
      <i class="nav-icon fas fa-plus-circle"></i>
      <p>
         Entradas
         <i class="fas fa-angle-left right"></i>
      </p>
   </a>
   <ul class="nav nav-treeview sub-item">
      <li class="nav-item">
         <a href="{{ route('cafe.entradas') }}" class="nav-link">
            <i class="fa fa-plus nav-icon"></i>
            <p>Entrada de Báscula</p>
         </a>
      </li>
   </ul>
   <ul class="nav nav-treeview sub-item">
      <li class="nav-item">
         <a href="{{ route('cafe.mezclas') }}" class="nav-link">
            <i class="nav-icon fas fa-sync"></i>
            <p>Mezclas de Cafe</p>
         </a>
      </li>
   </ul>
</li>
@endif
