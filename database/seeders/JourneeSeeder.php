<?php

namespace Database\Seeders;

use App\Models\Journee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class
JourneeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $journee  = Journee::factory()->create();
    }
}
