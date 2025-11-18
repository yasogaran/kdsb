<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // Posts
            'view posts',
            'create posts',
            'edit posts',
            'delete posts',

            // Categories
            'view categories',
            'create categories',
            'edit categories',
            'delete categories',

            // Events
            'view events',
            'create events',
            'edit events',
            'delete events',

            // Galleries
            'view galleries',
            'create galleries',
            'edit galleries',
            'delete galleries',

            // Syllabus
            'view syllabus',
            'create syllabus',
            'edit syllabus',
            'delete syllabus',

            // Circulars
            'view circulars',
            'create circulars',
            'edit circulars',
            'delete circulars',

            // Products
            'view products',
            'create products',
            'edit products',
            'delete products',

            // Product Categories
            'view product-categories',
            'create product-categories',
            'edit product-categories',
            'delete product-categories',

            // Settings
            'view settings',
            'edit settings',

            // Milestones
            'view milestones',
            'create milestones',
            'edit milestones',
            'delete milestones',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions

        // Super Admin - Full access
        $superAdmin = Role::create(['name' => 'super-admin']);
        $superAdmin->givePermissionTo(Permission::all());

        // Blogger - Content management only
        $blogger = Role::create(['name' => 'blogger']);
        $blogger->givePermissionTo([
            'view posts', 'create posts', 'edit posts', 'delete posts',
            'view categories', 'create categories', 'edit categories', 'delete categories',
            'view events', 'create events', 'edit events', 'delete events',
            'view galleries', 'create galleries', 'edit galleries', 'delete galleries',
            'view syllabus', 'create syllabus', 'edit syllabus', 'delete syllabus',
            'view circulars', 'create circulars', 'edit circulars', 'delete circulars',
        ]);

        // Shop Manager - Shop only
        $shopManager = Role::create(['name' => 'shop-manager']);
        $shopManager->givePermissionTo([
            'view products', 'create products', 'edit products', 'delete products',
            'view product-categories', 'create product-categories', 'edit product-categories', 'delete product-categories',
        ]);

        // Create a default super admin user
        $user = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@kandyscouts.lk',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        $user->assignRole('super-admin');
    }
}
