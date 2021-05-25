<?php

namespace Database\Seeders;

use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'first_name' => 'Muhammed',
            'last_name' => 'Fayaz',
            'email' => 'admin@gmail.com',
            'phone' => '1234567890',
            'password' => bcrypt('123456')
        ]);

        $role = Role::create(['name' => config('access.users.admin_role')]);

        $permissions = Permission::pluck('id','id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);
    }
}
