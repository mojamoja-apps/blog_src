<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class FrontContactController extends Controller
{

    function __construct() {
        // フロントページっぽく調整
        config(['adminlte.title' => 'お問い合わせフォーム']);
        config(['adminlte.logo' => 'お問い合わせフォーム']);
        // ユーザーメニュー非表示
        config(['adminlte.usermenu_enabled' => false]);
        // ログアウトメニュー非表示
        config(['adminlte.logout_menu' => false]);
        // トップナビレイアウト
        config(['adminlte.layout_topnav' => true]);
        // メニューを削除
        config(['adminlte.menu' => [] ]);
    }

    public function index() {
        return view('front/contact/index');
    }


    public function send(Request $request){
        $request->validate([
            'name' => 'required|max:100',
            'mail' => 'required|email|max:100',
            'body' => 'max:5000',
        ]
        ,[
            'name.required' => '必須項目です。',
            'name.max' => '50文字以内で入力してください。',
            'mail.required' => '必須項目です。',
            'mail.email' => 'メールアドレスを正しく入力してください。',
            'mail.max' => '50文字以内で入力してください。',
            'body.required' => '必須項目です。',
        ]);

        Contact::create([
            'name' => $request->name,
            'contacted_at' => date('Y-m-d H:i:s'),
            'mail' => $request->mail,
            'body' => $request->body,
        ]);

        return redirect()->route('front.contact.index')
            ->with(['message' => 'お問い合わせが完了しました。', 'status'=> 'info']);
    }
}
