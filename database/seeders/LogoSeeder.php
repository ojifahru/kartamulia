<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LogoSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('logos')->updateOrInsert(
            ['id' => 1],
            [
                'logo' => 'images/logo.png',
                'favicon' => 'images/favicon.png',
                'footer_logo' => 'images/logo.png',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}