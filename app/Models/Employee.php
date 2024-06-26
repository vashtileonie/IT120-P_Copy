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

class Employee extends Model
{
    use AuthUserTrait, Auditable, DataTableTraitV2, HasDataProvider, SoftDeletes, HasFactory;

    public $table       = 'employees';
    public $base_url    = 'employees';
    public $timestamps  = true;

    protected $casts = [
        'birthdate'  => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected $hidden = [
        'pivot'
    ];

    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'middle_name',
        'birthdate',
        'employee_no',
        'gender',
        'employee_status_id',
        'imagefile',
        'email',
        'address1',
        'address2',
        'phone_number',
        'mobile_number',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    public static $dataTableColumns = [
        [
            'data' => 'employee_no',
            'name' => 'employee_no',
        ],
        [
            'data' => 'last_name',
            'name' => 'last_name',
        ],
        [
            'data' => 'first_name',
            'name' => 'first_name',
        ],
        [
            'data' => 'middle_name',
            'name' => 'middle_name',
        ],
        [
            'data' => 'gender',
            'name' => 'gender',
        ],
        [
            'data' => 'email',
            'name' => 'email',
        ],
        [
            'data' => 'created_at',
            'name' => 'created_at',
        ],
    ];

    public static $searchable = [
        'first_name',
        'last_name',
        'employee_no',
        'email',
        'phone_number',
        'mobile_number',
        'address1',
        'address2',
    ];


    public static function list(Request $request): Builder
    {
        return self::search()
            ->listConditions($request)
            ->page($request);
    }


    public function scopeListConditions($query, Request $request): Builder
    {
        return $query
                ->when(($request->has('department_id') && ! empty($request->department_id)), function ($q) use ($request) {
                        $q->whereHas('departments', function ($q1) use ($request) {
                            $q1->where('department_id', $request->department_id);
                        });
                    })
                ->when(($request->has('position_id') && ! empty($request->position_id)), function ($q) use ($request) {
                    $q->whereHas('positions', function ($q1) use ($request) {
                        $q1->where('position_id', $request->position_id);
                    });
                })
                ->when(($request->has('subject_id') && ! empty($request->subject_id)), function ($q) use ($request) {
                    $q->whereHas('subjects', function ($q1) use ($request) {
                        $q1->where('subject_id', $request->subject_id);
                    });
                });
    }


    public function departments()
    {
        return $this->belongsToMany(Department::class)->whereNull('employee_department.deleted_at');
    }


    public function positions()
    {
        return $this->belongsToMany(Position::class)->whereNull('employee_position.deleted_at');
    }


    public function subjects()
    {
        return $this->belongsToMany(Subject::class)->whereNull('employee_subject.deleted_at');
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