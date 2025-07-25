<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Penumpang>
 */
class PenumpangFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $jenisKendaraan = ['avanza', 'Toyota', 'Honda', 'Suzuki', 'Daihatsu', 'Mitsubishi', 'Nissan', 'Isuzu', 'Kawasaki', 'Yamaha'];
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

        return [
            'nama_penumpang' => fake()->name(),
            'usia' => fake()->numberBetween(16, 65),
            'jenis_kelamin' => fake()->randomElement(['L', 'P']),
            'tujuan' => fake()->randomElement($tujuanDestinasi),
            'tanggal' => fake()->dateTimeBetween('now', '+30 days'),
            'nopol' => $this->generateNopol(),
            'jenis_kendaraan' => fake()->randomElement($jenisKendaraan),
            'status' => fake()->boolean(70), // 70% chance true
        ];
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
