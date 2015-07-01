<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Client extends Basemodel implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'clients';
	protected $guarded = ['id','created_at','updated_at'];
	protected $fillable = ['company_name','contact_name','email','phone','mobile','address','photo','created_by','organization_id'];

	public function scopeOwner($query)
    {
        return $query->where('created_by', user_id());
    }
    public function scopeOurClients($query)
    {
        return $query->where('clients.organization_id', organization_id());
    }

}
