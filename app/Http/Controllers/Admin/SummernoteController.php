<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SummernoteController extends Controller
{
    public function upload_image(Request $request)
    {
        $request->validate([
            'image' => ['required', 'image', 'mimes:jpeg,gif,png', 'max:2048'],
            'dir' => ['required'],
        ]);


        // 画像ファイルURL例
        // http://localhost/storage/images/20220811220537_OgcG9/Y5Ahf.jpg
        // images/日時_ランダム/ランダム
        $dir = 'images/' . $request->input('dir') . '/';
        $file = $request->file('image');
        $extension = $file->extension();
        $filename = Str::random(5) . '.' . $extension;
        $request->file('image')->storeAs($dir, $filename, 'public');

        return [
            'result' => true,
            'image_filename' => $filename,
            'image_url' => url('/storage/' . $dir . $filename)
        ];
    }
}
