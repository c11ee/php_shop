<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseRequest extends FormRequest
{
    /**
     * 判断用户是否有权限发出此请求
     */
    public function authorize(): bool
    {
        return true;
    }
    
    /**
     * 处理验证失败的情况
     */
    protected function failedValidation(Validator $validator)
    {
        $response = response()->json([
            'code' => -1,
            'message' => $validator->errors()->first(),
        ], 422);
        
        throw new HttpResponseException($response);
    }
}
