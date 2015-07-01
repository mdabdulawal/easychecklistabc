<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Laravel\Cashier\BillableTrait;
use Laravel\Cashier\BillableInterface;

class User extends Basemodel implements UserInterface, RemindableInterface, BillableInterface {

	use UserTrait, RemindableTrait, BillableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';
	protected $guarded = ['id','created_at','updated_at'];
	protected $fillable = ['first_name','middle_name','last_name','title','email', 'password','gender','phone','mobile','address','city','country','role','photo','pricing_id','about','created_by','organization_id'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

    protected $dates = array('trial_ends_at', 'subscription_ends_at');

    public static $rules = array(
                'email' => 'required|email|unique:users',
                'password' => 'required|alpha_num|between: 4,30|confirmed',
                'password_confirmation' => 'required|alpha_num|between: 4,30'
            );

	public function scopeOwner($query)
    {
        return $query->where('created_by', user_id());
    }
    public function tasks()
    {
    	return $this->hasMany('Task');
    }
    public function activities()
    {
        return $this->hasMany('RecentActivity');
    }
    public function scopeSystemAdmin($query)
    {
    	return $query->where('role', '100');
    }
    public function scopePaidUser($query)
    {
    	return $query->where('role', '99');
    }
    public function scopeCompanyAdmin($query)
    {
    	return $query->where('role', '88');
    }
    public function scopeCompanyUser($query)
    {
    	return $query->where('users.role', '77');
    }
    public function scopeMyOrganization($query)
    {
        return $query->where('users.organization_id', organization_id());
    }    

}
