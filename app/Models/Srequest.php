<?php

namespace App\Models;

use App\Traits\Auditable;
use App\Traits\AuthUserTrait;
use App\Traits\DataTableTraitV2;
use App\Traits\HasDataProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Srequest extends Model
{
    use AuthUserTrait, Auditable, DataTableTraitV2, HasDataProvider, SoftDeletes, HasFactory;

    public $table       = 'srequests';
    public $base_url    = 'srequests';
    public $timestamps  = true;

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected $hidden = [
        'pivot'
    ];

    protected $fillable = [
        'id',
        'form_type_id',
        'latest_request_status_id',
        'latest_request_status',
        'description',
        'title',
        'advising_type_id',
        'priority_id',
        'student_id',
        'employee_id',
        'notes',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    public static $dataTableColumns = [
        [
            'data' => 'id',
            'name' => 'id',
        ],
        [
            'data' => 'form_type_id',
            'name' => 'form_type_id',
        ],
        [
            'data' => 'title',
            'name' => 'title',
        ],
        [
            'data' => 'student_id',
            'name' => 'student_id',
        ],
        [
            'data' => 'employee_id',
            'name' => 'employee_id',
        ],
        [
            'data' => 'advising_type_id',
            'name' => 'advising_type_id',
        ],
        [
            'data' => 'priority_id',
            'name' => 'priority_id',
        ],
        [
            'data' => 'notes',
            'name' => 'notes',
        ],
    ];


    public static $searchable = [
        'title',
        'description',
        'notes',
    ];


    public static function list(Request $request): Builder
    {
        return self::search()->page($request);
    }


    public function renderButtons()
    {
        $buttons    = null;
        $allow_view = ! Gate::denies($this->table.'_index') ? true : false;
        $allow_edit = ! Gate::denies($this->table.'_edit') ? true : false;

        $view_btn   = '<a href="' . route($this->base_url . '.show', $this->id) . '" class="mr-2 show bs-tooltip" title="' . label('view') . '"><i class="fa fa-eye" aria-hidden="true"></i></a>';
        $edit_btn   = '<a class="edit mr-2 bs-tooltip" href="' . route($this->base_url.'.edit', $this->id) . '" title="' . label('edit') . '">
                            <i class="fa fa-pencil text-gray-600" aria-hidden="true"></i>
                        </a>';

        $delete_btn = '<a class="small deleteIcon bs-tooltip" href="#" title="' . label('delete') . '" data-url="' . route($this->base_url.'.destroy', $this->id) . '" data-toggle="modal" data-target="#deleteModal">
                            <i class="fa fa-trash text-gray-600" aria-hidden="true"></i>
                        </a>';

        if ($allow_view) {
            $buttons .= $view_btn;
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