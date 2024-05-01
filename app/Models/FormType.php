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

class FormType extends Model
{
    use AuthUserTrait, Auditable, DataTableTraitV2, HasDataProvider, SoftDeletes, HasFactory;

    public $table       = 'form_types';
    public $base_url    = 'form-types';
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
        'name',
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
            'data' => 'name',
            'name' => 'name',
        ],
        [
            'data' => 'created_at',
            'name' => 'created_at',
        ],
    ];

    public static $searchable = ['name'];


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

        $edit_btn   = '<a class="edit mr-2 bs-tooltip" href="' . route($this->base_url.'.edit', $this->id) . '" title="' . label('edit') . '">
                            <i class="fa fa-pencil text-gray-600" aria-hidden="true"></i>
                        </a>';

        $delete_btn = '<a class="small deleteIcon bs-tooltip" href="#" title="' . label('delete') . '" data-url="' . route($this->base_url.'.destroy', $this->id) . '" data-toggle="modal" data-target="#deleteModal">
                            <i class="fa fa-trash text-gray-600" aria-hidden="true"></i>
                        </a>';

        if ($allow_edit) {
            $buttons .= $edit_btn;
        }
        if ($this->isSuperAdmin()) {
            $buttons .= $delete_btn;
        }

        return $buttons;
    }

     /**
     * Prepare a date for array / JSON serialization.
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}