<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\DomCrawler\Crawler;

class ScrapeHariLibur extends Command
{
    protected $signature = 'libur:scrape {year?}'; //Mendaftarkan perintah Artisan libur:scrape dengan parameter opsional year.
    protected $description = 'Scraping hari libur nasional dari tanggalan.com';

    public function handle()
    {
        $year = $this->argument('year') ?? now()->year; //Menggunakan tahun dari argument CLI, jika tidak ada maka otomatis tahun saat ini.
        $url = "https://www.tanggalan.com/{$year}"; //Menentukan URL kalender berdasarkan tahun yang akan di-scrape.

        $response = Http::withoutVerifying()->get($url); //Mengambil HTML halaman kalender tanpa validasi SSL.

        //Menghentikan proses jika request gagal (status bukan 200).
        if (!$response->ok()) {
            $this->error('Gagal mengambil halaman');
            return;
        }

        $crawler = new Crawler($response->body()); //Mengubah HTML mentah menjadi objek DOM untuk proses scraping.

        $dataLibur = [];

        // Digunakan untuk mengonversi teks bulan Indonesia menjadi format angka.
        $bulanMap = [
            'januari'   => 1,
            'februari'  => 2,
            'maret'     => 3,
            'april'     => 4,
            'mei'       => 5,
            'juni'      => 6,
            'juli'      => 7,
            'agustus'   => 8,
            'september' => 9,
            'oktober'   => 10,
            'november'  => 11,
            'desember'  => 12,
        ];


        //  Melakukan iterasi (looping) setiap baris tabel hari libur pada halaman.
        $crawler->filter('#main article ul li table tr')->each(
            function (Crawler $tr) use (&$dataLibur, $year, $bulanMap) {

                $tds = $tr->filter('td');

                //Memastikan baris berisi tanggal dan keterangan hari libur yang valid.
                if ($tds->count() === 2) {
                    $tanggal = trim($tds->eq(0)->text());
                    $keterangan = trim($tds->eq(1)->text());

                    if (is_numeric($tanggal)) {

                        // Mengambil nama bulan dari header HTML lalu mengonversinya menjadi angka bulan.
                        // 🔑 AMBIL BULAN DARI REFERENSI <a href="bulan-2026">
                        $ul = $tr->ancestors()->filter('ul')->first();
                        $bulanText = strtolower(
                            trim($ul->filter('li')->first()->filter('a')->text())
                        );

                        // ambil nama bulan saja (hapus angka tahun)
                        $bulanText = preg_replace('/[^a-z]/', '', $bulanText);
                        $bulan = $bulanMap[$bulanText] ?? null;

                        if (!$bulan) {
                            return;
                        }

                        // Menyimpan satu entri hari libur ke array hasil scraping.
                        $dataLibur[] = [
                            'tanggal'    => (int) $tanggal,
                            'bulan'      => $bulan,
                            'keterangan' => $keterangan,
                            'tahun'      => $year,
                        ];
                    }
                }
            }
        );



        // Menyimpan hasil scraping ke file JSON
        Storage::put(
            "holidays/holidays-{$year}.json",
            json_encode($dataLibur, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );

        $this->info("✅ Berhasil menyimpan holidays-{$year}.json");
    }
}
