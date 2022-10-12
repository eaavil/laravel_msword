<?php

namespace app\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Listas extends Model
{

    use SoftDeletes;
    protected $SoftDeletes = true;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table='listas';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['tipo','id_servicio','item','created_at', 'updated_at', 'deleted_at'];

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
    protected $dates = ['fecha', 'created_at', 'updated_at', 'deleted_at'];

}
