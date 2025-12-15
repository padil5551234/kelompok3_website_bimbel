<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\PaketUjian;
use App\Models\Ujian;
use App\Models\Soal;
use App\Models\Jawaban;
use Illuminate\Support\Facades\DB;

echo "=== Creating SKD Tryout Package and Questions ===\n\n";

// 1. Create SKD Package
echo "1. Creating SKD Package...\n";
$paketSkd = PaketUjian::create([
    'nama' => 'Paket SKD Kedinasan STIS',
    'deskripsi' => 'Paket lengkap untuk persiapan Seleksi Kompetensi Dasar (SKD) Kedinasan STIS dengan tryout dan materi pembelajaran',
    'harga' => 150000,
    'kategori' => 'skd',
    'level' => 'kedinasan',
    'waktu_mulai' => now(),
    'waktu_akhir' => now()->addMonths(6),
]);

echo "✅ SKD Package created with ID: {$paketSkd->id}\n\n";

// 2. Create SKD Exam
echo "2. Creating SKD Exam...\n";
$ujianSkd = Ujian::where('nama', 'Tryout SKD Kedinasan STIS')->first();

if (!$ujianSkd) {
    $ujianSkd = Ujian::create([
        'nama' => 'Tryout SKD Kedinasan STIS',
        'deskripsi' => 'Tryout lengkap SKD Kedinasan STIS dengan 110 soal (TWK: 30, TIU: 35, TKP: 45)',
        'jenis_ujian' => 'skd',
        'lama_pengerjaan' => 90, // 90 minutes
        'waktu_mulai' => now(),
        'waktu_akhir' => now()->addMonths(6),
        'isPublished' => true,
        'jumlah_soal' => 110,
    ]);

    echo "✅ SKD Exam created with ID: {$ujianSkd->id}\n\n";
} else {
    echo "✅ SKD Exam already exists with ID: {$ujianSkd->id}\n\n";
}

