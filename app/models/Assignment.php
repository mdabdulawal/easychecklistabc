<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Assignment extends Basemodel implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'assignments';
	protected $guarded = ['id','created_at','updated_at'];
	protected $fillable = ['task_id','user_id','status'];

    public function scopeMyAssignment($query)
    {
    	return $query->where('assignments.user_id', user_id());
    }
    public function scopeRunning($query)
    {
    	return $query->where('assignments.status', 'Running');
    }
    public function scopeCompleted($query)
    {
    	return $query->where('assignments.status', 'Completed');
    }
}
