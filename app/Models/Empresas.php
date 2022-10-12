<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empresas extends Model
{

    use SoftDeletes;
    protected $SoftDeletes = true;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = '000_empresas';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['codigo_empresa', 'razon_social', 'nit', 'digito_verificacion', 'direccion1', 'direccion2', 'direccion3', 'id_poblacion', 'correo_electronico', 'telefono1', 'telefono2', 'retencion_renta_compras', 'retencion_renta_ventas', 'retencion_cree_ventas', 'retencion_iva_compras', 'retencion_iva_ventas', 'retencion_ica_compras', 'retencion_ica_ventas', 'tipo_modelo_ubl', 'gran_contribuyente', 'created_at', 'updated_at', 'deleted_at'];

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
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

}
