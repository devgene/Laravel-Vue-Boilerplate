<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Create Roles
       // $admin = Role::create(['name' => config('access.users.admin_role')]);
        $user = Role::create(['name' => config('access.users.default_role')]);


    }
}
