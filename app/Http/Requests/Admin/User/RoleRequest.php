<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;
class RoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $route = Route::current();
        if ($route->getName() === 'admin.user.role.store') {
            return [
                'name' => 'required|min:1|max:120',
                'description' => 'required|min:1|max:200',
                'permissions.*' => 'exists:permissions,id',
            ];
        }
        elseif ($route->getName() === 'admin.user.role.update') {
            return [
                'name' => 'required|min:1|max:120',
                'description' => 'required|min:1|max:200',
                ];
        }
        elseif ($route->getName() === 'admin.user.role.permission-update') {
            return [
                'permissions.*' => 'exists:permissions,id',
            ];
        }
    }

    public function attributes()
    {
        return [
            'name' => 'عنوان نقش',
            'permissions.*' => "دسترسی"
        ];
    }
}
