<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin1 = User::create([
            'name'      => 'guillermo',
            'email'     => 'guillermo@canteracreativa.com',
            'password'  => Hash::make('guillermo')
        ]);

        $admin1->assignRole('admin');

        $admin2 = User::create([
            'name'      => 'fernando',
            'email'     => 'fernando@canteracreativa.com',
            'password'  => Hash::make('fernando')
        ]);

        $admin2->assignRole('admin');

        $admin3 = User::create([
            'name'      => 'andres',
            'email'     => 'andres@canteracreativa.com',
            'password'  => Hash::make('andres')
        ]);

        $admin3->assignRole('admin');
    }
}
