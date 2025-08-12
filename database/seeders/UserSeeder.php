<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'jafar',
            'email' => 'pars@yahoo.com',
            'password' => Hash::make( 'p123456p' ),
        ]);

        User::factory()->create([
            'name' => 'jafar2',
            'email' => 'pars2@yahoo.com',
            'password' => Hash::make( 'p123456p' ),
        ]);

        User::factory()->create([
            'name' => 'jafar3',
            'email' => 'pars3@yahoo.com',
            'password' => Hash::make( 'p123456p' ),
        ]);

    }
}
