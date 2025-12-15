<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create super admin user
        $superAdmin = \App\Models\User::create([
            'name' => 'Super Admin',
            'email' => 'admin@magiccms.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);

        $superAdmin->roles()->attach(\App\Models\Role::where('slug', 'super-admin')->first());

        // Create demo editor
        $editor = \App\Models\User::create([
            'name' => 'Editor User',
            'email' => 'editor@magiccms.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);

        $editor->roles()->attach(\App\Models\Role::where('slug', 'editor')->first());

        // Create demo author
        $author = \App\Models\User::create([
            'name' => 'Author User',
            'email' => 'author@magiccms.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);

        $author->roles()->attach(\App\Models\Role::where('slug', 'author')->first());
    }
}
