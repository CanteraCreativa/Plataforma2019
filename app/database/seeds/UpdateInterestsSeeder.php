<?php

use App\Models\Interest;
use Illuminate\Database\Seeder;

class UpdateInterestsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $interest = Interest::where('name', 'Nightlife')->first();
        $interest->name = 'Salidas nocturnas';
        $interest->save();

        $interest = Interest::where('name', 'Salud / Fitness')->first();
        $interest->name = 'Salud';
        $interest->save();

        $interest = Interest::where('name', 'Tecnología')->first();
        $interest->name = 'Tecnología / Apps';
        $interest->save();

        Interest::where('name', 'Apps')->delete();
    }
}
