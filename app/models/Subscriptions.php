<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Subscription extends Basemodel implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'subscriptions';
	protected $fillable = ['user_id','transaction_id','amount','user_email','currency','card_type','last4digit','captured'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	// public function scopeCompleted($query)
 //    {
 //    	return $query->where('payment_status', 'Completed');
 //    }
 //    public function scopeSuccess($query)
 //    {
 //    	return $query->where('acknowledgement', 'Success');
 //    }
 //    public function scopeMonth($query)
 //    {
 //    	return $query->where(DB::raw('MONTH(created_at)'), DB::raw('MONTH(NOW())'));
 //    }
 //    public function scopeYear($query)
 //    {
 //    	return $query->where(DB::raw('YEAR(created_at)'), DB::raw('YEAR(NOW())'));
 //    }
 //    public function scopeMe($query)
 //    {
 //    	return $query->where('user_id', user_id());
 //    }

}
