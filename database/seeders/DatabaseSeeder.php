<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'base']);
        Permission::create(['name' => 'crud role']);
        Permission::create(['name' => 'crud permission']);

        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'delete users']);
        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'show users']);
        Permission::create(['name' => 'setting']);

        // create roles and assign existing permissions
        $role1 = Role::create(['name' => 'Super Admin']);
        $role1->syncPermissions(Permission::all());
        // $role1->givePermissionTo('base');
        // $role1->givePermissionTo('crud role');
        // $role1->givePermissionTo('crud permission');

        $user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'superadmin@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make("12345678"),
            'remember_token' => Str::random(10),
        ]);
        $user->assignRole($role1);

        User::factory(30)->create();
    }
}
