<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class NodeShopSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin Node Shop',
            'email' => 'admin@nodeshop.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '081234567890',
            'email_verified_at' => now(),
        ]);

        // Create Customer User
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'phone' => '081298765432',
            'address' => 'Jl. Teknik No. 10',
            'city' => 'Bandar Lampung',
            'province' => 'Lampung',
            'postal_code' => '35141',
            'email_verified_at' => now(),
        ]);

        // Create Categories
        $categories = [
            ['name' => 'Mikrokontroler', 'slug' => 'mikrokontroler', 'description' => 'Arduino, ESP32, ESP8266, Raspberry Pi, STM32 dan board development lainnya', 'icon' => '🔧', 'sort_order' => 1],
            ['name' => 'Sensor & Aktuator', 'slug' => 'sensor-aktuator', 'description' => 'Sensor suhu, kelembaban, gerak, gas, cahaya, servo, relay, dan lainnya', 'icon' => '📡', 'sort_order' => 2],
            ['name' => 'Module & Shield', 'slug' => 'module-shield', 'description' => 'WiFi, Bluetooth, LoRa, GPS, OLED, LCD dan shield Arduino', 'icon' => '📟', 'sort_order' => 3],
            ['name' => 'Starter Kit', 'slug' => 'starter-kit', 'description' => 'Paket belajar IoT lengkap untuk pemula', 'icon' => '📦', 'sort_order' => 4],
            ['name' => 'Tools & Aksesoris', 'slug' => 'tools-aksesoris', 'description' => 'Solder, breadboard, multimeter, jumper wire, power supply', 'icon' => '🛠️', 'sort_order' => 5],
            ['name' => 'IoT Preloved', 'slug' => 'iot-preloved', 'description' => 'Perangkat IoT bekas terverifikasi dengan kondisi baik', 'icon' => '♻️', 'sort_order' => 6],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }

        // Create Products
        $products = [
            // Mikrokontroler (category_id: 1)
            [
                'category_id' => 1, 'name' => 'Arduino Uno R3 Original', 'slug' => 'arduino-uno-r3-original',
                'description' => 'Arduino Uno R3 original dengan chip ATmega328P. Board development paling populer untuk belajar elektronika dan IoT. Dilengkapi 14 pin digital I/O, 6 analog input, koneksi USB, dan jack power.',
                'specifications' => 'Mikrokontroler: ATmega328P | Tegangan: 5V | Clock: 16MHz | Flash: 32KB | SRAM: 2KB | Digital I/O: 14 pin | Analog: 6 pin',
                    'price' => 85000, 'original_price' => 120000, 'stock' => 50, 'condition' => 'new', 'weight' => 30, 'is_featured' => true,
                    // Use a storage-accessible public path (served via public/storage after running `php artisan storage:link`)
                    'image' => 'storage/images/3D_isometric_Arduino_device_202605102235.jpeg',
            ],
            [
                'category_id' => 1, 'name' => 'ESP32 DevKit V1 WiFi+BT', 'slug' => 'esp32-devkit-v1',
                'description' => 'ESP32 Development Board dengan WiFi dan Bluetooth terintegrasi. Cocok untuk project IoT yang membutuhkan konektivitas wireless. Dual-core processor 240MHz.',
                'specifications' => 'CPU: Xtensa LX6 Dual-core 240MHz | WiFi: 802.11 b/g/n | BT: 4.2 + BLE | Flash: 4MB | GPIO: 36 pin | ADC: 18 channel',
                'price' => 65000, 'original_price' => 85000, 'stock' => 75, 'condition' => 'new', 'weight' => 15, 'is_featured' => true,
                'image' => 'storage/images/esp32.jpeg',
            ],
            [
                'category_id' => 1, 'name' => 'ESP8266 NodeMCU V3', 'slug' => 'esp8266-nodemcu-v3',
                'description' => 'NodeMCU V3 berbasis ESP8266 dengan WiFi terintegrasi. Board development compact dan murah untuk project IoT sederhana. Support Arduino IDE.',
                'specifications' => 'CPU: ESP8266 80/160MHz | WiFi: 802.11 b/g/n | Flash: 4MB | GPIO: 17 pin | ADC: 1 channel | USB: Micro-USB',
                'price' => 35000, 'original_price' => 50000, 'stock' => 100, 'condition' => 'new', 'weight' => 10, 'is_featured' => true,
                'image' => 'storage/images/esp8266.jpeg',
            ],
            [
                'category_id' => 1, 'name' => 'Raspberry Pi 4 Model B 4GB', 'slug' => 'raspberry-pi-4-4gb',
                'description' => 'Raspberry Pi 4 Model B dengan RAM 4GB. Komputer single-board terkuat untuk project IoT, server, media center, dan edge computing.',
                'specifications' => 'CPU: Broadcom BCM2711 Quad-core A72 1.5GHz | RAM: 4GB LPDDR4 | WiFi: 2.4/5GHz | BT: 5.0 | USB: 2x USB3 + 2x USB2 | HDMI: 2x Micro-HDMI',
                'price' => 950000, 'original_price' => 1200000, 'stock' => 15, 'condition' => 'new', 'weight' => 50,
                'image' => 'storage/images/raspberry pi.jpeg',
            ],
            [
                'category_id' => 1, 'name' => 'Arduino Nano V3 CH340', 'slug' => 'arduino-nano-v3',
                'description' => 'Arduino Nano V3 compact dengan chip CH340 USB. Ukuran kecil tapi powerful, cocok untuk project yang butuh space minimal.',
                'specifications' => 'Mikrokontroler: ATmega328P | Tegangan: 5V | Clock: 16MHz | Flash: 32KB | Digital I/O: 22 pin | Ukuran: 45x18mm',
                'price' => 25000, 'original_price' => 35000, 'stock' => 120, 'condition' => 'new', 'weight' => 7,
                'image' => 'storage/images/arduino nano.jpeg',
            ],

            // Sensor & Aktuator (category_id: 2)
            [
                'category_id' => 2, 'name' => 'DHT22 Sensor Suhu & Kelembaban', 'slug' => 'dht22-sensor',
                'description' => 'Sensor suhu dan kelembaban digital DHT22 (AM2302). Akurasi tinggi untuk monitoring lingkungan, greenhouse, dan smart home.',
                'specifications' => 'Range Suhu: -40°C~80°C (±0.5°C) | Range Humiditas: 0-100% (±2%) | Tegangan: 3.3-5V | Output: Digital',
                'price' => 35000, 'original_price' => null, 'stock' => 80, 'condition' => 'new', 'weight' => 5,
                'image' => 'storage/images/dht22.jpeg',
            ],
            [
                'category_id' => 2, 'name' => 'HC-SR04 Sensor Ultrasonik', 'slug' => 'hc-sr04-ultrasonik',
                'description' => 'Sensor jarak ultrasonik HC-SR04 untuk mengukur jarak 2cm-400cm. Cocok untuk robot obstacle avoidance dan smart parking.',
                'specifications' => 'Range: 2cm - 400cm | Resolusi: 0.3cm | Sudut: 15° | Tegangan: 5V | Trigger: 10µs TTL',
                'price' => 12000, 'original_price' => null, 'stock' => 150, 'condition' => 'new', 'weight' => 10,
                'image' => 'storage/images/HC-SR04_Sensor_Ultrasonik_render_202605102317.jpeg',
            ],
            [
                'category_id' => 2, 'name' => 'PIR Motion Sensor HC-SR501', 'slug' => 'pir-motion-hc-sr501',
                'description' => 'Sensor gerak infrared pasif untuk mendeteksi gerakan manusia. Ideal untuk alarm keamanan, lampu otomatis, dan smart home.',
                'specifications' => 'Range: 3-7m (adjustable) | Delay: 0.3s-5min | Tegangan: 4.5-20V | Output: 3.3V Digital',
                'price' => 15000, 'original_price' => null, 'stock' => 90, 'condition' => 'new', 'weight' => 8,
                'image' => 'storage/images/PIR_Motion_Sensor_HC-SR501_202605102318.jpeg',
            ],
            [
                'category_id' => 2, 'name' => 'Servo Motor SG90 9g', 'slug' => 'servo-sg90',
                'description' => 'Micro servo motor SG90 untuk project robotika dan IoT. Torsi cukup untuk menggerakkan mekanisme kecil.',
                'specifications' => 'Torsi: 1.8 kgf·cm (4.8V) | Kecepatan: 0.1s/60° | Berat: 9g | Tegangan: 4.8-6V | Rotasi: 180°',
                'price' => 18000, 'original_price' => 25000, 'stock' => 100, 'condition' => 'new', 'weight' => 9,
                'image' => 'storage/images/Servo_Motor_SG90_9g_render_202605102318.jpeg',
            ],
            [
                'category_id' => 2, 'name' => 'Relay Module 4 Channel 5V', 'slug' => 'relay-4ch-5v',
                'description' => 'Modul relay 4 channel dengan optocoupler isolasi. Untuk mengendalikan perangkat AC 220V dari mikrokontroler dengan aman.',
                'specifications' => 'Channel: 4 | Trigger: Low level | Tegangan: 5V | Max Load: 10A 250VAC / 10A 30VDC | Optocoupler isolation',
                'price' => 28000, 'original_price' => null, 'stock' => 60, 'condition' => 'new', 'weight' => 65,
                'image' => 'storage/images/Relay_Module_4_Channel_202605102318.jpeg',
            ],

            // Module & Shield (category_id: 3)
            [
                'category_id' => 3, 'name' => 'OLED Display 0.96" I2C SSD1306', 'slug' => 'oled-096-i2c',
                'description' => 'Display OLED 0.96 inch dengan resolusi 128x64 pixel. Interface I2C mudah dihubungkan, cocok untuk menampilkan data sensor.',
                'specifications' => 'Ukuran: 0.96 inch | Resolusi: 128x64 | Warna: Putih/Biru | Interface: I2C | Driver: SSD1306 | Tegangan: 3.3-5V',
                'price' => 32000, 'original_price' => 45000, 'stock' => 70, 'condition' => 'new', 'weight' => 5,
                'image' => 'storage/images/OLED_Display_0.96_I2C_202605102319.jpeg',
            ],
            [
                'category_id' => 3, 'name' => 'LoRa SX1278 Module 433MHz', 'slug' => 'lora-sx1278-433mhz',
                'description' => 'Modul LoRa SX1278 frekuensi 433MHz untuk komunikasi jarak jauh hingga 10km. Ideal untuk smart agriculture dan remote monitoring.',
                'specifications' => 'Frekuensi: 433MHz | Jangkauan: hingga 10km | Sensitivitas: -148dBm | Power: 100mW | Interface: SPI',
                'price' => 55000, 'original_price' => null, 'stock' => 30, 'condition' => 'new', 'weight' => 5,
                'image' => 'storage/images/LoRa_SX1278_Module_433MHz_202605102322.jpeg',
            ],
            [
                'category_id' => 3, 'name' => 'GPS Module NEO-6M + Antena', 'slug' => 'gps-neo-6m',
                'description' => 'Modul GPS NEO-6M dengan antena keramik. Support UART, akurasi posisi 2.5m. Untuk tracking dan navigasi IoT.',
                'specifications' => 'Chipset: u-blox NEO-6M | Akurasi: 2.5m CEP | Channel: 50 | Update: 5Hz | Interface: UART NMEA | Antena: Ceramic patch',
                'price' => 45000, 'original_price' => 60000, 'stock' => 35, 'condition' => 'new', 'weight' => 20,
                'image' => 'storage/images/GPS_Module_NEO-6M_Antena_202605102322.jpeg',
            ],
            [
                'category_id' => 3, 'name' => 'LCD 16x2 I2C Backlight Biru', 'slug' => 'lcd-16x2-i2c',
                'description' => 'LCD karakter 16x2 dengan modul I2C backpack terpasang. Hanya butuh 2 pin (SDA, SCL) untuk tampilan teks.',
                'specifications' => 'Display: 16 kolom x 2 baris | Backlight: Biru | Chip: HD44780 | Interface: I2C (PCF8574) | Tegangan: 5V',
                'price' => 25000, 'original_price' => null, 'stock' => 55, 'condition' => 'new', 'weight' => 30,
                'image' => 'storage/images/3D_Isometric_IoT_Device_202605102322.jpeg',
            ],

            // Starter Kit (category_id: 4)
            [
                'category_id' => 4, 'name' => 'Arduino Starter Kit Lengkap', 'slug' => 'arduino-starter-kit-lengkap',
                'description' => 'Paket belajar Arduino lengkap untuk pemula. Berisi Arduino Uno R3, breadboard, 65 jumper wire, LED, resistor, sensor, servo, LCD, dan komponen lainnya. Total 37+ komponen.',
                'specifications' => 'Isi: Arduino Uno R3 + Breadboard 830 + Jumper 65pcs + LED 24pcs + Resistor 30pcs + DHT11 + HC-SR04 + Servo SG90 + LCD 16x2 + Buzzer + dll',
                'price' => 250000, 'original_price' => 350000, 'stock' => 20, 'condition' => 'new', 'weight' => 350, 'is_featured' => true,
                'image' => 'storage/images/3D_Isometric_IoT_Device_Pack_202605102322.jpeg',
            ],
            [
                'category_id' => 4, 'name' => 'ESP32 IoT Learning Kit', 'slug' => 'esp32-iot-learning-kit',
                'description' => 'Kit belajar IoT berbasis ESP32 dengan modul WiFi+BT. Dilengkapi sensor, OLED, relay, dan panduan project IoT.',
                'specifications' => 'Isi: ESP32 DevKit + OLED 0.96" + DHT22 + PIR + Relay 2ch + Breadboard + Jumper + Resistor + LED + Buzzer',
                'price' => 185000, 'original_price' => 250000, 'stock' => 25, 'condition' => 'new', 'weight' => 250,
                
            ],

            // Tools & Aksesoris (category_id: 5)
            [
                'category_id' => 5, 'name' => 'Solder Station Digital 60W', 'slug' => 'solder-station-digital-60w',
                'description' => 'Solder station dengan display digital suhu. Adjustable 200-480°C, cocok untuk soldering komponen SMD dan through-hole.',
                'specifications' => 'Daya: 60W | Suhu: 200-480°C | Display: LED Digital | Tip: Replaceable | ESD Safe',
                'price' => 175000, 'original_price' => 220000, 'stock' => 15, 'condition' => 'new', 'weight' => 800,
            ],
            [
                'category_id' => 5, 'name' => 'Breadboard 830 Tie Point', 'slug' => 'breadboard-830',
                'description' => 'Breadboard besar 830 tie point untuk prototyping circuit tanpa solder. Material berkualitas, grip pin yang baik.',
                'specifications' => 'Tie Points: 830 | Ukuran: 165x55x10mm | Material: ABS | Rating: 300V/5A',
                'price' => 18000, 'original_price' => null, 'stock' => 200, 'condition' => 'new', 'weight' => 50,
            ],
            [
                'category_id' => 5, 'name' => 'Multimeter Digital DT830B', 'slug' => 'multimeter-dt830b',
                'description' => 'Multimeter digital portable untuk mengukur tegangan, arus, dan resistansi. Essential tool untuk setiap maker.',
                'specifications' => 'DC Voltage: 200mV-1000V | AC Voltage: 200-750V | DC Current: 200µA-10A | Resistance: 200Ω-2MΩ | Diode Test',
                'price' => 45000, 'original_price' => 65000, 'stock' => 40, 'condition' => 'new', 'weight' => 180,
                'image' => 'storage/images/Multimeter_Digital_DT830B_visual…_202605102326.jpeg',
            ],
            [
                'category_id' => 5, 'name' => 'Jumper Wire Kit Male-Female 120pcs', 'slug' => 'jumper-wire-kit-120pcs',
                'description' => 'Set kabel jumper 120 pcs (40 M-M + 40 M-F + 40 F-F). Panjang 20cm, warna-warni untuk kemudahan identifikasi.',
                'specifications' => 'Jumlah: 120pcs (3x40) | Tipe: M-M, M-F, F-F | Panjang: 20cm | AWG: 26 | Connector: DuPont 2.54mm',
                'price' => 22000, 'original_price' => null, 'stock' => 150, 'condition' => 'new', 'weight' => 30,
                'image' => 'storage/images/Jumper_wire_kit_visualization_202605102326.jpeg',
            ],

            // Test Product - For Midtrans Checkout Testing
            [
                'category_id' => 5, 'name' => 'Kabel Jumper Test Midtrans', 'slug' => 'kabel-jumper-test-midtrans',
                'description' => 'Product test untuk fitur checkout dan payment gateway Midtrans. Harga 1 rupiah untuk testing purposes.',
                'specifications' => 'Test Product | Harga: 1 | Untuk testing checkout',
                'price' => 1, 'original_price' => null, 'stock' => 10, 'condition' => 'new', 'weight' => 1,
                'image' => 'storage/images/3D_Isometric_IoT_Device_Pack_202605102346.jpeg',
            ],

            // IoT Preloved (category_id: 6)
            [
                'category_id' => 6, 'name' => 'Arduino Mega 2560 (Preloved)', 'slug' => 'arduino-mega-2560-preloved',
                'description' => 'Arduino Mega 2560 bekas pakai, kondisi 90% baik. Sudah dicek dan ditest semua pin berfungsi normal. Cocok untuk project besar.',
                'specifications' => 'Mikrokontroler: ATmega2560 | I/O: 54 Digital + 16 Analog | Flash: 256KB | Kondisi: Grade A (90%)',
                'price' => 95000, 'original_price' => 180000, 'stock' => 5, 'condition' => 'preloved', 'preloved_grade' => 'A', 'weight' => 40,
                'image' => 'storage/images/Arduino_Mega_2560_IoT_device_202605102327.jpeg',
            ],
            [
                'category_id' => 6, 'name' => 'Raspberry Pi 3B+ (Preloved)', 'slug' => 'raspberry-pi-3b-plus-preloved',
                'description' => 'Raspberry Pi 3 Model B+ bekas, kondisi 85%. WiFi dan Bluetooth berfungsi normal. Sudah dilengkapi heatsink.',
                'specifications' => 'CPU: BCM2837B0 Quad-core A53 1.4GHz | RAM: 1GB | WiFi: Dual-band | Kondisi: Grade A (85%)',
                'price' => 450000, 'original_price' => 750000, 'stock' => 3, 'condition' => 'preloved', 'preloved_grade' => 'A', 'weight' => 45,
                'image' => 'storage/images/raspberry pi.jpeg',
            ],
            [
                'category_id' => 6, 'name' => 'Sensor Kit 37-in-1 (Preloved)', 'slug' => 'sensor-kit-37in1-preloved',
                'description' => 'Kit sensor 37 macam bekas praktikum. Semua sensor sudah ditest dan berfungsi. Kondisi 80%, box penyimpanan sedikit penyok.',
                'specifications' => 'Isi: 37 jenis sensor | Termasuk: DHT11, SR04, PIR, Sound, LDR, MQ-series, dll | Kondisi: Grade B (80%)',
                'price' => 120000, 'original_price' => 280000, 'stock' => 4, 'condition' => 'preloved', 'preloved_grade' => 'B', 'weight' => 200,
                'image' => 'storage/images/Sensor_Kit_37-in-1_visualization_202605102327.jpeg',
            ],
            [
                'category_id' => 6, 'name' => 'ESP32-CAM dengan OV2640 (Preloved)', 'slug' => 'esp32-cam-preloved',
                'description' => 'ESP32-CAM dengan kamera OV2640 bekas project tugas akhir. WiFi streaming berfungsi normal, kondisi 90%.',
                'specifications' => 'CPU: ESP32-S dual-core 240MHz | Kamera: OV2640 2MP | WiFi: 802.11 b/g/n | MicroSD slot | Kondisi: Grade A',
                'price' => 55000, 'original_price' => 95000, 'stock' => 6, 'condition' => 'preloved', 'preloved_grade' => 'A', 'weight' => 15,
                'image' => 'storage/images/ESP32-CAM_futuristic_IoT_device_202605102327.jpeg',
            ],
        ];

        foreach ($products as $product) {
            $product['slug'] = $product['slug'] ?? Str::slug($product['name']);
            Product::create($product);
        }
    }
}
