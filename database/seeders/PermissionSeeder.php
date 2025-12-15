<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            ['name' => 'View Posts', 'slug' => 'view-posts', 'description' => 'Can view posts'],
            ['name' => 'Create Posts', 'slug' => 'create-posts', 'description' => 'Can create new posts'],
            ['name' => 'Edit Posts', 'slug' => 'edit-posts', 'description' => 'Can edit posts'],
            ['name' => 'Delete Posts', 'slug' => 'delete-posts', 'description' => 'Can delete posts'],

            ['name' => 'View Pages', 'slug' => 'view-pages', 'description' => 'Can view pages'],
            ['name' => 'Create Pages', 'slug' => 'create-pages', 'description' => 'Can create new pages'],
            ['name' => 'Edit Pages', 'slug' => 'edit-pages', 'description' => 'Can edit pages'],
            ['name' => 'Delete Pages', 'slug' => 'delete-pages', 'description' => 'Can delete pages'],

            ['name' => 'View Media', 'slug' => 'view-media', 'description' => 'Can view media library'],
            ['name' => 'Upload Media', 'slug' => 'upload-media', 'description' => 'Can upload files'],
            ['name' => 'Delete Media', 'slug' => 'delete-media', 'description' => 'Can delete media'],

            ['name' => 'Manage Users', 'slug' => 'manage-users', 'description' => 'Can manage users'],
            ['name' => 'Manage Roles', 'slug' => 'manage-roles', 'description' => 'Can manage roles'],
            ['name' => 'Manage Settings', 'slug' => 'manage-settings', 'description' => 'Can manage site settings'],
        ];

        foreach ($permissions as $permission) {
            \App\Models\Permission::create($permission);
        }

        // Assign permissions to roles
        $superAdmin = \App\Models\Role::where('slug', 'super-admin')->first();
        $admin = \App\Models\Role::where('slug', 'admin')->first();
        $editor = \App\Models\Role::where('slug', 'editor')->first();
        $author = \App\Models\Role::where('slug', 'author')->first();

        // Super Admin gets all permissions
        $superAdmin->permissions()->attach(\App\Models\Permission::all());

        // Admin gets most permissions except role management
        $admin->permissions()->attach(\App\Models\Permission::whereNotIn('slug', ['manage-roles'])->get());

        // Editor can manage content
        $editor->permissions()->attach(\App\Models\Permission::whereIn('slug', [
            'view-posts', 'create-posts', 'edit-posts', 'delete-posts',
            'view-pages', 'create-pages', 'edit-pages', 'delete-pages',
            'view-media', 'upload-media', 'delete-media'
        ])->get());

        // Author can only create and edit own content
        $author->permissions()->attach(\App\Models\Permission::whereIn('slug', [
            'view-posts', 'create-posts', 'edit-posts',
            'view-pages', 'create-pages', 'edit-pages',
            'view-media', 'upload-media'
        ])->get());
    }
}
