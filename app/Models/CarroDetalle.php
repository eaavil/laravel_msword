<?php

namespace app\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class CarroDetalle extends Model  
{
    use SoftDeletes;
    protected $SoftDeletes = true;


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = '004_carro_detalle';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['id_carro', 'id_articulo ', 'cantidad', 'valor_compra','valor','created_at', 'updated_at', 'deleted_at'];
   
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
