@if(\App\Http\Controllers\AuthController::checkAccessModule('contratos.compras',session('role_id')))
      <li class="nav-item">
         <a href="{{ asset('mostrar/ordenes') }}" class="nav-link">
            <i class="fas fa-mobile-alt nav-icon"></i>
            <p>Vista Celular</p>
         </a>
      </li>
      @endif