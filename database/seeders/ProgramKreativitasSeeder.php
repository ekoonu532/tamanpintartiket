<?php

use Illuminate\Database\Seeder;
use App\Models\ProgramKreativitas;

class ProgramKreativitasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Seed data for program kreativitas
        $programKreativitasData = [

            [
                'nama' => 'Kreasi Batik',
                'deskripsi' => '',
                'harga' => 20000,
                'kuota' => 40,
            ],
            [
                'nama' => 'Kreasi Gerabah',
                'deskripsi' => '',
                'harga' => 15000,
                'kuota' => 60,
            ],
            [
                'nama' => 'Lukis Kaos',
                'deskripsi' => '',
                'harga' => 48000,
                'kuota' => 30,
            ],
            [
                'nama' => 'Lukis Gerabah',
                'deskripsi' => '',
                'harga' => 17000,
                'kuota' => 50,
            ],
        ];

        // Insert data into the database
        foreach ($programKreativitasData as $data) {
            ProgramKreativitas::create($data);
        }
    }
}
