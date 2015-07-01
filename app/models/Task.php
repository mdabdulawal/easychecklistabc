<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Task extends Basemodel implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tasks';
	protected $guarded = ['id','created_at'];
	protected $fillable = ['checklist_id','title','start_date','due_date','user_id','link_to_folder','description', 'internal_notes','notes_to_client','status','created_by','organization_id'];

	public function scopeOwner($query)
    {
        return $query->where('created_by', user_id());
    }
    public function scopeMyAssignment($query)
    {
    	return $query->where('user_id', user_id());
    }
    public function scopeRunning($query)
    {
    	return $query->where('status', 'Running');
    }
    public function scopeCompleted($query)
    {
    	return $query->where('status', 'Completed');
    }
    public function scopeOurTasks($query)
    {
        return $query->where('tasks.organization_id', organization_id());
    }

    public function checklist()
    {
        return $this->belongsTo('Checklist');
    }

}
