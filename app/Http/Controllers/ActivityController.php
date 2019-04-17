<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Activity;
use App\Task;
use App\Assignment;
use Carbon\Carbon;
use Log;


class ActivityController extends Controller
{
    /*public function test(Request $request){
        $user = $request->user();
        return $user->id;
    }*/

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userId = $request->user()->id;

        $activities = Activity::where('userId', '=', $userId)->orderBy('startTime', 'asc')->get();
        foreach ($activities as $activity) {
                $startTime = Carbon::createFromFormat('H:i:s', $activity->startTime);
                $activity->startTime = $startTime->format('H:i');
                $endTime = Carbon::createFromFormat('H:i:s', $activity->endTime);
                $activity->endTime = $endTime->format('H:i');
        }

        if($request->input('withAssignment') != 'yes'){
            return $activities;
        }else{
            $result = Array();
            foreach ($activities as $activity) {
                $item = new \StdClass();

                $tasks = Assignment::where('activityId','=',$activity->id)->leftjoin('tasks','tasks.id','=','assignments.taskId')->get(); 

                $item->activity = $activity;
                $item->tasks = $tasks;
                array_push($result, $item);  
            }
            return $result;        
        }
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
        $activityName = $request->input('name');

        if($activityName){
            //$activity = Activity::firstOrCreate(['activityName' => $activityName]);
            //$activity = Activity::where('activityName', '=', $activityName)->first();
            $activity =Activity::find($request->input('id'));

            if ($activity == null){
                $activity = new Activity; 
                $activity->activityName = $activityName;
            }
            $activity->userId = $request->user()->id;
            $activity->activityName = $activityName;
            $activity->startTime = $request->input('startTime'); 
            $activity->endTime = $request->input('endTime');   
            $activity->description =  $request->input('description'); 
            $activity->save();
        }

        //return (Activity::All());
        return response()->json([
            'message' => 'Success'
        ]);

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
    public function destroy(Request $request,$id)
    {
        //$userId = $request->user()->id; 

        $activity = Activity::find($id);
        if($activity != null){
            $activity->destroy($id);
        }

        Assignment::where('activityId', '=', $id)->delete();
    }
}
