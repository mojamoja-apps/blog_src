<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class BlogController extends Controller
{
    public $search_session_name;

    function __construct() {
        $this->search_session_name = 'blog';
    }

    // 一覧
    public function index(Request $request) {
        // cardの開閉 全閉じ状態を初期値 必要に応じてオープン
        $collapse = config('const.COLLAPSE.CLOSE');



        $query = Blog::query();

        //検索
        $method = $request->method();
        $session = $request->session()->get($this->search_session_name);

        $search = [];
        $search_keys = [
            'keyword',
        ];
        foreach ($search_keys as $keyname) {
            $search[$keyname] = '';
            if($method == "POST"){
                $search[$keyname] = $request->input($keyname) ? $request->input($keyname) : '';
            } else if($method == "GET") {
                $search[$keyname] = isset($session[$keyname]) ? $session[$keyname] : '';
            }
        }

        // セッションを一旦消して検索値を保存
        $request->session()->forget($this->search_session_name);
        $puts = [];
        foreach ($search_keys as $keyname) {
            $puts[$keyname] = $search[$keyname];
        }
        $request->session()->put($this->search_session_name, $puts);


        $open = false; // 検索ボックスを開くか

        if ($search['keyword']) {
            // 全角スペースを半角に変換
            $spaceConversion = mb_convert_kana($search['keyword'], 's');
            // 単語を半角スペースで区切り、配列にする（例："山田 翔" → ["山田", "翔"]）
            $wordArraySearched = preg_split('/[\s,]+/', $spaceConversion, -1, PREG_SPLIT_NO_EMPTY);
            // 単語をループで回し、ユーザーネームと部分一致するものがあれば、$queryとして保持される
            foreach($wordArraySearched as $value) {
                $query->where('name', 'like', '%'.$value.'%')
                    ->OrWhere('zip', 'like', '%'.$value.'%')
                    ->OrWhere('pref', 'like', '%'.$value.'%')
                    ->OrWhere('address1', 'like', '%'.$value.'%')
                    ->OrWhere('address2', 'like', '%'.$value.'%')
                    ->OrWhere('tel', 'like', '%'.$value.'%')
                    ->OrWhere('memo', 'like', '%'.$value.'%')
                ;
            }
            $open = true;
        }

        if ($open) {
            $collapse = config('const.COLLAPSE.OPEN');
        }

        $blogs = $query->orderBy('updated_at', 'desc')->get();


        return view('admin/blog/index', compact('blogs', 'search', 'collapse'));
    }

    // 登録・編集
    public function edit($id = null) {
        if ($id == null) {
            $mode = config('const.editmode.create');
            $blog = New Blog; //新規なので空のインスタンスを渡す
        } else {
            $mode = config('const.editmode.edit');
            $blog = Blog::find($id);
        }

        // 画像アップロードディレクトリ用テキスト 無ければ生成
        if ($blog->dir == null) {
            $blog->dir = date('YmdHis') .'_'. Str::random(5);
        }
        return view('admin/blog/edit', compact('blog', 'mode'));
    }

    // 更新処理
    public function update(Request $request, $id = null) {
        $request->validate([
            'day' => 'required|date',
            'title' => 'required|max:100',
        ]
        ,[
            'day.required' => '必須項目です。',
            'day.date' => '有効な日付を指定してください。',
            'title.required' => '必須項目です。',
        ]);

        // 更新対象データ
        $updarr = [
            'day' => $request->input('day'),
            'title' => $request->input('title'),
            'body' => $request->input('body'),
            'dir' => $request->input('dir'),
        ];

        Blog::updateOrCreate(
            ['id' => $id],
            $updarr,
        );

        // CSRFトークンを再生成して、二重送信対策
        $request->session()->regenerateToken();

        return redirect( route('admin.blog.index') );
    }

    public function destroy(Request $request, $id) {
        $blog = Blog::find($id);
        $blog->delete();

        // CSRFトークンを再生成して、二重送信対策
        $request->session()->regenerateToken();

        return redirect( route('admin.blog.index') );
    }
}
