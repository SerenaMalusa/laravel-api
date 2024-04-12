<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTypeRequest;
use App\Http\Requests\UpdateTypeRequest;
use App\Models\Project;
use App\Models\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $types = Type::paginate(10);
        // dd($types);
        return view('admin.types.index', compact('types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.types.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTypeRequest $request)
    {
        // $data = $request->all();
        $data = $request->validated();
        $type = new Type;
        $type->fill($data);
        $type->save();

        return redirect()->route('admin.types.show', $type);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Type $type)
    {
        $types = Type::all();
        $related_projects = Project::where('type_id', $type->id)->paginate(4);
        // dd($related_projects);
        return view('admin.types.show', compact('type', 'related_projects', 'types'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Type $type)
    {
        return view('admin.types.form', compact('type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Type $type
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTypeRequest $request, Type $type)
    {
        // $data = $request->all();
        $data = $request->validated();
        $type->update($data);

        return redirect()->route('admin.types.show', $type);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Type $type)
    {
        // get all the request data
        $data = $request->all();
        // dd($data['project_action']);

        // get all project related to this type from the db
        $related_projects = Project::where('type_id', $type->id)->get();
        // dd($related_projects);

        // for every related project
        foreach ($related_projects as $project) {

            // if the selected project action is delete
            if ($data['project_action'] === 'delete') {

                // delete the project
                $project->delete();
            } else {

                // assign the project to the id selected with the project action
                $project->type_id = $data['project_action'];
                $project->save();
            }
        }

        // then delete the type and redirect to the index view
        $type->delete();
        return redirect()->route('admin.types.index');
    }
}
