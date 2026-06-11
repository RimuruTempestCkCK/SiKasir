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
        User::create([
            'name'     => 'Admin System',
            'email'    => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        // =============================================
        // 2. STORE DATA
        // =============================================
        $storeData = [
            // ----- TOKO 1 -----
            [
                'name'           => 'Toko Sembako Jaya',
                'address'        => 'Jl. Pahlawan No. 12, Depok',
                'phone'          => '081234560001',
                'pimpinan_name'  => 'Budi Santoso',
                'pimpinan_email' => 'pimpinan1@gmail.com',
                'kasirs'         => [
                    ['name' => 'Dewi Rahayu',   'email' => 'kasir1a@gmail.com'],
                    ['name' => 'Eko Prasetyo',  'email' => 'kasir1b@gmail.com'],
                    ['name' => 'Fitri Lestari', 'email' => 'kasir1c@gmail.com'],
                ],
                'type' => 'Retail',
                'categories' => [
                    'Beras & Biji-bijian' => [
                        ['name' => 'Beras Premium 5kg',           'price' => 75000,  'stock' => 300],
                        ['name' => 'Beras Merah Organik 2kg',     'price' => 38000,  'stock' => 150],
                        ['name' => 'Beras Putih Rojolele 5kg',    'price' => 68000,  'stock' => 200],
                        ['name' => 'Jagung Pipil 1kg',            'price' => 12000,  'stock' => 250],
                        ['name' => 'Kacang Hijau 500gr',          'price' => 15000,  'stock' => 180],
                        ['name' => 'Kedelai 1kg',                 'price' => 18000,  'stock' => 120],
                    ],
                    'Minyak & Lemak' => [
                        ['name' => 'Minyak Goreng Bimoli 2L',     'price' => 35000,  'stock' => 400],
                        ['name' => 'Minyak Goreng Filma 2L',      'price' => 34000,  'stock' => 350],
                        ['name' => 'Mentega Blue Band 200gr',     'price' => 12000,  'stock' => 200],
                        ['name' => 'Margarin Simas 200gr',        'price' => 11000,  'stock' => 180],
                        ['name' => 'Minyak Kelapa 500ml',         'price' => 25000,  'stock' => 100],
                    ],
                    'Gula & Pemanis' => [
                        ['name' => 'Gula Pasir 1kg',              'price' => 17000,  'stock' => 500],
                        ['name' => 'Gula Merah 500gr',            'price' => 14000,  'stock' => 200],
                        ['name' => 'Gula Aren 500gr',             'price' => 22000,  'stock' => 150],
                        ['name' => 'Madu Murni 250ml',            'price' => 55000,  'stock' => 80],
                        ['name' => 'Sirup Marjan Cocopandan 460ml', 'price' => 24000, 'stock' => 120],
                    ],
                    'Bumbu Dapur' => [
                        ['name' => 'Garam Refina 250gr',          'price' => 5000,   'stock' => 600],
                        ['name' => 'Merica Bubuk Ladaku 25gr',    'price' => 7500,   'stock' => 400],
                        ['name' => 'Kecap Manis Bango 220ml',     'price' => 16000,  'stock' => 350],
                        ['name' => 'Kecap Asin ABC 135ml',        'price' => 9000,   'stock' => 250],
                        ['name' => 'Saos Tiram Panda 270ml',      'price' => 18000,  'stock' => 200],
                        ['name' => 'Terasi ABC 50gr',             'price' => 8000,   'stock' => 300],
                        ['name' => 'Vetsin Ajinomoto 50gr',       'price' => 6000,   'stock' => 500],
                        ['name' => 'Bawang Putih Bubuk 100gr',    'price' => 12000,  'stock' => 200],
                    ],
                    'Minuman Kemasan' => [
                        ['name' => 'Aqua Galon 19L',              'price' => 20000,  'stock' => 100],
                        ['name' => 'Teh Botol Sosro 450ml',       'price' => 8000,   'stock' => 500],
                        ['name' => 'Pocari Sweat 500ml',          'price' => 12000,  'stock' => 300],
                        ['name' => 'Indomilk Coklat 200ml',       'price' => 6500,   'stock' => 400],
                        ['name' => 'Good Day Cappuccino 220ml',   'price' => 7500,   'stock' => 350],
                        ['name' => 'Mizone Apple Guava 500ml',    'price' => 8000,   'stock' => 280],
                        ['name' => 'Fanta Strawberry 390ml',      'price' => 8500,   'stock' => 300],
                    ],
                    'Snack & Camilan' => [
                        ['name' => 'Chitato Original 68gr',       'price' => 15000,  'stock' => 400],
                        ['name' => 'Cheetos Crunchy 60gr',        'price' => 13000,  'stock' => 350],
                        ['name' => 'Oreo Original 119.6gr',       'price' => 15000,  'stock' => 300],
                        ['name' => 'Roma Marie 225gr',            'price' => 12000,  'stock' => 250],
                        ['name' => 'Wafer Tango Coklat 176gr',    'price' => 18000,  'stock' => 200],
                        ['name' => 'Kacang Garuda Bawang 100gr',  'price' => 11000,  'stock' => 300],
                    ],
                    'Kebutuhan Mandi & Cuci' => [
                        ['name' => 'Sabun Lifebuoy 100gr',        'price' => 7500,   'stock' => 500],
                        ['name' => 'Shampoo Clear 170ml',         'price' => 32000,  'stock' => 200],
                        ['name' => 'Detergen Rinso 800gr',        'price' => 25000,  'stock' => 300],
                        ['name' => 'Pewangi Molto 900ml',         'price' => 23000,  'stock' => 200],
                        ['name' => 'Sabun Cuci Piring Sunlight 800ml', 'price' => 18000, 'stock' => 350],
                        ['name' => 'Pasta Gigi Pepsodent 225gr',  'price' => 22000,  'stock' => 300],
                        ['name' => 'Sikat Gigi Formula',          'price' => 10000,  'stock' => 250],
                    ],
                ],
            ],

            // ----- TOKO 2 -----
            [
                'name'           => 'Warung Berkah Makmur',
                'address'        => 'Jl. Merdeka No. 45, Bogor',
                'phone'          => '081234560002',
                'pimpinan_name'  => 'Siti Aminah',
                'pimpinan_email' => 'pimpinan2@gmail.com',
                'kasirs'         => [
                    ['name' => 'Hendra Wijaya',  'email' => 'kasir2a@gmail.com'],
                    ['name' => 'Intan Permata',  'email' => 'kasir2b@gmail.com'],
                ],
                'type' => 'Grosir',
                'categories' => [
                    'Sembako Pokok' => [
                        ['name' => 'Beras Cianjur 25kg',          'price' => 310000, 'stock' => 200],
                        ['name' => 'Beras IR64 25kg',             'price' => 280000, 'stock' => 180],
                        ['name' => 'Tepung Terigu Bogasari 25kg', 'price' => 185000, 'stock' => 150],
                        ['name' => 'Gula Pasir 50kg',             'price' => 820000, 'stock' => 100],
                        ['name' => 'Garam Kasar 1kg',             'price' => 8000,   'stock' => 500],
                        ['name' => 'Minyak Goreng 5L',            'price' => 80000,  'stock' => 250],
                    ],
                    'Mie & Pasta' => [
                        ['name' => 'Indomie Goreng 1 Dus (40pcs)', 'price' => 115000, 'stock' => 200],
                        ['name' => 'Indomie Kuah 1 Dus (40pcs)',  'price' => 112000, 'stock' => 200],
                        ['name' => 'Mie Sedaap Goreng Dus',       'price' => 108000, 'stock' => 150],
                        ['name' => 'Pop Mie Rasa Ayam 75gr',      'price' => 5000,   'stock' => 500],
                        ['name' => 'Bihun Rose Brand 400gr',      'price' => 15000,  'stock' => 300],
                        ['name' => 'Spaghetti La Fonte 500gr',    'price' => 22000,  'stock' => 150],
                    ],
                    'Elektronik Ringan' => [
                        ['name' => 'Baterai ABC AA 2pcs',         'price' => 8000,   'stock' => 600],
                        ['name' => 'Baterai ABC AAA 2pcs',        'price' => 8000,   'stock' => 500],
                        ['name' => 'Lampu LED Philips 7W',        'price' => 25000,  'stock' => 300],
                        ['name' => 'Lampu LED Philips 14W',       'price' => 35000,  'stock' => 200],
                        ['name' => 'Stop Kontak Broco 3 Lubang',  'price' => 28000,  'stock' => 150],
                        ['name' => 'Kabel Rol 5m',                'price' => 55000,  'stock' => 100],
                        ['name' => 'Korek Api Gas Tokai',         'price' => 7000,   'stock' => 400],
                    ],
                    'Alat Tulis' => [
                        ['name' => 'Pulpen Pilot G2 Hitam',       'price' => 15000,  'stock' => 400],
                        ['name' => 'Buku Tulis Sinar Dunia 58lbr','price' => 8000,   'stock' => 600],
                        ['name' => 'Kertas HVS A4 70gr (500lbr)', 'price' => 55000,  'stock' => 200],
                        ['name' => 'Stabilo Boss 4 Warna',        'price' => 32000,  'stock' => 150],
                        ['name' => 'Pensil 2B Faber Castell',     'price' => 5000,   'stock' => 500],
                        ['name' => 'Penghapus Staedtler',         'price' => 6000,   'stock' => 400],
                        ['name' => 'Gunting Kenko 6"',            'price' => 18000,  'stock' => 200],
                        ['name' => 'Isolasi Bening 2"',           'price' => 7000,   'stock' => 350],
                    ],
                    'Rokok & Tembakau' => [
                        ['name' => 'Sampoerna Mild 16',           'price' => 30000,  'stock' => 300],
                        ['name' => 'Gudang Garam Filter 12',      'price' => 26000,  'stock' => 300],
                        ['name' => 'Djarum Super 12',             'price' => 26000,  'stock' => 250],
                        ['name' => 'Marlboro Red 20',             'price' => 38000,  'stock' => 200],
                        ['name' => 'Camel Filter 20',             'price' => 36000,  'stock' => 150],
                        ['name' => 'LA Lights 16',                'price' => 28000,  'stock' => 200],
                    ],
                ],
            ],

            // ----- TOKO 3 -----
            [
                'name'           => 'Minimarket Sejahtera',
                'address'        => 'Jl. Sudirman No. 88, Bekasi',
                'phone'          => '081234560003',
                'pimpinan_name'  => 'Agus Kurniawan',
                'pimpinan_email' => 'pimpinan3@gmail.com',
                'kasirs'         => [
                    ['name' => 'Joko Susilo',    'email' => 'kasir3a@gmail.com'],
                    ['name' => 'Kartini Dewi',   'email' => 'kasir3b@gmail.com'],
                    ['name' => 'Lukman Hakim',   'email' => 'kasir3c@gmail.com'],
                    ['name' => 'Maya Sari',      'email' => 'kasir3d@gmail.com'],
                ],
                'type' => 'Retail',
                'categories' => [
                    'Makanan Instan' => [
                        ['name' => 'Indomie Goreng Spesial',      'price' => 3500,   'stock' => 800],
                        ['name' => 'Indomie Soto Ayam',           'price' => 3500,   'stock' => 700],
                        ['name' => 'Sarimi Isi 2 Soto',          'price' => 4000,   'stock' => 500],
                        ['name' => 'Sedap Goreng',                'price' => 3500,   'stock' => 600],
                        ['name' => 'Supermi Soto Spesial',        'price' => 3000,   'stock' => 450],
                        ['name' => 'Nissin Ramen Chicken',        'price' => 5500,   'stock' => 300],
                        ['name' => 'Sanmaru Chicken',             'price' => 5000,   'stock' => 250],
                    ],
                    'Minuman Segar' => [
                        ['name' => 'Aqua 600ml',                  'price' => 5000,   'stock' => 800],
                        ['name' => 'Le Minerale 600ml',           'price' => 4500,   'stock' => 700],
                        ['name' => 'Teh Kotak 250ml',             'price' => 5500,   'stock' => 600],
                        ['name' => 'Coca Cola 390ml',             'price' => 8500,   'stock' => 500],
                        ['name' => 'Sprite 390ml',                'price' => 8500,   'stock' => 450],
                        ['name' => 'Fanta Strawberry 390ml',      'price' => 8500,   'stock' => 400],
                        ['name' => 'Green Tea Sosro 350ml',       'price' => 6000,   'stock' => 500],
                        ['name' => 'Kopi Luwak White 240ml',      'price' => 8000,   'stock' => 350],
                        ['name' => 'Ultra Milk Full Cream 250ml', 'price' => 9000,   'stock' => 400],
                    ],
                    'Frozen Food' => [
                        ['name' => 'Sosis So Nice 340gr',         'price' => 28000,  'stock' => 200],
                        ['name' => 'Nugget So Good 400gr',        'price' => 32000,  'stock' => 180],
                        ['name' => 'Kornet Pronas 198gr',         'price' => 22000,  'stock' => 150],
                        ['name' => 'Dimsum Cedea Siomay 250gr',   'price' => 35000,  'stock' => 120],
                        ['name' => 'Bakso Ikan Finna 200gr',      'price' => 18000,  'stock' => 150],
                        ['name' => 'Es Krim Campina Cone',        'price' => 10000,  'stock' => 200],
                        ['name' => 'Walls Paddle Pop 60ml',       'price' => 8000,   'stock' => 300],
                    ],
                    'Personal Care' => [
                        ['name' => 'Sabun Mandi Dove 110gr',      'price' => 10000,  'stock' => 400],
                        ['name' => 'Shampoo Pantene 170ml',       'price' => 35000,  'stock' => 250],
                        ['name' => 'Conditioner Pantene 170ml',   'price' => 35000,  'stock' => 200],
                        ['name' => 'Deodorant Rexona Roll On',    'price' => 22000,  'stock' => 300],
                        ['name' => 'Body Lotion Citra 200ml',     'price' => 28000,  'stock' => 200],
                        ['name' => 'Facial Wash Garnier 100ml',   'price' => 32000,  'stock' => 180],
                        ['name' => 'Pembalut Laurier 30cm 16pcs', 'price' => 22000,  'stock' => 200],
                        ['name' => 'Kapas Viva 50gr',             'price' => 8000,   'stock' => 300],
                    ],
                    'Perlengkapan Rumah' => [
                        ['name' => 'Tisu Paseo 250lbr',           'price' => 18000,  'stock' => 500],
                        ['name' => 'Tisu Basah Baby Wipes 50lbr', 'price' => 25000,  'stock' => 300],
                        ['name' => 'Kantong Plastik Kresek M',    'price' => 5000,   'stock' => 600],
                        ['name' => 'Korek Api Panjang',           'price' => 5000,   'stock' => 400],
                        ['name' => 'Lilin Kecil 6pcs',            'price' => 7000,   'stock' => 350],
                        ['name' => 'Isi Staples No 10',           'price' => 5000,   'stock' => 300],
                        ['name' => 'Lakban Bening 1"',            'price' => 8000,   'stock' => 250],
                    ],
                    'Susu & Olahan' => [
                        ['name' => 'Susu Bendera Coklat 1kg',     'price' => 82000,  'stock' => 150],
                        ['name' => 'Dancow Full Cream 800gr',     'price' => 125000, 'stock' => 100],
                        ['name' => 'SGM 3 Madu 900gr',            'price' => 145000, 'stock' => 80],
                        ['name' => 'Indomilk Kaleng 385gr',       'price' => 22000,  'stock' => 200],
                        ['name' => 'Frisian Flag Putih 1kg',      'price' => 88000,  'stock' => 120],
                        ['name' => 'Yakult 5 Botol',              'price' => 22000,  'stock' => 300],
                    ],
                ],
            ],

            // ----- TOKO 4 -----
            [
                'name'           => 'Toko Herbal & Organik Nusantara',
                'address'        => 'Jl. Diponegoro No. 21, Bandung',
                'phone'          => '081234560004',
                'pimpinan_name'  => 'Retno Wulandari',
                'pimpinan_email' => 'pimpinan4@gmail.com',
                'kasirs'         => [
                    ['name' => 'Novi Andriani',  'email' => 'kasir4a@gmail.com'],
                    ['name' => 'Oki Setiawan',   'email' => 'kasir4b@gmail.com'],
                ],
                'type' => 'Retail',
                'categories' => [
                    'Herbal & Jamu' => [
                        ['name' => 'Jamu Kunyit Asam Nyonya Meneer', 'price' => 8000, 'stock' => 400],
                        ['name' => 'Jamu Tolak Angin Sido Muncul',  'price' => 5000,  'stock' => 600],
                        ['name' => 'Temulawak Kering 100gr',        'price' => 18000, 'stock' => 200],
                        ['name' => 'Jahe Merah Bubuk 100gr',        'price' => 22000, 'stock' => 180],
                        ['name' => 'Kayu Manis Bubuk 50gr',         'price' => 15000, 'stock' => 200],
                        ['name' => 'Kunyit Bubuk Organik 100gr',    'price' => 18000, 'stock' => 150],
                        ['name' => 'Akar Bajakah Kering 50gr',      'price' => 45000, 'stock' => 100],
                        ['name' => 'Spirulina Tablet 100pcs',       'price' => 75000, 'stock' => 80],
                    ],
                    'Beras & Pangan Organik' => [
                        ['name' => 'Beras Merah Organik 1kg',       'price' => 22000, 'stock' => 200],
                        ['name' => 'Beras Hitam Organik 1kg',       'price' => 28000, 'stock' => 150],
                        ['name' => 'Quinoa 500gr',                  'price' => 65000, 'stock' => 100],
                        ['name' => 'Chia Seed 250gr',               'price' => 55000, 'stock' => 120],
                        ['name' => 'Gula Kelapa Organik 500gr',     'price' => 35000, 'stock' => 150],
                        ['name' => 'Madu Hutan Murni 250ml',        'price' => 85000, 'stock' => 100],
                    ],
                    'Suplemen & Vitamin' => [
                        ['name' => 'Vitamin C 1000mg 30 Tablet',    'price' => 45000, 'stock' => 300],
                        ['name' => 'Omega 3 Fish Oil 60 Caps',      'price' => 85000, 'stock' => 150],
                        ['name' => 'Propolis Brazil 30ml',          'price' => 95000, 'stock' => 100],
                        ['name' => 'Minyak Zaitun Extra Virgin 250ml', 'price' => 75000, 'stock' => 120],
                        ['name' => 'Klorofil Konsentrat 500ml',     'price' => 120000,'stock' => 80],
                        ['name' => 'Squalene 500mg 30 Caps',        'price' => 110000,'stock' => 90],
                    ],
                    'Minuman Sehat' => [
                        ['name' => 'Teh Hijau Organik 25 Sachet',   'price' => 35000, 'stock' => 250],
                        ['name' => 'Teh Rosella Kering 50gr',       'price' => 25000, 'stock' => 200],
                        ['name' => 'Kopi Robusta Premium 200gr',    'price' => 55000, 'stock' => 150],
                        ['name' => 'Susu Kedelai Bubuk 500gr',      'price' => 48000, 'stock' => 120],
                        ['name' => 'Wedang Jahe Instan 10 Sachet',  'price' => 22000, 'stock' => 300],
                        ['name' => 'Jahe Lemon Madu 10 Sachet',     'price' => 28000, 'stock' => 250],
                    ],
                    'Perawatan Alami' => [
                        ['name' => 'Sabun Belerang 70gr',           'price' => 8000,  'stock' => 400],
                        ['name' => 'Minyak Kemiri Asli 60ml',       'price' => 35000, 'stock' => 200],
                        ['name' => 'Masker Madu & Kunyit 30gr',     'price' => 22000, 'stock' => 150],
                        ['name' => 'Lidah Buaya Gel 150gr',         'price' => 28000, 'stock' => 180],
                        ['name' => 'Minyak Sereh 10ml',             'price' => 18000, 'stock' => 200],
                        ['name' => 'Sabun Susu Kambing 80gr',       'price' => 25000, 'stock' => 180],
                    ],
                ],
            ],

            // ----- TOKO 5 -----
            [
                'name'           => 'Elektronik & Aksesori Maju Teknologi',
                'address'        => 'Jl. Gatot Subroto No. 55, Tangerang',
                'phone'          => '081234560005',
                'pimpinan_name'  => 'Prasetyo Wibowo',
                'pimpinan_email' => 'pimpinan5@gmail.com',
                'kasirs'         => [
                    ['name' => 'Qori Fatimah',   'email' => 'kasir5a@gmail.com'],
                    ['name' => 'Rizal Mahmud',   'email' => 'kasir5b@gmail.com'],
                    ['name' => 'Sari Indah',     'email' => 'kasir5c@gmail.com'],
                ],
                'type' => 'Retail',
                'categories' => [
                    'Aksesori HP' => [
                        ['name' => 'Kabel Data USB Type-C 1m',     'price' => 25000,  'stock' => 500],
                        ['name' => 'Kabel Lightning iPhone 1m',    'price' => 35000,  'stock' => 300],
                        ['name' => 'Charger Anker 20W',            'price' => 155000, 'stock' => 150],
                        ['name' => 'Powerbank Xiaomi 10000mAh',    'price' => 185000, 'stock' => 100],
                        ['name' => 'Tempered Glass Universal 6"',  'price' => 15000,  'stock' => 400],
                        ['name' => 'Case Silikon iPhone 14',       'price' => 35000,  'stock' => 200],
                        ['name' => 'Earphone Baseus 3.5mm',        'price' => 75000,  'stock' => 200],
                        ['name' => 'Holder HP Mobil Magnetic',     'price' => 45000,  'stock' => 150],
                    ],
                    'Perangkat Komputer' => [
                        ['name' => 'Mouse Logitech M100',          'price' => 125000, 'stock' => 150],
                        ['name' => 'Keyboard Rexus Basic',         'price' => 155000, 'stock' => 100],
                        ['name' => 'Flashdisk Sandisk 32GB',       'price' => 75000,  'stock' => 300],
                        ['name' => 'Flashdisk Sandisk 64GB',       'price' => 125000, 'stock' => 200],
                        ['name' => 'Mouse Pad Gaming 30x25cm',     'price' => 35000,  'stock' => 250],
                        ['name' => 'Pembersih LCD Spray 150ml',    'price' => 25000,  'stock' => 200],
                        ['name' => 'Cooling Pad Laptop',           'price' => 125000, 'stock' => 80],
                    ],
                    'Audio & Visual' => [
                        ['name' => 'TWS Bluetooth Earbuds',        'price' => 145000, 'stock' => 150],
                        ['name' => 'Speaker Bluetooth Mini',       'price' => 185000, 'stock' => 100],
                        ['name' => 'Headset Gaming 7.1',           'price' => 245000, 'stock' => 80],
                        ['name' => 'HDMI Cable 1.5m v2.0',        'price' => 45000,  'stock' => 200],
                        ['name' => 'Converter HDMI to VGA',        'price' => 65000,  'stock' => 150],
                    ],
                    'Kelistrikan' => [
                        ['name' => 'Stop Kontak 5 Lubang Surge',   'price' => 85000,  'stock' => 200],
                        ['name' => 'Terminal Listrik 3m',          'price' => 55000,  'stock' => 250],
                        ['name' => 'Lampu LED 10W Cool White',     'price' => 22000,  'stock' => 400],
                        ['name' => 'Lampu LED 15W Warm White',     'price' => 28000,  'stock' => 350],
                        ['name' => 'Baterai Panasonic AA 4pcs',    'price' => 18000,  'stock' => 500],
                        ['name' => 'Baterai Panasonic AAA 4pcs',   'price' => 18000,  'stock' => 450],
                        ['name' => 'Fitting Lampu E27',            'price' => 12000,  'stock' => 300],
                    ],
                ],
            ],

            // ----- TOKO 6 -----
            [
                'name'           => 'Apotek & Toko Kesehatan Sehat Selalu',
                'address'        => 'Jl. Ahmad Yani No. 33, Surabaya',
                'phone'          => '081234560006',
                'pimpinan_name'  => 'dr. Taufik Hidayat',
                'pimpinan_email' => 'pimpinan6@gmail.com',
                'kasirs'         => [
                    ['name' => 'Uswatun Hasanah',  'email' => 'kasir6a@gmail.com'],
                    ['name' => 'Vina Oktaviani',   'email' => 'kasir6b@gmail.com'],
                ],
                'type' => 'Retail',
                'categories' => [
                    'Obat Bebas' => [
                        ['name' => 'Paracetamol 500mg 10 Tab',     'price' => 6000,   'stock' => 600],
                        ['name' => 'Ibuprofen 400mg 10 Tab',       'price' => 12000,  'stock' => 400],
                        ['name' => 'Antasida Doen 10 Tab',         'price' => 7000,   'stock' => 500],
                        ['name' => 'OBH Combi Batuk Pilek 100ml',  'price' => 32000,  'stock' => 300],
                        ['name' => 'Antimo 10 Tab',                'price' => 18000,  'stock' => 250],
                        ['name' => 'Promag 10 Tab',                'price' => 16000,  'stock' => 400],
                        ['name' => 'Norit 10 Tab',                 'price' => 14000,  'stock' => 350],
                        ['name' => 'Bodrex Migra 10 Tab',          'price' => 14000,  'stock' => 300],
                    ],
                    'Alat Kesehatan' => [
                        ['name' => 'Masker Medis 3ply 50pcs',      'price' => 35000,  'stock' => 300],
                        ['name' => 'Masker KN95 5pcs',             'price' => 28000,  'stock' => 200],
                        ['name' => 'Sarung Tangan Latex M 100pcs', 'price' => 75000,  'stock' => 100],
                        ['name' => 'Termometer Digital',           'price' => 65000,  'stock' => 80],
                        ['name' => 'Plester Luka Hansaplast 10pcs','price' => 15000,  'stock' => 400],
                        ['name' => 'Perban Gulung 5cm',            'price' => 8000,   'stock' => 300],
                        ['name' => 'Alkohol 70% 100ml',            'price' => 12000,  'stock' => 350],
                        ['name' => 'Betadine 30ml',                'price' => 22000,  'stock' => 250],
                    ],
                    'Vitamin & Suplemen' => [
                        ['name' => 'Vitamin C Redoxon 500mg 10 Tab', 'price' => 28000, 'stock' => 400],
                        ['name' => 'Vitamin B Complex 50 Tab',     'price' => 35000,  'stock' => 300],
                        ['name' => 'Calcium 500mg 30 Tab',         'price' => 42000,  'stock' => 200],
                        ['name' => 'Zinc 10mg 30 Tab',             'price' => 35000,  'stock' => 250],
                        ['name' => 'Imboost Force 10 Tab',         'price' => 55000,  'stock' => 300],
                        ['name' => 'Scott Emulsion Orange 200ml',  'price' => 45000,  'stock' => 200],
                    ],
                    'Perawatan Luka & Kulit' => [
                        ['name' => 'Salep Kulit Gentamicin',       'price' => 18000,  'stock' => 200],
                        ['name' => 'Salep Hidrokortison',          'price' => 22000,  'stock' => 180],
                        ['name' => 'Caladine Lotion 60ml',         'price' => 28000,  'stock' => 200],
                        ['name' => 'Minyak Telon Lang 60ml',       'price' => 22000,  'stock' => 300],
                        ['name' => 'Baby Oil Johnson 200ml',       'price' => 35000,  'stock' => 250],
                        ['name' => 'Hansaplast Wound Spray 40ml',  'price' => 45000,  'stock' => 150],
                    ],
                ],
            ],
        ];

        // =============================================
        // 3. SEED EACH STORE
        // =============================================
        foreach ($storeData as $index => $data) {

            // Create Pimpinan
            $pimpinan = User::create([
                'name'     => $data['pimpinan_name'],
                'email'    => $data['pimpinan_email'],
                'password' => Hash::make('password'),
                'role'     => 'pimpinan',
            ]);

            // Create Store
            $store = Store::create([
                'user_id' => $pimpinan->id,
                'name'    => $data['name'],
                'address' => $data['address'],
                'phone'   => $data['phone'],
                'type'    => $data['type'],
            ]);

            $pimpinan->update(['store_id' => $store->id]);

            // Create Kasirs
            $kasirs = [];
            foreach ($data['kasirs'] as $kasirData) {
                $kasirs[] = User::create([
                    'name'     => $kasirData['name'],
                    'email'    => $kasirData['email'],
                    'password' => Hash::make('password'),
                    'role'     => 'kasir',
                    'store_id' => $store->id,
                ]);
            }

            // Create Categories & Products
            $allProducts = collect();

            foreach ($data['categories'] as $catName => $products) {
                $category = Category::create([
                    'store_id' => $store->id,
                    'name'     => $catName,
                ]);

                foreach ($products as $prod) {
                    $product = Product::create([
                        'store_id'    => $store->id,
                        'category_id' => $category->id,
                        'name'        => $prod['name'],
                        'price'       => $prod['price'],
                        'stock'       => $prod['stock'],
                    ]);

                    // Initial Stock Log (31 days ago)
                    StockLog::create([
                        'product_id' => $product->id,
                        'type'       => 'in',
                        'quantity'   => $prod['stock'],
                        'note'       => 'Stok awal',
                        'created_at' => Carbon::now()->subDays(31),
                        'updated_at' => Carbon::now()->subDays(31),
                    ]);

                    $allProducts->push($product);
                }
            }

            // =============================================
            // 4. CREATE TRANSACTIONS (90 HARI TERAKHIR)
            // =============================================
            for ($d = 90; $d >= 0; $d--) {
                $date = Carbon::now()->subDays($d);

                // Variasi jumlah transaksi: weekday lebih sedikit, weekend lebih ramai
                $isWeekend = $date->isWeekend();
                $dailyTransCount = $isWeekend ? rand(10, 20) : rand(5, 12);

                for ($t = 1; $t <= $dailyTransCount; $t++) {
                    $cashier = $kasirs[array_rand($kasirs)];

                    // Ambil random 1-6 produk
                    $maxItems = min(6, $allProducts->count());
                    $selectedProducts = $allProducts->random(rand(1, $maxItems));

                    $transDetails = [];
                    $totalPrice   = 0;

                    foreach ($selectedProducts as $prod) {
                        $qty = rand(1, 5);
                        $totalPrice    += $prod->price * $qty;
                        $transDetails[] = [
                            'product_id' => $prod->id,
                            'quantity'   => $qty,
                            'price'      => $prod->price,
                        ];
                        // Kurangi stok
                        $prod->decrement('stock', $qty);
                    }

                    // Bulatkan ke kelipatan 1000 terdekat ke atas
                    $amountPaid = (int) (ceil($totalPrice / 1000) * 1000);
                    if ($amountPaid < $totalPrice) $amountPaid += 1000;

                    $transTime = $date->copy()
                        ->addHours(rand(8, 21))
                        ->addMinutes(rand(0, 59))
                        ->addSeconds(rand(0, 59));

                    $transaction = Transaction::create([
                        'store_id'       => $store->id,
                        'user_id'        => $cashier->id,
                        'invoice_number' => 'INV-'
                            . str_pad($store->id, 2, '0', STR_PAD_LEFT)
                            . '-' . $date->format('Ymd')
                            . '-' . str_pad($t, 4, '0', STR_PAD_LEFT),
                        'total_price'    => $totalPrice,
                        'amount_paid'    => $amountPaid,
                        'change'         => $amountPaid - $totalPrice,
                        'created_at'     => $transTime,
                        'updated_at'     => $transTime,
                    ]);

                    foreach ($transDetails as $detail) {
                        TransactionDetail::create([
                            'transaction_id' => $transaction->id,
                            'product_id'     => $detail['product_id'],
                            'quantity'       => $detail['quantity'],
                            'price'          => $detail['price'],
                            'created_at'     => $transTime,
                            'updated_at'     => $transTime,
                        ]);
                    }
                }
            }

            // =============================================
            // 5. STOCK RESTOCK (beberapa kali selama 90 hari)
            // =============================================
            foreach ($allProducts as $prod) {
                // Lakukan restock 2-4 kali acak selama 90 hari
                $restockCount = rand(2, 4);
                for ($r = 0; $r < $restockCount; $r++) {
                    $restockDay = rand(1, 89);
                    $restockQty = rand(50, 200);
                    $restockDate = Carbon::now()->subDays($restockDay);

                    StockLog::create([
                        'product_id' => $prod->id,
                        'type'       => 'in',
                        'quantity'   => $restockQty,
                        'note'       => 'Restock dari supplier',
                        'created_at' => $restockDate,
                        'updated_at' => $restockDate,
                    ]);

                    // Update stok
                    $prod->increment('stock', $restockQty);
                }
            }
        }
    }
}
