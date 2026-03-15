<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Flat;
use App\Models\PriceHistory;

class PriceHistorySeeder extends Seeder
{
    public function run()
    {
        // ID квартир, для которых нужно создать историю цен
        $flatIds = [3, 7, 10, 12, 14, 15, 16, 17];
        
        foreach ($flatIds as $flatId) {
            // Очищаем старую историю для этой квартиры
            PriceHistory::where('flat_id', $flatId)->delete();
            
            // Получаем квартиру
            $flat = Flat::find($flatId);
            
            if (!$flat) {
                $this->command->error("❌ Квартира с ID {$flatId} не найдена!");
                continue;
            }
            
            $currentPrice = $flat->price; // текущая цена из БД
            
            $this->command->info("🏠 Квартира ID {$flatId} - {$flat->title}");
            $this->command->info("💰 Текущая цена: " . number_format($currentPrice, 0, ',', ' ') . " ₽");
            
            // Генерируем случайные цены для истории
            $historyData = [];
            
            // Базовая цена (6 месяцев назад) - случайная от 70% до 90% от текущей
            $basePrice = rand($currentPrice * 0.7, $currentPrice * 0.9);
            
            // Генерируем цены за последние 6 месяцев с небольшими колебаниями
            $prices = [];
            $prices[] = $basePrice; // 6 месяцев назад
            
            for ($i = 5; $i >= 1; $i--) {
                // Случайное изменение от -2% до +5% от предыдущей цены
                $prevPrice = $prices[count($prices) - 1];
                $changePercent = rand(-2, 5) / 100;
                $newPrice = round($prevPrice * (1 + $changePercent));
                
                // Не даем упасть слишком низко
                if ($newPrice < $basePrice * 0.8) {
                    $newPrice = round($basePrice * 0.85);
                }
                
                $prices[] = $newPrice;
            }
            
            // Последняя цена должна быть близка к текущей (в пределах 5%)
            $finalPrice = round($currentPrice * (1 + rand(-3, 3) / 100));
            $prices[] = $finalPrice;
            
            // Создаем записи истории
            for ($i = 0; $i <= 6; $i++) {
                $monthsAgo = 6 - $i;
                
                $historyData[] = [
                    'flat_id' => $flatId,
                    'price' => $prices[$i],
                    'date' => now()->subMonths($monthsAgo)->startOfMonth(),
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
            
            // Вставляем все записи
            PriceHistory::insert($historyData);
            
            // Считаем рост
            $firstPrice = $prices[0];
            $lastPrice = $prices[6];
            $growth = $lastPrice - $firstPrice;
            $growthPercent = $firstPrice > 0 ? round(($growth / $firstPrice) * 100, 1) : 0;
            
            // Выводим информацию
            $this->command->info("📊 История цен для квартиры ID {$flatId}:");
            $this->command->info("   6 мес назад: " . number_format($prices[0], 0, ',', ' ') . " ₽");
            $this->command->info("   5 мес назад: " . number_format($prices[1], 0, ',', ' ') . " ₽");
            $this->command->info("   4 мес назад: " . number_format($prices[2], 0, ',', ' ') . " ₽");
            $this->command->info("   3 мес назад: " . number_format($prices[3], 0, ',', ' ') . " ₽");
            $this->command->info("   2 мес назад: " . number_format($prices[4], 0, ',', ' ') . " ₽");
            $this->command->info("   1 мес назад: " . number_format($prices[5], 0, ',', ' ') . " ₽");
            $this->command->info("   сейчас:      " . number_format($prices[6], 0, ',', ' ') . " ₽");
            
            if ($growth > 0) {
                $this->command->info("✅ Рост за полгода: +" . number_format($growth, 0, ',', ' ') . " ₽ (+{$growthPercent}%)");
            } else {
                $this->command->info("📉 Падение за полгода: " . number_format($growth, 0, ',', ' ') . " ₽ ({$growthPercent}%)");
            }
            
            $this->command->info("------------------------");
        }
        
        $this->command->info("✅ Сидер выполнен для квартир: " . implode(', ', $flatIds));
    }
}