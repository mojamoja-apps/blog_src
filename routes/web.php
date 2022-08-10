<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Report\FrontReportController;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\SiteController;
use App\Http\Controllers\Admin\WorkerController;
use App\Http\Controllers\Admin\DeduraController;
use App\Http\Controllers\Admin\KintaiController;

use App\Http\Controllers\Api\ValidateController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    //return view('welcome');
    return redirect('/report');
});


// 管理画面
Route::middleware('auth')->group(function () {
    Route::get('/admin', function () {
        return view('admin/index');
    })->name('admin');

    // 管理者
    Route::match(['get', 'post'], '/admin/user', [UserController::class, 'index'])->name('admin.user.index');
    Route::get('/admin/user/edit/{id?}', [UserController::class, 'edit'])->name('admin.user.edit');
    Route::post('/admin/user/update/{id?}', [UserController::class, 'update'])->name('admin.user.update');
    Route::post('/admin/user/destroy/{id}', [UserController::class, 'destroy'])->name('admin.user.destroy');

    // 元請け
    Route::match(['get', 'post'], '/admin/company', [CompanyController::class, 'index'])->name('admin.company.index');
    Route::get('/admin/company/edit/{id?}', [CompanyController::class, 'edit'])->name('admin.company.edit');
    Route::post('/admin/company/update/{id?}', [CompanyController::class, 'update'])->name('admin.company.update');
    Route::post('/admin/company/destroy/{id}', [CompanyController::class, 'destroy'])->name('admin.company.destroy');


});

// API 作業証明書の重複チェック
Route::post('/api/validate/report', [ValidateController::class, 'report'])->name('api.validate.report');

require __DIR__.'/auth.php';
