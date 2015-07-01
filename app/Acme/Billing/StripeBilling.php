<?php namespace Acme\Billing;

use Stripe;
use Stripe_Charge;
use Config;

class StripeBilling implements BillingInterface {

	public function __construct()
	{
		Stripe::setApiKey('sk_test_4Roa6DikSZ2ecSwRNQaTELhK');
	}

	public function charge(array $data)
	{
		try
		{
			return Stripe_Charge::create([
				'amount' => 1000, // 1 USD = 10
				'currency' => 'usd',
				'description' => $data['email'],
				'card' => $data['token']
			]);
		}catch(Stripe_CardError $e)
		{
			dd('Card was declined !');
		}		
	}

}