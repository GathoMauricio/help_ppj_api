<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeguimientoCaso extends Model
{
    use HasFactory;

    protected $table = 'case_follows';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'case_id', 'author_id', 'body'
    ];

    public function caso()
    {
        return $this->belongsTo(
            'App\Models\Caso',
            'case_id',
            'id'
        )
            ->withDefault();
    }

    public function autor()
    {
        return $this->belongsTo(
            'App\Models\User',
            'author_id',
            'id'
        )
            ->withDefault();
    }
}
