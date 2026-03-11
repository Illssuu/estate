<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Flat;
use App\Models\PriceHistory;

class PriceHistorySeeder extends Seeder
{
    public function run()
    {
        // Очищаем ТОЛЬКО историю для квартиры ID 1
        PriceHistory::where('flat_id', 1)->delete();
        
        // Получаем квартиру с ID 1
        $flat = Flat::find(1);
        
        if (!$flat) {
            $this->command->error('❌ Квартира с ID 1 не найдена!');
            return;
        }
        
        $currentPrice = $flat->price; // текущая цена из БД
        
        $this->command->info("🏠 Квартира ID 1");
        $this->command->info("💰 Текущая цена: " . number_format($currentPrice, 0, ',', ' ') . " ₽");
        
        // История цен для квартиры 1
        $historyData = [
            [
                'flat_id' => 1,
                'price' => 4000000, // 4 млн - 6 месяцев назад
                'date' => now()->subMonths(6)->startOfMonth(),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'flat_id' => 1,
                'price' => 4200000, // 4.2 млн - 5 месяцев назад
                'date' => now()->subMonths(5)->startOfMonth(),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'flat_id' => 1,
                'price' => 4300000, // 4.3 млн - 4 месяца назад
                'date' => now()->subMonths(4)->startOfMonth(),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'flat_id' => 1,
                'price' => 4500000, // 4.5 млн - 3 месяца назад
                'date' => now()->subMonths(3)->startOfMonth(),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'flat_id' => 1,
                'price' => 4700000, // 4.7 млн - 2 месяца назад
                'date' => now()->subMonths(2)->startOfMonth(),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'flat_id' => 1,
                'price' => 4850000, // 4.85 млн - месяц назад
                'date' => now()->subMonths(1)->startOfMonth(),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'flat_id' => 1,
                'price' => $currentPrice, // текущая цена
                'date' => now()->startOfMonth(),
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];
        
        // Вставляем все записи
        PriceHistory::insert($historyData);
        
        // Считаем рост
        $growth = $currentPrice - 4000000;
        $growthPercent = round(($growth / 4000000) * 100, 1);
        
        $this->command->info("📊 История цен создана:");
        $this->command->info("   6 мес назад: 4 000 000 ₽");
        $this->command->info("   5 мес назад: 4 200 000 ₽");
        $this->command->info("   4 мес назад: 4 300 000 ₽");
        $this->command->info("   3 мес назад: 4 500 000 ₽");
        $this->command->info("   2 мес назад: 4 700 000 ₽");
        $this->command->info("   1 мес назад: 4 850 000 ₽");
        $this->command->info("   сейчас:      " . number_format($currentPrice, 0, ',', ' ') . " ₽");
        $this->command->info("✅ Рост за полгода: +" . number_format($growth, 0, ',', ' ') . " ₽ (+{$growthPercent}%)");
    }
}