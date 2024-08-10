<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("categories")->insert([
            "category_name" => "Hot Drink",
        ]);

        DB::table("categories")->insert([
            "category_name" => "Cold Drink",
        ]);

        DB::table("categories")->insert([
            "category_name" => "Savory",
        ]);

     
    }
}
