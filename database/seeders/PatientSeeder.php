<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

        for ($i = 0; $i < 10; $i++) {
            $medicalRecordNumber = 'MR-' . $faker->unique()->numberBetween(10000000, 99999999); 
            DB::table('patients')->insert([
                'medical_record_number' => $medicalRecordNumber,
                'full_name' => $faker->name,
                'nik' => $faker->nik,
                'gender' => $faker->randomElement(['Male', 'Female']),
                'address' => $faker->address,
                'birth_date' => $faker->date($format = 'Y-m-d', $max = '2003-12-18'), 
                'phone' => $faker->phoneNumber,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