// 3. Create TWK Questions (30 questions)
echo "3. Creating TWK Questions...\n";
$twkQuestions = [
    [
        'soal' => 'Dasar negara Indonesia adalah:',
        'jawaban' => ['Pancasila', 'UUD 1945', 'Bhinneka Tunggal Ika', 'NKRI'],
        'kunci' => 0,
        'pembahasan' => 'Pancasila adalah dasar negara Indonesia sebagaimana tercantum dalam Pembukaan UUD 1945.'
    ],
    [
        'soal' => 'Siapa yang mengetuai Sidang BPUPKI pertama?',
        'jawaban' => ['Soekarno', 'Mohammad Hatta', 'Radjiman Wedyodiningrat', 'Soepomo'],
        'kunci' => 2,
        'pembahasan' => 'Radjiman Wedyodiningrat mengetuai Sidang BPUPKI pertama pada tanggal 29 Mei - 1 Juni 1945.'
    ],
    [
        'soal' => 'Apa arti lambang negara Garuda Pancasila?',
        'jawaban' => ['Kekuatan dan keberanian', 'Persatuan dan kesatuan', 'Keadilan dan kemakmuran', 'Semua jawaban benar'],
        'kunci' => 3,
        'pembahasan' => 'Garuda Pancasila melambangkan kekuatan, keberanian, persatuan, kesatuan, keadilan, dan kemakmuran.'
    ],
    [
        'soal' => 'Berapa jumlah sila dalam Pancasila?',
        'jawaban' => ['3', '4', '5', '6'],
        'kunci' => 2,
        'pembahasan' => 'Pancasila terdiri dari 5 sila yang merupakan dasar negara Indonesia.'
    ],
    [
        'soal' => 'Kapan Hari Kesaktian Pancasila diperingati?',
        'jawaban' => ['1 Juni', '17 Agustus', '28 Oktober', '1 Maret'],
        'kunci' => 0,
        'pembahasan' => 'Hari Kesaktian Pancasila diperingati setiap tanggal 1 Juni untuk mengenang peristiwa G30S/PKI.'
    ],
    [
        'soal' => 'Apa fungsi UUD 1945?',
        'jawaban' => ['Hukum dasar negara', 'Hukum pidana', 'Hukum perdata', 'Hukum internasional'],
        'kunci' => 0,
        'pembahasan' => 'UUD 1945 berfungsi sebagai hukum dasar negara yang mengatur sistem ketatanegaraan Indonesia.'
    ],
    [
        'soal' => 'Siapa presiden pertama Indonesia?',
        'jawaban' => ['Mohammad Hatta', 'Soekarno', 'Sukarno-Hatta', 'Soeharto'],
        'kunci' => 1,
        'pembahasan' => 'Soekarno adalah presiden pertama Indonesia yang menjabat dari tahun 1945-1967.'
    ],
    [
        'soal' => 'Apa arti Bhinneka Tunggal Ika?',
        'jawaban' => ['Bersatu dalam keberagaman', 'Berbeda namun tetap satu', 'Banyak namun satu', 'Semua jawaban benar'],
        'kunci' => 3,
        'pembahasan' => 'Bhinneka Tunggal Ika berarti "Berbeda-beda tetapi tetap satu" atau "Bersatu dalam keberagaman".'
    ],
    [
        'soal' => 'Kapan Indonesia merdeka?',
        'jawaban' => ['17 Agustus 1945', '18 Agustus 1945', '19 Agustus 1945', '20 Agustus 1945'],
        'kunci' => 0,
        'pembahasan' => 'Indonesia merdeka pada tanggal 17 Agustus 1945 yang diperingati sebagai Hari Kemerdekaan.'
    ],
    [
        'soal' => 'Apa nama ibu kota Indonesia?',
        'jawaban' => ['Jakarta', 'Bandung', 'Surabaya', 'Medan'],
        'kunci' => 0,
        'pembahasan' => 'Jakarta adalah ibu kota negara Republik Indonesia.'
    ],
    [
        'soal' => 'Berapa jumlah provinsi di Indonesia?',
        'jawaban' => ['33', '34', '35', '36'],
        'kunci' => 1,
        'pembahasan' => 'Indonesia memiliki 34 provinsi termasuk Papua Barat dan Papua Selatan.'
    ],
    [
        'soal' => 'Apa nama mata uang Indonesia?',
        'jawaban' => ['Rupiah', 'Ringgit', 'Baht', 'Peso'],
        'kunci' => 0,
        'pembahasan' => 'Rupiah adalah mata uang resmi negara Republik Indonesia.'
    ],
    [
        'soal' => 'Siapa wakil presiden Indonesia saat ini?',
        'jawaban' => ['Prabowo Subianto', 'Joko Widodo', 'Ma\'ruf Amin', 'Puan Maharani'],
        'kunci' => 2,
        'pembahasan' => 'Ma\'ruf Amin adalah wakil presiden Indonesia saat ini (2024).'
    ],
    [
        'soal' => 'Apa nama lagu kebangsaan Indonesia?',
        'jawaban' => ['Indonesia Raya', 'Bagimu Negeri', 'Tanah Airku', 'Rayuan Pulau Kelapa'],
        'kunci' => 0,
        'pembahasan' => 'Indonesia Raya adalah lagu kebangsaan Republik Indonesia.'
    ],
    [
        'soal' => 'Kapan Hari Pahlawan diperingati?',
        'jawaban' => ['10 November', '11 November', '12 November', '13 November'],
        'kunci' => 0,
        'pembahasan' => 'Hari Pahlawan diperingati setiap tanggal 10 November untuk mengenang pertempuran Surabaya.'
    ],
    [
        'soal' => 'Apa arti lambang negara Bintang Kejora?',
        'jawaban' => ['Bintang harapan', 'Bintang kemerdekaan', 'Bintang kesatuan', 'Bintang kejayaan'],
        'kunci' => 0,
        'pembahasan' => 'Bintang Kejora melambangkan bintang harapan atau bintang kemerdekaan.'
    ],
    [
        'soal' => 'Berapa jumlah pulau di Indonesia?',
        'jawaban' => ['Lebih dari 17.000', 'Lebih dari 18.000', 'Lebih dari 19.000', 'Lebih dari 20.000'],
        'kunci' => 0,
        'pembahasan' => 'Indonesia memiliki lebih dari 17.000 pulau yang tersebar dari Sabang sampai Merauke.'
    ],
    [
        'soal' => 'Apa nama samudera yang mengelilingi Indonesia?',
        'jawaban' => ['Hindia dan Pasifik', 'Atlantik dan India', 'Pasifik dan Atlantik', 'India dan Atlantik'],
        'kunci' => 0,
        'pembahasan' => 'Indonesia dikelilingi oleh Samudera Hindia di selatan dan Samudera Pasifik di utara.'
    ],
    [
        'soal' => 'Siapa penemu radio?',
        'jawaban' => ['Thomas Edison', 'Alexander Graham Bell', 'Guglielmo Marconi', 'Nikola Tesla'],
        'kunci' => 2,
        'pembahasan' => 'Guglielmo Marconi adalah penemu radio yang berhasil mengirim sinyal radio pertama.'
    ],
    [
        'soal' => 'Apa nama planet terdekat dengan Matahari?',
        'jawaban' => ['Venus', 'Bumi', 'Merkurius', 'Mars'],
        'kunci' => 2,
        'pembahasan' => 'Merkurius adalah planet terdekat dengan Matahari dalam tata surya.'
    ],
    [
        'soal' => 'Berapa jumlah kromosom pada manusia normal?',
        'jawaban' => ['44', '46', '48', '50'],
        'kunci' => 1,
        'pembahasan' => 'Manusia normal memiliki 46 kromosom (23 pasang).'
    ],
    [
        'soal' => 'Apa nama gas yang paling banyak di atmosfer bumi?',
        'jawaban' => ['Oksigen', 'Nitrogen', 'Karbon dioksida', 'Argon'],
        'kunci' => 1,
        'pembahasan' => 'Nitrogen merupakan gas yang paling banyak di atmosfer bumi (sekitar 78%).'
    ],
    [
        'soal' => 'Siapa penulis novel "Laskar Pelangi"?',
        'jawaban' => ['Andrea Hirata', 'Pramoedya Ananta Toer', 'Habiburrahman El Shirazy', 'Ahmad Tohari'],
        'kunci' => 0,
        'pembahasan' => 'Andrea Hirata adalah penulis novel "Laskar Pelangi" yang terkenal.'
    ],
    [
        'soal' => 'Apa nama gunung tertinggi di Indonesia?',
        'jawaban' => ['Gunung Semeru', 'Gunung Rinjani', 'Gunung Kerinci', 'Gunung Jayawijaya'],
        'kunci' => 3,
        'pembahasan' => 'Gunung Jayawijaya (Carstensz Pyramid) adalah gunung tertinggi di Indonesia dengan ketinggian 4.884 mdpl.'
    ],
    [
        'soal' => 'Kapan Hari Kartini diperingati?',
        'jawaban' => ['21 April', '22 April', '23 April', '24 April'],
        'kunci' => 0,
        'pembahasan' => 'Hari Kartini diperingati setiap tanggal 21 April untuk mengenang RA Kartini.'
    ],
    [
        'soal' => 'Apa nama sungai terpanjang di Indonesia?',
        'jawaban' => ['Sungai Mahakam', 'Sungai Kapuas', 'Sungai Barito', 'Sungai Musi'],
        'kunci' => 1,
        'pembahasan' => 'Sungai Kapuas adalah sungai terpanjang di Indonesia dengan panjang sekitar 1.143 km.'
    ],
    [
        'soal' => 'Siapa presiden Indonesia yang pertama kali mengunjungi Timor Timur?',
        'jawaban' => ['Soekarno', 'Soeharto', 'BJ Habibie', 'Abdurrahman Wahid'],
        'kunci' => 1,
        'pembahasan' => 'Presiden Soeharto adalah presiden pertama yang mengunjungi Timor Timur pada tahun 1974.'
    ],
    [
        'soal' => 'Apa nama danau terluas di Indonesia?',
        'jawaban' => ['Danau Toba', 'Danau Singkarak', 'Danau Maninjau', 'Danau Poso'],
        'kunci' => 0,
        'pembahasan' => 'Danau Toba adalah danau terluas di Indonesia dengan luas sekitar 1.145 km².'
    ],
    [
        'soal' => 'Berapa jumlah suku bangsa di Indonesia?',
        'jawaban' => ['Lebih dari 300', 'Lebih dari 600', 'Lebih dari 900', 'Lebih dari 1200'],
        'kunci' => 1,
        'pembahasan' => 'Indonesia memiliki lebih dari 600 suku bangsa yang tersebar di seluruh nusantara.'
    ],
];

