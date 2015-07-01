<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Checklist extends Basemodel implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'checklists';
	protected $guarded = ['id','created_at','updated_at'];
	protected $fillable = ['title','client_id','user_id','start_date','due_date','link_to_folder','description', 'internal_notes', 'notes_to_client', 'status','created_by','organization_id','completed_at'];

	public function scopeOwner($query)
    {
        return $query->where('checklists.created_by', user_id());
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
    public function scopeOurChecklists($query)
    {
        return $query->where('checklists.organization_id', organization_id());
    }
    // public function scopeOnTime($query)
    // {
    //     return $query->where('due_date', '>=', 'completed_at');
    // }

    public function tasks()
    {
        return $this->hasMany('Task');
    }

}
