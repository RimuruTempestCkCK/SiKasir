<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\StockLog;
use App\Models\Store;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // =============================================
        // 1. CREATE ADMIN
        // =============================================
        User::firstOrCreate(
            ['email' => 'admin@sikasir.com'],
            [
                'name'     => 'Admin SiKasir',
                'password' => Hash::make('password'),
                'role'     => 'admin',
            ]
        );

        // =============================================
        // 2. STORE DATA (20 TOKO)
        // =============================================
        $storeData = [

            // ─────────────────────────────────────────
            // TOKO 1 – Sembako Jaya (Retail)
            // ─────────────────────────────────────────
            [
                'name'           => 'Toko Sembako Jaya',
                'address'        => 'Jl. Pahlawan No. 12, Depok',
                'phone'          => '081234560001',
                'pimpinan_name'  => 'Budi Santoso',
                'pimpinan_email' => 'budi.santoso@sembakojaya.com',
                'kasirs'         => [
                    ['name' => 'Dewi Rahayu',   'email' => 'dewi.rahayu@gmail.com'],
                    ['name' => 'Eko Prasetyo',  'email' => 'eko.prasetyo@gmail.com'],
                    ['name' => 'Fitri Lestari', 'email' => 'fitri.lestari@gmail.com'],
                ],
                'type' => 'Retail',
                'categories' => [
                    'Beras & Biji-bijian' => [
                        ['name' => 'Beras Premium 5kg',              'price' => 75000,  'purchase_price' => 62000, 'stock' => 300],
                        ['name' => 'Beras Merah Organik 2kg',        'price' => 38000,  'purchase_price' => 30000, 'stock' => 150],
                        ['name' => 'Beras Putih Rojolele 5kg',       'price' => 68000,  'purchase_price' => 55000, 'stock' => 200],
                        ['name' => 'Jagung Pipil 1kg',               'price' => 12000,  'purchase_price' => 9000,  'stock' => 250],
                        ['name' => 'Kacang Hijau 500gr',             'price' => 15000,  'purchase_price' => 12000, 'stock' => 180],
                        ['name' => 'Kedelai 1kg',                    'price' => 18000,  'purchase_price' => 14500, 'stock' => 120],
                        ['name' => 'Beras Basmati 1kg',              'price' => 32000,  'purchase_price' => 25000, 'stock' => 100],
                        ['name' => 'Beras Ketan Putih 1kg',          'price' => 22000,  'purchase_price' => 18000, 'stock' => 160],
                    ],
                    'Minyak & Lemak' => [
                        ['name' => 'Minyak Goreng Bimoli 2L',        'price' => 35000,  'purchase_price' => 29000, 'stock' => 400],
                        ['name' => 'Minyak Goreng Filma 2L',         'price' => 34000,  'purchase_price' => 28000, 'stock' => 350],
                        ['name' => 'Mentega Blue Band 200gr',        'price' => 12000,  'purchase_price' => 9500,  'stock' => 200],
                        ['name' => 'Margarin Simas 200gr',           'price' => 11000,  'purchase_price' => 8500,  'stock' => 180],
                        ['name' => 'Minyak Kelapa 500ml',            'price' => 25000,  'purchase_price' => 20000, 'stock' => 100],
                        ['name' => 'Minyak Goreng Tropical 2L',      'price' => 33000,  'purchase_price' => 27500, 'stock' => 320],
                        ['name' => 'Minyak Goreng SunCo 2L',         'price' => 36000,  'purchase_price' => 30000, 'stock' => 250],
                    ],
                    'Gula & Pemanis' => [
                        ['name' => 'Gula Pasir 1kg',                 'price' => 17000,  'purchase_price' => 14000, 'stock' => 500],
                        ['name' => 'Gula Merah 500gr',               'price' => 14000,  'purchase_price' => 11000, 'stock' => 200],
                        ['name' => 'Gula Aren 500gr',                'price' => 22000,  'purchase_price' => 17500, 'stock' => 150],
                        ['name' => 'Madu Murni 250ml',               'price' => 55000,  'purchase_price' => 45000, 'stock' => 80],
                        ['name' => 'Sirup Marjan Cocopandan 460ml',  'price' => 24000,  'purchase_price' => 19500, 'stock' => 120],
                        ['name' => 'Sirup ABC Melon 450ml',          'price' => 21000,  'purchase_price' => 16000, 'stock' => 140],
                    ],
                ],
            ],

            // ─────────────────────────────────────────
            // TOKO 2 – Warung Berkah Makmur (Grosir)
            // ─────────────────────────────────────────
            [
                'name'           => 'Warung Berkah Makmur',
                'address'        => 'Jl. Merdeka No. 45, Bogor',
                'phone'          => '081234560002',
                'pimpinan_name'  => 'Siti Aminah',
                'pimpinan_email' => 'siti.aminah@berkahmakmur.com',
                'kasirs'         => [
                    ['name' => 'Hendra Wijaya',  'email' => 'hendra.wijaya@gmail.com'],
                    ['name' => 'Intan Permata',  'email' => 'intan.permata@gmail.com'],
                    ['name' => 'Jamal Harun',    'email' => 'jamal.harun@gmail.com'],
                ],
                'type' => 'Grosir',
                'categories' => [
                    'Sembako Pokok' => [
                        ['name' => 'Beras Cianjur 25kg',             'price' => 310000, 'purchase_price' => 285000, 'stock' => 200],
                        ['name' => 'Beras IR64 25kg',                'price' => 280000, 'purchase_price' => 255000, 'stock' => 180],
                        ['name' => 'Tepung Terigu Bogasari 25kg',    'price' => 185000, 'purchase_price' => 165000, 'stock' => 150],
                        ['name' => 'Gula Pasir 50kg',                'price' => 820000, 'purchase_price' => 780000, 'stock' => 100],
                        ['name' => 'Garam Kasar 1kg',                'price' => 8000,   'purchase_price' => 6000,   'stock' => 500],
                        ['name' => 'Minyak Goreng 5L',               'price' => 80000,  'purchase_price' => 72000,  'stock' => 250],
                        ['name' => 'Minyak Goreng 18L (Jerigen)',    'price' => 285000, 'purchase_price' => 260000, 'stock' => 50],
                    ],
                    'Mie & Pasta' => [
                        ['name' => 'Indomie Goreng 1 Dus (40pcs)',   'price' => 115000, 'purchase_price' => 105000, 'stock' => 200],
                        ['name' => 'Indomie Kuah 1 Dus (40pcs)',     'price' => 112000, 'purchase_price' => 102000, 'stock' => 200],
                        ['name' => 'Mie Sedaap Goreng Dus',          'price' => 108000, 'purchase_price' => 98000,  'stock' => 150],
                        ['name' => 'Mie Sedaap Soto Dus',            'price' => 105000, 'purchase_price' => 95000,  'stock' => 150],
                        ['name' => 'Supermi Kaldu Ayam Dus',         'price' => 102000, 'purchase_price' => 92000,  'stock' => 100],
                    ],
                ],
            ],

            // ─────────────────────────────────────────
            // TOKO 3 – Minimarket Sejahtera (Retail)
            // ─────────────────────────────────────────
            [
                'name'           => 'Minimarket Sejahtera',
                'address'        => 'Jl. Sudirman No. 88, Bekasi',
                'phone'          => '081234560003',
                'pimpinan_name'  => 'Agus Kurniawan',
                'pimpinan_email' => 'agus.kurniawan@sejahteramart.com',
                'kasirs'         => [
                    ['name' => 'Joko Susilo',    'email' => 'joko.susilo@gmail.com'],
                    ['name' => 'Kartini Dewi',   'email' => 'kartini.dewi@gmail.com'],
                    ['name' => 'Lukman Hakim',   'email' => 'lukman.hakim@gmail.com'],
                    ['name' => 'Maya Sari',      'email' => 'maya.sari@gmail.com'],
                ],
                'type' => 'Retail',
                'categories' => [
                    'Makanan Instan' => [
                        ['name' => 'Indomie Goreng Spesial',         'price' => 3500,   'purchase_price' => 2800,   'stock' => 800],
                        ['name' => 'Indomie Soto Ayam',              'price' => 3500,   'purchase_price' => 2800,   'stock' => 700],
                        ['name' => 'Sarimi Isi 2 Soto',             'price' => 4000,   'purchase_price' => 3200,   'stock' => 500],
                        ['name' => 'Mie Sedaap Goreng',              'price' => 3500,   'purchase_price' => 2800,   'stock' => 600],
                        ['name' => 'Pop Mie Rasa Ayam',              'price' => 5500,   'purchase_price' => 4200,   'stock' => 300],
                        ['name' => 'Pop Mie Rasa Baso',              'price' => 5500,   'purchase_price' => 4200,   'stock' => 300],
                    ],
                    'Minuman Segar' => [
                        ['name' => 'Aqua 600ml',                     'price' => 5000,   'purchase_price' => 3500,   'stock' => 800],
                        ['name' => 'Le Minerale 600ml',              'price' => 4500,   'purchase_price' => 3200,   'stock' => 700],
                        ['name' => 'Teh Botol Sosro 450ml',          'price' => 7000,   'purchase_price' => 5000,   'stock' => 400],
                        ['name' => 'Pocari Sweat 500ml',             'price' => 8500,   'purchase_price' => 6500,   'stock' => 300],
                        ['name' => 'Coca Cola 390ml',                'price' => 6000,   'purchase_price' => 4500,   'stock' => 250],
                        ['name' => 'Susu Ultra Milk 250ml',          'price' => 6500,   'purchase_price' => 5200,   'stock' => 500],
                    ],
                ],
            ],

            // ─────────────────────────────────────────
            // TOKO 4 – Herbal & Organik Nusantara (Retail)
            // ─────────────────────────────────────────
            [
                'name'           => 'Toko Herbal & Organik Nusantara',
                'address'        => 'Jl. Diponegoro No. 21, Bandung',
                'phone'          => '081234560004',
                'pimpinan_name'  => 'Retno Wulandari',
                'pimpinan_email' => 'retno.wulandari@herbalnusantara.com',
                'kasirs'         => [
                    ['name' => 'Novi Andriani',  'email' => 'novi.andriani@gmail.com'],
                    ['name' => 'Oki Setiawan',   'email' => 'oki.setiawan@gmail.com'],
                    ['name' => 'Peni Rahayu',    'email' => 'peni.rahayu@gmail.com'],
                ],
                'type' => 'Retail',
                'categories' => [
                    'Herbal & Jamu' => [
                        ['name' => 'Jamu Kunyit Asam Nyonya Meneer', 'price' => 8000,  'purchase_price' => 6000,   'stock' => 400],
                        ['name' => 'Jamu Tolak Angin Sido Muncul',   'price' => 5000,  'purchase_price' => 4000,   'stock' => 600],
                        ['name' => 'Madu Pramuka 500ml',             'price' => 125000, 'purchase_price' => 100000, 'stock' => 50],
                        ['name' => 'Sari Kurma Al-Jazira',           'price' => 45000,  'purchase_price' => 35000, 'stock' => 100],
                        ['name' => 'Habbatussauda 100 Kapsul',       'price' => 65000,  'purchase_price' => 50000, 'stock' => 150],
                    ],
                    'Organik' => [
                        ['name' => 'Garam Himalaya 500gr',           'price' => 35000,  'purchase_price' => 25000, 'stock' => 80],
                        ['name' => 'Chia Seed 250gr',                'price' => 45000,  'purchase_price' => 32000, 'stock' => 60],
                    ],
                ],
            ],

            // ─────────────────────────────────────────
            // TOKO 5 – Maju Teknologi (Retail)
            // ─────────────────────────────────────────
            [
                'name'           => 'Elektronik & Aksesori Maju Teknologi',
                'address'        => 'Jl. Gatot Subroto No. 55, Tangerang',
                'phone'          => '081234560005',
                'pimpinan_name'  => 'Prasetyo Wibowo',
                'pimpinan_email' => 'prasetyo.wibowo@majuteknologi.com',
                'kasirs'         => [
                    ['name' => 'Qori Fatimah',   'email' => 'qori.fatimah@gmail.com'],
                    ['name' => 'Rizal Mahmud',   'email' => 'rizal.mahmud@gmail.com'],
                    ['name' => 'Sari Indah',     'email' => 'sari.indah@gmail.com'],
                ],
                'type' => 'Retail',
                'categories' => [
                    'Aksesori HP' => [
                        ['name' => 'Kabel Data USB Type-C 1m',      'price' => 25000,  'purchase_price' => 15000,  'stock' => 500],
                        ['name' => 'Kabel Lightning iPhone 1m',      'price' => 35000,  'purchase_price' => 22000,  'stock' => 300],
                        ['name' => 'Powerbank 10000mAh Anker',       'price' => 350000, 'purchase_price' => 280000, 'stock' => 50],
                        ['name' => 'Charger Samsung 25W Original',   'price' => 225000, 'purchase_price' => 180000, 'stock' => 100],
                        ['name' => 'Headset JBL Tune 110',           'price' => 150000, 'purchase_price' => 110000, 'stock' => 150],
                    ],
                    'Komputer' => [
                        ['name' => 'Mouse Logitech M170 Wireless',   'price' => 165000, 'purchase_price' => 125000, 'stock' => 80],
                        ['name' => 'Keyboard Logitech K120',         'price' => 135000, 'purchase_price' => 100000, 'stock' => 60],
                    ],
                ],
            ],

            // ─────────────────────────────────────────
            // TOKO 6 – Sehat Selalu (Retail)
            // ─────────────────────────────────────────
            [
                'name'           => 'Apotek & Toko Kesehatan Sehat Selalu',
                'address'        => 'Jl. Ahmad Yani No. 33, Surabaya',
                'phone'          => '081234560006',
                'pimpinan_name'  => 'Taufik Hidayat',
                'pimpinan_email' => 'taufik.hidayat@sehatselalu.com',
                'kasirs'         => [
                    ['name' => 'Uswatun Hasanah',  'email' => 'uswatun.hasanah@gmail.com'],
                    ['name' => 'Vina Oktaviani',   'email' => 'vina.oktaviani@gmail.com'],
                    ['name' => 'Wahyu Nugroho',    'email' => 'wahyu.nugroho@gmail.com'],
                ],
                'type' => 'Retail',
                'categories' => [
                    'Obat Bebas' => [
                        ['name' => 'Paracetamol 500mg 10 Tab',      'price' => 6000,   'purchase_price' => 4000,   'stock' => 600],
                        ['name' => 'Panadol Extra 10 Tab',           'price' => 12000,  'purchase_price' => 9500,   'stock' => 300],
                        ['name' => 'Bodrex 20 Tab',                  'price' => 10000,  'purchase_price' => 8000,   'stock' => 400],
                        ['name' => 'Promag 12 Tablet',               'price' => 9000,   'purchase_price' => 7000,   'stock' => 500],
                    ],
                    'Vitamin' => [
                        ['name' => 'Enervon C 30 Tablet',            'price' => 45000,  'purchase_price' => 35000,  'stock' => 200],
                        ['name' => 'Sangobion 10 Kapsul',            'price' => 25000,  'purchase_price' => 20000,  'stock' => 150],
                    ],
                ],
            ],

            // ─────────────────────────────────────────
            // TOKO 7 – Butik Indah (Retail)
            // ─────────────────────────────────────────
            [
                'name'           => 'Butik Fashion Indah Berseri',
                'address'        => 'Jl. Kebon Jeruk No. 17, Jakarta Barat',
                'phone'          => '081234560007',
                'pimpinan_name'  => 'Indah Permatasari',
                'pimpinan_email' => 'indah.permatasari@butikindah.com',
                'kasirs'         => [
                    ['name' => 'Yuni Astuti',    'email' => 'yuni.astuti@gmail.com'],
                    ['name' => 'Zainal Arifin',  'email' => 'zainal.arifin@gmail.com'],
                    ['name' => 'Ayu Lestari',    'email' => 'ayu.lestari@gmail.com'],
                ],
                'type' => 'Retail',
                'categories' => [
                    'Pakaian Wanita' => [
                        ['name' => 'Blus Batik Tulis Pekalongan',   'price' => 185000, 'purchase_price' => 145000, 'stock' => 80],
                        ['name' => 'Gamis Syar\'i Premium',          'price' => 350000, 'purchase_price' => 280000, 'stock' => 50],
                        ['name' => 'Rok Plisket Panjang',            'price' => 95000,  'purchase_price' => 70000,  'stock' => 120],
                        ['name' => 'Jilbab Bella Square',            'price' => 25000,  'purchase_price' => 15000,  'stock' => 500],
                    ],
                    'Pakaian Pria' => [
                        ['name' => 'Kemeja Koko Lengan Panjang',     'price' => 165000, 'purchase_price' => 130000, 'stock' => 100],
                        ['name' => 'Celana Chino Pria',              'price' => 185000, 'purchase_price' => 140000, 'stock' => 80],
                    ],
                ],
            ],

            // ─────────────────────────────────────────
            // TOKO 8 – Kokoh Jaya (Retail)
            // ─────────────────────────────────────────
            [
                'name'           => 'Toko Bangunan & Material Kokoh Jaya',
                'address'        => 'Jl. Raya Serpong No. 99, Tangerang Selatan',
                'phone'          => '081234560008',
                'pimpinan_name'  => 'Bambang Sudirman',
                'pimpinan_email' => 'bambang.sudirman@kokohjaya.com',
                'kasirs'         => [
                    ['name' => 'Candra Purnama',  'email' => 'candra.purnama@gmail.com'],
                    ['name' => 'Diah Ayu',        'email' => 'diah.ayu@gmail.com'],
                    ['name' => 'Endang Saputra',  'email' => 'endang.saputra@gmail.com'],
                ],
                'type' => 'Retail',
                'categories' => [
                    'Semen & Pasir' => [
                        ['name' => 'Semen Tiga Roda 50kg',          'price' => 62000,  'purchase_price' => 58000,  'stock' => 300],
                        ['name' => 'Semen Gresik 50kg',              'price' => 60000,  'purchase_price' => 56000,  'stock' => 300],
                        ['name' => 'Pasir Bangka 1 Kijang',          'price' => 450000, 'purchase_price' => 380000, 'stock' => 20],
                    ],
                    'Cat & Finishing' => [
                        ['name' => 'Cat Dulux Pentalite 2.5L White', 'price' => 245000, 'purchase_price' => 210000, 'stock' => 50],
                        ['name' => 'Cat Avian Kayu & Besi 1kg Black','price' => 75000,  'purchase_price' => 62000,  'stock' => 100],
                    ],
                ],
            ],

            // ─────────────────────────────────────────
            // TOKO 9 – Cerdas Bangsa (Retail)
            // ─────────────────────────────────────────
            [
                'name'           => 'Toko Buku & ATK Cerdas Bangsa',
                'address'        => 'Jl. Pendidikan No. 5, Yogyakarta',
                'phone'          => '081234560009',
                'pimpinan_name'  => 'Sri Wahyuni',
                'pimpinan_email' => 'sri.wahyuni@cerdasbangsa.com',
                'kasirs'         => [
                    ['name' => 'Fajar Nugroho',  'email' => 'fajar.nugroho@gmail.com'],
                    ['name' => 'Galuh Purnama',  'email' => 'galuh.purnama@gmail.com'],
                ],
                'type' => 'Retail',
                'categories' => [
                    'Buku Pelajaran' => [
                        ['name' => 'Buku Matematika SMP Kelas 7',   'price' => 55000,  'purchase_price' => 45000,  'stock' => 150],
                        ['name' => 'Buku Bahasa Inggris SMA Kelas 10','price' => 65000, 'purchase_price' => 52000,  'stock' => 120],
                        ['name' => 'Kamus Inggris-Indonesia John Echols','price' => 125000, 'purchase_price' => 100000, 'stock' => 60],
                    ],
                    'Alat Tulis Kantor' => [
                        ['name' => 'Buku Tulis Sidu 38 Lembar (10pcs)','price' => 42000, 'purchase_price' => 35000,  'stock' => 300],
                        ['name' => 'Pulpen Snowman V-1 Black (12pcs)','price' => 30000, 'purchase_price' => 24000,  'stock' => 200],
                    ],
                ],
            ],

            // ─────────────────────────────────────────
            // TOKO 10 – Kuliner Lezat (Retail)
            // ─────────────────────────────────────────
            [
                'name'           => 'Toko Kuliner & Bahan Makanan Lezat',
                'address'        => 'Jl. Raya Kuliner No. 23, Semarang',
                'phone'          => '081234560010',
                'pimpinan_name'  => 'Heri Gunawan',
                'pimpinan_email' => 'heri.gunawan@kulinermaterial.com',
                'kasirs'         => [
                    ['name' => 'Ida Farida',     'email' => 'ida.farida@gmail.com'],
                    ['name' => 'Jati Wibowo',    'email' => 'jati.wibowo@gmail.com'],
                    ['name' => 'Kiki Amalia',    'email' => 'kiki.amalia@gmail.com'],
                ],
                'type' => 'Retail',
                'categories' => [
                    'Bahan Kopi & Minuman Kafe' => [
                        ['name' => 'Kopi Arabika Gayo 500gr',        'price' => 95000,  'purchase_price' => 80000,  'stock' => 150],
                        ['name' => 'Kopi Robusta Lampung 500gr',     'price' => 65000,  'purchase_price' => 52000,  'stock' => 200],
                        ['name' => 'Bubuk Green Tea Matcha 1kg',     'price' => 145000, 'purchase_price' => 120000, 'stock' => 80],
                        ['name' => 'Sirup Monin Vanilla 700ml',      'price' => 165000, 'purchase_price' => 140000, 'stock' => 40],
                    ],
                    'Snack Import' => [
                        ['name' => 'Pringles Original 107gr',        'price' => 24000,  'purchase_price' => 19000,  'stock' => 300],
                        ['name' => 'Kitkat Green Tea Japan',         'price' => 55000,  'purchase_price' => 42000,  'stock' => 100],
                    ],
                ],
            ],

            // ─────────────────────────────────────────
            // TOKO 11 – Lulu Pet Shop (Retail)
            // ─────────────────────────────────────────
            [
                'name'           => 'Lulu Pet Shop & Care',
                'address'        => 'Jl. Anggrek No. 42, Malang',
                'phone'          => '081234560011',
                'pimpinan_name'  => 'Lulu Atika',
                'pimpinan_email' => 'lulu.atika@lulupetshop.com',
                'kasirs'         => [
                    ['name' => 'Mita Sari',      'email' => 'mita.sari@gmail.com'],
                    ['name' => 'Nanang Kosim',   'email' => 'nanang.kosim@gmail.com'],
                ],
                'type' => 'Retail',
                'categories' => [
                    'Makanan Kucing' => [
                        ['name' => 'Whiskas Adult Tuna 1.2kg',       'price' => 65000,  'purchase_price' => 55000, 'stock' => 100],
                        ['name' => 'Royal Canin Kitten 2kg',         'price' => 285000, 'purchase_price' => 245000, 'stock' => 40],
                        ['name' => 'Me-O Cat Food Salmon 1.1kg',     'price' => 58000,  'purchase_price' => 48000, 'stock' => 120],
                    ],
                    'Aksesori Hewan' => [
                        ['name' => 'Pasir Kucing Gumpal 10L',        'price' => 75000,  'purchase_price' => 55000, 'stock' => 200],
                        ['name' => 'Shampoo Kucing Antijamur 250ml', 'price' => 45000,  'purchase_price' => 35000, 'stock' => 80],
                    ],
                ],
            ],

            // ─────────────────────────────────────────
            // TOKO 12 – Sport Station (Retail)
            // ─────────────────────────────────────────
            [
                'name'           => 'Sport Station Nusantara',
                'address'        => 'Jl. Stadion No. 1, Solo',
                'phone'          => '081234560012',
                'pimpinan_name'  => 'Bambang Pamungkas',
                'pimpinan_email' => 'bambang.pamungkas@sportstation.com',
                'kasirs'         => [
                    ['name' => 'Oky Setiawan',   'email' => 'oky.setiawan@gmail.com'],
                    ['name' => 'Putra Pratama',  'email' => 'putra.pratama@gmail.com'],
                ],
                'type' => 'Retail',
                'categories' => [
                    'Sepak Bola & Futsal' => [
                        ['name' => 'Bola Sepak Adidas Al Rihla',     'price' => 350000, 'purchase_price' => 280000, 'stock' => 50],
                        ['name' => 'Sepatu Futsal Specs Lightspeed', 'price' => 499000, 'purchase_price' => 410000, 'stock' => 30],
                        ['name' => 'Sarung Tangan Kiper Specs',      'price' => 225000, 'purchase_price' => 180000, 'stock' => 40],
                    ],
                    'Badminton' => [
                        ['name' => 'Raket Yonex Astrox 88D Play',    'price' => 750000, 'purchase_price' => 620000, 'stock' => 20],
                        ['name' => 'Shuttlecock Yonex AS2 (Slop)',   'price' => 285000, 'purchase_price' => 240000, 'stock' => 100],
                    ],
                ],
            ],

            // ─────────────────────────────────────────
            // TOKO 13 – Dunia Mainan (Retail)
            // ─────────────────────────────────────────
            [
                'name'           => 'Dunia Mainan Anak Ceria',
                'address'        => 'Jl. Kidul No. 10, Bali',
                'phone'          => '081234560013',
                'pimpinan_name'  => 'Kadek Devi',
                'pimpinan_email' => 'kadek.devi@duniamainan.com',
                'kasirs'         => [
                    ['name' => 'Ratih Kumala',   'email' => 'ratih.kumala@gmail.com'],
                    ['name' => 'Santi Wijaya',   'email' => 'santi.wijaya@gmail.com'],
                ],
                'type' => 'Retail',
                'categories' => [
                    'Mainan Edukasi' => [
                        ['name' => 'LEGO Classic Bricks 150pcs',     'price' => 250000, 'purchase_price' => 210000, 'stock' => 60],
                        ['name' => 'Puzzle Kayu Huruf & Angka',      'price' => 45000,  'purchase_price' => 32000, 'stock' => 150],
                        ['name' => 'Pasir Kinetik 1kg + Cetakan',    'price' => 65000,  'purchase_price' => 45000, 'stock' => 100],
                    ],
                    'Mainan Kendaraan' => [
                        ['name' => 'Hot Wheels Basic Car (Assorted)','price' => 35000,  'purchase_price' => 22000, 'stock' => 500],
                        ['name' => 'Mobil Remote Control Rock Crawler','price' => 325000, 'purchase_price' => 260000, 'stock' => 30],
                    ],
                ],
            ],

            // ─────────────────────────────────────────
            // TOKO 14 – Glow Up (Retail)
            // ─────────────────────────────────────────
            [
                'name'           => 'Glow Up Beauty Store',
                'address'        => 'Jl. Melati No. 8, Palembang',
                'phone'          => '081234560014',
                'pimpinan_name'  => 'Siska Kohl',
                'pimpinan_email' => 'siska.kohl@glowupbeauty.com',
                'kasirs'         => [
                    ['name' => 'Tania Putri',    'email' => 'tania.putri@gmail.com'],
                    ['name' => 'Ulya Rahma',     'email' => 'ulya.rahma@gmail.com'],
                ],
                'type' => 'Retail',
                'categories' => [
                    'Skincare' => [
                        ['name' => 'Sunscreen Azarine SPF 45',       'price' => 65000,  'purchase_price' => 52000, 'stock' => 120],
                        ['name' => 'Scarlett Whitening Body Lotion', 'price' => 75000,  'purchase_price' => 60000, 'stock' => 200],
                        ['name' => 'Serum Whitelab Brightening',     'price' => 85000,  'purchase_price' => 68000, 'stock' => 150],
                        ['name' => 'Cetaphil Gentle Cleanser 250ml', 'price' => 145000, 'purchase_price' => 120000, 'stock' => 80],
                    ],
                    'Makeup' => [
                        ['name' => 'Lip Cream Wardah Velvet',        'price' => 55000,  'purchase_price' => 42000, 'stock' => 300],
                        ['name' => 'Maybelline Mascara Sky High',    'price' => 125000, 'purchase_price' => 100000, 'stock' => 100],
                    ],
                ],
            ],

            // ─────────────────────────────────────────
            // TOKO 15 – Sumber Plastik (Grosir)
            // ─────────────────────────────────────────
            [
                'name'           => 'Sumber Plastik & Packaging',
                'address'        => 'Jl. Industri No. 5, Makassar',
                'phone'          => '081234560015',
                'pimpinan_name'  => 'Vicky Prasetyo',
                'pimpinan_email' => 'vicky.prasetyo@sumberplastik.com',
                'kasirs'         => [
                    ['name' => 'Wawan Gunawan',  'email' => 'wawan.gunawan@gmail.com'],
                    ['name' => 'Xena Warrior',   'email' => 'xena.warrior@gmail.com'],
                ],
                'type' => 'Grosir',
                'categories' => [
                    'Kantong Plastik' => [
                        ['name' => 'Plastik Kresek Putih 15 (1pak)', 'price' => 12000,  'purchase_price' => 9000,  'stock' => 500],
                        ['name' => 'Plastik Kresek Hitam 24 (1pak)', 'price' => 18000,  'purchase_price' => 14000, 'stock' => 500],
                        ['name' => 'Plastik Sampah Besar (10pcs)',   'price' => 25000,  'purchase_price' => 18000, 'stock' => 300],
                    ],
                    'Packaging Makanan' => [
                        ['name' => 'Kotak Makan Styrofoam (100pcs)', 'price' => 45000,  'purchase_price' => 35000, 'stock' => 200],
                        ['name' => 'Paper Bowl 500ml (50pcs)',       'price' => 55000,  'purchase_price' => 42000, 'stock' => 150],
                    ],
                ],
            ],

            // ─────────────────────────────────────────
            // TOKO 16 – Oleh-oleh (Retail)
            // ─────────────────────────────────────────
            [
                'name'           => 'Pusat Oleh-oleh Khas Nusantara',
                'address'        => 'Jl. Malioboro No. 101, Yogyakarta',
                'phone'          => '081234560016',
                'pimpinan_name'  => 'Yulia Rahman',
                'pimpinan_email' => 'yulia.rahman@oleholehnusantara.com',
                'kasirs'         => [
                    ['name' => 'Zizi Zubaidah',  'email' => 'zizi.zubaidah@gmail.com'],
                    ['name' => 'Ani Lestari',    'email' => 'ani.stari@gmail.com'],
                ],
                'type' => 'Retail',
                'categories' => [
                    'Makanan Khas' => [
                        ['name' => 'Bakpia Pathok 25 Keju',          'price' => 45000,  'purchase_price' => 35000, 'stock' => 200],
                        ['name' => 'Bakpia Pathok 25 Kacang Hijau',  'price' => 42000,  'purchase_price' => 32000, 'stock' => 200],
                        ['name' => 'Gudeg Kaleng Yu Djum Original',  'price' => 48000,  'purchase_price' => 38000, 'stock' => 150],
                        ['name' => 'Pia Legong Bali Keju',           'price' => 125000, 'purchase_price' => 100000, 'stock' => 80],
                    ],
                    'Camilan Tradisional' => [
                        ['name' => 'Keripik Tempe Sagu 250gr',       'price' => 25000,  'purchase_price' => 18000, 'stock' => 300],
                        ['name' => 'Emping Jagung Pedas Manis',      'price' => 22000,  'purchase_price' => 15000, 'stock' => 300],
                    ],
                ],
            ],

            // ─────────────────────────────────────────
            // TOKO 17 – Maju Motor (Retail)
            // ─────────────────────────────────────────
            [
                'name'           => 'Bengkel Maju Motor & Parts',
                'address'        => 'Jl. Otomotif No. 7, Jakarta Timur',
                'phone'          => '081234560017',
                'pimpinan_name'  => 'Rizky Febian',
                'pimpinan_email' => 'rizky.febian@majumotor.com',
                'kasirs'         => [
                    ['name' => 'Baim Wong',      'email' => 'baim.wong@gmail.com'],
                    ['name' => 'Citra Kirana',   'email' => 'citra.kirana@gmail.com'],
                ],
                'type' => 'Retail',
                'categories' => [
                    'Suku Cadang' => [
                        ['name' => 'Oli Mesin Shell Helix 1L',       'price' => 125000, 'purchase_price' => 105000, 'stock' => 80],
                        ['name' => 'Oli Motor Yamalube Matic 0.8L',  'price' => 55000,  'purchase_price' => 45000,  'stock' => 150],
                        ['name' => 'Busi NGK Iridium',               'price' => 110000, 'purchase_price' => 85000,  'stock' => 200],
                        ['name' => 'Aki Motor GS Astra MF',          'price' => 245000, 'purchase_price' => 210000, 'stock' => 40],
                    ],
                    'Aksesori Motor' => [
                        ['name' => 'Helm KYT DJ Maru Solid',         'price' => 325000, 'purchase_price' => 275000, 'stock' => 30],
                        ['name' => 'Spion Tomok Rizoma Style',       'price' => 185000, 'purchase_price' => 140000, 'stock' => 50],
                    ],
                ],
            ],

            // ─────────────────────────────────────────
            // TOKO 18 – Kilau Indah (Retail)
            // ─────────────────────────────────────────
            [
                'name'           => 'Kilau Indah Jewelry',
                'address'        => 'Jl. Emas No. 22, Medan',
                'phone'          => '081234560018',
                'pimpinan_name'  => 'Dian Sastro',
                'pimpinan_email' => 'dian.sastro@kilauindah.com',
                'kasirs'         => [
                    ['name' => 'Erica Putri',    'email' => 'erica.putri@gmail.com'],
                    ['name' => 'Fadly Faisal',   'email' => 'fadly.faisal@gmail.com'],
                ],
                'type' => 'Retail',
                'categories' => [
                    'Aksesori Perak' => [
                        ['name' => 'Kalung Perak 925 Rantai',        'price' => 250000, 'purchase_price' => 180000, 'stock' => 30],
                        ['name' => 'Cincin Perak Permata Zirconia',  'price' => 185000, 'purchase_price' => 135000, 'stock' => 50],
                        ['name' => 'Gelang Perak Model Bangle',      'price' => 320000, 'purchase_price' => 240000, 'stock' => 20],
                    ],
                    'Aksesori Emas Muda' => [
                        ['name' => 'Anting Emas Muda 375 (1gr)',     'price' => 650000, 'purchase_price' => 580000, 'stock' => 15],
                    ],
                ],
            ],

            // ─────────────────────────────────────────
            // TOKO 19 – Cepat Copy (Retail)
            // ─────────────────────────────────────────
            [
                'name'           => 'Cepat Copy & Stationery',
                'address'        => 'Jl. Kampus No. 3, Padang',
                'phone'          => '081234560019',
                'pimpinan_name'  => 'Gading Marten',
                'pimpinan_email' => 'gading.marten@cepatcopy.com',
                'kasirs'         => [
                    ['name' => 'Hana Saraswati', 'email' => 'hana.saraswati@gmail.com'],
                    ['name' => 'Ivan Gunawan',   'email' => 'ivan.gunawan@gmail.com'],
                ],
                'type' => 'Retail',
                'categories' => [
                    'Kertas & Tinta' => [
                        ['name' => 'Kertas HVS A4 80gr 1 Box',       'price' => 325000, 'purchase_price' => 285000, 'stock' => 20],
                        ['name' => 'Kertas HVS F4 70gr 1 Rim',       'price' => 55000,  'purchase_price' => 48000,  'stock' => 100],
                        ['name' => 'Tinta Epson 003 Black',          'price' => 95000,  'purchase_price' => 80000,  'stock' => 50],
                        ['name' => 'Tinta Epson 003 Cyan/Mag/Yel',   'price' => 95000,  'purchase_price' => 80000,  'stock' => 60],
                    ],
                    'Alat Kantor' => [
                        ['name' => 'Stopmap Folio (50pcs)',          'price' => 45000,  'purchase_price' => 35000,  'stock' => 150],
                        ['name' => 'Stapler Kangaro HP-45',          'price' => 85000,  'purchase_price' => 65000,  'stock' => 40],
                    ],
                ],
            ],

            // ─────────────────────────────────────────
            // TOKO 20 – Rumah Nyaman (Retail)
            // ─────────────────────────────────────────
            [
                'name'           => 'Rumah Nyaman Furniture',
                'address'        => 'Jl. Interior No. 15, Denpasar',
                'phone'          => '081234560020',
                'pimpinan_name'  => 'Jessica Mila',
                'pimpinan_email' => 'jessica.mila@rumahnyaman.com',
                'kasirs'         => [
                    ['name' => 'Kevin Julio',    'email' => 'kevin.julio@gmail.com'],
                    ['name' => 'Lania Fira',     'email' => 'lania.fira@gmail.com'],
                ],
                'type' => 'Retail',
                'categories' => [
                    'Dapur' => [
                        ['name' => 'Wajan Anti Lengket 24cm',        'price' => 185000, 'purchase_price' => 145000, 'stock' => 40],
                        ['name' => 'Panci Presto 8L Maxim',          'price' => 450000, 'purchase_price' => 380000, 'stock' => 20],
                        ['name' => 'Satu Set Pisau Dapur Oxone',     'price' => 325000, 'purchase_price' => 260000, 'stock' => 30],
                    ],
                    'Ruang Tamu' => [
                        ['name' => 'Lampu Hias Minimalis Stand',     'price' => 550000, 'purchase_price' => 450000, 'stock' => 15],
                        ['name' => 'Bantal Sofa 40x40 Canvas',       'price' => 65000,  'purchase_price' => 45000,  'stock' => 100],
                    ],
                ],
            ],
        ];

        // =============================================
        // 3. SEED EACH STORE
        // =============================================
        foreach ($storeData as $index => $data) {

            // Create Pimpinan / Owner
            $pimpinan = User::where('name', $data['pimpinan_name'])
                            ->where('role', 'pimpinan')
                            ->first();

            if ($pimpinan) {
                $pimpinan->update(['email' => $data['pimpinan_email']]);
            } else {
                $pimpinan = User::firstOrCreate(
                    ['email' => $data['pimpinan_email']],
                    [
                        'name'     => $data['pimpinan_name'],
                        'password' => Hash::make('password'),
                        'role'     => 'pimpinan',
                    ]
                );
            }

            // Create Store
            $store = Store::firstOrCreate(
                ['user_id' => $pimpinan->id],
                [
                    'name'    => $data['name'],
                    'address' => $data['address'],
                    'phone'   => $data['phone'],
                    'type'    => $data['type'],
                ]
            );

            $pimpinan->update(['store_id' => $store->id]);

            // Create Kasirs
            $kasirs = [];
            foreach ($data['kasirs'] as $kasirData) {
                $kasir = User::where('name', $kasirData['name'])
                             ->where('store_id', $store->id)
                             ->where('role', 'kasir')
                             ->first();

                if ($kasir) {
                    $kasir->update(['email' => $kasirData['email']]);
                } else {
                    $kasir = User::firstOrCreate(
                        ['email' => $kasirData['email']],
                        [
                            'name'     => $kasirData['name'],
                            'password' => Hash::make('password'),
                            'role'     => 'kasir',
                            'store_id' => $store->id,
                        ]
                    );
                }
                $kasirs[] = $kasir;
            }

            // =============================================
            // 4. GENERATE MASSIVE PRODUCTS
            // =============================================
            $allProductsData = [];
            $categoriesInStore = [];

            // A. Manual Products from Array
            foreach ($data['categories'] as $catName => $products) {
                $category = Category::firstOrCreate(['store_id' => $store->id, 'name' => $catName]);
                $categoriesInStore[$catName] = $category->id;

                foreach ($products as $prod) {
                    $exists = Product::where('store_id', $store->id)->where('name', $prod['name'])->exists();
                    if (!$exists) {
                        $purchasePrice = $prod['purchase_price'] ?? round($prod['price'] * 0.8);
                        $allProductsData[] = [
                            'store_id'       => $store->id,
                            'category_id'    => $category->id,
                            'name'           => $prod['name'],
                            'purchase_price' => $purchasePrice,
                            'selling_price'  => $prod['price'],
                            'stock'          => $prod['stock'],
                            'created_at'     => Carbon::now()->subDays(365),
                            'updated_at'     => Carbon::now()->subDays(365),
                        ];
                    }
                }
            }

            // B. Auto-Generated Additional Products
            $currentTotal = count($allProductsData) + Product::where('store_id', $store->id)->count();
            $targetCount = 200;

            if ($currentTotal < $targetCount) {
                $pool = [
                    'Sembako' => [
                        'Sabun' => ['Lifebuoy 80gr', 'Lux Soft Touch 85gr', 'Giv White 80gr', 'Biore Guard 80gr', 'Dettol Original 100gr', 'Nuvo Family 80gr'],
                        'Sampo' => ['Sunsilk Soft 170ml', 'Pantene Black 160ml', 'Clear Ice Cool 160ml', 'Dove Hair Fall 160ml', 'Zinc Anti Dandruff 170ml'],
                        'Deterjen' => ['Rinso Molto 800gr', 'So Klin Liquid 750ml', 'Attack Jaz1 850gr', 'Daia Putih 850gr', 'Boom Deterjen 800gr'],
                        'Snack' => ['Chitato Sapi Panggang', 'Qtela Singkong 185gr', 'Taro Net Seaweed', 'Kusuka Keripik 180gr', 'Oreo Vanilla 133gr', 'Silverqueen Almond 65gr', 'Beng-beng Share It', 'Pocky Chocolate'],
                        'Minuman' => ['Teh Pucuk Harum 350ml', 'Aqua Botol 1500ml', 'Mizone Blue 500ml', 'You C1000 Orange', 'Kopi Kapal Api 165gr', 'Luwak White Koffie 10s'],
                        'Bumbu' => ['Masako Ayam 250gr', 'Royco Sapi 230gr', 'Sasa MSG 250gr', 'Garam Refina 500gr', 'Kecap Bango 550ml', 'Saus ABC Sambal 335ml'],
                    ],
                    'Elektronik' => [
                        'Aksesori' => ['MicroSD Sandisk 32GB', 'Flashdisk Kingston 64GB', 'Baterai ABC Alkaline AA', 'Mousepad Gaming XL', 'Ring Light 26cm', 'Tripod HP 1m'],
                        'Kabel' => ['HDMI Cable 2m', 'AUX Cable 3.5mm', 'Extension Plug 3 Socket', 'VGA to HDMI Converter'],
                    ],
                    'Fashion' => [
                        'Atasan' => ['Kaos Polos Cotton Combed', 'Kemeja Flanel Kotak', 'Jaket Hoodie Polos', 'Sweater Rajut Wanita'],
                        'Bawahan' => ['Celana Jeans Denim', 'Celana Kulot Linen', 'Legging Spandex', 'Celana Pendek Chino'],
                    ],
                    'Obat' => [
                        'Suplemen' => ['Vitamin D3 1000IU', 'C-1000 mg 10 Tablet', 'Minyak Ikan Omega 3', 'Madu TJ Kurma'],
                        'P3K' => ['Hanyaplast 10s', 'Betadine 15ml', 'Alkohol 70% 100ml', 'Kapas Wajah 50gr'],
                    ],
                ];

                $selectedPool = $pool['Sembako'];
                if (str_contains($data['name'], 'Teknologi')) $selectedPool = $pool['Elektronik'];
                if (str_contains($data['name'], 'Fashion') || str_contains($data['name'], 'Butik')) $selectedPool = $pool['Fashion'];
                if (str_contains($data['name'], 'Sehat') || str_contains($data['name'], 'Apotek')) $selectedPool = $pool['Obat'];

                for ($i = $currentTotal + 1; $i <= $targetCount; $i++) {
                    $catName = array_rand($selectedPool);
                    $categoryId = $categoriesInStore[$catName] ?? Category::firstOrCreate(['store_id' => $store->id, 'name' => $catName])->id;
                    $categoriesInStore[$catName] = $categoryId;

                    $itemPool = $selectedPool[$catName];
                    $prodName = $itemPool[array_rand($itemPool)] . " (V" . str_pad($i, 2, '0', STR_PAD_LEFT) . ")";

                    $allProductsData[] = [
                        'store_id'       => $store->id,
                        'category_id'    => $categoryId,
                        'name'           => $prodName,
                        'purchase_price' => rand(5, 100) * 1000,
                        'selling_price'  => rand(110, 150) * 1000,
                        'stock'          => rand(100, 500),
                        'created_at'     => Carbon::now()->subDays(365),
                        'updated_at'     => Carbon::now()->subDays(365),
                    ];
                }
            }

            // Bulk Insert Products
            foreach (array_chunk($allProductsData, 100) as $chunk) {
                Product::insert($chunk);
            }

            // Get all products in store for transaction seeding
            $products = Product::where('store_id', $store->id)->get();
            $allProductIds = $products->pluck('id')->toArray();
            
            // =============================================
            // 5. CREATE MASSIVE TRANSACTIONS (365 HARI)
            // =============================================
            $existingTransCount = Transaction::where('store_id', $store->id)->count();

            if ($existingTransCount < 5000) { 
                $transactionsToInsert = [];
                $detailsToInsert = [];
                $invoiceCounter = $existingTransCount + 1;

                for ($d = 365; $d >= 0; $d--) {
                    $date = Carbon::now()->subDays($d);
                    $isWeekend = $date->isWeekend();
                    $dailyTransCount = $isWeekend ? rand(15, 30) : rand(5, 15);

                    for ($t = 1; $t <= $dailyTransCount; $t++) {
                        $cashier = $kasirs[array_rand($kasirs)];
                        $transTime = $date->copy()->addHours(rand(8, 21))->addMinutes(rand(0, 59));
                        
                        $numItems = rand(1, 5);
                        $selectedProds = $products->random(min($numItems, $products->count()));
                        
                        $totalPrice = 0;
                        $tempDetails = [];

                        foreach ($selectedProds as $prod) {
                            $qty = rand(1, 3);
                            $totalPrice += $prod->selling_price * $qty;
                            $tempDetails[] = [
                                'product_id'     => $prod->id,
                                'quantity'       => $qty,
                                'purchase_price' => $prod->purchase_price,
                                'selling_price'  => $prod->selling_price,
                                'created_at'     => $transTime,
                                'updated_at'     => $transTime,
                            ];
                        }

                        $amountPaid = ceil($totalPrice / 1000) * 1000;
                        if ($amountPaid < $totalPrice) $amountPaid += 1000;

                        // Insert transaction and get ID
                        $transactionId = \DB::table('transactions')->insertGetId([
                            'store_id'       => $store->id,
                            'user_id'        => $cashier->id,
                            'invoice_number' => 'INV-' . $store->id . '-' . $date->format('Ymd') . '-' . str_pad($invoiceCounter++, 5, '0', STR_PAD_LEFT),
                            'total_price'    => $totalPrice,
                            'amount_paid'    => $amountPaid,
                            'change'         => $amountPaid - $totalPrice,
                            'created_at'     => $transTime,
                            'updated_at'     => $transTime,
                        ]);

                        foreach ($tempDetails as $detail) {
                            $detail['transaction_id'] = $transactionId;
                            $detailsToInsert[] = $detail;
                        }

                        // Bulk insert details every 500 rows to keep memory low
                        if (count($detailsToInsert) >= 500) {
                            \DB::table('transaction_details')->insert($detailsToInsert);
                            $detailsToInsert = [];
                        }
                    }
                }
                // Final insert for remaining details
                if (count($detailsToInsert) > 0) {
                    \DB::table('transaction_details')->insert($detailsToInsert);
                }
            }

            // =============================================
            // 6. FINAL STOCK ADJUSTMENT (Sangat Cepat)
            // =============================================
            // Secara realistis, kita set saja stok ke angka random yang aman 
            // karena menghitung stok mundur dari jutaan transaksi akan sangat lambat.
            \DB::table('products')->where('store_id', $store->id)->update(['stock' => rand(50, 200)]);
        }


    }
}
