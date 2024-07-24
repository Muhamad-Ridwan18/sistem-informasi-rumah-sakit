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
        
        Medicine::create(
            [
                'code' => '' . Str::random(10),
                'name' => 'Amoxicillin',
                'price' => '10000',
                'jenis' => 'Tablet',
            ],
        );
        Medicine::create(
            [
                'code' => '' . Str::random(10),
                'name' => 'Cefalexin',
                'price' => '20000',
                'jenis' => 'Tablet',
            ],
        );
        Medicine::create(
            [
                'code' => '' . Str::random(10),
                'name' => 'Cefepime',
                'price' => '30000',
                'jenis' => 'Tablet',
            ],
        );
        Medicine::create(
            [
                'code' => '' . Str::random(10),
                'name' => 'Panadole',
                'price' => '40000',
                'jenis' => 'Tablet',
            ]
        );
        Medicine::create(
            [
                'code' => '' . Str::random(10),
                'name' => 'Boniva',
                'price' => '40000',
                'jenis' => 'Tablet',
            ]
        );
        Medicine::create(
            [
                'code' => '' . Str::random(10),
                'name' => 'Tamiflu',
                'price' => '40000',
                'jenis' => 'Tablet',
            ]
        );
        Medicine::create(
            [
                'code' => '' . Str::random(10),
                'name' => 'Insulina',
                'price' => '40000',
                'jenis' => 'Tablet',
            ]
        );

    }
}

