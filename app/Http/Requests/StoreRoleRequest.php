<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoleRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'          => 'required|max:255|unique:roles',
            'permissions'   => 'nullable|array',
            'permissions.*' => 'exists:permissions,id'
        ];
    }
}
