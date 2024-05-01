<?php

namespace App\Models;

use App\Traits\Auditable;
use App\Traits\AuthUserTrait;
use App\Traits\DataTableTraitV2;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class Permission extends Model
{
    use Auditable, AuthUserTrait, DataTableTraitV2, SoftDeletes, HasFactory;

    public $table       = 'permissions';
    public $timestamps  = true;

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected $fillable = [
        'id',
        'name',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public static $dataTableColumns = [
        [
            'data' => 'name',
            'name' => 'name',
        ],
    ];

    public static $searchable = ['name'];


    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }


    public static function list(Request $request): Builder
    {
        return self::search()
                ->page($request);
    }


    public function renderButtons()
    {
        $buttons    = null;
        $allow_view = ! Gate::denies($this->table.'_index') ? true : false;
        $allow_edit = ! Gate::denies($this->table.'_edit') ? true : false;

        $view_roles_btn = '<a class="roleIcon mr-2 bs-tooltip" href="#" title="' . label('roles_view_all') . '" data-toggle="modal" data-target="#rolesModal" data-url="' . route($this->table.'.roles', $this->id) . '">
                                <i class="fa fa-user text-gray-600" aria-hidden="true"></i>
                            </a>';

        $edit_btn   = '<a class="edit mr-2 bs-tooltip" href="' . route($this->table.'.edit', $this->id) . '" title="' . label('edit') . '">
                            <i class="fa fa-pencil text-gray-600" aria-hidden="true"></i>
                        </a>';

        $delete_btn = '<a class="small deleteIcon bs-tooltip" href="#" title="' . label('delete') . '" data-url="' . route($this->table.'.destroy', $this->id) . '" data-toggle="modal" data-target="#deleteModal">
                            <i class="fa fa-trash text-gray-600" aria-hidden="true"></i>
                        </a>';

        if ($allow_view) {
            $buttons = $view_roles_btn;
        }
        if ($allow_edit) {
            $buttons .= $edit_btn;
        }
        if ($this->isSuperAdmin()) {
            $buttons .= $delete_btn;
        }
        return $buttons;
    }

}