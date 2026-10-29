<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Equipment;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Buat tiga kategori awal; updateOrCreate mencegah duplikasi saat seeder diulang.
        $server = Category::updateOrCreate(['code' => 'SRV'], ['name' => 'Server & Cloud']);
        $iot = Category::updateOrCreate(['code' => 'IOT'], ['name' => 'Internet of Things']);
        $drone = Category::updateOrCreate(['code' => 'DRN'], ['name' => 'Multimedia & Drone']);

        // Data contoh aset. Kode aset dibuat unik dan bisa digunakan untuk mencoba filter.
        $items = [
            ['category_id'=>$server->id,'asset_code'=>'EQ-SRV-001','name'=>'Dell PowerEdge T40 Server','specification'=>'Server untuk praktikum jaringan dan server.','condition'=>'baik','status'=>'dipinjam','daily_rental_fee'=>75000],
            ['category_id'=>$server->id,'asset_code'=>'EQ-SRV-002','name'=>'Mini Lab Server','specification'=>'Mini server untuk simulasi layanan.','condition'=>'baik','status'=>'tersedia','daily_rental_fee'=>50000],
            ['category_id'=>$iot->id,'asset_code'=>'EQ-IOT-001','name'=>'Kit Sensor IoT','specification'=>'Kit sensor dan mikrokontroler untuk praktikum IoT.','condition'=>'baik','status'=>'tersedia','daily_rental_fee'=>15000],
            ['category_id'=>$iot->id,'asset_code'=>'EQ-IOT-002','name'=>'Raspberry Pi Starter Kit','specification'=>'Papan komputer mini dan aksesori.','condition'=>'rusak_ringan','status'=>'dalam_perbaikan','daily_rental_fee'=>20000],
            ['category_id'=>$drone->id,'asset_code'=>'EQ-DRN-001','name'=>'DJI Mavic Air 2 Fly More Combo','specification'=>'Drone observasi dengan kamera.','condition'=>'baik','status'=>'tersedia','daily_rental_fee'=>50000],
            ['category_id'=>$drone->id,'asset_code'=>'EQ-DRN-003','name'=>'FPV Racing Drone BetaFPV Cetus Pro','specification'=>'Drone latihan FPV.','condition'=>'baik','status'=>'tersedia','daily_rental_fee'=>25000],
        ];
        foreach ($items as $item) { Equipment::updateOrCreate(['asset_code'=>$item['asset_code']], $item); } // Simpan setiap aset contoh.
    }
}
