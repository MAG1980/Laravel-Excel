<?php

namespace Database\Seeders;

use App\Models\Type;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    private $types = [
        'Цветочный магазин' => 1,
        'Обувной магазин' => 2,
        'Закусочная' => 3,
        'Кинотеатр для двоих' => 4,
        'Лавка овощей и фруктов' => 5,
        'Игровой клуб' => 6,
        'Фитнес клуб' => 7,
        'Парикмахерская' => 8,
        'Спа салон' => 9,
        'Магазин спортивной одежды' => 10,
        'Магазин спортивного питания' => 11,
        'Магазин женского белья' => 12,
        'Кафе' => 13
    ];

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        foreach ($this->types as $name => $type) {
            Type::create([
                'title' => $name,
            ]);
        }
    }
}
