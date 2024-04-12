<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $names = ['Frontend', 'Backend', 'Fullstack'];

        foreach ($names as $name) {

            $type = new Type;
            $type->name = $name;
            $type->description = $faker->sentence();
            $type->colour = $faker->hexColor();
            $type->save();
        }
    }
}
