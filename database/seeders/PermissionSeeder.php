<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'add_user',
            'show_user',
            'edit_user',
            'delete_user',
            'manage_categories',
            'create_category',
            'show_category',
            'edit_category',
            'delete_category',
            'manage_lessons',
            'create_lesson',
            'show_lesson',
            'edit_lesson',
            'delete_lesson',
            'publish_lesson',
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(['name' => $permission],
                ['name' => $permission,
                        'guard_name' => 'admin',
                        ]);
        }
        
    }
    
}