<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{
    InstituteController,
    EmployeeController,
    CircleController,
    AttendanceController,
    NotificationController
};


// كل REST APIs تحت حماية Sanctum
Route::middleware('auth:sanctum')->group(function () {

    // المعاهد
    Route::apiResource('institutes', InstituteController::class);

    // الموظفون
    Route::apiResource('employees', EmployeeController::class)
        ->only(['index','store','show','update','destroy']);

    // الحلقات
    Route::apiResource('circles', CircleController::class);

    // الحضور (قراءة/إضافة/عرض مفردة) — بنقدر نضيف  update/delete لاحقًا إن لزم
    Route::apiResource('attendances', AttendanceController::class)
        ->only(['index','store','show']);
    // ->only(['index','store','show','update','destroy']);

    // الإشعارات
    Route::apiResource('notifications', NotificationController::class)
        ->only(['index','store','show','destroy']);
    // وسم كمقروء
    Route::post('notifications/{notification}/read', [NotificationController::class, 'markAsRead'])
        ->name('notifications.markAsRead');
});
