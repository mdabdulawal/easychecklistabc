<?php

class SystemController extends BaseController{
	/*used for task system setup, view users, pricing table etc.*/
	
	public function showPricing()
	{
		$data['title'] = 'Pricing List';
		$data['pricings'] = Pricing::get();

		return View::make('private.pricing', $data);
	}
	public function createNewPricing()
	{
		$pricing = new Pricing;
		$pricing->fill(Input::all());
		$pricing->save();

		return Redirect::route('pricing')
					->with('message', 'New pricing package added successfully.')
					->with('alertType', 'success');
	}
	public function updatePricing($id)
	{		
		$data['title'] = 'Pricing List';
		$data['pricing'] = Pricing::findOrFail($id);
		$data['pricings'] = Pricing::get();

		return View::make('private.pricing-update', $data);
	}
	public function updatePricingInfo($id)
	{
		$pricing = Pricing::findOrFail($id);
		$pricing->fill(Input::all());
		$pricing->save();

		return Redirect::route('pricing')
					->with('message', 'Pricing info updated successfully.')
					->with('alertType', 'success');
	}
	public function paidUsers()
	{
		$data['title'] = 'Paid users list';
		$data['users'] = User::select('users.*', 'pricings.id as pricing','pricings.package_name')
							->leftJoin('pricings', 'pricings.id', '=', 'users.pricing_id')
							->orderBy('created_at', 'DESC')
							->paidUser()
							->paginate(5);

		return View::make('private.users-paid', $data);
	}
	public function systemAdmin()
	{
		$data['title'] = 'System Admin';
		$data['users'] = User::systemAdmin()->get();

		return View::make('private.system-admin', $data); 
	}
	public function createNew()
	{
		$user = new User;
		$user->fill(Input::except(array('password')));
		$user->password = Hash::make(Input::get('password'));
		$user->role = '100';
		$user->organization_id = organization_id();
		$user->created_by = user_id();
		$user->save();

		/*send an welcome mail to newly created user*/
		$data['mail_title'] = 'Welcome to Easychecklist ABC';
		$data['intro_msg'] = 'Following are your temporary login info for our system:';
		$data['temp_email'] = Input::get('email');
		$data['temp_password'] = Input::get('password');
		Mail::send('emails.welcome-system-admin', $data, function($message)
		{
		    $message->from(Auth::user()->email, 'Easychecklist ABC');
		    $message->subject('Welcome To EasychecklistABC');
		    $message->to(Input::get('email'));		    
		});
		/*mail section ends*/

		return Redirect::back()
					->with('message', 'New system admin added successfully')
					->with('alertType', 'success');
	}
	public function showInfo($id)
	{
		$data['title'] = 'System Admin Info Update';
		$data['user'] = User::findOrFail($id);
		$data['users'] = User::systemAdmin()->get();

		return View::make('private.sys-admin-info-update', $data);
	}
	public function updateInfo($id)
	{
		$user = User::findOrFail($id);
		$user->fill(Input::except(array('password')));
		if(Input::has('password'))
		{
			$user->password = Hash::make(Input::get('password'));
		}
		$user->save();

		return Redirect::route('system-admin')
					->with('message', 'Info updated successfully.')
					->with('alertType', 'success');
	}
	public function upgradePlan($id)
	{
		$data['title'] = 'Upgrade User Plan';
		$data['user'] = User::findOrFail($id);
		$data['pricings'] = Pricing::lists('package_name', 'id');

		return View::make('private.upgrade-user-plan', $data);

	}
	public function upgradeTo($id)
	{
		$pricing_id = Input::get('pricing_id');
		$user = User::findorFail($id);

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
		$user->subscription($plan)->swap();		
		$user->pricing_id = $pricing_id;
		$user->save();

		return Redirect::route('paid-users')
					->with('title', 'Subscription Upgraded.')
					->with('alertType', 'success');
	}
	public function demoTemplates()
	{
		$data['title'] = 'Demo Templates';
		$data['checklist'] = Checklist::ourChecklists()
								->with('tasks')
								->select('checklists.*', 'clients.company_name')
								->leftJoin('clients', 'clients.id', '=', 'checklists.client_id')
								->orderBy('created_at', 'DESC')
								->get();
		$data['users'] = User::myOrganization()				
							->select('id', DB::raw('CONCAT(`first_name`, " ", `middle_name` , " ", `last_name`) AS full_name'))
							->lists('full_name', 'id');
		return View::make('private.demo-checklist', $data);
	}
	public function demoNewTemplates()
	{
		$data['title'] = 'Demo Templates';
		$data['users'] = User::myOrganization()				
							->select('id', DB::raw('CONCAT(`first_name`, " ", `middle_name` , " ", `last_name`) AS full_name'))
							->lists('full_name', 'id');
		return View::make('private.create-demo-checklist', $data);
	}
	public function saveChecklistInfo()
	{
		$checklist = new Checklist;
		$checklist->fill(Input::except(array('created_by','organization_id')));
		$checklist->created_by = user_id();
		$checklist->organization_id = organization_id();
		$checklist->save();

		/*fetch last inserted checklist info and send those
		 data to create new task to this checklist*/
		$data['title'] = 'Add Task';
		$data['to_checklist'] = Checklist::where('id', $checklist->id)->lists('title', 'id');
		$data['checklist'] = Checklist::findorFail($checklist->id);
				
		return View::make('private.demo-task', $data);
	}
	public function saveTaskInfo()
	{
		$task = new Task;
		$task->fill(Input::except(array('created_by','organization_id')));
		$task->created_by = user_id();
		$task->organization_id = organization_id();
		$task->save();

		return Redirect::route('demo-templates')
				->with('message', 'Congratulation ! Task info added to demo checklist successfully.')
				->with('alertType', 'success');
	}
	
}