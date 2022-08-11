<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class FrontBlogController extends Controller
{

    function __construct() {
        //
    }

    // 一覧
    public function index(Request $request) {


        $query = Blog::query();

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

        if (isset($_GET['category']) && $_GET['category']) {
            $query->where('category', '=', $_GET['category']);
        }

        $blogs = $query->orderBy('day', 'desc')->get();


        return view('front/blog/index', compact('blogs'));
    }

}
