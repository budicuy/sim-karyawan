<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Penumpang;
use App\Models\User;

class PenumpangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua user yang ada
        $users = User::all();

        if ($users->isEmpty()) {
            $this->command->error('Tidak ada user ditemukan. Jalankan UserSeeder terlebih dahulu.');
            return;
        }

        $jenisKendaraan = ['Bus', 'Minibus', 'Mobil', 'Motor', 'Truk'];
        $tujuanDestinasi = [
            'Jakarta',
            'Surabaya',
            'Bandung',
            'Medan',
            'Semarang',
            'Makassar',
            'Palembang',
            'Tangerang',
            'Depok',
            'Bogor',
            'Bekasi',
            'Batam',
            'Pekanbaru',
            'Bandar Lampung',
            'Malang'
        ];

        $penumpangData = [];

        for ($i = 1; $i <= 50; $i++) {
            $user = $users->random();
            $jenisKelamin = fake()->randomElement(['L', 'P']);
            $tanggal = fake()->dateTimeBetween('now', '+30 days');
            $kendaraan = fake()->randomElement($jenisKendaraan);

            $penumpangData[] = [
                'user_id' => $user->id,
                'usia' => fake()->numberBetween(16, 65),
                'jenis_kelamin' => $jenisKelamin,
                'tujuan' => fake()->randomElement($tujuanDestinasi),
                'tanggal' => $tanggal,
                'nopol' => $this->generateNopol(),
                'jenis_kendaraan' => $kendaraan,
                'status' => fake()->boolean(70), // 70% chance true
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Penumpang::insert($penumpangData);

        $this->command->info('Berhasil membuat 50 data penumpang');
    }

    /**
     * Generate nomor polisi acak
     */
    private function generateNopol(): string
    {
        $huruf = ['B', 'D', 'F', 'N', 'L', 'M', 'W', 'T', 'K', 'G'];
        $angka = fake()->numberBetween(1000, 9999);
        $hurufTambahan = fake()->randomElement(['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z']);

        return fake()->randomElement($huruf) . ' ' . $angka . ' ' . $hurufTambahan . fake()->randomElement(['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z']);
    }
}
