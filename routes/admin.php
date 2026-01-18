<?php

use App\Http\Controllers\Admin\admin_panel_settingController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Setting\Finance__calenderController;
use App\Models\Admin;
use Illuminate\Support\Facades\Route;

define('PAGINATE_CONTROLLER', 10);
Route::group(['prefix' => 'admin', 'middleware' => 'auth:admin'], function () {
    Route::get('/', [DashboardController::class, 'index']);
    Route::get('logout', [AuthController::class, 'logout'])->name('admin.logout');
});
