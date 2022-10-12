@if(\App\Http\Controllers\AuthController::checkAccessModule('catalogo.listado.clientes',session('role_id')))
    <li class="nav-item">
        <a href="{{ route('contratos.compras') }}" class="nav-link">
            <i class="fas fa-file nav-icon"></i>
            <p>
                Demandas
            </p>
        </a>
    </li>
@endif
