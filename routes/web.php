<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Report\FrontReportController;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\SummernoteController;
use App\Http\Controllers\Front\FrontBlogController;

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

    // ブログ
    Route::match(['get', 'post'], '/admin/blog', [BlogController::class, 'index'])->name('admin.blog.index');
    Route::get('/admin/blog/edit/{id?}', [BlogController::class, 'edit'])->name('admin.blog.edit');
    Route::post('/admin/blog/update/{id?}', [BlogController::class, 'update'])->name('admin.blog.update');
    Route::post('/admin/blog/destroy/{id}', [BlogController::class, 'destroy'])->name('admin.blog.destroy');

    // 画像アップロード
    Route::post('/admin/upload_image', [SummernoteController::class, 'upload_image'])->name('admin.upload_image');

});


// フロント
Route::get('/blog', [FrontBlogController::class, 'index'])->name('front.blog.index');
Route::get('/blog/category/{category_id}', [FrontBlogController::class, 'index'])->name('front.blog.category_index');
Route::get('/blog/{id}', [FrontBlogController::class, 'view'])->name('front.blog.view');


require __DIR__.'/auth.php';
