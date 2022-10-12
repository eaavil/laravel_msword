@if(\App\Http\Controllers\AuthController::checkAccessModule('catalogo.listado.clientes',session('role_id')))
    <li class="nav-item">
        <a href="{{asset('bancos/cuentas/saldo')}}" class="nav-link">
            <i class="nav-icon fas fa-cash-register"></i>
            <p>
                Movimiento Contable
            </p>
        </a>
    </li>
@endif
