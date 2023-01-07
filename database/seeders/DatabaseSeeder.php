<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Http\Helper\RandomStringGenerator;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         \App\Models\User::factory()->create([
             'name' => 'Admin user',
             'email' => 'adminuser@adminuser.com',
             'roles' => ['user', 'admin'],
             'password' => bcrypt('Qwerty123$'),
             'invitation_link' => RandomStringGenerator::generate(30),
         ]);
         \App\Models\User::factory()->create([
             'name' => 'Admin',
             'email' => 'admin@admin.com',
             'roles' => ['admin'],
             'password' => bcrypt('Qwerty123$'),
             'invitation_link' => RandomStringGenerator::generate(30),
         ]);
    }
}