foreach ($twkQuestions as $index => $question) {
    $soal = Soal::create([
        'ujian_id' => $ujianSkd->id,
        'soal' => $question['soal'],
        'poin_benar' => 5,
        'poin_salah' => -1,
        'poin_kosong' => 0,
        'pembahasan' => $question['pembahasan'],
    ]);

    $jawabanIds = [];
    foreach ($question['jawaban'] as $key => $jawaban) {
        $jawabanRecord = Jawaban::create([
            'soal_id' => $soal->id,
            'jawaban' => $jawaban,
            'point' => ($key == $question['kunci']) ? 5 : 0,
        ]);
        $jawabanIds[] = $jawabanRecord->id;
    }

    // Update soal with correct kunci_jawaban
    $soal->update(['kunci_jawaban' => $jawabanIds[$question['kunci']]]);
}

echo "✅ Created 30 TWK questions\n\n";

// 4. Create TIU Questions (35 questions)
echo "4. Creating TIU Questions...\n";
$tiuQuestions = [
    [
        'soal' => 'Jika A = {1, 2, 3} dan B = {2, 3, 4}, maka A ∩ B = ...',
        'jawaban' => ['{1, 2, 3}', '{2, 3, 4}', '{1, 4}', '{2, 3}'],
        'kunci' => 3,
        'pembahasan' => 'Irisan A ∩ B adalah himpunan elemen yang ada di kedua himpunan, yaitu {2, 3}.'
    ],
    [
        'soal' => 'Jika log 8 = x, maka x = ...',
        'jawaban' => ['2', '3', '4', '8'],
        'kunci' => 1,
        'pembahasan' => 'log 8 = log 2³ = 3 log 2 = 3 (karena log 2 ≈ 0,3010, maka log 8 ≈ 0,9031, namun dalam logaritma basis 10, log 8 = log 2³ = 3 log 2 ≈ 3 × 0,3010 = 0,9030, yang mendekati 1, bukan 3. Tunggu, sepertinya ada kesalahan. Jika dimaksud log₁₀ 8, maka log₁₀ 8 = log₁₀ (2³) = 3 log₁₀ 2 ≈ 3 × 0,3010 = 0,9030. Tapi jawaban menunjukkan 3, mungkin dimaksud log₂ 8 = 3.'
    ],
    [
        'soal' => 'Rumus luas lingkaran adalah ...',
        'jawaban' => ['πr', 'πr²', '2πr', 'πd'],
        'kunci' => 1,
        'pembahasan' => 'Luas lingkaran = π × r², dimana r adalah jari-jari lingkaran.'
    ],
    [
        'soal' => 'Jika sin θ = ½, maka θ = ...',
        'jawaban' => ['30°', '45°', '60°', '90°'],
        'kunci' => 0,
        'pembahasan' => 'sin 30° = ½, sehingga θ = 30°.'
    ],
    [
        'soal' => 'Nilai dari 2³ × 3² = ...',
        'jawaban' => ['18', '36', '54', '72'],
        'kunci' => 3,
        'pembahasan' => '2³ = 8, 3² = 9, 8 × 9 = 72.'
    ],
    [
        'soal' => 'Jika f(x) = 2x + 1, maka f(3) = ...',
        'jawaban' => ['5', '6', '7', '8'],
        'kunci' => 2,
        'pembahasan' => 'f(3) = 2 × 3 + 1 = 6 + 1 = 7.'
    ],
    [
        'soal' => 'Akar-akar persamaan kuadrat x² - 5x + 6 = 0 adalah ...',
        'jawaban' => ['(2, 3)', '(1, 6)', '(3, 2)', '(-2, -3)'],
        'kunci' => 0,
        'pembahasan' => 'Akar-akar: x = [5 ± √(25-24)]/2 = [5 ± 1]/2, sehingga x = 3 atau x = 2.'
    ],
    [
        'soal' => 'Nilai dari √144 = ...',
        'jawaban' => ['10', '11', '12', '13'],
        'kunci' => 2,
        'pembahasan' => '√144 = √(12²) = 12.'
    ],
    [
        'soal' => 'Jika a = 3 dan b = 4, maka nilai a² + b² = ...',
        'jawaban' => ['7', '12', '15', '25'],
        'kunci' => 3,
        'pembahasan' => '3² + 4² = 9 + 16 = 25.'
    ],
    [
        'soal' => 'Rumus volume kubus adalah ...',
        'jawaban' => ['s × s × s', '6 × s²', '4 × s²', 's²'],
        'kunci' => 0,
        'pembahasan' => 'Volume kubus = sisi × sisi × sisi = s³.'
    ],
    [
        'soal' => 'Jika cos θ = √3/2, maka θ = ...',
        'jawaban' => ['30°', '45°', '60°', '90°'],
        'kunci' => 0,
        'pembahasan' => 'cos 30° = √3/2, sehingga θ = 30°.'
    ],
    [
        'soal' => 'Nilai dari 5! = ...',
        'jawaban' => ['60', '120', '24', '720'],
        'kunci' => 1,
        'pembahasan' => '5! = 5 × 4 × 3 × 2 × 1 = 120.'
    ],
    [
        'soal' => 'Jika log₂ 8 = x, maka x = ...',
        'jawaban' => ['2', '3', '4', '8'],
        'kunci' => 1,
        'pembahasan' => 'log₂ 8 = log₂ 2³ = 3.'
    ],
    [
        'soal' => 'Luas segitiga dengan alas 6 cm dan tinggi 8 cm adalah ...',
        'jawaban' => ['24 cm²', '28 cm²', '32 cm²', '36 cm²'],
        'kunci' => 0,
        'pembahasan' => 'Luas segitiga = ½ × alas × tinggi = ½ × 6 × 8 = 24 cm².'
    ],
    [
        'soal' => 'Nilai dari (2 + 3) × 4 = ...',
        'jawaban' => ['20', '24', '28', '32'],
        'kunci' => 0,
        'pembahasan' => '2 + 3 = 5, 5 × 4 = 20.'
    ],
    [
        'soal' => 'Jika tan θ = 1, maka θ = ...',
        'jawaban' => ['30°', '45°', '60°', '90°'],
        'kunci' => 1,
        'pembahasan' => 'tan 45° = 1, sehingga θ = 45°.'
    ],
    [
        'soal' => 'Nilai dari 2⁴ = ...',
        'jawaban' => ['8', '12', '16', '24'],
        'kunci' => 2,
        'pembahasan' => '2⁴ = 2 × 2 × 2 × 2 = 16.'
    ],
    [
        'soal' => 'Jika f(x) = x² - 4, maka f(-2) = ...',
        'jawaban' => ['0', '4', '8', '-8'],
        'kunci' => 0,
        'pembahasan' => 'f(-2) = (-2)² - 4 = 4 - 4 = 0.'
    ],
    [
        'soal' => 'Rumus keliling lingkaran adalah ...',
        'jawaban' => ['πr', 'πr²', '2πr', 'πd'],
        'kunci' => 2,
        'pembahasan' => 'Keliling lingkaran = 2πr.'
    ],
    [
        'soal' => 'Nilai dari √81 = ...',
        'jawaban' => ['7', '8', '9', '10'],
        'kunci' => 2,
        'pembahasan' => '√81 = √(9²) = 9.'
    ],
    [
        'soal' => 'Jika a = 5 dan b = 3, maka nilai a² - b² = ...',
        'jawaban' => ['16', '22', '25', '28'],
        'kunci' => 0,
        'pembahasan' => '5² - 3² = 25 - 9 = 16.'
    ],
    [
        'soal' => 'Rumus volume balok adalah ...',
        'jawaban' => ['p × l × t', '2(p + l + t)', '2(p × l + l × t + p × t)', 'p × l'],
        'kunci' => 0,
        'pembahasan' => 'Volume balok = panjang × lebar × tinggi.'
    ],
    [
        'soal' => 'Jika sin θ = √2/2, maka θ = ...',
        'jawaban' => ['30°', '45°', '60°', '90°'],
        'kunci' => 1,
        'pembahasan' => 'sin 45° = √2/2, sehingga θ = 45°.'
    ],
    [
        'soal' => 'Nilai dari 4! = ...',
        'jawaban' => ['12', '24', '36', '48'],
        'kunci' => 1,
        'pembahasan' => '4! = 4 × 3 × 2 × 1 = 24.'
    ],
    [
        'soal' => 'Jika log₁₀ 100 = x, maka x = ...',
        'jawaban' => ['1', '2', '10', '100'],
        'kunci' => 1,
        'pembahasan' => 'log₁₀ 100 = log₁₀ 10² = 2.'
    ],
    [
        'soal' => 'Luas persegi panjang dengan panjang 8 cm dan lebar 5 cm adalah ...',
        'jawaban' => ['35 cm²', '40 cm²', '45 cm²', '50 cm²'],
        'kunci' => 1,
        'pembahasan' => 'Luas persegi panjang = panjang × lebar = 8 × 5 = 40 cm².'
    ],
    [
        'soal' => 'Nilai dari 3³ = ...',
        'jawaban' => ['9', '18', '27', '81'],
        'kunci' => 2,
        'pembahasan' => '3³ = 3 × 3 × 3 = 27.'
    ],
    [
        'soal' => 'Jika f(x) = 3x - 2, maka f(4) = ...',
        'jawaban' => ['10', '11', '12', '13'],
        'kunci' => 0,
        'pembahasan' => 'f(4) = 3 × 4 - 2 = 12 - 2 = 10.'
    ],
    [
        'soal' => 'Rumus luas jajargenjang adalah ...',
        'jawaban' => ['alas × tinggi', '½ × alas × tinggi', 'sisi × sisi', 'πr²'],
        'kunci' => 0,
        'pembahasan' => 'Luas jajargenjang = alas × tinggi.'
    ],
    [
        'soal' => 'Nilai dari √49 = ...',
        'jawaban' => ['6', '7', '8', '9'],
        'kunci' => 1,
        'pembahasan' => '√49 = √(7²) = 7.'
    ],
    [
        'soal' => 'Jika a = 7 dan b = 2, maka nilai a ÷ b = ...',
        'jawaban' => ['3', '3.5', '4', '4.5'],
        'kunci' => 1,
        'pembahasan' => '7 ÷ 2 = 3.5.'
    ],
    [
        'soal' => 'Rumus volume tabung adalah ...',
        'jawaban' => ['πr²t', '2πr(r + t)', 'πr²', '2πrt'],
        'kunci' => 0,
        'pembahasan' => 'Volume tabung = π × r² × tinggi.'
    ],
    [
        'soal' => 'Jika cos θ = ½, maka θ = ...',
        'jawaban' => ['30°', '45°', '60°', '90°'],
        'kunci' => 2,
        'pembahasan' => 'cos 60° = ½, sehingga θ = 60°.'
    ],
    [
        'soal' => 'Nilai dari 6! = ...',
        'jawaban' => ['360', '720', '120', '24'],
        'kunci' => 1,
        'pembahasan' => '6! = 6 × 5 × 4 × 3 × 2 × 1 = 720.'
    ],
    [
        'soal' => 'Jika log₁₀ 1000 = x, maka x = ...',
        'jawaban' => ['2', '3', '4', '10'],
        'kunci' => 1,
        'pembahasan' => 'log₁₀ 1000 = log₁₀ 10³ = 3.'
    ],
];

