<?php

namespace Database\Seeders;

use App\Models\KosakataWalikan;
use Illuminate\Database\Seeder;

class KosakataWalikanSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            // === A ===
            ['kata_walikan' => 'acakatam', 'kata_asli' => 'kacamata', 'arti' => 'kacamata', 'bahasa_asal' => 'Indonesia', 'kelas_kata' => 'n'],
            ['kata_walikan' => 'adapes', 'kata_asli' => 'sepeda', 'arti' => 'sepeda', 'bahasa_asal' => 'Indonesia', 'kelas_kata' => 'n'],
            ['kata_walikan' => 'adapes rotom', 'kata_asli' => 'sepeda motor', 'arti' => 'sepeda motor', 'bahasa_asal' => 'Indonesia', 'kelas_kata' => 'phrase'],
            ['kata_walikan' => 'agit', 'kata_asli' => 'tiga', 'arti' => 'tiga', 'bahasa_asal' => 'Indonesia', 'kelas_kata' => 'num'],
            ['kata_walikan' => 'ayas', 'kata_asli' => 'saya', 'arti' => 'saya', 'bahasa_asal' => 'Indonesia', 'kelas_kata' => 'pron'],

            // === K ===
            ['kata_walikan' => 'kéra', 'kata_asli' => 'arék', 'arti' => 'anak/orang', 'bahasa_asal' => 'Jawa', 'kelas_kata' => 'n', 'catatan' => 'Sapaan khas Arek Malang'],
            ['kata_walikan' => 'kadit', 'kata_asli' => 'tidak', 'arti' => 'tidak/bukan', 'bahasa_asal' => 'Indonesia', 'kelas_kata' => 'adv'],
            ['kata_walikan' => 'kipa', 'kata_asli' => 'apik', 'arti' => 'bagus', 'bahasa_asal' => 'Jawa', 'kelas_kata' => 'adj'],

            // === N ===
            ['kata_walikan' => 'nakam', 'kata_asli' => 'makan', 'arti' => 'makan', 'bahasa_asal' => 'Indonesia', 'kelas_kata' => 'v', 'catatan' => 'Kata paling populer di Malang'],
            ['kata_walikan' => 'ngalam', 'kata_asli' => 'malang', 'arti' => 'Malang', 'bahasa_asal' => 'Jawa', 'kelas_kata' => 'prop'],
            ['kata_walikan' => 'néndhés kombét', 'kata_asli' => 'séndhén témbok', 'arti' => 'santai / (dulu) mabuk', 'bahasa_asal' => 'Jawa', 'kelas_kata' => 'phrase', 'catatan' => 'Makna bergeser dari konotasi negatif ke netral'],

            // === KATA KASAR (contoh) ===
            ['kata_walikan' => 'lontok', 'kata_asli' => 'kontol', 'arti' => 'penis', 'bahasa_asal' => 'Jawa', 'kelas_kata' => 'n', 'kategori_kasar' => true, 'tingkat_formal' => 'kasar'],
            ['kata_walikan' => 'kempit', 'kata_asli' => 'tempik', 'arti' => 'vagina', 'bahasa_asal' => 'Jawa', 'kelas_kata' => 'n', 'kategori_kasar' => true, 'tingkat_formal' => 'kasar'],

            // === SERAPAN ASING ===
            ['kata_walikan' => 'woles', 'kata_asli' => 'selow', 'arti' => 'santai/pelan', 'bahasa_asal' => 'Inggris', 'kelas_kata' => 'adj'],
            ['kata_walikan' => 'skelir', 'kata_asli' => 'rileks', 'arti' => 'santai', 'bahasa_asal' => 'Inggris', 'kelas_kata' => 'adj'],
            ['kata_walikan' => 'nés', 'kata_asli' => 'zén', 'arti' => 'cantik/bagus', 'bahasa_asal' => 'Arab', 'kelas_kata' => 'adj'],
        ];

        foreach ($data as $item) {
            KosakataWalikan::create(array_merge([
                'bahasa_asal' => 'Jawa',
                'kelas_kata' => null,
                'kategori_kasar' => false,
                'tingkat_formal' => 'informal',
                'tipe_walikan' => 'Total Segment Reversal',
                'catatan' => null,
            ], $item));
        }
    }
}
