<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Medicine;
use Illuminate\Support\Str;

class MedicineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 50; $i++) {
            $code = "O" . Str::random(5);

            Medicine::create([
                'code' => $code,
                'name' => $faker->unique()->word,
                'price' => $faker->randomElement([5000, 10000, 15000, 20000, 25000, 30000, 35000, 40000, 45000, 50000]),
                'jenis' => $faker->randomElement(['Tablet', 'Kapsul', 'Sirup', 'Salep']),
            ]);
        }
    }
}
