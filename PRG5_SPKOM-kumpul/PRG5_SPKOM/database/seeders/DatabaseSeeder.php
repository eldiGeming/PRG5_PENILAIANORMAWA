<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    // Pada UserFactory.php
    protected $primaryKey = 'nomor_induk';

    // Pada DatabaseSeeder.php
    public function run()
    {
        User::factory()->create([
            'nomor_induk' => '0320220106',
        ]);
    }

}
