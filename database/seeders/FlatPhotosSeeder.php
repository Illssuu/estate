<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FlatPhotosSeeder extends Seeder
{
    public function run(): void
    {
        // ID квартиры
        $flatId = 1;
        
        // Массив с фотографиями для квартиры
        $photos = [
            [
                'flat_id' => $flatId,
                'image_path' => 'img/1.jpg',
                'image_name' => 'Гостиная с евроремонтом',
                'sort_order' => 1,
                'is_main' => 1, // Главное фото
            ],
            [
                'flat_id' => $flatId,
                'image_path' => 'img/2.jpg', 
                'image_name' => 'Спальня с панорамным окном',
                'sort_order' => 2,
                'is_main' => 0,
            ],
            [
                'flat_id' => $flatId,
                'image_path' => 'img/3.jpg',
                'image_name' => 'Современная кухня',
                'sort_order' => 3,
                'is_main' => 0,
            ]
        ];
        
        // ВСТАВЛЯЕМ ФОТО В БАЗУ ДАННЫХ
        DB::table('flat_photos')->insert($photos);
    }
}