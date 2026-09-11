<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        DB::table('users')->insert([
            'name'       => 'Administrator',
            'email'      => 'admin@smandas.sch.id',
            'password'   => Hash::make('smandas12'),
            'role'       => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Contoh siswa
        DB::table('users')->insert([
            'name'          => 'Budi Santoso',
            'nis'           => '2024001',
            'kelas'         => 'XI IPA 1',
            'jenis_kelamin' => 'L',
            'email'         => 'siswa@test.com',
            'password'      => Hash::make('password'),
            'role'          => 'siswa',
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);

        // ── Gejala ─────────────────────────────────────────────
        $gejala = [
            ['kode'=>'G01','nama'=>'Sulit berkonsentrasi saat belajar'],
            ['kode'=>'G02','nama'=>'Mudah lupa materi yang baru dipelajari'],
            ['kode'=>'G03','nama'=>'Sering merasa lelah meskipun sudah cukup tidur'],
            ['kode'=>'G04','nama'=>'Kesulitan tidur atau sering terbangun di malam hari'],
            ['kode'=>'G05','nama'=>'Mudah marah atau tersinggung tanpa alasan jelas'],
            ['kode'=>'G06','nama'=>'Merasa cemas atau khawatir berlebihan terhadap ujian'],
            ['kode'=>'G07','nama'=>'Sering sakit kepala atau pusing'],
            ['kode'=>'G08','nama'=>'Nafsu makan menurun atau meningkat drastis'],
            ['kode'=>'G09','nama'=>'Merasa tidak berdaya dan pesimis terhadap masa depan'],
            ['kode'=>'G10','nama'=>'Menarik diri dari pergaulan sosial (teman, keluarga)'],
            ['kode'=>'G11','nama'=>'Sering menunda-nunda tugas atau pekerjaan sekolah'],
            ['kode'=>'G12','nama'=>'Jantung berdebar-debar tanpa sebab yang jelas'],
            ['kode'=>'G13','nama'=>'Telapak tangan berkeringat saat menghadapi ujian'],
            ['kode'=>'G14','nama'=>'Merasa otot tegang, terutama di leher dan bahu'],
            ['kode'=>'G15','nama'=>'Sering mengeluh sakit perut atau gangguan pencernaan'],
            ['kode'=>'G16','nama'=>'Kehilangan minat pada hobi atau aktivitas yang biasa dinikmati'],
            ['kode'=>'G17','nama'=>'Sering menangis tanpa alasan yang jelas'],
            ['kode'=>'G18','nama'=>'Sulit mengambil keputusan meskipun untuk hal kecil'],
            ['kode'=>'G19','nama'=>'Merasa tidak mampu memenuhi ekspektasi orang tua/guru'],
            ['kode'=>'G20','nama'=>'Sering bermain HP/media sosial secara berlebihan sebagai pelarian'],
            ['kode'=>'G21','nama'=>'Prestasi akademik menurun secara signifikan'],
            ['kode'=>'G22','nama'=>'Sering absen atau malas masuk sekolah'],
            ['kode'=>'G23','nama'=>'Merasa takut gagal atau takut membuat malu keluarga'],
            ['kode'=>'G24','nama'=>'Pikiran terus berputar-putar dan tidak bisa berhenti memikirkan masalah'],
            ['kode'=>'G25','nama'=>'Mengalami perubahan perilaku yang mencolok (lebih pendiam/lebih agresif)'],
            ['kode'=>'G26','nama'=>'Sering merasa tidak bersemangat di pagi hari'],
            ['kode'=>'G27','nama'=>'Mengalami gangguan napas (sesak) saat menghadapi tekanan'],
            ['kode'=>'G28','nama'=>'Sering menghindari tugas kelompok atau presentasi di kelas'],
        ];
        foreach ($gejala as $g) {
            DB::table('gejala')->insert(array_merge($g, ['created_at'=>now(),'updated_at'=>now()]));
        }

        // ── Output ─────────────────────────────────────────────
        $output = [
            ['kode'=>'S1','tingkat'=>'Normal',
             'deskripsi'=>'Siswa berada pada kondisi psikologis yang sehat. Gejala stres yang muncul masih dalam batas wajar dan dapat dikelola secara mandiri.',
             'rekomendasi'=>'Pertahankan pola hidup sehat, tetap aktif berolahraga, dan jaga keseimbangan belajar-istirahat.',
             'warna'=>'#28a745'],
            ['kode'=>'S2','tingkat'=>'Stres Ringan',
             'deskripsi'=>'Siswa mengalami tekanan psikologis yang masih tergolong ringan. Beberapa gejala fisik dan emosional mulai muncul namun tidak mengganggu fungsi sehari-hari secara signifikan.',
             'rekomendasi'=>'Lakukan relaksasi ringan seperti teknik pernapasan, olahraga rutin, dan berdiskusi dengan teman atau keluarga. Kunjungi guru BK jika dibutuhkan.',
             'warna'=>'#17a2b8'],
            ['kode'=>'S3','tingkat'=>'Stres Sedang',
             'deskripsi'=>'Siswa mengalami stres pada level menengah. Gejala fisik dan emosional sudah cukup mengganggu aktivitas belajar dan hubungan sosial. Membutuhkan perhatian lebih lanjut.',
             'rekomendasi'=>'Disarankan segera berkonsultasi dengan guru Bimbingan Konseling (BK). Terapkan manajemen waktu yang lebih terstruktur dan hindari pemicu stres berlebih.',
             'warna'=>'#ffc107'],
            ['kode'=>'S4','tingkat'=>'Stres Berat',
             'deskripsi'=>'Siswa berada dalam kondisi stres tinggi yang berdampak nyata terhadap performa akademik, kesehatan fisik, dan kesehatan mental. Intervensi segera diperlukan.',
             'rekomendasi'=>'Wajib berkonsultasi dengan psikolog sekolah atau profesional kesehatan mental. Orang tua/wali perlu dilibatkan untuk memberikan dukungan penuh.',
             'warna'=>'#fd7e14'],
            ['kode'=>'S5','tingkat'=>'Stres Sangat Berat (Kritis)',
             'deskripsi'=>'Siswa mengalami krisis psikologis yang serius. Gejala sudah mengganggu seluruh aspek kehidupan dan berpotensi mengarah pada kondisi yang lebih berbahaya jika tidak segera ditangani.',
             'rekomendasi'=>'Penanganan segera oleh tenaga profesional (psikolog/psikiater) sangat diperlukan. Pihak sekolah, orang tua, dan tenaga medis harus berkoordinasi untuk memberikan intervensi komprehensif.',
             'warna'=>'#dc3545'],
        ];
        foreach ($output as $o) {
            DB::table('output_stres')->insert(array_merge($o, ['created_at'=>now(),'updated_at'=>now()]));
        }

        // ── Rules ──────────────────────────────────────────────
        $rules = [
            ['kode'=>'R01','output'=>'S2','gejala'=>['G01','G11']],
            ['kode'=>'R02','output'=>'S2','gejala'=>['G03','G26']],
            ['kode'=>'R03','output'=>'S2','gejala'=>['G06','G13']],
            ['kode'=>'R04','output'=>'S2','gejala'=>['G05','G18']],
            ['kode'=>'R05','output'=>'S2','gejala'=>['G07','G14']],
            ['kode'=>'R06','output'=>'S3','gejala'=>['G01','G02','G11']],
            ['kode'=>'R07','output'=>'S3','gejala'=>['G04','G07','G15']],
            ['kode'=>'R08','output'=>'S3','gejala'=>['G05','G06','G19']],
            ['kode'=>'R09','output'=>'S3','gejala'=>['G08','G16','G20']],
            ['kode'=>'R10','output'=>'S3','gejala'=>['G10','G22','G28']],
            ['kode'=>'R11','output'=>'S3','gejala'=>['G03','G04','G12','G14']],
            ['kode'=>'R12','output'=>'S3','gejala'=>['G06','G13','G23','G24']],
            ['kode'=>'R13','output'=>'S4','gejala'=>['G01','G02','G09','G21']],
            ['kode'=>'R14','output'=>'S4','gejala'=>['G04','G07','G12','G15','G27']],
            ['kode'=>'R15','output'=>'S4','gejala'=>['G05','G10','G17','G25']],
            ['kode'=>'R16','output'=>'S4','gejala'=>['G08','G16','G19','G22']],
            ['kode'=>'R17','output'=>'S4','gejala'=>['G06','G09','G21','G23','G24']],
            ['kode'=>'R18','output'=>'S4','gejala'=>['G11','G16','G20','G22','G25']],
            ['kode'=>'R19','output'=>'S4','gejala'=>['G03','G04','G07','G14','G15','G26']],
            ['kode'=>'R20','output'=>'S5','gejala'=>['G01','G02','G04','G09','G10','G17','G21','G24']],
            ['kode'=>'R21','output'=>'S5','gejala'=>['G05','G09','G12','G17','G19','G23','G25','G27']],
            ['kode'=>'R22','output'=>'S5','gejala'=>['G06','G09','G10','G16','G17','G22','G24']],
            ['kode'=>'R23','output'=>'S5','gejala'=>['G04','G07','G09','G12','G15','G17','G27']],
            ['kode'=>'R24','output'=>'S5','gejala'=>['G08','G09','G10','G16','G21','G22','G25']],
            ['kode'=>'R25','output'=>'S5','gejala'=>['G01','G03','G04','G09','G17','G21','G23','G24','G25']],
            ['kode'=>'R26','output'=>'S1','gejala'=>['G01','G03','G04','G05','G06','G07','G09'],'negasi'=>true],
            ['kode'=>'R27','output'=>'S3','gejala'=>['G13','G23','G28']],
            ['kode'=>'R28','output'=>'S3','gejala'=>['G02','G11','G18','G20']],
            ['kode'=>'R29','output'=>'S4','gejala'=>['G10','G17','G19','G25','G22']],
            ['kode'=>'R30','output'=>'S5','gejala'=>['G24','G25','G27','G09','G12','G16']],
        ];

        foreach ($rules as $r) {
            $ruleId = DB::table('rules')->insertGetId([
                'kode'        => $r['kode'],
                'output_kode' => $r['output'],
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
            $negasi = $r['negasi'] ?? false;
            foreach ($r['gejala'] as $g) {
                DB::table('rule_gejala')->insert([
                    'rule_id'    => $ruleId,
                    'gejala_kode'=> $g,
                    'is_negasi'  => $negasi,
                ]);
            }
        }
    }
}