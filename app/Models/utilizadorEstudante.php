<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class utilizadorEstudante extends Model
{
    use HasFactory;

    protected $table= 'utilizadorestudante';
    public $timestamps=false;
    public $fillable= ['id','curso', 'anocorrente', 'media'];
    
}
