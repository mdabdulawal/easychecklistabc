<?php

class TaskReminder extends \Eloquent {
	protected $table = 'task_reminders';
	protected $guarded = ['id','created_at','updated_at'];
	protected $fillable = ['user_id', 'client_id', 'task_id', 'notify_date', 'status'];

	public function scopeToday($query)
    {
        return $query->where('notify_date', date('Y-m-d'));
    }
}