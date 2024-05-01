<?php
namespace App\Models;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

use Hash;

use App\Imports\UsersImport;
use App\Traits\Auditable;
use App\Traits\AuthUserTrait;
use App\Traits\DataTableTraitV2;
use App\Traits\ImportableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class User extends Authenticatable 
{
    use SoftDeletes, HasFactory, Notifiable, Auditable, AuthUserTrait, DataTableTraitV2, ImportableTrait;

    protected $table    = 'users'; 
    protected $with     = ['roles'];

    protected $hidden = [
        'pivot',
        'password',
        'remember_token',
    ];

    protected $casts = [
        'updated_at'            => 'datetime',
        'created_at'            => 'datetime',
        'deleted_at'            => 'datetime',
        'email_verified_at'     => 'datetime',
        'password_changed_at'   => 'datetime',
        'password'              => 'hashed',
    ];

    protected $fillable = [
        'id',
        'username',
        'password',
        'password_changed_at',
        'last_name',
        'first_name',
        'email',
        'email_verified_at',
        'phone_number',
        'mobile_number',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];


    public static $dataTableColumns = [
        [
            'data' => 'username',
            'name' => 'username',
        ],
        [
            'data' => 'first_name',
            'name' => 'first_name',
        ],
        [
            'data' => 'last_name',
            'name' => 'last_name',
        ],
        [
            'data' => 'email',
            'name' => 'email',
        ],
        [
            'data' => 'phone_number',
            'name' => 'phone_number',
        ],
        [
            'data' => 'mobile_number',
            'name' => 'mobile_number',
        ],
        [
            'data' => 'role',
            'name' => 'role',
        ]
    ];

    public static $searchable = [
        'first_name',
        'last_name',
        'username',
        'email',
        'phone_number',
        'mobile_number',
        'role',
        'account_type',
        'account',
    ];


    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }


    public function renderButtons()
    {
        $buttons        = '';
        $show_edit_btn  = ! Gate::denies($this->table . '_edit') ? true : false;
        $show_view_btn  = ! Gate::denies($this->table . '_show') ? true : false;

        $view_btn = '<a href="' . route($this->table . '.show', $this->id) . '" class="mr-2 show bs-tooltip" title="' . label('view') . '"><i class="fa fa-eye" aria-hidden="true"></i></a>';
        $edit_btn = '<a href="' . route($this->table . '.edit', $this->id) . '" class="mr-2 edit bs-tooltip" title="' . label('edit') . '"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
        $delete_btn = '<a href="#" class="mr-2 delete deleteIcon bs-tooltip" title="' . label('delete') . '" data-url="' . route($this->table . '.destroy', $this->id). '" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-trash" aria-hidden="true"></i></a>';

        if ($show_view_btn) {
            $buttons .= $view_btn;
        }
        if ($show_edit_btn) {
            $buttons .= $edit_btn;
        }
        if ($this->isSuperAdmin()) {
            $buttons .= $delete_btn;
        }

        return $buttons;
    }


    public function getFullNameAttribute()
    {
        $name = [
            $this->first_name,
            $this->last_name,
        ];
        return implode(' ', array_filter($name));
    }


    public function scopeFiltered($query, $unfiltered = false)
    {
    
    }


    public function getImporter(): string
    {
        return UsersImport::class;
    }


    public function getIdentifiers(): array
    {
        return [
            'username',
        ];
    }


    public function setPasswordAttribute($input)
    {
        if($input)
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
    }


    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }


    public function roles()
    {
        return $this->belongsToMany(Role::class)->withTimestamps()->select(['roles.id','roles.name']);
    }


    public function user_roles()
    {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');
    }


    protected static function getListCount()
    {
        return self::selectData(false)
                ->listConditions(request())
                ->count();
    }

    protected static function getSearchListCount()
    {
        return self::search()
                ->selectData()
                ->listConditions(request())
                ->count();
    }


    public function scopeSelectData($query, bool $search = true)
    {
        $query = $search ? self::search() : $query;

        return $query->from(
            self::select(
                'id',
                DB::raw(
                    '(SELECT roles.name FROM role_user LEFT JOIN roles ON roles.id = role_user.role_id WHERE user_id = users.id LIMIT 1) role'
                ),
                'username',
                'first_name',
                'last_name',
                'email',
                'phone_number',
                'mobile_number',
                'deleted_at'
            ),
            'users'
        );
    }


    public function scopeListConditions($query, Request $request): Builder
    {
        return $query->when(
                    ($request->has('role_id')
                        && ! empty($request->role_id)
                    ), function ($q) use ($request) {
                        $q->whereHas('user_roles', function ($q1) use ($request) {
                            $q1->where('role_id', $request->role_id);
                        });
                    }
                )
                ->when(! $this->isSuperAdmin(), function ($q) {
                    $q->where('id', auth()->id());
                });
    }


    protected static function list(Request $request): Builder
    {
        return self::search()
                ->selectData()
                ->listConditions($request)
                ->page($request);
    }


    /**
     * Performs deleting account by prepending a tag on the Email
     *
     * @return void
     */
    public function scopeDeleteEmail($query)
    {
        // for count checker
        $i = 0;

        // for stopper
        $deleted_email_exists = true;

        // let's loop through
        while ($deleted_email_exists) {

            // get user
            $deleted_user = self::getByDeletedEmail($this->email, $i);

            // if it exists
            if (is_null($deleted_user)) {

                // update
                $this->email = 'deleted' . ($i == 0 ? '' : $i) . '_' . $this->email;
                $this->save();

                // stop the loop
                $deleted_email_exists = false;
            }

            // increment for loop
            $i++;
        }
    }

    /**
     * Get user by post deleted email
     *
     * @param string $email
     * @param int $index
     */
    private function getByDeletedEmail($email, $index = 0)
    {
        // initial check
        if ($index == 0) {
            $index = '';
        }

        return self::query()
                ->where('email', 'deleted' . $index . '_' . $email)
                ->withTrashed()
                ->first();
    }
}