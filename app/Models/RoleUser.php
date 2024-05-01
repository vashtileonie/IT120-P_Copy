<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoleUser extends Model
{
    use SoftDeletes, HasFactory;

    public $table       = 'role_user';
    public $timestamps  = true;

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'id',
        'user_id',
        'role_id',
        'updated_at',
        'created_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by'
    ];
}