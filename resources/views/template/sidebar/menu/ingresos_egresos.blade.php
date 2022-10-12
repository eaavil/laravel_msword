
@if(\App\Http\Controllers\AuthController::checkAccessModule('catalogo.listado.clientes',session('role_id')))
    <li class="nav-item">
        <a href="{{ route('ingreso_egreso.listado') }}" class="nav-link">
            <i class="nav-icon fas fa-sync"></i>
            <p>
            Ingresos y Egresos
            </p>
        </a>
    </li>
@endif