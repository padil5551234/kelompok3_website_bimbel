<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::firstOrCreate(['name' => 'view ujian']);
        Permission::firstOrCreate(['name' => 'create ujian']);
        Permission::firstOrCreate(['name' => 'update ujian']);
        Permission::firstOrCreate(['name' => 'delete ujian']);
        Permission::firstOrCreate(['name' => 'manage users']);
        Permission::firstOrCreate(['name' => 'manage roles']);
        Permission::firstOrCreate(['name' => 'manage permissions']);
        Permission::firstOrCreate(['name' => 'view dashboard']);
        
        // Tutor permissions
        Permission::firstOrCreate(['name' => 'create live class']);
        Permission::firstOrCreate(['name' => 'update live class']);
        Permission::firstOrCreate(['name' => 'delete live class']);
        Permission::firstOrCreate(['name' => 'manage materials']);
        Permission::firstOrCreate(['name' => 'create material']);
        Permission::firstOrCreate(['name' => 'update material']);
        Permission::firstOrCreate(['name' => 'delete material']);
        Permission::firstOrCreate(['name' => 'embed youtube videos']);
        Permission::firstOrCreate(['name' => 'view tutor dashboard']);

        // create roles and assign created permissions
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->syncPermissions(Permission::all()); // Give admin all permissions

        $bendaharaRole = Role::firstOrCreate(['name' => 'bendahara']);
        $bendaharaRole->syncPermissions(['view ujian', 'view dashboard']);

        // Tutor role with specific permissions
        $tutorRole = Role::firstOrCreate(['name' => 'tutor']);
        $tutorRole->syncPermissions([
            'view tutor dashboard',
            'create live class',
            'update live class',
            'delete live class',
            'manage materials',
            'create material',
            'update material',
            'delete material',
            'embed youtube videos'
        ]);

        Role::firstOrCreate(['name' => 'panitia']);
        Role::firstOrCreate(['name' => 'user']);
    }
}
