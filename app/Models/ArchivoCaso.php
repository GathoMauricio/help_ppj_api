<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchivoCaso extends Model
{
    use HasFactory;

    protected $table = 'case_files';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'case_id',
        'author_id',
        'name',
        'route',
        'mime_type'
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
