<?php

namespace Database\Seeders;

use App\Enums\TaskOrderStatus;
use App\Enums\TaskStatus;
use App\Models\SubCategory;
use App\Models\Task;
use App\Models\TaskOrder;
use App\Models\User;
use Illuminate\Database\Seeder;

class TestDataSeeder extends Seeder
{
    public function run(): void
    {
        // Удаляем тестовые данные перед загрузкой новых
        // Порядок важен из-за FK constraints
        TaskOrder::query()->delete();
        Task::query()->delete();
        User::where('email', 'not like', config('user.admin.email'))->each(fn($u) => $u->delete());

        $currency = \App\Models\Currency::first();

        if (!$currency) {
            $this->command->warn('Currencies not found. Run CurrenciesSeeder first.');
            return;
        }

        // Получаем sub_category_id по английскому имени (имя хранится как JSON)
        $sub = fn(string $en) => SubCategory::all()
            ->first(fn($s) => data_get($s->name, 'en') === $en)
            ?->id ?? SubCategory::first()->id;

        // --- Создаём пользователей ---

        /** @var User $customer1 */
        $customer1 = User::firstOrCreate(
            ['email' => 'ivan@example.com'],
            [
                'name'     => 'Иван Петров',
                'password' => bcrypt('password'),
                'phone'    => '+380991234567',
                'city'     => 'Kyiv',
                'email_verified_at' => now(),
            ]
        );
        $customer1->syncRoles('customer');

        /** @var User $customer2 */
        $customer2 = User::firstOrCreate(
            ['email' => 'olga@example.com'],
            [
                'name'     => 'Ольга Коваль',
                'password' => bcrypt('password'),
                'phone'    => '+380997654321',
                'city'     => 'Lviv',
                'email_verified_at' => now(),
            ]
        );
        $customer2->syncRoles('customer');

        /** @var User $employee1 */
        $employee1 = User::firstOrCreate(
            ['email' => 'mykola@example.com'],
            [
                'name'     => 'Микола Бондар',
                'password' => bcrypt('password'),
                'phone'    => '+380501112233',
                'city'     => 'Kyiv',
                'email_verified_at' => now(),
            ]
        );
        $employee1->syncRoles('employee');

        /** @var User $employee2 */
        $employee2 = User::firstOrCreate(
            ['email' => 'darya@example.com'],
            [
                'name'     => 'Дарья Мельник',
                'password' => bcrypt('password'),
                'phone'    => '+380503334455',
                'city'     => 'Odessa',
                'email_verified_at' => now(),
            ]
        );
        $employee2->syncRoles('employee');

        // --- Задачи customer1 ---

        // Задача 1: есть отклик, в процессе
        $task1 = Task::create([
            'customer_id'      => $customer1->id,
            'sub_category_id'  => $sub('Home Cleaning'),
            'name'             => 'Уборка квартиры после ремонта',
            'description'      => 'Нужна генеральная уборка 3-комнатной квартиры после ремонта. Площадь 80 м².',
            'address'        => ['city' => 'Kyiv', 'street' => 'ул. Крещатик, 10'],
            'price'          => 1500,
            'currency_code'  => $currency->code,
            'estimated_date' => now()->addDays(3),
            'status'         => TaskStatus::InProgress,
        ]);

        TaskOrder::create([
            'task_id'     => $task1->id,
            'employee_id' => $employee1->id,
            'status'      => TaskOrderStatus::PendingForCompletion,
        ]);

        // Задача 2: ожидает исполнителя, откликов нет
        Task::create([
            'customer_id'      => $customer1->id,
            'sub_category_id'  => $sub('Window Cleaning'),
            'name'             => 'Мытьё окон в офисе',
            'description'      => 'Офис на 3 этаже, 12 окон. Нужно помыть снаружи и внутри.',
            'address'        => ['city' => 'Kyiv', 'street' => 'пр. Победы, 45'],
            'price'          => 800,
            'currency_code'  => $currency->code,
            'estimated_date' => now()->addDays(7),
            'status'         => TaskStatus::Pending,
        ]);

        // Задача 3: завершена
        $task3 = Task::create([
            'customer_id'      => $customer1->id,
            'sub_category_id'  => $sub('Furniture Assembly'),
            'name'             => 'Сборка кухонного гарнитура',
            'description'      => 'Гарнитур IKEA, 8 секций. Все детали и инструкция есть.',
            'address'        => ['city' => 'Kyiv', 'street' => 'ул. Лесная, 7'],
            'price'          => 600,
            'currency_code'  => $currency->code,
            'estimated_date' => now()->subDays(5),
            'status'         => TaskStatus::Completed,
        ]);

        TaskOrder::create([
            'task_id'     => $task3->id,
            'employee_id' => $employee2->id,
            'status'      => TaskOrderStatus::Completed,
        ]);

        // --- Задачи customer2 ---

        // Задача 4: ожидает исполнителя, два отклика
        $task4 = Task::create([
            'customer_id'      => $customer2->id,
            'sub_category_id'  => $sub('Lawn Mowing'),
            'name'             => 'Стрижка газона на даче',
            'description'      => 'Участок 6 соток, трава высокая. Нужна своя газонокосилка.',
            'address'        => ['city' => 'Lviv', 'street' => 'Дачный переулок, 3'],
            'price'          => 500,
            'currency_code'  => $currency->code,
            'estimated_date' => now()->addDays(2),
            'status'         => TaskStatus::PendingForExecutor,
        ]);

        TaskOrder::create([
            'task_id'     => $task4->id,
            'employee_id' => $employee1->id,
            'status'      => TaskOrderStatus::Pending,
        ]);

        // Задача 5: отменена
        Task::create([
            'customer_id'      => $customer2->id,
            'sub_category_id'  => $sub('Plumbing'),
            'name'             => 'Замена смесителя в ванной',
            'description'      => 'Нужно заменить старый смеситель на новый (смеситель куплен, лежит в коробке).',
            'address'        => ['city' => 'Lviv', 'street' => 'ул. Франко, 22'],
            'price'          => 350,
            'currency_code'  => $currency->code,
            'estimated_date' => now()->subDays(2),
            'status'         => TaskStatus::Cancelled,
        ]);

        // Задача 6: в процессе
        $task6 = Task::create([
            'customer_id'      => $customer2->id,
            'sub_category_id'  => $sub('Package Delivery'),
            'name'             => 'Доставка мебели из магазина',
            'description'      => 'Нужно забрать диван из магазина и доставить домой. Есть грузовое авто или газель.',
            'address'        => ['city' => 'Lviv', 'street' => 'ул. Городоцька, 56'],
            'price'          => 700,
            'currency_code'  => $currency->code,
            'estimated_date' => now()->addDays(1),
            'status'         => TaskStatus::InProgress,
        ]);

        TaskOrder::create([
            'task_id'     => $task6->id,
            'employee_id' => $employee2->id,
            'status'      => TaskOrderStatus::PendingForCompletion,
        ]);

        $this->command->info('Test data seeded successfully.');
        $this->command->table(
            ['Role', 'Email', 'Password'],
            [
                ['customer',  'ivan@example.com',   'password'],
                ['customer',  'olga@example.com',   'password'],
                ['employee',  'mykola@example.com', 'password'],
                ['employee',  'darya@example.com',  'password'],
            ]
        );
    }
}
