<?php

class AuthController extends BaseController{
	/*used for signup, signin and signout*/

	public function login()
	{
		$data['title'] = 'Login Panel :: Checklist ABC';
		$data['pricings'] = Pricing::lists('package_name', 'id');
		return View::make('public.login', $data);
	}
	public function register()
	{
		$token = Input::get('stripe-token');		

		switch(Input::get('pricing_id')) {
			case '3':
				$plan = 'monthly2';
				break;

			case '5':
				$plan = 'monthly3';
				break;
			
			case '2':
				$plan = 'yearly';
				break;

			case '4':
				$plan = 'yearly2';
				break;

			case '6':
				$plan = 'yearly3';
				break;

			default:
				$plan = 'monthly';
				break;
		}

		$validation = User::validate(Input::all());
		if($validation->passes())
		{
			$user = new User;
			$user->fill(Input::except(array('password','organization_id')));
			$user->password = Hash::make(Input::get('password'));
			$user->organization_id = Input::get('email');
			$user->save();

			User::findorFail($user->id)->subscription($plan)->create($token);

			/*send an welcome mail to newly created paid user*/
			$plan = Pricing::select('package_name')
						->where('id', '=', Input::get('pricing_id'))->limit(1)->first();

			$data['mail_title'] = 'Welcome to Easychecklist ABC';
			$data['intro_msg'] = 'Welcome To EasychecklistABC. Following are your basic info. Please login to our system to update your profile.';
			$data['email'] = Input::get('email');
			$data['plan'] = $plan->package_name;
			
			Mail::send('emails.welcome-paid-user', $data, function($message)
			{
			    $message->from('info@easychecklistabc.com', 'Easychecklist ABC');
			    $message->subject('Welcome To EasychecklistABC');
			    $message->to(Input::get('email'));		    
			});
			/*mail section ends*/

			return Redirect::route('login')
						->with('message', 'Your account has been created successfully.')
						->with('alertType', 'success');
		}
		else
		{
			return Redirect::route('login')->withErrors($validation)->withInput();						
		}		
	}
	public function authentication()
	{
		$user = array(
				'email' => Input::get('email'),
				'password' => Input::get('password')
			);
		if(Auth::attempt($user))
		{
			return Redirect::route('profile');
		}
		else
		{
			return Redirect::route('login')
				->with('message', 'Your Email/Password combination is incorrect. Please Try Again.')
				->with('alertType', 'danger');
		}
	}
	public function logout()
	{

		if(Auth::check())
		{
			Auth::logout();
			return Redirect::route('login')
				->with('message', 'You are logged out.')
				->with('alertType', 'success');
		}
		else
		{
			return Redirect::route('profile');
		}
	}
	public function upgradePlan()
	{
		$pricing_id = Input::get('pricing_id');
		$user = User::findorFail(user_id());

		switch ($pricing_id) {
			case '3':
				$plan = 'monthly2';
				break;

			case '5':
				$plan = 'monthly3';
				break;
			
			case '2':
				$plan = 'yearly';
				break;

			case '4':
				$plan = 'yearly2';
				break;

			case '6':
				$plan = 'yearly3';
				break;

			default:
				$plan = 'monthly';
				break;
		}
		Auth::user()->subscription($plan)->swap();		
		$user->pricing_id = $pricing_id;
		$user->save();

		return Redirect::back()->with('message', 'Congratulations ! Your are upgraded to new package.')
								->with('alertType', 'success');
	}
	public function cancelSubscription()
	{
		Auth::user()->subscription()->cancel();

		return Redirect::back()->with('message', 'Your are unsubscribed now !')
								->with('alertType', 'success');
	}
	public function reSubscription()
	{
		$user = User::findorFail(user_id());
		$user->subscription($user->stripe_plan)->resume();

		return Redirect::back()->with('message', 'Your are subscribed ! Thanks.')
								->with('alertType', 'success');
	}
}