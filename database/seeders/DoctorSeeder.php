<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Doctor;

class DoctorSeeder extends Seeder
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
            Doctor::create([
                'full_name' => $faker->name,
                'specialization' => $faker->jobTitle,
                'phone' => $faker->phoneNumber,
                'email' => $faker->unique()->safeEmail,
                'gender' => $faker->randomElement(['male', 'female']),
                'tarif' => $faker->randomElement([50000, 100000, 150000, 200000, 250000, 300000, 350000, 400000, 450000, 500000]),
            ]);
        }
    }
}
