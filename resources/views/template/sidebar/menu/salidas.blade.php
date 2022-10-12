@if(\App\Http\Controllers\AuthController::checkAccessModule('cafe.salidas',session('role_id')))
<li class="nav-item has-treeview">
   <a href="#" class="nav-link">
      <i class="nav-icon fas fa-minus-circle "></i>
      <p>
         Salidas
         <i class="fas fa-angle-left right"></i>
      </p>
   </a>
   <ul class="nav nav-treeview sub-item">
      <li class="nav-item">
         <a href="{{ route('cafe.salidas') }}" class="nav-link">
            <i class="fa fa-plus nav-icon"></i>
            <p>Salida de Báscula</p>
         </a>
      </li>
   </ul>
</li>
@endif
