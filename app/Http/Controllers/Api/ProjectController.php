<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Type;
use Illuminate\Http\Request;
use App\Models\Projects;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::with('type','technologies',)
            ->select('id','title','type_id','slug', 'cover_image','description')
            ->paginate(12);

        foreach ($projects as  $project) {
            $project->description = $project->getAbstract(200);
            $project->cover_image = $project->getAbsUriImage();
        }

        return response()->json($projects);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = Project::with('type','technologies',)
            ->select('id','title','type_id','slug', 'cover_image','description')
            ->where('id', $id)
            ->first();
        
        if (!$project)
            abort(404, 'project not found');
        
        return response()->json($project);
    }

    public function ProjectsByType($type_id){

        $type = Type::select('id', 'color', 'label')
            ->where('id', $type_id)
            ->first();

        if (!$type)
            abort(404, 'type not found');

        $projects = Project::with('type','technologies',)
            ->select('id','title','type_id','slug', 'cover_image','description')
            ->where('type_id', $type_id)
            ->orderByDesc('id')
            ->paginate(12);

        foreach ($projects as  $project) {
            $project->description = $project->getAbstract(200);
            $project->cover_image = $project->getAbsUriImage();
        }

        return response()->json($projects);

    }

}
