<?php

namespace App\Services;

class BlogService
{

    /*
        * ブログ本文等から 最初に出てくる画像URLを抽出
    */
    public function pickupImageURL($body)
    {
        $pattern = '/<img.*?src\s*=\s*[\"|\'](.*?)[\"|\'].*?>/i';
        if (preg_match($pattern, $body, $match) == FALSE) {
            //画像URLなし
            return '';
        }

        return $match[1];
    }
}
