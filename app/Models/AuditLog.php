<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AuditLog extends Model
{
    use SoftDeletes, HasFactory;

    public $table       = 'audit_logs';
    public $timestamps  = true;

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'id',
        'description',
        'subject_id',
        'subject_type',
        'user_id',
        'properties',
        'host',
        'created_at',
        'updated_at'
    ];
}
