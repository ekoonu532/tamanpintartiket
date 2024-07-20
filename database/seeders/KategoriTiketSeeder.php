<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriTiket;

class KategoriTiketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Create 'Event' record
        KategoriTiket::create([
            'kategori_tiket_id' => 1, // Unique ID for 'Event'
            'nama' => 'Event',
            'deskripsi' => 'Tiket untuk acara tertentu.'
        ]);

        // Create 'Wahana' record
        KategoriTiket::create([
            'kategori_tiket_id' => 2, // Unique ID for 'Wahana'
            'nama' => 'Wahana',
            'deskripsi' => 'Tiket untuk berbagai wahana di taman hiburan.'
        ]);

        // Create 'Program Kreativitas' record
        KategoriTiket::create([
            'kategori_tiket_id' => 3, // Unique ID for 'Program Kreativitas'
            'nama' => 'Program Kreativitas',
            'deskripsi' => 'Tiket untuk berbagai program kreativitas.'
        ]);
    }
}
