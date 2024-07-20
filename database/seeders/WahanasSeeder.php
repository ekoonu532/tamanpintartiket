<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Wahana;

class WahanasSeeder extends Seeder
{
    public function run()
    {

        $wahanaData = [
            // Wahana Anak Dewasa
            [
                'nama' => 'Oval Kotak',
                'deskripsi' => '',
                'harga_anak' => 14000,
                'harga_dewasa' => 24000,
                'kuota' => 100,
            ],
            [
                'nama' => 'Dino Adventure',
                'deskripsi' => 'Wahana petualangan dengan tema dinosaurus.',
                'harga_anak' => 20000,
                'harga_dewasa' => 25000,
                'kuota' => 80,
            ],
            [
                'nama' => 'Teater 4D',
                'deskripsi' => 'Wahana teater dengan efek 4D yang memukau.',
                'harga_anak' => 15000,
                'harga_dewasa' => 20000,
                'kuota' => 120,
            ],
            [
                'nama' => 'Hand on Science',
                'deskripsi' => 'Wahana belajar sains yang interaktif.',
                'harga_anak' => 12000,
                'harga_dewasa' => 12000,
                'kuota' => 90,
            ],
            [
                'nama' => 'Presenter TV',
                'deskripsi' => 'Wahana menjadi presenter TV dalam simulasi.',
                'harga_anak' => 15000,
                'harga_dewasa' => 15000,
                'kuota' => 70,
            ],
        [
            'nama' => 'Planetarium',
            'deskripsi' => '',
            'harga_anak' => 25000,
            'harga_dewasa' => 25000,
            'kuota' => 150,
        ],
        [
            'nama' => 'Paud',
            'deskripsi' => 'Usia praTK 3-6 tahun',
            'harga_anak' => 5000,
            'harga_dewasa' => 5000,
            'kuota' => 50,
        ],
        [
            'nama' => 'Wahana Bahari',
            'deskripsi' => '',
            'harga_anak' => 8000,
            'harga_dewasa' => 8000,
            'kuota' => 60,
        ],
        [
            'nama' => 'Lalu Lintas',
            'deskripsi' => 'Usia praTK 3-6 tahun',
            'harga_anak' => 15000,
            'harga_dewasa' => 15000,
            'kuota' => 80,
        ]

        ];

        foreach ($wahanaData as $data) {
            Wahana::create($data);
        }

        // Tambahkan data lainnya sesuai kebutuhan
    }
    /**
     * Run the database seeds.
     */

}
