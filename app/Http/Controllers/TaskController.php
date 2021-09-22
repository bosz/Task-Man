<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Project;
use Illuminate\Support\Carbon;
use PhpParser\Node\Expr\PostInc;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $projects = Project::all();
        $tasks = new Task;
        if ($request->get('project_id')) {
            $tasks = $tasks->where('project_id', $request->get('project_id'));
        }
        $tasks = $tasks->orderBy('position', 'desc')->paginate(10);
        return view('task.index')
            ->with('tasks', $tasks)
            ->with('projects', $projects);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string'],
            'priority' => ['required', 'string', 'in:normal,urgent,high'],
            'schedule_date_date' => ['required', 'date'],
            'schedule_date_time' => ['required', 'date_format:H:i'],
            'project_id' => ['required', 'exists:projects,id'],
        ]);

        $task = new Task; 
        $task->name = $request->name;
        $task->priority = $request->priority;
        $task->schedule_date = Carbon::parse($request->schedule_date_date . ' ' . $request->schedule_date_time);
        $task->project_id = $request->project_id;
        $task->save();

        return redirect()->back();
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'task_id' => ['required', 'exists:tasks,id'],
            'name' => ['required', 'string'],
            'priority' => ['required', 'string', 'in:normal,urgent,high'],
            'schedule_date_date' => ['required', 'date'],
            'schedule_date_time' => ['required'],
            'project_id' => ['required', 'exists:projects,id'],
        ]);
        $task = Task::find($request->task_id); 
        $task->name = $request->name;
        $task->priority = $request->priority;
        $task->schedule_date = Carbon::parse($request->schedule_date_date . ' ' . $request->schedule_date_time);
        $task->project_id = $request->project_id;
        $task->save();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function drop($id)
    {
        $task = Task::find($id);
        if ($task) {
            $task->delete(); 
        }

        return redirect()->back();
    }


    public function reorder(Request $request)
    {
        $this->validate($request, [
            'ids' => ['required', 'array'],
            'ids.*' => ['required', 'exists:tasks,id'],
        ]);

        $topTask = Task::orderBy('position')->first();
        $position = $topTask->position + 1;

        $ids = $request->ids;
        foreach($ids as $id) {
            $task = Task::find($id);
            $task->position = $position;
            $task->save();
            $position++;
        }

        return response()->json($ids);
    }
}
