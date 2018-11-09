<?php

use App\Modiles\Categories\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Category::truncate();
         $this->call(CategorySeeder::class);
    }
}
