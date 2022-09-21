<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/** Clase para almacenar el json de un usuario de CU, ya no se ocupa */
class ClaveUnica extends Model
{
    use HasFactory;
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'user_id','access_token','response',
    ];

    /**
    * The primary key associated with the table.
    *
    * @var string
    */
    protected $table = 'users_clave_unica';
    
}
