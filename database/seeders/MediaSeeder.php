<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('medias')->insert([
            'product_id' => 2346,
            'author' => 'JAMIE',
            'created_at' => now()
        ]);
    }
}
