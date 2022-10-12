@if(\App\Http\Controllers\AuthController::checkAccessModule('settings.listado',session('role_id')))


  <li class="nav-item">
        <a href="{{ route('settings.listado') }}" class="nav-link">
            <i class="nav-icon fas fa-cog"></i>
            <p>
                Parametros del Sistema
            </p>
        </a>
    </li>

@endif
