<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrioridadCaso extends Model
{
    use HasFactory;

    protected $table = 'case_priorities';
    protected $primaryKey = 'id';
    public $timestamps = true;
}
