<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateRoleRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            //'name'          => 'required|max:255|unique:roles,name,' . request()->route('role')->id,
            'permissions'   => 'nullable|array',
            'permissions.*' => 'exists:permissions,id'
        ];
    }
}
