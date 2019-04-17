<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Log;

class Activity extends Model
{
    /*public function getStartTimeAttribute($value)
	{
		//Log::info('start time');
    	$time = Carbon::createFromFormat('H:i:s', $value);
    	return $time->format('H:i');
	}

	public function getEndTimeAttribute($value)
	{
		//Log::info('end time');
    	$time = Carbon::createFromFormat('H:i:s', $value);
    	return $time->format('H:i');
	}*/
}
