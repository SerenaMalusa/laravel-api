<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // select all the chosen colunms of the Projects, with the details of related type and technologies, then paginate them
        $projects = Project::orderBy('created_at', 'desc')
            ->select(['id', 'type_id', 'title', 'description', 'repository', 'image', 'github_link', 'creation_date', 'last_commit'])
            ->paginate();

        //cycle all projects
        foreach ($projects as $project) {
            // add the html tag for the badge to the type
            $project->type_badge = $project->type->getBadge();
            // add the html tags for the badges of the technologies
            $project->technologies_badges = $project->getTechnologiesBadges();
            // if there is a related image send the url, else send null
            $project->image = ($project->image) ? asset('/storage/' . $project->image) : null;
        }

        return response()->json($projects);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        //clone the project
        $project_copy = clone $project;
        //get the badge for the type related to this project
        $project_copy->type_badge = $project->type->getBadge();
        //set an empty array
        $technologies_badges = [];
        //for every technology related to this project push the badge into the array
        foreach ($project->technologies as $technology) {
            array_push($technologies_badges, $technology->getBadge());
        }
        //save the array with the badges in a new property of project 
        $project_copy->technologies_badges = $technologies_badges;

        //return the project
        return response()->json($project_copy);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, $id)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     //
    // }
}
