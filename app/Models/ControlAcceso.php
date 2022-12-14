<?php

namespace app\Models;
use Illuminate\Database\Eloquent\Model;

class ControlAcceso extends Model  
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = '100_control_acceso';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['id_rol', 'id_seccion', 'permiso', 'created_at', 'updated_at', 'deleted_at'];

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
