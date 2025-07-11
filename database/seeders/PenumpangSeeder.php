<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Penumpang;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

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

        // Pastikan direktori storage ada
        if (!Storage::disk('public')->exists('tiket_photos')) {
            Storage::disk('public')->makeDirectory('tiket_photos');
        }

        $penumpangData = [];

        for ($i = 1; $i <= 50; $i++) {
            $user = $users->random();
            $jenisKelamin = fake()->randomElement(['L', 'P']);
            $tanggal = fake()->dateTimeBetween('now', '+30 days');
            $kendaraan = fake()->randomElement($jenisKendaraan);

            // Generate fake image tiket
            $imagePath = $this->buatImageFakeTiket($i);

            $penumpangData[] = [
                'user_id' => $user->id,
                'usia' => fake()->numberBetween(16, 65),
                'jenis_kelamin' => $jenisKelamin,
                'tujuan' => fake()->randomElement($tujuanDestinasi),
                'tanggal' => $tanggal,
                'nopol' => $this->generateNopol(),
                'jenis_kendaraan' => $kendaraan,
                'nomor_tiket' => $this->generateNomorTiket(),
                'url_image_tiket' => $imagePath,
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

    /**
     * Generate nomor tiket unik
     */
    private function generateNomorTiket(): string
    {
        $prefix = 'TKT';
        $timestamp = date('Ymd');
        $random = fake()->unique()->numberBetween(1000, 9999);

        return $prefix . $timestamp . $random;
    }

    /**
     * Buat image fake tiket dan simpan di storage
     */
    private function buatImageFakeTiket(int $index): string
    {
        // Data untuk fake image
        $nomorTiket = "TKT" . date('Ymd') . str_pad($index, 4, '0', STR_PAD_LEFT);
        $tujuan = fake()->randomElement(['Jakarta', 'Surabaya', 'Bandung', 'Medan']);
        $tanggal = fake()->dateTimeBetween('now', '+30 days')->format('d/m/Y');
        $nopol = $this->generateNopol();

        // Buat SVG fake tiket
        $svgContent = $this->buatSvgTiket($nomorTiket, $tujuan, $tanggal, $nopol);

        // Simpan ke storage
        $namaFile = 'tiket_' . $nomorTiket . '_' . time() . $index . '.svg';
        $pathLengkap = 'tiket_photos/' . $namaFile;

        Storage::disk('public')->put($pathLengkap, $svgContent);

        return $pathLengkap;
    }

    /**
     * Buat SVG tiket fake
     */
    private function buatSvgTiket(string $nomorTiket, string $tujuan, string $tanggal, string $nopol): string
    {
        $jenisKendaraan = fake()->randomElement(['Bus', 'Minibus', 'Mobil', 'Motor', 'Truk']);

        return <<<SVG
<svg width="400" height="600" xmlns="http://www.w3.org/2000/svg">
  <!-- Background -->
  <rect width="400" height="600" fill="white" stroke="#ddd" stroke-width="2"/>

  <!-- Header -->
  <rect x="0" y="0" width="400" height="80" fill="#0064c8"/>
  <text x="200" y="50" font-family="Arial, sans-serif" font-size="20" font-weight="bold" text-anchor="middle" fill="white">TIKET PERJALANAN</text>

  <!-- Konten Tiket -->
  <text x="20" y="120" font-family="Arial, sans-serif" font-size="16" font-weight="bold" fill="#333">No. Tiket: {$nomorTiket}</text>
  <text x="20" y="160" font-family="Arial, sans-serif" font-size="14" fill="#666">Tujuan: {$tujuan}</text>
  <text x="20" y="190" font-family="Arial, sans-serif" font-size="14" fill="#666">Tanggal: {$tanggal}</text>
  <text x="20" y="220" font-family="Arial, sans-serif" font-size="14" fill="#666">Nopol: {$nopol}</text>
  <text x="20" y="250" font-family="Arial, sans-serif" font-size="14" fill="#666">Jenis: {$jenisKendaraan}</text>

  <!-- Garis pemisah -->
  <line x1="20" y1="280" x2="380" y2="280" stroke="#ccc" stroke-width="1"/>

  <!-- Barcode simulasi -->
  <g transform="translate(50, 320)">
    <rect x="0" y="0" width="4" height="40" fill="#000"/>
    <rect x="8" y="0" width="2" height="40" fill="#000"/>
    <rect x="14" y="0" width="6" height="40" fill="#000"/>
    <rect x="24" y="0" width="3" height="40" fill="#000"/>
    <rect x="30" y="0" width="2" height="40" fill="#000"/>
    <rect x="36" y="0" width="5" height="40" fill="#000"/>
    <rect x="44" y="0" width="2" height="40" fill="#000"/>
    <rect x="50" y="0" width="4" height="40" fill="#000"/>
    <rect x="58" y="0" width="3" height="40" fill="#000"/>
    <rect x="64" y="0" width="2" height="40" fill="#000"/>
    <rect x="70" y="0" width="6" height="40" fill="#000"/>
    <rect x="80" y="0" width="2" height="40" fill="#000"/>
    <rect x="86" y="0" width="4" height="40" fill="#000"/>
    <rect x="94" y="0" width="3" height="40" fill="#000"/>
    <rect x="100" y="0" width="2" height="40" fill="#000"/>
  </g>

  <!-- QR Code simulasi -->
  <g transform="translate(250, 300)">
    <rect x="0" y="0" width="100" height="100" fill="white" stroke="#000" stroke-width="2"/>
    <rect x="10" y="10" width="15" height="15" fill="#000"/>
    <rect x="30" y="10" width="10" height="15" fill="#000"/>
    <rect x="50" y="10" width="20" height="15" fill="#000"/>
    <rect x="75" y="10" width="15" height="15" fill="#000"/>
    <rect x="10" y="30" width="10" height="20" fill="#000"/>
    <rect x="25" y="30" width="15" height="20" fill="#000"/>
    <rect x="45" y="30" width="10" height="20" fill="#000"/>
    <rect x="60" y="30" width="20" height="20" fill="#000"/>
    <rect x="85" y="30" width="5" height="20" fill="#000"/>
    <rect x="10" y="55" width="20" height="10" fill="#000"/>
    <rect x="35" y="55" width="15" height="10" fill="#000"/>
    <rect x="55" y="55" width="10" height="10" fill="#000"/>
    <rect x="70" y="55" width="20" height="10" fill="#000"/>
    <rect x="10" y="70" width="15" height="20" fill="#000"/>
    <rect x="30" y="70" width="10" height="20" fill="#000"/>
    <rect x="45" y="70" width="25" height="20" fill="#000"/>
    <rect x="75" y="70" width="15" height="20" fill="#000"/>
  </g>

  <!-- Footer -->
  <text x="20" y="550" font-family="Arial, sans-serif" font-size="12" fill="#999">Terima kasih telah menggunakan layanan kami</text>
  <text x="20" y="570" font-family="Arial, sans-serif" font-size="10" fill="#ccc">Generated: " . now()->format('d/m/Y H:i') . "</text>
</svg>
SVG;
    }
}
