<?php

namespace App\Http\Controllers\Api\TodoTasks\V1;

use App\Project;
use App\Timer;
use App\Todo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Controllers\API\ApiResponse;

class ProjectController extends BaseController
{


    public function index()
    {
        $projects = Auth::user()->projects()->get();
        return $this->sendOkResponse($projects->toArray(), 'Projects retrieved successfully.');
    }

    public function show($id)
    {
        $user = Auth::user();

        $project = Project::where('user_id', $user->id)->where('id', $id)->first();

        if (!$project) {
            return $this->sendBadRequest('Resource cannot be found.');
        }

        return $this->sendOkResponse($project->toArray(), 'Projects retrieved successfully.');
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();

    
        $project = Project::where('user_id', $user->id)->where('id', $id)->first();

        if (!$project) {
            return $this->sendBadRequest('Resource cannot be found.');
        }
        
        $project->update(
            [
                'description' => $request->description,
                'name' => $request->name,
            ]
        );
        

        return $this->sendOkResponse($project->toArray(), 'Project updated successfully.');
    }

    public function store(Request $request)
    {
        if($request->frequency == 'No recurrence'){
            $request->frequency = null;
        }

        $user = Auth::user();
        $project = new Project([
            'user_id' => $user->id,
            'description' => $request->description,
            'name' => $request->name,
        ]);
        $project->save();

        return $this->sendOkResponse($project->toArray(), 'Project created successfully.');
    }

    public function destroy($id)
    {
        $user = Auth::user();

        $project = Project::where('user_id', $user->id)->where('id', $id)->first();

        if (!$project) {
            return $this->sendBadRequest('Resource cannot be found.');
        }

        $project->delete();
        return $this->sendOkResponse($project->toArray(), 'Project successfully deleted.');
    }
}
