<?php

namespace Database\Seeders;

use App\Models\Tiket;
use App\Models\KategoriTiket;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;


class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        $id = Str::uuid();

        Tiket::create([
            'tiket_id' => Str::uuid(),
            'nama' => 'OVAL KOTAK',
            'slug' => Str::slug('OVAL-KOTAK'),
            'deskripsi' => 'Tiket untuk wahana OVAL KOTAK',
            'kategori_tiket_id' => 2,
            'jenis' => 'wahana',
            'harga_anak' => 14000,
            'harga_dewasa' => 24000,
            'kuota' => 100,
        ]);

        Tiket::create([
            'tiket_id' => Str::uuid(),
            'nama' => 'DINO ADVENTURE',
            'slug' => Str::slug('DINO-ADVENTURE'),
            'deskripsi' => 'Tiket untuk wahana DINO ADVENTURE',
            'kategori_tiket_id' => 2,
            'jenis' => 'wahana',
            'harga_anak' => 20000,
            'harga_dewasa' => 25000,
            'kuota' => 80,
        ]);

        // Tiket untuk kategori Wahana
        Tiket::create([
            'tiket_id' => Str::uuid(),
            'nama' => 'TEATER 4D',
            'slug' => Str::slug('TEATER-4D'),
            'deskripsi' => 'Tiket untuk wahana TEATER 4D',
            'kategori_tiket_id' => 2,
            'jenis' => 'wahana',
            'harga_anak' => 15000,
            'harga_dewasa' => 20000,
            'kuota' => 50,
        ]);

        Tiket::create([
            'tiket_id' => Str::uuid(),
            'nama' => 'HAND ON SCIENCE',
            'slug' => Str::slug('HAND-ON-SCIENCE'),
            'deskripsi' => 'Tiket untuk wahana HAND ON SCIENCE',
            'kategori_tiket_id' => 2,
            'jenis' => 'wahana',
            'harga_anak' => 12000,
            'harga_dewasa' => 12000,
            'kuota' => 40,
        ]);

        Tiket::create([
            'tiket_id' => Str::uuid(),
            'nama' => 'PRESENTER TV',
            'slug' => Str::slug('PRESENTER-TV'),
            'deskripsi' => 'Tiket untuk wahana PRESENTER TV',
            'kategori_tiket_id' => 2,
            'jenis' => 'wahana',
            'harga_anak' => 15000,
            'harga_dewasa' => 15000,
            'kuota' => 30,
        ]);



        // Tiket untuk kategori Acara
        Tiket::create([
            'tiket_id' => Str::uuid(),
            'nama' => 'PLANETARIUM',
            'slug' => Str::slug('PLANETARIUM'),
            'deskripsi' => 'Tiket untuk acara Planetarium',
            'kategori_tiket_id' => 2,
            'jenis' => 'wahana',
            'harga_anak' => 25000,
            'harga_dewasa' => 25000,
            'kuota' => 100,
        ]);

        Tiket::create([
            'tiket_id' => Str::uuid(),
            'nama' => 'PAUD',
            'slug' => Str::slug('PAUD'),
            'deskripsi' => 'Tiket untuk acara PAUD',
            'kategori_tiket_id' => 2,
            'jenis' => 'Wahana',
            'harga_anak' => 5000,
            'harga_dewasa' => null, // Tidak ada harga dewasa untuk tiket PAUD
            'kuota' => 50,
        ]);

        Tiket::create([
            'tiket_id' => Str::uuid(),
            'nama' => 'WAHANA BAHARI',
            'slug' => Str::slug('WAHANA-BAHARI'),
            'deskripsi' => 'Tiket untuk wahana WAHANA BAHARI',
            'kategori_tiket_id' => 3,
            'jenis' => 'wahana',
            'harga_anak' => 8000,
            'harga_dewasa' => 8000,
            'kuota' => 60,
        ]);

        Tiket::create([
            'tiket_id' => Str::uuid(),
            'nama' => 'LALU LINTAS',
            'slug' => Str::slug('LALU-LINTAS'),
            'deskripsi' => 'Tiket untuk wahana LALU LINTAS',
            'kategori_tiket_id' => 2,
            'jenis' => 'wahana',
            'harga_anak' => 15000,
            'harga_dewasa' => null, // Tidak ada harga dewasa untuk tiket LALU LINTAS
            'kuota' => 35,
        ]);


        // Tiket untuk kategori Program Kreativitas
        Tiket::create([
            'tiket_id' => Str::uuid(),
            'nama' => 'KREASI BATIK',
            'slug' => Str::slug('KREASI-BATIK'),
            'deskripsi' => 'Tiket untuk program kreativitas KREASI BATIK',
            'kategori_tiket_id' => 3,
            'jenis' => 'program_kreativitas',
            'harga_anak' => 20000,
            'harga_dewasa' => null, // Tidak ada harga dewasa untuk tiket program kreativitas
            'kuota' => 40,
        ]);


        Tiket::create([
            'tiket_id' => Str::uuid(),
            'nama' => 'KREASI GERABAH',
            'slug' => Str::slug('KREASI-GERABAH'),
            'deskripsi' => 'Tiket untuk program kreativitas KREASI GERABAH',
            'kategori_tiket_id' => 3,
            'jenis' => 'program_kreativitas',
            'harga_anak' => 15000,
            'harga_dewasa' => null, // Tidak ada harga dewasa untuk tiket program kreativitas
            'kuota' => 30,
        ]);

        Tiket::create([
            'tiket_id' => Str::uuid(),
            'nama' => 'LUKIS KAOS',
            'slug' => Str::slug('LUKIS-KAOS'),
            'deskripsi' => 'Tiket untuk program kreativitas LUKIS KAOS',
            'kategori_tiket_id' => 3,
            'jenis' => 'program_kreativitas',
            'harga_anak' => 48000,
            'harga_dewasa' => null, // Tidak ada harga dewasa untuk tiket program kreativitas
            'kuota' => 20,
        ]);

        Tiket::create([
            'tiket_id' => Str::uuid(),
            'nama' => 'LUKIS GERABAH',
            'slug' => Str::slug('LUKIS-GERABAH'),
            'deskripsi' => 'Tiket untuk program kreativitas LUKIS GERABAH',
            'kategori_tiket_id' => 3,
            'jenis' => 'program_kreativitas',
            'harga_anak' => 17000,
            'harga_dewasa' => null, // Tidak ada harga dewasa untuk tiket program kreativitas
            'kuota' => 25,
        ]);




        // Lanjutkan untuk program kreativitas lainnya...
    }
}
