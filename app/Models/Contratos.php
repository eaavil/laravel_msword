<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contratos extends Model
{


    use SoftDeletes;
    protected $SoftDeletes = true;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = '003_contratos';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['numero','cotizacion','factura','fecha_contrato', 'id_catalogo_empresa_facturador', 'id_catalogo_empresa_cliente' , 'id_catalogo_empresa_proveedor', 'fecha_entrega', 'id_tipo_cafe', 'id_centro_operacion', 'factor_base', 'kilos_compromiso', 'precio_arroba', 'precio_kilogramo', 'valor_contrato', 'valor_pagado', 'estado', 'created_at', 'updated_at', 'deleted_at'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['fecha_contrato', 'fecha_entrega', 'created_at', 'updated_at', 'deleted_at'];

}
