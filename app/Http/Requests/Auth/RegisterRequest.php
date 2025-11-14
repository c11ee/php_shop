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

    /**
     * 获取自定义的属性名称
     */
    public function attributes(): array
    {
        return [
            'name' => __('validation.attributes.name'),
            'email' => __('validation.attributes.email'),
            'password' => __('validation.attributes.password'),
        ];
    }

    /**
     * 自定义错误信息（使用翻译函数）
     */
    public function messages(): array
    {
        // 使用Laravel的默认验证翻译，无需重复定义通用错误消息
        // 只需要定义特定的自定义消息
        return [
            'email.unique' => __('validation.unique'),
            // 这里可以添加其他特定的自定义翻译消息
        ];
    }
}
