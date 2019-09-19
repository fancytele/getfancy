<?php

use Illuminate\Database\Seeder;
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
        $admin = Role::create(['name' => 'admin']);
        $agent = Role::create(['name' => 'agent']);

        Role::create(['name' => 'user']);

        $admin_permissions = [
            'create admin', 'update admin', 'view admin', 'remove admin',
            'create agent', 'update agent', 'view agent', 'remove agent'
        ];

        foreach ($admin_permissions as $item) {
            $permission = Permission::create(['name' => $item]);
            $permission->assignRole($admin);
        }

        $shared_permissions = [
            'create user', 'update user', 'view user', 'remove user',
            'change subscription', 'cancel subscription'
        ];

        foreach ($shared_permissions as $item) {
            $permission = Permission::create(['name' => $item]);
            $permission->syncRoles([$admin, $agent]);
        }
    }
}
