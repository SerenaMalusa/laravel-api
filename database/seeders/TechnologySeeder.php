<?php

namespace Database\Seeders;

use App\Models\Technology;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class TechnologySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $names = ['Html', 'CSS', 'Bootstrap', 'Javascript', 'NodeJs', 'Vue+Vite', 'Axios', 'MYSQL', 'php', 'Laravel', 'Blade'];

        foreach ($names as $name) {
            $technology = new Technology;
            $technology->name = $name;
            $technology->colour = $faker->hexColor();
            $technology->save();
        }
    }
}
