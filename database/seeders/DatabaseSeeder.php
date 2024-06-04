<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        User::factory()->create(
            [
                'name' => 'Muhamad Ridwan 2',
                'email' => 'admin2@gmail.com',
                'role' => 'Admin',
                'password' => bcrypt('password'),
            ],
        );
        // Buat dokter
        User::factory()->create([
            'name' => 'Doctor 1',
            'email' => 'doctor1@gmail.com',
            'role' => 'Doctor',
            'password' => bcrypt('password'),
        ]);

        // Buat perawat
        User::factory()->create([
            'name' => 'Perawat 1',
            'email' => 'nurse1@gmail.com',
            'role' => 'Perawat',
            'password' => bcrypt('password'),
        ]);

        // Buat petugas administrasi
        User::factory()->create([
            'name' => 'Petugas Administrasi 1',
            'email' => 'adminstaff1@gmail.com',
            'role' => 'Petugas Administrasi',
            'password' => bcrypt('password'),
        ]);

        // Buat farmasis
        User::factory()->create([
            'name' => 'Farmasis 1',
            'email' => 'pharmacist1@gmail.com',
            'role' => 'Farmasis',
            'password' => bcrypt('password'),
        ]);

        // Buat teknisi laboratorium
        User::factory()->create([
            'name' => 'Teknisi Laboratorium 1',
            'email' => 'labtech1@gmail.com',
            'role' => 'Teknisi Laboratorium',
            'password' => bcrypt('password'),
        ]);

        // Buat manajemen
        User::factory()->create([
            'name' => 'Manajemen 1',
            'email' => 'management1@gmail.com',
            'role' => 'Manajemen',
            'password' => bcrypt('password'),
        ]);
        
        // $this->call(DoctorSeeder::class);
        
    }
}
