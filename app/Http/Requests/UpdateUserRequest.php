<?php

namespace App\Http\Requests;

use App\Models\Role;
use App\Models\User;
use App\Models\Wallet;
use App\Traits\AuthUserTrait;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    use AuthUserTrait;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $user_id = request()->route('user')->id;

        $rules = [
            'first_name'    =>  [
                                    'required',
                                    'min:0',
                                    'max:255'
                                ],
            'last_name'     =>  [
                                    'required',
                                    'min:0',
                                    'max:255'
                                ],
            'email'         =>  [
                                    'required',
                                    'unique:users,email,' . $user_id . ',id,deleted_at,NULL',
                                    'email'
                                ],
            'phone_number'  =>  [
                                    'nullable',
                                    'unique:users,phone_number,' . $user_id . ',id,deleted_at,NULL'
                                ],
            'mobile_number' =>  [
                                    'required',
                                    'unique:users,mobile_number,' . $user_id . ',id,deleted_at,NULL'
                                ],
            'role_id'       =>  [
                                    'required',
                                    'exists:roles,id'
                                ]
        ];

        // if user is not super admin
        if (! $this->isSuperAdmin()) {
            $rules['role_id'] = 'nullable';
        }

        return $rules;
    }

    public function attributes()
    {
        return [
            'role_id' => label('role')
        ];
    }
}
