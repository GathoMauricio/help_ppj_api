<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caso extends Model
{
    use HasFactory;

    protected $table = 'cases';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'area_id',
        'num_case',
        'status_id',
        'service_id',
        'user_contact_id',
        'priority_case_id',
        'description',
    ];

    public function contacto()
    {
        return $this->belongsTo(
            'App\Models\User',
            'user_contact_id',
            'id'
        )
            ->withDefault();
    }

    public function tipo_servicio()
    {
        return $this->belongsTo(
            'App\Models\TipoServicio',
            'service_id',
            'id'
        )
            ->withDefault();
    }

    public function prioridad()
    {
        return $this->belongsTo(
            'App\Models\PrioridadCaso',
            'priority_case_id',
            'id'
        )
            ->withDefault();
    }

    public function estatus()
    {
        return $this->belongsTo(
            'App\Models\EstatusCaso',
            'status_id',
            'id'
        )
            ->withDefault();
    }

    public function seguimientos()
    {
        return $this->hasMany('App\Models\SeguimientoCaso', 'case_id');
    }

    public function archivos()
    {
        return $this->hasMany('App\Models\ArchivoCaso', 'case_id');
    }
}
