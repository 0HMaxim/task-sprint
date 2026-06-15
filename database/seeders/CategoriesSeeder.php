<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\File;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class CategoriesSeeder extends Seeder
{
    private function icons(): array
    {
        return [
            'cleaning' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 22h18"/><path d="M5 22V8a2 2 0 0 1 2-2h2l1-2h4l1 2h2a2 2 0 0 1 2 2v14"/><path d="M9 16h6"/><path d="M9 12h6"/></svg>',
            'moving' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 17h4V5H2v12h3"/><path d="M14 9h5l3 3v5h-2"/><circle cx="7" cy="17" r="2"/><circle cx="17" cy="17" r="2"/></svg>',
            'repairs' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg>',
            'gardening' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22v-9"/><path d="M12 13c-3.5 0-6-2.5-6-6 0-1 .2-2 .5-3C9.5 4.5 12 7 12 10c0-3 2.5-5.5 5.5-6 .3 1 .5 2 .5 3 0 3.5-2.5 6-6 6z"/></svg>',
            'personal-assistance' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
        ];
    }

    public function run(): void
    {
        // Remove any previously seeded broken data (use Eloquent to trigger cascade deletes)
        Category::all()->each(fn ($category) => $category->delete());

        $categories = [
            [
                'name' => ['en' => 'Cleaning', 'ru' => 'Уборка', 'uk' => 'Прибирання'],
                'color' => '#4F46E5',
                'icon' => 'cleaning',
                'sub_categories' => [
                    ['en' => 'Home Cleaning', 'ru' => 'Уборка квартиры', 'uk' => 'Прибирання квартири'],
                    ['en' => 'Office Cleaning', 'ru' => 'Уборка офиса', 'uk' => 'Прибирання офісу'],
                    ['en' => 'Window Cleaning', 'ru' => 'Мытьё окон', 'uk' => 'Миття вікон'],
                ],
            ],
            [
                'name' => ['en' => 'Moving & Delivery', 'ru' => 'Перевозки и доставка', 'uk' => 'Перевезення та доставка'],
                'color' => '#0891B2',
                'icon' => 'moving',
                'sub_categories' => [
                    ['en' => 'Furniture Moving', 'ru' => 'Перевозка мебели', 'uk' => 'Перевезення меблів'],
                    ['en' => 'Package Delivery', 'ru' => 'Доставка посылок', 'uk' => 'Доставка посилок'],
                ],
            ],
            [
                'name' => ['en' => 'Repairs & Maintenance', 'ru' => 'Ремонт и обслуживание', 'uk' => 'Ремонт та обслуговування'],
                'color' => '#D97706',
                'icon' => 'repairs',
                'sub_categories' => [
                    ['en' => 'Plumbing', 'ru' => 'Сантехника', 'uk' => 'Сантехніка'],
                    ['en' => 'Electrical', 'ru' => 'Электрика', 'uk' => 'Електрика'],
                    ['en' => 'Furniture Assembly', 'ru' => 'Сборка мебели', 'uk' => 'Збірка меблів'],
                ],
            ],
            [
                'name' => ['en' => 'Gardening', 'ru' => 'Садоводство', 'uk' => 'Садівництво'],
                'color' => '#16A34A',
                'icon' => 'gardening',
                'sub_categories' => [
                    ['en' => 'Lawn Mowing', 'ru' => 'Стрижка газона', 'uk' => 'Стрижка газону'],
                    ['en' => 'Tree Trimming', 'ru' => 'Обрезка деревьев', 'uk' => 'Обрізка дерев'],
                ],
            ],
            [
                'name' => ['en' => 'Personal Assistance', 'ru' => 'Личная помощь', 'uk' => 'Особиста допомога'],
                'color' => '#DB2777',
                'icon' => 'personal-assistance',
                'sub_categories' => [
                    ['en' => 'Pet Sitting', 'ru' => 'Присмотр за животными', 'uk' => 'Догляд за тваринами'],
                    ['en' => 'Tutoring', 'ru' => 'Репетиторство', 'uk' => 'Репетиторство'],
                ],
            ],
        ];

        $adminId = User::where('email', config('user.admin.email'))->value('id');
        $icons = $this->icons();

        foreach ($categories as $categoryData) {
            $category = Category::create([
                'name' => $categoryData['name'],
                'color' => $categoryData['color'],
            ]);

            $svg = $icons[$categoryData['icon']] ?? null;
            if ($adminId && $svg) {
                $destPath = 'category-icons/' . $category->id . '.svg';
                Storage::disk('local')->put($destPath, $svg);

                File::create([
                    'name' => $categoryData['icon'] . '.svg',
                    'mime_type' => 'image/svg+xml',
                    'size' => strlen($svg),
                    'path' => $destPath,
                    'disk' => 'local',
                    'user_id' => $adminId,
                    'fileable_id' => $category->id,
                    'fileable_type' => Category::class,
                ]);
            }

            foreach ($categoryData['sub_categories'] as $subCategoryName) {
                SubCategory::create([
                    'category_id' => $category->id,
                    'name' => $subCategoryName,
                ]);
            }
        }
    }
}
