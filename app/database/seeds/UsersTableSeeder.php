<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\User;
use App\Events\RolesUpdated;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'name'      => 'admin',
            'email'     => 'admin@canteracreativa.com',
            'password'  => Hash::make('admin')
        ]);

        $admin->assignRole('admin');

        $user = User::create([
            'name'      => 'creative',
            'email'     => 'creative@canteracreativa.com',
            'password'  => Hash::make('creative')
        ]);

        $user->assignRole('creative');
        event(new RolesUpdated($user));
    }
}
