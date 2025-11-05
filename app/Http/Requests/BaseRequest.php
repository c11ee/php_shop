<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BaseRequest extends FormRequest
{
    /**
     * 判断用户是否有权限发出此请求
     */
    public function authorize(): bool
    {
        return true;
    }
}
