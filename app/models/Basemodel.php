<?php
class Basemodel extends Eloquent{
	public static function validate($data)
	{
		return Validator::make($data, static::$rules);
	}
	public static function profile_validate($data)
	{
		return Validator::make($data, static::$profile);
	}
	public static function contact_validate($data)
	{
		return Validator::make($data, static::$contacts);
	}
}