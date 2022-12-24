<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'Georgia'],
            ['name' => 'Germany'],
            ['name' => 'USA'],
            ['name' => 'China'],
        ];

        foreach ($data as $datum)
        {
            Country::firstOrCreate($datum);
        }
    }
}
