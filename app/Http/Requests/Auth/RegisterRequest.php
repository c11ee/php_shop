<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseRequest;

class RegisterRequest extends BaseRequest
{
    /**
     * 定义验证规则
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
        ];
    }

    // /**
    //  * 自定义错误信息
    //  */
    // public function messages(): array
    // {
    //     return [
    //         'name.required'     => '请输入用户名',
    //         'email.required'    => '请输入邮箱',
    //         'email.email'       => '请输入正确的邮箱格式',
    //         'email.unique'      => '邮箱已被注册',
    //         'password.required' => '请输入密码',
    //         'password.min'      => '密码至少6位',
    //     ];
    // }
}
