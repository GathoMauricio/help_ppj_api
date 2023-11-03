<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRol extends Model
{
    use HasFactory;

    protected $table = 'user_roles';
    protected $primaryKey = 'id';
    public $timestamps = true;
}
