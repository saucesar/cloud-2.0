<?php

use App\Models\UserCategory;
use Illuminate\Database\Seeder;

class UserCategorySeeder extends Seeder
{
    public function run()
    {
        factory(UserCategory::class, 10)->create();
    }
}
