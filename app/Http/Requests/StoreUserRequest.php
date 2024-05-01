<?php

namespace App\Http\Requests;

use App\Models\Role;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [            
            'first_name'    =>  'required',
            'last_name'     =>  'required',
            'email'         =>  [
                                    'required',
                                    'unique:users,email,NULL,id,deleted_at,NULL',
                                    'email'
                                ],
            'phone_number'  =>  [
                                    'nullable',
                                    'unique:users,phone_number,NULL,id,deleted_at,NULL'
                                ],
            'mobile_number' =>  [
                                    'required',
                                    'unique:users,mobile_number,NULL,id,deleted_at,NULL'
                                ],
            'username'      =>  [
                                    'required',
                                    'unique:users,username,NULL,id,deleted_at,NULL'
                                ],
            'password'      =>  [
                                    'required',
                                    'confirmed',
                                    Password::min(8)
                                        ->letters()
                                        ->mixedCase()
                                        ->numbers()
                                        ->symbols()
                                        ->uncompromised(),
                                ],
            'role_id'       =>  [
                                    'required',
                                    'exists:roles,id'
                                ]
        ];

        // get role
        $role = Role::find((int) request('role_id'));
        return $rules;
    }

    public function attributes()
    {
        return [
            'role_id'  => label('role')
        ];
    }
}