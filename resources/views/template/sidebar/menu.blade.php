<!-- Sidebar Menu -->
<nav class="mt-1">
   <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <li class="nav-header">Administrativo</li>
      {{--@include('template.sidebar.menu.dashboard')
      @include('template.sidebar.menu.gerencia') 
      @include('template.sidebar.menu.empresas')
      --}}
      @include('template.sidebar.menu.clientes')
      {{--@include('template.sidebar.menu.bancos')
      @include('template.sidebar.menu.productos')
      @include('template.sidebar.menu.vista_tecnico')--}}
      @if(
        \App\Http\Controllers\AuthController::checkAccessModule('giros.listado',session('role_id')) or
        \App\Http\Controllers\AuthController::checkAccessModule('anticipos.listado',session('role_id')) or
        \App\Http\Controllers\AuthController::checkAccessModule('contratos.compras',session('role_id')) or
        \App\Http\Controllers\AuthController::checkAccessModule('contratos.ventas',session('role_id'))
      )
      <li class="nav-header">Comercial</li>
      @endif
      @include('template.sidebar.menu.contratos')
      @include('template.sidebar.menu.plantillas')
      
     {{--  
     @include('template.sidebar.menu.ordenes')
      @include('template.sidebar.menu.giros_anticipos')
      @if(
        \App\Http\Controllers\AuthController::checkAccessModule('cafe.entradas',session('role_id')) or
        \App\Http\Controllers\AuthController::checkAccessModule('cafe.salidas',session('role_id')) or
        \App\Http\Controllers\AuthController::checkAccessModule('contratos.compras',session('role_id')) or
        \App\Http\Controllers\AuthController::checkAccessModule('contratos.ventas',session('role_id'))
      )
      @include('template.sidebar.menu.ingresos_egresos')
      @include('template.sidebar.menu.agenda_citas')
      @endif --}}
      {{--<li class="nav-header">Operativo</li>
      @include('template.sidebar.menu.ingresos_egresos')
       @include('template.sidebar.menu.entradas')
	    @include('template.sidebar.menu.salidas')
      @include('template.sidebar.menu.despachos')
      @include('template.sidebar.menu.liquidaciones')
      @include('template.sidebar.menu.inventario')
      @include('template.sidebar.menu.empaques')
      
      @include('template.sidebar.menu.transportes')--}}

      @if(session('role_id')==1)
         <li class="nav-header">Seguridad</li>
         @include('template.sidebar.menu.configuraciones')
         @include('template.sidebar.menu.perfiles')
         @include('template.sidebar.menu.usuarios')
      @endif
   </ul>
</nav>
<!-- /.sidebar-menu -->
