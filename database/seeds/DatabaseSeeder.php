<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UserCategorySeeder::class,
            UsersTableSeeder::class,
            ImageSeeder::class,
            TemplateSeeder::class,
        ]);

        \App\Models\Maquina::create([
            'cpu_utilizavel' => 30,
            'ram_utilizavel' => 1024,
            'hashcode' => '$2y$10$meLLu4qZwa9GXlGSB9/KLu/KDT.ayLqTAFKbtxP/qQpieyFe2.wUW',
            'user_id' => 1,
            'ip' => '1.1.1.1',
        ]);
    }
}
