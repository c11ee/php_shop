<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // 注册
    public function register(RegisterRequest $request)
    {

        // 通过验证后可安全获取数据
        // $data = $request->validated();

        // 创建用户
        $user = new User;
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        // 加密密码
        $user->password = bcrypt($request->input('password'));
        $user->save();

        return response()->json([
            'message' => '注册成功',
            'code' => 0,
            'data' => [],
        ], 200);
    }

    // 登录
    public function login(Request $request)
    {
        // 校验规则
        $rules = [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string'
        ];

        // 自定义消息
        $messages = [
            'email.required'    => '请输入邮箱',
            'email.email'       => '请输入正确的邮箱格式',
            'password.required' => '请输入密码',
        ];

        // 校验
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'code' => -1,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $credentials = $validator->validated();
        // 登录
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'code' => -1,
                'message' => '邮箱或密码错误',
            ], 422);
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // 生成 Sanctum token
        $token = $user->createToken('authToken')->plainTextToken;

        // 获取配置, 如果没写默认 7 天
        $expirationMinutes = config('sanctum.expiration', 60 * 24 * 7);

        return response()->json([
            'message' => '登录成功',
            'code' => 0,
            'data' => [
                'token' => $token,
                // 过期时间, 
                'expires_at' => now()->addMinutes($expirationMinutes)->timestamp,
                'user' => $user,
            ],
        ], 200);
    }

    // 退出登录
    public function logout(Request $request)
    {
        // 清除当前用户的所有 token
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => '退出登录成功',
            'code' => 0,
            'data' => [],
        ], 200);
    }
}
