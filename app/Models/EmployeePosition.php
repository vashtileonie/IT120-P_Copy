<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeePosition extends Model
{
    use Auditable, HasFactory, SoftDeletes;

    public $table       = 'employee_position';
    public $timestamps  = true;

    protected $auditable = false;

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected $fillable = [
        'id',
        'employee_id',
        'position_id',
        'updated_at',
        'created_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];
}