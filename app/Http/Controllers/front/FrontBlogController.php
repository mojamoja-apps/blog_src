<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Pagination\Paginator;

use App\Services\BlogService;

class FrontBlogController extends Controller
{

    function __construct() {
        // フロントページっぽく調整
        config(['adminlte.title' => 'ブログ記事一覧']);
        config(['adminlte.logo' => 'ブログ記事一覧']);
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

    // 登録・編集
    public function view($id) {
        $query = Blog::query();
        $query->where('id', $id);
        $query->where('is_enabled', true);
        $blog = $query->firstOrFail();


        // 次の新しい記事
        $query = Blog::query();
        $query->where('id', '<>', $blog->id);
        $query->where('day', '>=', $blog->day);
        $query->where('updated_at', '>=', $blog->updated_at);
        $query->where('is_enabled', true);
        $next = $query
            ->orderBy('day', 'asc')
            ->orderBy('updated_at', 'asc')
            ->orderBy('id', 'asc')
            ->first();

        // 前の新しい記事
        $query = Blog::query();
        $query->where('id', '<>', $blog->id);
        $query->where('day', '<=', $blog->day);
        $query->where('updated_at', '<=', $blog->updated_at);
        $query->where('is_enabled', true);
        $prev = $query
            ->orderBy('day', 'desc')
            ->orderBy('updated_at', 'desc')
            ->orderBy('id', 'desc')
            ->first();


        return view('front/blog/view', compact('blog', 'next', 'prev'));
    }

    // 一覧
    public function index(Request $request, $category_id = null) {

        $query = Blog::query();
        $query->where('is_enabled', '=', true);

        if (isset($_GET['keyword']) && $_GET['keyword']) {
            // 全角スペースを半角に変換
            $spaceConversion = mb_convert_kana($_GET['keyword'], 's');
            // 単語を半角スペースで区切り、配列にする（例："山田 翔" → ["山田", "翔"]）
            $wordArraySearched = preg_split('/[\s,]+/', $spaceConversion, -1, PREG_SPLIT_NO_EMPTY);
            // 単語をループで回し、ユーザーネームと部分一致するものがあれば、$queryとして保持される
            foreach($wordArraySearched as $value) {
                $query->where('title', 'like', '%'.$value.'%')
                    ->OrWhere('body', 'like', '%'.$value.'%')
                ;
            }
            $open = true;
        }

        if (isset($category_id) && !empty($category_id)) {
            $query->where('category', '=', $category_id);
        }

        $blogs = $query
            ->orderBy('day', 'desc')
            ->orderBy('updated_at', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(10);

        // ブログ本文から最初の画像を抜き出してimageカラムを設定
        $blogsv = New BlogService();
        $blogs->map(function ($v) use ($blogsv) {
            $v['image'] = $blogsv->pickupImageURL($v['body']);
            return $v;
        });

        return view('front/blog/index', compact('blogs'));
    }

}
