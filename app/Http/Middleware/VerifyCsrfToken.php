<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'bancos/cuentas/listado/data','catalogo/listado/clientes/data','bancos/listado/data',
        'bancos/listado','contratos/listado/compra/data','contratos/listado/venta/data',
        'anticipos/listado/data','giros/listado/data','despachos/pendientes/data','despachos/listado/data',
        'liquidaciones/entrada/liquidada/data','liquidaciones/entrada/listado/data',
        'liquidaciones/entrada/contratos/data','liquidaciones/salida/listado/data','liquidaciones/salida/liquidada/data',
        'liquidaciones/salida/contratos/data','empresas/listado/data','empresas/centros_operacion/listado/data','despachos/culminados/data',
        'ingreso-egreso/data','cafe/listado/entradas/data','cafe/listado/salidas/data','contratos/listado/reporte',
        'empresas/centros_operacion/listado/data','cafe/salidas/reporte','entradas/salidas/corte','ingreso-egreso/fecha','eliminar/servicio',
        'articulos/listado/data','/categoria/registrar','categoria/eliminar','categoria/editar','inventario/listado/data','eliminar/articulo',
        'articulo/actualizar','catalogo/registrar/cliente','contrato/listado/articulos','servicio/registrar','servicios/listado/data','liquidaciones/folios/cargar',
        'listado/recepcion/data','inventario/destacar','/despachos/actualizar','/listar/ordenes/tabla','/registrar_editar/orden','/almacenar/detalles','almacenar/detalles/',
        '/categorias/listado/data',"buscar/orden","registrar/base_datos","servicios/comunes/data","registrar_editar/plantilla"
    ];
}
