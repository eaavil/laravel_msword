@if(\App\Http\Controllers\AuthController::checkAccessModule('catalogo.listado.clientes',session('role_id')))
    <li class="nav-item">
        <a href="{{ route('contratos.compras') }}" class="nav-link">
            <i class="far fa-address-book nav-icon"></i>
            <p>
                Agenda de citas
            </p>
        </a>
    </li>
@endif
