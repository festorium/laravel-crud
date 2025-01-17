<?php

namespace App\Services;

use App\Models\SystemLog;

class SystemLogService
{
    // Log user activity
    public function logActivity($userId, $action, $description)
    {
        SystemLog::create([
            'user_id' => $userId,
            'log_action' => $action,
            'log_description' => $description,
            'timestamp' => now(),
        ]);
    }
}
