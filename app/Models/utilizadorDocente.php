<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class utilizadorDocente extends Model
{
    use HasFactory;
    
    protected $table= 'utilizadordocente';
    public $timestamps=false;
    public $fillable= ['id','departamento', 'formacao'];
}