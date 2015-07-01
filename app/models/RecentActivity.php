<?php

class RecentActivity extends \Eloquent {
	protected $table = 'recent_activities';
	protected $guarded = ['id','created_at','updated_at'];
	protected $fillable = ['user_id', 'type','activity','organization_id'];

	public function scopeMe($query)
    {
    	return $query->where('user_id', user_id());
    }
    public function scopeOurActivities($query)
    {
        return $query->where('recent_activities.organization_id', organization_id());
    }
    public function user()
    {
    	return $this->belongsTo('User');
    }
}