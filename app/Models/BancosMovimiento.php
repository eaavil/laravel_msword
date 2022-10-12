<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class BancosMovimiento extends Model  
{

    use SoftDeletes;
    protected $SoftDeletes = true;
    

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = '000_bancos_movimiento';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['numero', 'tipo_operacion', 'fecha_operacion', 'forma_pago', 'id_tercero', 'id_cuenta_banco', 'descripcion', 'numero_factura_remision', 'valor', 'modo', 'created_at', 'updated_at', 'deleted_at'];

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
    protected $dates = ['fecha_operacion', 'created_at', 'updated_at', 'deleted_at'];

}
