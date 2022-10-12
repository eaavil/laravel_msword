@if(\App\Http\Controllers\AuthController::checkAccessModule('empaques.entradas',session('role_id')) or \App\Http\Controllers\AuthController::checkAccessModule('empaques.salidas',session('role_id')))
<li class="nav-item has-treeview">
   <a href="#" class="nav-link">
      <i class="nav-icon fas fa-cube"></i>
      <p>
         Empaques
         <i class="fas fa-angle-left right"></i>
      </p>
   </a>
   <ul class="nav nav-treeview sub-item">
      @if(\App\Http\Controllers\AuthController::checkAccessModule('empaques.entradas',session('role_id')))
      <li class="nav-item">
         <a href="{{ route('empaques.entradas') }}" class="nav-link">
            <i class="fa fa-cog nav-icon"></i>
            <p>Movimiento proveedor</p>
         </a>
      </li>
      @endif
      @if(\App\Http\Controllers\AuthController::checkAccessModule('empaques.salidas',session('role_id')))
      <li class="nav-item">
         <a href="{{ route('empaques.salidas') }}" class="nav-link">
            <i class="fa fa-cog nav-icon"></i>
            <p>Movimiento cliente</p>
         </a>
      </li>
      @endif
   </ul>
</li>
@endif