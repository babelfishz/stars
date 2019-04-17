<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Assignment;
use App\Task;
use App\Activity;
use Log;

class AssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Assignment::All();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $taskId = $request->taskId;
        $source = $request->input('source');
        $chosen = json_decode($request->chosen);


        $activityList = Activity::All();
        foreach ($activityList as $activity) {
            if(in_array($activity->id, $chosen)){
                //log::info("yes");
                $assignment = Assignment::where('taskId', '=', $taskId)->where('activityId','=',$activity->id)->first();
                if($assignment == null){
                    $assignment = new Assignment;
                    $assignment->taskSource = $source;
                    $assignment->taskId = $taskId;
                    $assignment->activityId = $activity->id;
                    $assignment->save();
                }
            }
            else{
                //log::info("nop");
                $assignments = Assignment::where('taskId', '=', $taskId)->where('activityId','=',$activity->id)->get();
                foreach ($assignments as $assignment) {
                    $assignment->delete();
                }
            }
        }

        return Assignment::All();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
