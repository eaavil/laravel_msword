@if(\App\Http\Controllers\AuthController::checkAccessModule('catalogo.listado.clientes',session('role_id')))
    <li class="nav-item">
        <a href="{{ asset('/listar/ordenes/vista_escritorio') }}" class="nav-link">
            <i class="nav-icon fas fa-car-alt"></i>
            <p>
            Ordenes de trabajo
            </p>
        </a>
    </li>
@endif