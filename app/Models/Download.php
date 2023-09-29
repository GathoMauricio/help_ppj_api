<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Download extends Model
{
    use HasFactory;

    protected $table = 'downloads';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'ip',
        'version'
    ];
}
