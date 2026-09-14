<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        DB::transaction(function (): void {
            $permissionNames = array_values(array_unique(array_filter(getAdminRoutes())));

            foreach ($permissionNames as $permissionName) {
                Permission::firstOrCreate([
                    'name' => $permissionName,
                    'guard_name' => 'web',
                ]);
            }

            $role = Role::firstOrCreate([
                'name' => 'administrator',
                'guard_name' => 'web',
            ]);

            $role->syncPermissions(
                Permission::query()->where('guard_name', 'web')->get()
            );

            $admin = User::withTrashed()->firstOrNew([
                'email' => 'admin@athar.com',
            ]);

            $admin->fill([
                'name' => 'Athar Super Admin',
                'mobile' => '0500002026',
                'password' => Hash::make('Athar@2026#Admin'),
                'status' => true,
            ]);
            $admin->email_verified_at = now();
            $admin->deleted_at = null;
            $admin->save();

            $admin->syncRoles([$role]);
        });

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
