<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Pagination\Paginator;

use App\Services\BlogService;

class FrontController extends Controller
{

    function __construct() {
        // フロントページっぽく調整
        config(['adminlte.title' => 'ブログトップページ']);
        config(['adminlte.logo' => 'ブログトップページ']);
        // ユーザーメニュー非表示
        config(['adminlte.usermenu_enabled' => false]);
        // ログアウトメニュー非表示
        config(['adminlte.logout_menu' => false]);
        // トップナビレイアウト
        config(['adminlte.layout_topnav' => true]);
        // メニューを削除
        config(['adminlte.menu' => [] ]);


        Paginator::useBootstrap();
    }

    // 一覧
    public function index(Request $request, $category_id = null) {

        $query = Blog::query();
        $query->where('is_enabled', '=', true);

        $blogs = $query
            ->orderBy('day', 'desc')
            ->orderBy('updated_at', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(5);

        // ブログ本文から最初の画像を抜き出してimageカラムを設定
        $blogsv = New BlogService();
        $blogs->map(function ($v) use ($blogsv) {
            $v['image'] = $blogsv->pickupImageURL($v['body']);
            return $v;
        });

        return view('front/index', compact('blogs'));
    }

}
