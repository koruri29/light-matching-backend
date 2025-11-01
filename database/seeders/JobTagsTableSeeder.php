<?php

namespace Database\Seeders;

use App\Models\JobTag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobTagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            ['name' => 'pin', 'kana_name' => 'ピン作業あり', 'sort_order' => 1],
            ['name' => 'truss', 'kana_name' => 'トラス作業あり', 'sort_order' => 2],
            ['name' => 'pre_stay', 'kana_name' => '前泊の可能性あり', 'sort_order' => 3],
            ['name' => 'post_stay', 'kana_name' => '後泊の可能性あり', 'sort_order' => 4],
        ];

        foreach ($tags as $tag) {
            JobTag::create($tag);
        }
    }
}