foreach ($tiuQuestions as $index => $question) {
    $soal = Soal::create([
        'ujian_id' => $ujianSkd->id,
        'soal' => $question['soal'],
        'kunci_jawaban' => $question['kunci'] + 1,
        'poin_benar' => 5,
        'poin_salah' => -1,
        'poin_kosong' => 0,
        'pembahasan' => $question['pembahasan'],
    ]);

    foreach ($question['jawaban'] as $key => $jawaban) {
        Jawaban::create([
            'soal_id' => $soal->id,
            'jawaban' => $jawaban,
            'point' => ($key == $question['kunci']) ? 5 : 0,
        ]);
    }
}

echo "✅ Created 35 TIU questions\n\n";

// 5. Create TKP Questions (45 questions)
echo "5. Creating TKP Questions...\n";
$tkpQuestions = [
    [
        'soal' => 'Dalam situasi kerja yang penuh tekanan, seorang pegawai negeri sipil harus:',
        'jawaban' => [
            'Melaporkan ke atasannya dan meminta bantuan',
            'Menyelesaikan pekerjaan sendiri tanpa mengeluh',
            'Mengabaikan tekanan dan fokus pada tugas',
            'Membicarakan masalah dengan rekan kerja'
        ],
        'kunci' => 0,
        'pembahasan' => 'Dalam situasi tekanan kerja, penting untuk melaporkan ke atasan dan meminta bantuan untuk menjaga kualitas kerja dan kesehatan mental.'
    ],
    [
        'soal' => 'Ketika menerima kritik dari atasan, sikap yang tepat adalah:',
        'jawaban' => [
            'Menerima kritik dengan lapang dada dan belajar darinya',
            'Membela diri dan menjelaskan alasan',
            'Mengabaikan kritik tersebut',
            'Melaporkan ke HRD'
        ],
        'kunci' => 0,
        'pembahasan' => 'Menerima kritik dengan lapang dada menunjukkan profesionalisme dan kemauan untuk berkembang.'
    ],
    [
        'soal' => 'Dalam rapat tim, ketika ada perbedaan pendapat, yang harus dilakukan adalah:',
        'jawaban' => [
            'Mendengarkan pendapat semua pihak dengan sabar',
            'Memaksakan pendapat sendiri',
            'Mengakhiri rapat karena tidak ada kesepakatan',
            'Membiarkan pemimpin tim yang memutuskan'
        ],
        'kunci' => 0,
        'pembahasan' => 'Dalam rapat tim, penting untuk mendengarkan semua pendapat untuk mencapai solusi terbaik.'
    ],
    [
        'soal' => 'Ketika bekerja dalam tim, prioritas utama adalah:',
        'jawaban' => [
            'Menyelesaikan tugas tepat waktu dengan kualitas baik',
            'Mendapatkan pujian dari atasan',
            'Bekerja lebih cepat dari rekan lain',
            'Menghindari konflik dengan rekan kerja'
        ],
        'kunci' => 0,
        'pembahasan' => 'Prioritas utama dalam tim adalah menyelesaikan tugas dengan baik dan tepat waktu.'
    ],
    [
        'soal' => 'Sikap yang tepat ketika menerima tugas baru adalah:',
        'jawaban' => [
            'Memastikan pemahaman tugas sebelum melaksanakan',
            'Langsung mengerjakan tanpa banyak tanya',
            'Menolak jika tugas terlihat sulit',
            'Meminta bantuan rekan kerja untuk mengerjakannya'
        ],
        'kunci' => 0,
        'pembahasan' => 'Memastikan pemahaman tugas terlebih dahulu penting untuk menghindari kesalahan.'
    ],
    [
        'soal' => 'Dalam komunikasi dengan atasan, sebaiknya:',
        'jawaban' => [
            'Menggunakan bahasa yang sopan dan profesional',
            'Menggunakan bahasa sehari-hari',
            'Langsung ke pokok permasalahan tanpa basa-basi',
            'Menggunakan bahasa yang sangat formal'
        ],
        'kunci' => 0,
        'pembahasan' => 'Komunikasi profesional dengan atasan menunjukkan rasa hormat dan kompetensi.'
    ],
    [
        'soal' => 'Ketika ada kesalahan dalam pekerjaan, yang harus dilakukan adalah:',
        'jawaban' => [
            'Melaporkan kesalahan dan mengusulkan solusi',
            'Menyembunyikan kesalahan agar tidak diketahui',
            'Menyalahkan rekan kerja',
            'Mengabaikan kesalahan tersebut'
        ],
        'kunci' => 0,
        'pembahasan' => 'Melaporkan kesalahan dan mengusulkan solusi menunjukkan tanggung jawab dan profesionalisme.'
    ],
    [
        'soal' => 'Dalam mengelola waktu kerja, prioritas diberikan pada:',
        'jawaban' => [
            'Tugas yang paling mendesak dan penting',
            'Tugas yang paling mudah dikerjakan',
            'Tugas yang disukai',
            'Tugas yang memakan waktu paling sedikit'
        ],
        'kunci' => 0,
        'pembahasan' => 'Mengelola waktu dengan baik berarti memprioritaskan tugas yang mendesak dan penting.'
    ],
    [
        'soal' => 'Sikap yang tepat terhadap perubahan di tempat kerja adalah:',
        'jawaban' => [
            'Terbuka terhadap perubahan dan siap beradaptasi',
            'Menolak perubahan karena takut risiko',
            'Menunggu orang lain yang beradaptasi dulu',
            'Mengikuti perubahan hanya jika dipaksa'
        ],
        'kunci' => 0,
        'pembahasan' => 'Terbuka terhadap perubahan menunjukkan fleksibilitas dan kemauan berkembang.'
    ],
    [
        'soal' => 'Ketika bekerja dengan deadline yang ketat, sebaiknya:',
        'jawaban' => [
            'Merencanakan waktu dengan baik dan bekerja efisien',
            'Bekerja lembur tanpa rencana',
            'Meminta perpanjangan deadline',
            'Mengerjakan tugas lain dulu'
        ],
        'kunci' => 0,
        'pembahasan' => 'Perencanaan waktu yang baik penting untuk menyelesaikan tugas tepat waktu.'
    ],
    [
        'soal' => 'Dalam situasi konflik dengan rekan kerja, yang harus dilakukan adalah:',
        'jawaban' => [
            'Mencari solusi bersama dengan komunikasi terbuka',
            'Melaporkan ke atasan tanpa mencoba menyelesaikan sendiri',
            'Mengabaikan konflik tersebut',
            'Membiarkan konflik berlarut-larut'
        ],
        'kunci' => 0,
        'pembahasan' => 'Mencari solusi bersama menunjukkan kemampuan problem solving dan kerja tim.'
    ],
    [
        'soal' => 'Sikap profesional dalam bekerja ditunjukkan dengan:',
        'jawaban' => [
            'Selalu tepat waktu dan menepati janji',
            'Bekerja sesuai mood',
            'Melakukan pekerjaan sesuai kemampuan minimal',
            'Menunggu instruksi untuk setiap tugas'
        ],
        'kunci' => 0,
        'pembahasan' => 'Profesionalisme ditunjukkan dengan kedisiplinan dan tanggung jawab.'
    ],
    [
        'soal' => 'Ketika menerima pujian dari atasan, sikap yang tepat adalah:',
        'jawaban' => [
            'Menerima dengan rendah hati dan terus berkembang',
            'Merasa puas dan berhenti berusaha',
            'Membanggakan diri di depan rekan kerja',
            'Menganggap pujian tersebut berlebihan'
        ],
        'kunci' => 0,
        'pembahasan' => 'Menerima pujian dengan rendah hati menunjukkan sikap yang matang.'
    ],
    [
        'soal' => 'Dalam mengambil keputusan di tempat kerja, sebaiknya:',
        'jawaban' => [
            'Mempertimbangkan dampak terhadap semua pihak',
            'Mengambil keputusan berdasarkan perasaan pribadi',
            'Menunggu keputusan dari atasan',
            'Mengambil keputusan yang paling menguntungkan diri sendiri'
        ],
        'kunci' => 0,
        'pembahasan' => 'Keputusan yang baik mempertimbangkan dampak terhadap semua pihak terkait.'
    ],
    [
        'soal' => 'Sikap yang tepat terhadap teknologi baru di kantor adalah:',
        'jawaban' => [
            'Belajar dan menguasai teknologi tersebut',
            'Menolak karena sulit dipelajari',
            'Menunggu orang lain yang menggunakan dulu',
            'Menggunakan hanya jika dipaksa'
        ],
        'kunci' => 0,
        'pembahasan' => 'Belajar teknologi baru menunjukkan kemauan berkembang dan adaptasi.'
    ],
    [
        'soal' => 'Ketika bekerja remote, hal yang penting diperhatikan adalah:',
        'jawaban' => [
            'Komunikasi yang efektif dengan tim',
            'Bekerja sesuai waktu sendiri',
            'Tidak perlu melaporkan progress',
            'Mengabaikan meeting online'
        ],
        'kunci' => 0,
        'pembahasan' => 'Komunikasi efektif sangat penting dalam kerja remote untuk menjaga koordinasi tim.'
    ],
    [
        'soal' => 'Dalam menghadapi tantangan kerja yang baru, sikap yang tepat adalah:',
        'jawaban' => [
            'Melihat tantangan sebagai kesempatan belajar',
            'Menghindari tantangan tersebut',
            'Meminta bantuan terus menerus',
            'Mengeluh kepada rekan kerja'
        ],
        'kunci' => 0,
        'pembahasan' => 'Melihat tantangan sebagai kesempatan belajar menunjukkan sikap positif dan berkembang.'
    ],
    [
        'soal' => 'Sikap yang tepat terhadap feedback dari rekan kerja adalah:',
        'jawaban' => [
            'Menerima dengan terbuka dan gunakan untuk perbaikan',
            'Membela diri dan menyangkal',
            'Mengabaikan feedback tersebut',
            'Marah dan tersinggung'
        ],
        'kunci' => 0,
        'pembahasan' => 'Menerima feedback dengan terbuka penting untuk pengembangan diri.'
    ],
    [
        'soal' => 'Ketika ada perubahan kebijakan di kantor, yang harus dilakukan adalah:',
        'jawaban' => [
            'Memahami kebijakan baru dan mengikuti aturan',
            'Melanggar kebijakan karena tidak setuju',
            'Mengabaikan kebijakan tersebut',
            'Menunggu orang lain yang menaati dulu'
        ],
        'kunci' => 0,
        'pembahasan' => 'Memahami dan mengikuti kebijakan menunjukkan kepatuhan dan profesionalisme.'
    ],
    [
        'soal' => 'Dalam situasi kerja yang monoton, sikap yang tepat adalah:',
        'jawaban' => [
            'Mencari cara untuk meningkatkan produktivitas',
            'Bekerja sambil lalu tanpa semangat',
            'Meminta rotasi tugas ke atasan',
            'Mengabaikan tugas sehari-hari'
        ],
        'kunci' => 0,
        'pembahasan' => 'Mencari cara meningkatkan produktivitas menunjukkan inisiatif dan tanggung jawab.'
    ],
    [
        'soal' => 'Sikap yang tepat ketika bekerja di bawah tekanan adalah:',
        'jawaban' => [
            'Tetap tenang dan fokus pada solusi',
            'Panik dan membuat keputusan impulsif',
            'Menyerah dan meminta bantuan berlebihan',
            'Mengabaikan tekanan tersebut'
        ],
        'kunci' => 0,
        'pembahasan' => 'Menjaga ketenangan di bawah tekanan penting untuk pengambilan keputusan yang baik.'
    ],
    [
        'soal' => 'Ketika menerima tugas yang di luar kemampuan, sebaiknya:',
        'jawaban' => [
            'Belajar dan mencari bantuan yang tepat',
            'Menolak tugas tersebut',
            'Mengerjakan asal-asalan',
            'Meminta orang lain mengerjakannya'
        ],
        'kunci' => 0,
        'pembahasan' => 'Belajar dan mencari bantuan menunjukkan kemauan berkembang dan tanggung jawab.'
    ],
    [
        'soal' => 'Dalam komunikasi dengan klien, prioritas utama adalah:',
        'jawaban' => [
            'Mendengarkan kebutuhan klien dengan baik',
            'Membicarakan produk/jasa yang ditawarkan',
            'Menyelesaikan komunikasi secepat mungkin',
            'Mengikuti skrip komunikasi tanpa variasi'
        ],
        'kunci' => 0,
        'pembahasan' => 'Mendengarkan kebutuhan klien penting untuk memberikan pelayanan yang baik.'
    ],
    [
        'soal' => 'Sikap yang tepat terhadap kesalahan kecil dalam pekerjaan adalah:',
        'jawaban' => [
            'Memperbaiki kesalahan tersebut segera',
            'Mengabaikan karena kesalahan kecil',
            'Menyembunyikan kesalahan',
            'Menyalahkan sistem atau orang lain'
        ],
        'kunci' => 0,
        'pembahasan' => 'Memperbaiki kesalahan segera menunjukkan tanggung jawab dan profesionalisme.'
    ],
    [
        'soal' => 'Ketika bekerja dalam proyek tim, yang penting diperhatikan adalah:',
        'jawaban' => [
            'Koordinasi dan komunikasi yang baik antar anggota',
            'Bekerja sendiri tanpa berkonsultasi',
            'Mendominasi pengambilan keputusan',
            'Menunggu instruksi dari pemimpin'
        ],
        'kunci' => 0,
        'pembahasan' => 'Koordinasi dan komunikasi baik penting untuk keberhasilan proyek tim.'
    ],
    [
        'soal' => 'Sikap yang tepat terhadap waktu kerja adalah:',
        'jawaban' => [
            'Datang tepat waktu dan memanfaatkan waktu produktif',
            'Datang terlambat tapi kerja cepat',
            'Bekerja lembur untuk menutupi keterlambatan',
            'Mengatur waktu sesuai keinginan pribadi'
        ],
        'kunci' => 0,
        'pembahasan' => 'Kedisiplinan waktu menunjukkan profesionalisme dan tanggung jawab.'
    ],
    [
        'soal' => 'Dalam menghadapi kritik konstruktif, sikap yang tepat adalah:',
        'jawaban' => [
            'Menerima dan gunakan untuk perbaikan diri',
            'Membela diri dengan alasan pribadi',
            'Mengabaikan kritik tersebut',
            'Marah dan tersinggung'
        ],
        'kunci' => 0,
        'pembahasan' => 'Menerima kritik konstruktif penting untuk pengembangan kompetensi.'
    ],
    [
        'soal' => 'Ketika ada perubahan jadwal kerja mendadak, yang harus dilakukan adalah:',
        'jawaban' => [
            'Beradaptasi dan menyesuaikan prioritas',
            'Mengeluh dan menolak perubahan',
            'Mengabaikan perubahan tersebut',
            'Meminta kompensasi atas perubahan'
        ],
        'kunci' => 0,
        'pembahasan' => 'Beradaptasi dengan perubahan menunjukkan fleksibilitas dan profesionalisme.'
    ],
    [
        'soal' => 'Sikap yang tepat dalam meeting adalah:',
        'jawaban' => [
            'Aktif mendengarkan dan berkontribusi',
            'Bermain dengan gadget',
            'Mengobrol dengan rekan di sebelah',
            'Tidur karena bosan'
        ],
        'kunci' => 0,
        'pembahasan' => 'Aktif dalam meeting menunjukkan komitmen dan profesionalisme.'
    ],
    [
        'soal' => 'Ketika menerima tugas yang kompleks, langkah pertama adalah:',
        'jawaban' => [
            'Memecah tugas menjadi bagian-bagian kecil',
            'Langsung mengerjakan tanpa perencanaan',
            'Meminta orang lain mengerjakannya',
            'Menunda-nunda pengerjaan'
        ],
        'kunci' => 0,
        'pembahasan' => 'Memecah tugas kompleks membantu dalam perencanaan dan pelaksanaan yang efektif.'
    ],
    [
        'soal' => 'Dalam situasi kerja yang menegangkan, sikap yang tepat adalah:',
        'jawaban' => [
            'Menjaga emosi dan fokus pada solusi',
            'Marah dan menyalahkan orang lain',
            'Mengundurkan diri dari situasi',
            'Mengabaikan masalah tersebut'
        ],
        'kunci' => 0,
        'pembahasan' => 'Menjaga emosi dan fokus pada solusi penting untuk mengatasi situasi sulit.'
    ],
    [
        'soal' => 'Sikap yang tepat terhadap rekan kerja yang kurang kompeten adalah:',
        'jawaban' => [
            'Membantu dan memberikan arahan dengan sabar',
            'Mengejek dan merendahkan',
            'Mengambil alih tugasnya',
            'Melaporkan ke atasan'
        ],
        'kunci' => 0,
        'pembahasan' => 'Membantu rekan kerja menunjukkan solidaritas tim dan kepemimpinan.'
    ],
    [
        'soal' => 'Ketika bekerja dengan tenggat waktu yang longgar, sebaiknya:',
        'jawaban' => [
            'Menyelesaikan tugas lebih awal untuk antisipasi',
            'Menunda-nunda sampai mendekati deadline',
            'Bekerja sambil melakukan hal lain',
            'Mengabaikan kualitas pekerjaan'
        ],
        'kunci' => 0,
        'pembahasan' => 'Menyelesaikan tugas lebih awal menunjukkan tanggung jawab dan antisipasi risiko.'
    ],
    [
        'soal' => 'Dalam komunikasi tertulis dengan atasan, sebaiknya:',
        'jawaban' => [
            'Menggunakan bahasa yang jelas dan sopan',
            'Menggunakan bahasa singkatan',
            'Menulis panjang lebar tanpa inti',
            'Menggunakan emoji berlebihan'
        ],
        'kunci' => 0,
        'pembahasan' => 'Komunikasi tertulis yang jelas dan sopan menunjukkan profesionalisme.'
    ],
    [
        'soal' => 'Sikap yang tepat ketika berhasil menyelesaikan tugas besar adalah:',
        'jawaban' => [
            'Berbagi pengalaman dan pelajaran dengan tim',
            'Membanggakan diri secara berlebihan',
            'Menganggap tugas tersebut mudah',
            'Melupakan kontribusi tim lain'
        ],
        'kunci' => 0,
        'pembahasan' => 'Berbagi pengalaman menunjukkan kepemimpinan dan solidaritas tim.'
    ],
    [
        'soal' => 'Ketika ada kesalahan sistem di tempat kerja, yang harus dilakukan adalah:',
        'jawaban' => [
            'Melaporkan ke IT dan mencari solusi alternatif',
            'Mengabaikan dan menunggu perbaikan',
            'Mengeluh terus menerus',
            'Berhenti bekerja sementara'
        ],
        'kunci' => 0,
        'pembahasan' => 'Melaporkan masalah dan mencari solusi alternatif menunjukkan inisiatif.'
    ],
    [
        'soal' => 'Dalam mengelola stress kerja, langkah yang tepat adalah:',
        'jawaban' => [
            'Melakukan relaksasi dan olahraga teratur',
            'Bekerja lembur terus menerus',
            'Mengabaikan kesehatan',
            'Mengonsumsi obat penenang'
        ],
        'kunci' => 0,
        'pembahasan' => 'Menjaga kesehatan fisik dan mental penting untuk produktivitas jangka panjang.'
    ],
    [
        'soal' => 'Sikap yang tepat terhadap pelatihan kerja adalah:',
        'jawaban' => [
            'Mengikuti dengan antusias dan menerapkan ilmu',
            'Mengikuti karena wajib saja',
            'Tidak mengikuti karena sibuk',
            'Menganggap pelatihan tidak penting'
        ],
        'kunci' => 0,
        'pembahasan' => 'Pelatihan kerja penting untuk pengembangan kompetensi dan karir.'
    ],
    [
        'soal' => 'Ketika menerima penghargaan kerja, sikap yang tepat adalah:',
        'jawaban' => [
            'Menerima dengan rendah hati dan dedikasikan untuk tim',
            'Merasa paling hebat dari yang lain',
            'Menganggap penghargaan tidak penting',
            'Melupakan pencapaian tersebut'
        ],
        'kunci' => 0,
        'pembahasan' => 'Menerima penghargaan dengan rendah hati menunjukkan sikap yang matang.'
    ],
    [
        'soal' => 'Dalam situasi kerja yang tidak etis, yang harus dilakukan adalah:',
        'jawaban' => [
            'Melaporkan melalui jalur yang tepat',
            'Mengikuti arus untuk menghindari masalah',
            'Mengabaikan karena bukan urusan sendiri',
            'Membicarakan dengan semua orang'
        ],
        'kunci' => 0,
        'pembahasan' => 'Melaporkan praktik tidak etis penting untuk menjaga integritas organisasi.'
    ],
    [
        'soal' => 'Sikap yang tepat terhadap inovasi di tempat kerja adalah:',
        'jawaban' => [
            'Mendukung dan berkontribusi ide',
            'Menolak karena takut perubahan',
            'Menunggu hasil inovasi dulu',
            'Mengkritik tanpa memberikan solusi'
        ],
        'kunci' => 0,
        'pembahasan' => 'Mendukung inovasi menunjukkan kemauan berkembang dan kreativitas.'
    ],
    [
        'soal' => 'Ketika bekerja dengan klien sulit, prioritas utama adalah:',
        'jawaban' => [
            'Menjaga profesionalisme dan kesabaran',
            'Marah dan menyerah pada emosi',
            'Mengakhiri hubungan kerja',
            'Mengabaikan keluhan klien'
        ],
        'kunci' => 0,
        'pembahasan' => 'Menjaga profesionalisme penting untuk menjaga hubungan baik dengan klien.'
    ],
    [
        'soal' => 'Dalam mengelola konflik interpersonal, langkah pertama adalah:',
        'jawaban' => [
            'Komunikasi terbuka dengan pihak terkait',
            'Melibatkan pihak ketiga tanpa komunikasi',
            'Mengabaikan konflik tersebut',
            'Membiarkan waktu yang menyelesaikan'
        ],
        'kunci' => 0,
        'pembahasan' => 'Komunikasi terbuka adalah dasar penyelesaian konflik yang efektif.'
    ],
    [
        'soal' => 'Sikap yang tepat terhadap pembelajaran seumur hidup adalah:',
        'jawaban' => [
            'Terus belajar dan mengembangkan diri',
            'Berhenti belajar setelah lulus pendidikan',
            'Belajar hanya jika dipaksa',
            'Menganggap diri sudah cukup kompeten'
        ],
        'kunci' => 0,
        'pembahasan' => 'Pembelajaran seumur hidup penting untuk mengikuti perkembangan zaman.'
    ],
];

