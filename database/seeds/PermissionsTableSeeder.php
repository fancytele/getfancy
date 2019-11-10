<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->delete();
        DB::statement('ALTER TABLE roles AUTO_INCREMENT = 1');

        DB::table('permissions')->delete();
        DB::statement('ALTER TABLE permissions AUTO_INCREMENT = 1');

        DB::table('role_has_permissions')->delete();
        DB::table('model_has_permissions')->delete();
        DB::table('model_has_roles')->delete();

        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $admin = Role::create(['name' => 'admin']);
        $agent = Role::create(['name' => 'agent']);
        Role::create(['name' => 'user']);
        $supervisor = Role::create(['name' => 'supervisor']);
        $operator = Role::create(['name' => 'operator']);

        $permissions = [
            'create admin', 'update admin', 'view admin', 'remove admin',
            'create supervisor', 'update supervisor', 'view supervisor', 'remove supervisor',
            'create agent', 'update agent', 'view agent', 'remove agent',
            'create operator', 'update operator', 'view operator', 'remove operator',
            'create user', 'update user', 'view user', 'remove user',
            'change subscription', 'cancel subscription', 'change fancy setting',
            'create ticket', 'view ticket', 'update ticket', 'remove ticket'
        ];
        
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Admin
        $admin->givePermissionTo($permissions);

        // Agent
        $agent_permissions = [
            'create user', 'update user', 'view user', 'remove user',
            'change subscription', 'cancel subscription', 'change fancy setting',
            'create ticket', 'update ticket'
        ];

        $agent->givePermissionTo($agent_permissions);

        // Supervisor
        $supervisor->givePermissionTo(['create agent', 'update agent', 'view agent', 'remove agent']);

        // Operator
        $operator->givePermissionTo(['view ticket', 'update ticket', 'remove ticket']);
    }
}
