<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class CatalogoEmpresas extends Model  
{

    
    use SoftDeletes;
    protected $SoftDeletes = true;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = '000_catalogo_empresas';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['id','id_empresa', 'nombre', 'siglas', 'nit', 'digito_verificacion_nit', 'persona_contacto', 'cargo_persona_contacto', 'direccion', 'id_poblacion', 'numero_telefono_1', 'numero_telefono_2', 'numero_celular_1', 'numero_celular_2', 'numero_celular_3', 'email_empresa', 'email_persona_contacto', 'notas', 'imagen_logo', 'id_tipo_regimen', 'id_banco', 'numero_cuenta', 'tipo_cuenta', 'es_proveedor', 'es_cliente', 'es_empresa_transporte', 'es_eps', 'es_arp', 'es_caja_compensacion', 'es_pension', 'es_cesantias', 'es_taller', 'es_medico', 'es_colegio', 'es_ess', 'estado', 'es_arl', 'es_propietario', 'es_tercero', 'created_at', 'updated_at', 'deleted_at'];

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
