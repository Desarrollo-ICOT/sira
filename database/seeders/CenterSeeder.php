<?php

namespace Database\Seeders;

use App\Models\Center;
use Illuminate\Database\Seeder;

class CenterSeeder extends Seeder
{
    public function run()
    {
        // Define the number of centers you want to create

        // Create the specified number of centers
        Center::factory()->count(3)->create();
    }
}