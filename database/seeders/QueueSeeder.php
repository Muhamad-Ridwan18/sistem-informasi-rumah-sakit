<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Queue;
use App\Models\Patient;
use App\Models\Clinic;
use Faker\Factory as Faker;

class QueueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Membuat instance Faker
        $faker = Faker::create();

        // Ambil seluruh data pasien dan klinik
        $patients = Patient::all();
        $clinics = Clinic::all();

        // Loop untuk membuat beberapa data antrian dummy
        foreach ($patients as $patient) {
            foreach ($clinics as $clinic) {
                // Generate nomor antrian
                $clinicInitials = $this->getInitials($clinic->name);
                $queueNumber = $this->generateQueueNumber($clinicInitials);
                $queueCode = $clinicInitials . str_pad($queueNumber, 3, '0', STR_PAD_LEFT);
                $startDate = 'now';
                $endDate = '+1 day';
                // Buat antrian baru
                Queue::create([
                    'patient_id' => $patient->id,
                    'clinic_id' => $clinic->id,
                    'queue_code' => $queueCode,
                    'queue_number' => $queueNumber,
                    'status' => $faker->randomElement(['pending']),
                    'created_at' => $faker->dateTimeBetween($startDate, $endDate),
                    'updated_at' => $faker->dateTimeBetween('created_at', '+1 day'), 
                ]);
            }
        }
    }

    // Fungsi untuk mengenerate nomor antrian
    private function generateQueueNumber($clinicInitials)
    {
        $latestQueue = Queue::where('queue_code', 'LIKE', $clinicInitials . '%')->latest()->first();
        $queueNumber = $latestQueue ? ((int)substr($latestQueue->queue_code, strlen($clinicInitials)) + 1) : 1;
        return $queueNumber;
    }

    // Fungsi untuk mendapatkan inisial dari nama klinik
    private function getInitials($name)
    {
        $words = explode(' ', $name);
        $initials = '';

        foreach ($words as $word) {
            $initials .= strtoupper(substr($word, 0, 1));
        }

        return $initials;
    }
}
