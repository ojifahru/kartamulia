<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IdentitySeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('identities')->insert([
            'name' => json_encode([
                'id' => 'Karta Mulia University',
                'en' => 'Karta Mulia University',
            ]),
            'email' => 'info@kartamulia.ac.id',
            'domain' => 'https://kartamulia.ac.id',
            'address' => 'Jl. Pendidikan No. 1, Jakarta, Indonesia',
            'phone' => '+62 21 1234 5678',
            'meta_description' => 'Website resmi Karta Mulia University.',
            'meta_keywords' => 'kampus, universitas, pendidikan, karta mulia',
            'maps' => 'https://maps.google.com/?q=Karta+Mulia+University',
            'facebook' => 'https://facebook.com/kartamulia',
            'twitter' => 'https://twitter.com/kartamulia',
            'instagram' => 'https://instagram.com/kartamulia',
            'linkedin' => 'https://linkedin.com/company/kartamulia',
            'whatsapp' => '6281234567890',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
