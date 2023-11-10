<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
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
        ->select('id','title','type_id','slug', 'cover_image',)
        ->paginate(12);
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
        return response()->json($project);
    }

}
