@if(\App\Http\Controllers\AuthController::checkAccessModule('giros.listado',session('role_id')) or \App\Http\Controllers\AuthController::checkAccessModule('anticipos.listado',session('role_id')))
<li class="nav-item has-treeview">
   <a href="#" class="nav-link">
      <i class="nav-icon fas fa-money-bill-alt"></i>
      <p>
         Giros y Anticipos
         <i class="fas fa-angle-left right"></i>
      </p>
   </a>
   <ul class="nav nav-treeview sub-item">
     @if(\App\Http\Controllers\AuthController::checkAccessModule('giros.listado',session('role_id')))
      <li class="nav-item">
        <a href="{{ asset('giros/listado') }}" class="nav-link">
            <i class="fa fa-plus nav-icon"></i>
            <p>Generar Giro a Proveedor</p>
         </a>
      </li>
      @endif
      @if(\App\Http\Controllers\AuthController::checkAccessModule('anticipos.listado',session('role_id')))
      <li class="nav-item">
         <a href="{{ asset('anticipos/listado') }}" class="nav-link">
            <i class="fa fa-plus nav-icon"></i>
            <p>Generar Anticipo de Cliente</p>
         </a>
      </li>
      @endif
   </ul>
</li>
@endif
