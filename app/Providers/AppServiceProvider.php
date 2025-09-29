<?php

namespace App\Providers;

use App\Models\Sanctum\PersonalAccessToken;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     * 启动任何应用服务.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();

        // 自定义 Sanctum token 模型
        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);
    }

    protected function configureRateLimiting()
    {
        // 我想自定义错误提示
        RateLimiter::for('api', function ($request) {
            // 每分钟 60 次, 根据用户或 IP
            return Limit::perMinute(60)
                ->by(optional($request->user())->id, $request->ip())
                ->response(function ($request, array $headers) {
                    return response()->json([
                        'code' => -1,
                        'message' => '请求太频繁, 请稍后再试'
                    ], 429, $headers);
                });
        });
    }
}
