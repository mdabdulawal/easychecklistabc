<?php

class ChecklistReminder extends \Eloquent {
	protected $table = 'checklist_reminders';
	protected $guarded = ['id','created_at','updated_at'];
	protected $fillable = ['user_id', 'client_id', 'checklist_id', 'notify_date', 'status'];

	public function scopeToday($query)
    {
        return $query->where('notify_date', date('Y-m-d'));
    }
    public function scopeNext($query)
    {
        return $query->where('notify_date', '>=', date('Y-m-d'));
    }
    public function scopeMyNotification($query)
    {
        return $query->where('checklist_reminders.user_id', user_id());
    }
}