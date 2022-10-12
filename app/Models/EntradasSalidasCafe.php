<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EntradasSalidasCafe extends Model
{


    use SoftDeletes;
    protected $SoftDeletes = true;


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = '003_entradas_salidas_cafe';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['tipo_operacion', 'numero_ticket', 'fecha_ticket', 'id_catalogo_proveedor', 'id_centro_costo', 'id_tipo_cafe', 'factor', 'cantidad_sacos', 'catidad_tulas', 'nombre_conductor', 'cedula_conductor', 'telefono_conductor', 'placa', 'observaciones', 'peso_entrada', 'peso_salida', 'peso_bruto', 'tara', 'peso_neto', 'empresa_transportadora', 'direccion_destino', 'lugar_destino', 'id_catalogo_cliente', 'kilometros', 'liquidado', 'id_contrato','created_at', 'updated_at', 'deleted_at'];

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
    protected $dates = ['fecha_ticket', 'created_at', 'updated_at', 'deleted_at'];

}
