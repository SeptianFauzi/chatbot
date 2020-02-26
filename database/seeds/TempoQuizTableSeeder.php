<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TempoQuizTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $urlImage = env("URL_IMAGE");
        DB::table("tempo_quiz")->insert([
            [
                "keyword"=>"bola",
                "question" => "Apa sih nama tim terakhir yang lolos dari babak Kualifikasi Euro 2020? Untuk tahu jawabannya kamu bisa klik http://bit.ly/2CXdruC",
                "option_a" => "A. Hungaria",
                "option_b" => "B. Kroasia",
                "option_c" => "C. Azerbaijan",
                "option_d" => "D. Wales",
                "asset" => $urlImage."/bola/",
                "answer" => "D"
            ],
            [
                "keyword"=>"foto",
                "question" => "Kamu tahu nggak tanggal berapakah Peringatan Hari Anak Sedunia? Untuk tahu jawabannya kamu bisa klik http://bit.ly/2QwHwcq",
                "option_a" => "A. 20 November",
                "option_b" => "B. 1 Desember",
                "option_c" => "C. 10 November",
                "option_d" => "D. 22 Desember",
                "asset" => $urlImage."/foto/",
                "answer" => "A"
            ],
            [
                "keyword"=>"infografis",
                "question" => "Berlaku mulai 1 Januari 2020, berapa persen jumlah kenaikan UMP? Untuk tahu jawabannya kamu bisa klik http://bit.ly/2O40rtv",
                "option_a" => "A. 9,14 Persen",
                "option_b" => "B. 7,26 Persen",
                "option_c" => "C. 8,51 Persen",
                "option_d" => "D. 8,72 Persen",
                "asset" => $urlImage."/infografis/",
                "answer" => "C"
            ],
            [
                "keyword"=>"travel",
                "question" => "Di Selatan Jakarta kita punya ruang kreatif yang asik untuk dijadikan tempat nogkrong dan baru diresmikan 26 September 2019 lalu, kamu tahu namanya apa?  Untuk tahu jawabannya kamu bisa klik http://bit.ly/2Qzxk2Q",
                "option_a" => "A. Skatepark Dukuh Atas",
                "option_b" => "B. M Bloc Space",
                "option_c" => "C. Taman Barito",
                "option_d" => "D. Taman Suropati",
                "asset" => $urlImage."/travel/",
                "answer" => "B"
            ],
            [
                "keyword"=>"otomotif",
                "question" => "Di Thailand Talent Cup Seri 6, pembalap ini sapu bersih podium juara, siapa nama pembalap tersebut? Untuk tahu jawabannya kamu bisa klik http://bit.ly/2Ow8MVD",
                "option_a" => "A. Herlian Dandi",
                "option_b" => "B. Azryan Dheo",
                "option_c" => "C. Dandy",
                "option_d" => "D. Indra",
                "asset" => $urlImage."/otomotif/",
                "answer" => "B"
            ],
            [
                "keyword"=>"dunia",
                "question" => "Presiden Pantai Gading ini mencalonkan diri ke-3 kali nya loh, siapa nama Presiden tersebut? Untuk tahu jawabannya kamu bisa klik http://bit.ly/2Ld7Jcm",
                "option_a" => "A. Guillaume Soro",
                "option_b" => "B. Laurent Gbagbo",
                "option_c" => "C. Henri Konan Bedie",
                "option_d" => "D. Alassane Ouattara",
                "asset" => $urlImage."/dunia/",
                "answer" => "D"
            ],
            [
                "keyword"=>"seleb",
                "question" => "Film animasi Spongebob Squarepants terbaru berjudul Sponge on the Run akan ditayangkan pada Mei 2020. Film tersebut melibatkan sejumlah pemain film terkenal sebagai pengisi suara. Keanu Reeves akan mengisi suara karakter akar tanaman bernama siapa? Untuk tahu jawabannya kamu bisa klik http://bit.ly/35jnciQ",
                "option_a" => "A. Tumbleweed",
                "option_b" => "B. Mr. Crab",
                "option_c" => "C. Sandy",
                "option_d" => "D. Patrick",
                "asset" => $urlImage."/seleb/",
                "answer" => "A"
            ],
            [
                "keyword"=>"tekno",
                "question" => "Mahasiswa IPB ini membuat aplikasi untuk membantu menurunkan Stunting, apa nama aplikasi tersebut? Untuk tahu jawabannya kamu bisa klik http://bit.ly/35jCnbJ",
                "option_a" => "A. Gizind",
                "option_b" => "B. Healthy",
                "option_c" => "C. Stunting One",
                "option_d" => "D. Stunting",
                "asset" => $urlImage."/tekno/",
                "answer" => "A"
            ],
            [
                "keyword"=>"bisnis",
                "question" => "Sejak tahun 2018 hingga Oktober 2019 OJK telah menghentikan aktivitas 1.773 financial technology (pinjaman online) ilegal, lalu sampai saat ini ada berapa Fintech yang mempunyai izin? Untuk tahu jawabannya kamu bisa klik http://bit.ly/2P2GPoL",
                "option_a" => "A. 140",
                "option_b" => "B. 67",
                "option_c" => "C. 13",
                "option_d" => "D. 45",
                "asset" => $urlImage."/bisnis/",
                "answer" => "C"
            ],
            [
                "keyword"=>"video",
                "question" => "Perayaan kelahiran Nabi Muhammad SAW diperingati dengan acara apa di Keraton Surakarta? Untuk tahu jawabannya kamu bisa klik http://bit.ly/2O6k4Bd",
                "option_a" => "A. Maulid Nabi",
                "option_b" => "B. Grebeg Maulid",
                "option_c" => "C. Maulid",
                "option_d" => "D. Shalawat Nabi",
                "asset" => $urlImage."/video/",
                "answer" => "B"
            ],
            [
                "keyword"=>"nasional",
                "question" => "Mendagri Tito Karnavian menyebut tengah mengkaji sejumlah opsi sebagai solusi atas evaluasi pemilihan kepala daerah atau Pilkada langsung. Salah satu opsi yang disebut Tito adalah Pilkada?Untuk tahu jawabannya kamu bisa klik http://bit.ly/2XuYmtw",
                "option_a" => "A. Serentak",
                "option_b" => "B. Langsung",
                "option_c" => "C. Asimetris",
                "option_d" => "D. Bersama",
                "asset" => $urlImage."/nasional/",
                "answer" => "C"
            ],
            [
                "keyword"=>"investigasi",
                "question" => "SELAMAT, KAMU LANGSUNG MASUK DALAM BOX UNDIAN",
                "option_a" => "-",
                "option_b" => "-",
                "option_c" => "-",
                "option_d" => "-",
                "asset" => "-",
                "answer" => "-"
            ],
            [
                "keyword"=>"metro",
                "question" => "SELAMAT, KAMU LANGSUNG MASUK DALAM BOX UNDIAN",
                "option_a" => "-",
                "option_b" => "-",
                "option_c" => "-",
                "option_d" => "-",
                "asset" => "-",
                "answer" => "-"
            ],
        ]);
    }
}
