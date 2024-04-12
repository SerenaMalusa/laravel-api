<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Technology;
use Illuminate\Support\Str;
use App\Models\Type;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    //
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // get all types and all technologies form db
        $types = Type::all();
        $technologies = Technology::all();
        // dd($types);
        return view('admin.projects.create', compact('types', 'technologies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectRequest $request)
    {
        // $data = $request->all();
        // dd($request);
        $data = $request->validated();
        $project = new Project();
        $project->fill($data);
        $project->slug = Str::slug($data['title'], '-');

        //ifthe request contains the key image then save it in the store folder and save the path in the db
        if ($request->hasFile('image')) $project->image = Storage::put('uploads/projects', $request->file('image'));

        $project->save();

        //if the key technologies exist in the array data, then assign the values passed
        //with data[technologies] to the project, creating the relations
        if (Arr::exists($data, 'technologies')) $project->technologies()->attach($data['technologies']);

        return redirect()->route('projects.show', $project);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        // get all types and all technologies form db
        $types = Type::all();
        $technologies = Technology::all();

        //get an array of the ids of the technologies related to this project
        $technologies_ids = $project->technologies->pluck('id')->toArray();

        return view('admin.projects.edit', compact('project', 'types', 'technologies', 'technologies_ids'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        // $data = $request->all();
        // dd($request);
        $data = $request->validated();
        // $project->update($data);
        $project->fill($data);
        $project->slug = Str::slug($data['title'], '-');

        //if the project already has an image
        if ($request->hasFile('image')) {
            //delete it from the storage
            if ($project->image) Storage::delete($project->image);
        }
        //then substitute the values
        if ($request->hasFile('image')) $project->image = Storage::put('uploads/projects', $request->file('image'));


        $project->save();

        //if the key technologies exist in the array data
        if (Arr::exists($data, 'technologies')) {
            //assign the values passed
            //with data[technologies] to the project, creating the relationships
            $project->technologies()->sync($data['technologies']);
        } else {
            //detach all technologies from this project
            $project->technologies()->detach();
        }

        return redirect()->route('projects.show', $project);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comic  $comic
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('projects.index');
    }
}
