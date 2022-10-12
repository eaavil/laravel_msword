<?php

namespace app\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Ordenes extends Model
{

    use SoftDeletes;
    protected $SoftDeletes = true;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'ordenes';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['id_cliente',"id_vendedor","id_nomina_1","id_nomina_2","id_nomina_3",'tecnico','tecnico_2',"estado","modelo","petente",'tecnico_3','numero', 'tiempo_inicio',"tiempo_fin","fecha_salida","mes_salida","dia_salida","tiempo_total","neto","es_iva","descuento","total","total_des","forma_pago", 'descripcion', 'created_at', 'updated_at', 'deleted_at'];

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
    protected $dates = ["fecha_salida", 'created_at', 'updated_at', 'deleted_at'];

}
