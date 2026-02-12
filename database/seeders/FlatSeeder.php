<?php

namespace Database\Seeders;

use App\Models\Flat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FlatSeeder extends Seeder
{
    public function run(): void
    {
        $flats = [
            [
                'title' => '3-комнатная квартира в ЖК Северный',
                'description' => 'Просторная 3-комнатная квартира в новом жилом комплексе с современной планировкой.',
                'price' => 8500000.00,
                'area' => 85.50,
                'living_area' => 65.30, // Добавлено
                'rooms' => 3,
                'floor' => 5,
                'total_floors' => 12,
                'housing_type' => 'new_building',
                'finishing' => 'fine',
                'view_type' => 'street',
                'balcony' => true,
                'bathroom' => 'separate',
                'is_available' => true, // Добавлено
                'status' => 'available' // Добавлено
            ],
            [
                'title' => '2-комнатная квартира в центре',
                'description' => 'Уютная 2-комнатная квартира после ремонта в историческом центре города.',
                'price' => 6500000.00,
                'area' => 58.20,
                'living_area' => 42.80,
                'rooms' => 2,
                'floor' => 3,
                'total_floors' => 5,
                'housing_type' => 'secondary',
                'finishing' => 'euro',
                'view_type' => 'yard',
                'balcony' => true,
                'bathroom' => 'combined',
                'is_available' => true,
                'status' => 'available'
            ],
            // Добавьте больше квартир по аналогии
        ];

        foreach ($flats as $flat) {
            Flat::create($flat);
        }
    }
}