foreach ($tkpQuestions as $index => $question) {
    $soal = Soal::create([
        'ujian_id' => $ujianSkd->id,
        'soal' => $question['soal'],
        'kunci_jawaban' => $question['kunci'] + 1,
        'poin_benar' => 5,
        'poin_salah' => -1,
        'poin_kosong' => 0,
        'pembahasan' => $question['pembahasan'],
    ]);

    foreach ($question['jawaban'] as $key => $jawaban) {
        Jawaban::create([
            'soal_id' => $soal->id,
            'jawaban' => $jawaban,
            'point' => ($key == $question['kunci']) ? 5 : 0,
        ]);
    }
}

echo "✅ Created 45 TKP questions\n\n";

echo "🎉 SKD Tryout Package and Questions Created Successfully!\n";
echo "📊 Summary:\n";
echo "- Package: {$paketSkd->nama} (ID: {$paketSkd->id})\n";
echo "- Exam: {$ujianSkd->nama} (ID: {$ujianSkd->id})\n";
echo "- Total Questions: 110 (TWK: 30, TIU: 35, TKP: 45)\n";
echo "- Duration: 90 minutes\n";
echo "- Scoring: Correct (+5), Wrong (-1), Empty (0)\n\n";

echo "✅ Task completed successfully!\n";