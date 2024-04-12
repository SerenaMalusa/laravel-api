<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTechnologyRequest;
use App\Http\Requests\UpdateTechnologyRequest;
use App\Models\Project;
use App\Models\Technology;
use Illuminate\Http\Request;

class TechnologyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get all technologies from DB and paginate them so you can see 10 per page
        $technologies = Technology::paginate(10);
        //return the view index and pass the variables to it
        return view('admin.technologies.index', compact('technologies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //return the create view
        return view('admin.technologies.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTechnologyRequest $request)
    {
        //estrapolate data from the request
        // $data = $request->all();
        $data = $request->validated();
        // dd($data);

        //create a new technology and fill it, then save it
        $technology = new Technology;
        $technology->fill($data);
        $technology->save();

        //redirect to the view show of the technology just created
        return redirect()->route('admin.technologies.show', $technology);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Technology  $technology
     * @return \Illuminate\Http\Response
     */
    public function show(Technology $technology)
    {
        // get all the ids of the projects related to this technology,
        // then get all the projects with those ids
        $related_projects_ids = $technology->projects->pluck('id')->toArray();
        $related_projects = Project::whereIn('id', $related_projects_ids)->paginate(6);
        // dd($related_projects);

        //return the view show and pass the variables
        return view('admin.technologies.show', compact('technology', 'related_projects'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Technology  $technology
     * @return \Illuminate\Http\Response
     */
    public function edit(Technology $technology)
    {
        //return the form view and pass the technology to modify
        return view('admin.technologies.form', compact('technology'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Technology  $technology
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTechnologyRequest $request, Technology $technology)
    {
        //estract the data from the request, then update the thech with it
        // $data = $request->all();
        $data = $request->validated();
        $technology->update($data);

        //return the show view of the modified tech
        return redirect()->route('admin.technologies.show', $technology);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Technology  $technology
     * @return \Illuminate\Http\Response
     */
    public function destroy(Technology $technology)
    {
        //delete all relationships between this tech and the related projects
        $technology->projects()->detach();
        //delete the technology
        $technology->delete();

        //redirect to the tech index view
        return redirect()->route('admin.technologies.index');
    }
}
