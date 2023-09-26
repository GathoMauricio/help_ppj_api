<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstatusCaso extends Model
{
    use HasFactory;

    protected $table = 'case_statuses';
    protected $primaryKey = 'id';
    public $timestamps = true;
}
