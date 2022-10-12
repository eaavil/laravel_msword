<?php

namespace app\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Liquidaciones extends Model
{


    use SoftDeletes;
    protected $SoftDeletes = true;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = '002_liquidaciones';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['id_entrada_cafe', 'id_salida_cafe', 'kilogramos', 'factor', 'descuento_factor', 'factor_descuento', 'valor_arroba', 'valor_bruta', 'valor_descuento', 'porcentaje_retencion', 'valor_retencion_fuente', 'porcentaje_retencion_4_mil', 'valor_retencion_4_mil', 'total', 'porcentaje_retencion_cooperativa', 'valor_retencion_cooperativa', 'porcentaje_retencion_tercero', 'valor_retencion_tercero', 'id_usuario', 'fecha_liquidacion', 'created_at', 'updated_at', 'deleted_at'];

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
