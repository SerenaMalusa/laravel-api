<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Technology;
use Faker\Generator as Faker;

class ProjectTechnologySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        //get all projects from DB
        $projects = Project::all();
        //get all technologies from DB and put ids into an array
        $technologies_ids = Technology::all()->pluck('id');

        //cycle all projects
        foreach ($projects as $project) {

            //get a rundom number of random technologies ids
            // $rand_technology_ids = $faker->randomElements($technologies_ids, rand(1, sizeof($technologies_ids)));
            $rand_num = rand(1, sizeof($technologies_ids));
            $rand_ids = $faker->randomElements($technologies_ids, $rand_num);

            // var_dump($project->id);
            // var_dump($rand_num);
            // var_dump($rand_ids);

            //then assign the ids to the project
            $project->technologies()->sync($rand_ids);
        }
    }
}
