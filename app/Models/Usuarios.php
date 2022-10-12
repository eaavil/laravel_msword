<?php

 namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Usuarios extends Model  
{

    use SoftDeletes;
    protected $SoftDeletes = true;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = '100_usuarios';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['nombres', 'apellidos', 'login', 'password', 'email', 'id_rol', 'token_verificacion', 'estado', 'created_at', 'updated_at', 'deleted_at'];

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
