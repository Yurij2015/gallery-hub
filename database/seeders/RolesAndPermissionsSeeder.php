<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('role_has_permissions')->truncate();
        DB::table('model_has_roles')->truncate();
        DB::table('model_has_permissions')->truncate();
        DB::table('roles')->truncate();
        DB::table('permissions')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $permissions = [
            'manage_user',
            'manage_bucket',
            'manage_project',
            'view_public_gallery',
            'interact_with_images',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo(Permission::all());

        $owner = Role::create(['name' => 'owner']);
        $owner->givePermissionTo(Permission::all());

        $guest = Role::create(['name' => 'guest']);
        $guest->givePermissionTo(['view_public_gallery']);

        $client = Role::create(['name' => 'client']);
        $client->givePermissionTo(['view_public_gallery', 'interact_with_images']);

        $photographer = Role::create(['name' => 'photographer']);
        $photographer->givePermissionTo(
            Permission::all()->filter(function ($permission) {
                return !in_array($permission->name, ['manage_user', 'manage_bucket']);
            })
        );

    }
}
