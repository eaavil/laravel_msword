<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MovimientoEmpaques extends Model  
{
   
    use SoftDeletes;
    protected $SoftDeletes = true;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = '003_movimiento_empaques';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['cantidad', 'id_tipo_empaque', 'id_catalogo_empresas_proveedor', 'id_catalogo_empresas_cliente', 'tipo_operacion', 'fecha_ingreso', 'created_at', 'updated_at', 'deleted_at'];

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
    protected $dates = ['fecha_ingreso', 'created_at', 'updated_at', 'deleted_at'];

}
