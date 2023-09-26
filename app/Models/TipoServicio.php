<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoServicio extends Model
{
    use HasFactory;

    protected $table = 'service_types';
    protected $primaryKey = 'id';
    public $timestamps = true;


    public function area()
    {
        return $this->belongsTo(
            'App\Models\Area',
            'service_area_id',
            'id'
        )
            ->withDefault();
    }
}
