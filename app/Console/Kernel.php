<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

// 还需配置服务器 cron 任务, 每天执行一次
class Kernel extends ConsoleKernel
{
    /**
     * 定义应用的命令调度。
     */
    protected function schedule(Schedule $schedule)
    {
        // 每天执行一次 Sanctum 清理过期 Token
        $schedule->command('sanctum:prune-expired --hours=24')->daily();
    }

    /**
     * 注册应用的命令。
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
