<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => ['en' => 'Cleaning', 'ru' => 'Уборка', 'uk' => 'Прибирання'],
                'color' => '#4F46E5',
                'sub_categories' => [
                    ['en' => 'Home Cleaning', 'ru' => 'Уборка квартиры', 'uk' => 'Прибирання квартири'],
                    ['en' => 'Office Cleaning', 'ru' => 'Уборка офиса', 'uk' => 'Прибирання офісу'],
                    ['en' => 'Window Cleaning', 'ru' => 'Мытьё окон', 'uk' => 'Миття вікон'],
                ],
            ],
            [
                'name' => ['en' => 'Moving & Delivery', 'ru' => 'Перевозки и доставка', 'uk' => 'Перевезення та доставка'],
                'color' => '#0891B2',
                'sub_categories' => [
                    ['en' => 'Furniture Moving', 'ru' => 'Перевозка мебели', 'uk' => 'Перевезення меблів'],
                    ['en' => 'Package Delivery', 'ru' => 'Доставка посылок', 'uk' => 'Доставка посилок'],
                ],
            ],
            [
                'name' => ['en' => 'Repairs & Maintenance', 'ru' => 'Ремонт и обслуживание', 'uk' => 'Ремонт та обслуговування'],
                'color' => '#D97706',
                'sub_categories' => [
                    ['en' => 'Plumbing', 'ru' => 'Сантехника', 'uk' => 'Сантехніка'],
                    ['en' => 'Electrical', 'ru' => 'Электрика', 'uk' => 'Електрика'],
                    ['en' => 'Furniture Assembly', 'ru' => 'Сборка мебели', 'uk' => 'Збірка меблів'],
                ],
            ],
            [
                'name' => ['en' => 'Gardening', 'ru' => 'Садоводство', 'uk' => 'Садівництво'],
                'color' => '#16A34A',
                'sub_categories' => [
                    ['en' => 'Lawn Mowing', 'ru' => 'Стрижка газона', 'uk' => 'Стрижка газону'],
                    ['en' => 'Tree Trimming', 'ru' => 'Обрезка деревьев', 'uk' => 'Обрізка дерев'],
                ],
            ],
            [
                'name' => ['en' => 'Personal Assistance', 'ru' => 'Личная помощь', 'uk' => 'Особиста допомога'],
                'color' => '#DB2777',
                'sub_categories' => [
                    ['en' => 'Pet Sitting', 'ru' => 'Присмотр за животными', 'uk' => 'Догляд за тваринами'],
                    ['en' => 'Tutoring', 'ru' => 'Репетиторство', 'uk' => 'Репетиторство'],
                ],
            ],
        ];

        foreach ($categories as $categoryData) {
            $category = Category::firstOrCreate(
                ['name' => json_encode($categoryData['name'])],
                ['color' => $categoryData['color']]
            );

            foreach ($categoryData['sub_categories'] as $subCategoryName) {
                SubCategory::firstOrCreate([
                    'category_id' => $category->id,
                    'name' => json_encode($subCategoryName),
                ]);
            }
        }
    }
}
