@if(\App\Http\Controllers\AuthController::checkAccessModule('catalogo.listado.clientes',session('role_id')))
    <li class="nav-item">
        <a href="{{ asset('/listar_empresas/vista') }}" class="nav-link">
            <i class="nav-icon fas fa-users"></i>
            <p>
                Catalogo de Personas
            </p>
        </a>
    </li>
@endif
