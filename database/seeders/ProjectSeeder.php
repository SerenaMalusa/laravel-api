<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $types = Type::all()->pluck('id');
        // $types[] = null;

        for ($i = 0; $i < 50; $i++) {

            $project = new Project();
            $project->type_id = $faker->randomElement($types);
            $project->title = $faker->words(3, true);
            $project->slug = Str::slug($project->title, '-');
            $project->description = $faker->sentence(20);
            $project->repository = $faker->word() . '-' . $faker->word();
            $project->github_link = $faker->url();
            $rand_date = $faker->dateTimeThisYear();
            $project->creation_date = $rand_date;
            $new_date = clone $rand_date;
            $project->last_commit = $new_date->modify("+2 day");
            $project->save();
        }
    }
}
