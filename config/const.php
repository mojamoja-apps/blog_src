<?php
// 手動作成 基本定数ファイル
// \public\js\admin\common.js にも設定あり
return [
    'editmode' => [
        'create' => 'create',
        'edit' => 'edit',
        'destroy' => 'destroy',
    ],


    // 作業証明書 1回での取得件数マックス
    'max_get' => 1000,

    // ブログカテゴリ
    'BLOG_CATEGORY' => [
        10 => '未分類',
        20 => 'お知らせ',
        30 => 'オススメのお店',
        40 => 'マンガ',
        50 => '子育て',
        999 => 'その他',
    ],

    // adminlte cardが閉じてる・開いてるのクラス・スタイル
/*
閉じてる
collapsed-card
fa-plus
display: none;


開いてる
なし
fa-minus
display: block;
*/
    'COLLAPSE' => [
        'CLOSE' => [
            'CARD_CLASS' => 'collapsed-card',
            'BTN_CLASS'  => 'fa-plus',
            'BODY_STYLE' => 'display: none;',
        ],
        'OPEN' => [
            'CARD_CLASS' => '',
            'BTN_CLASS'  => 'fa-minus',
            'BODY_STYLE' => '',
        ],
    ],
];
