<?php

use App\Modiles\Categories\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name' => 'print templates',
            'slug' => 'print-templates'
        ]);
        Category::create([
            'name' => 'graphics',
            'slug' => 'graphics'
        ]);
        Category::create([
            'name' => 'web & apps',
            'slug' => 'web-apps'
        ]);
        Category::create([
            'name' => 'branding',
            'slug' => 'branding'
        ]);
        Category::create([
            'name' => 'plug-ins',
            'slug' => 'plugins'
        ]);
        Category::create([
            'name' => 'fonts',
            'slug' => 'fonts'
        ]);
        Category::create([
            'name' => '3d assets',
            'slug' => '3d'
        ]);
    }
}
