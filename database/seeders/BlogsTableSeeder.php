<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlogsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $cate_arr = [10,20,30,40,50,999];

        for ($ix = 1; $ix <= 500; $ix++) {
            $dispix = sprintf('%03d', $ix);
            \DB::table('blogs')->insert([
                [
                    'title' => 'ブログ記事テスト' . $dispix,
                    'day' => date('Y-m-d H:i:s', strtotime('2021/01/01 +' . $ix . ' day')),
                    'is_enabled' => 1,
                    'category' => $cate_arr[ array_rand($cate_arr) ],
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]
            ]);
        }
    }
}
