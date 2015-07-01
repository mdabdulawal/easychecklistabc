<?php

class UserController extends BaseController{
	/*used for profile setup, create clients etc.*/

	public function viewProfile()
	{
		if(Auth::user()->role == '100')
		{
			$data['title'] = 'System Admin';
			$data['system_admin'] = User::systemAdmin()->count();
			$data['paid_user'] = User::paidUser()->count();
			$data['company_user'] = User::companyUser()->count();
			$data['pricing'] = Pricing::count();

			return View::make('private.system-admin-dashboard', $data);
		}
		elseif(Auth::user()->role == '99')
		{
			$data['title'] = 'Company Dashboard :: Easychecklist ABC';

			$employees = User::myOrganization()->lists('id');
			
			$data['task_overview'] = Task::select(DB::raw('COUNT(CASE WHEN status = "Running" THEN id END) AS Running'), 
											DB::raw('COUNT(CASE WHEN status = "Completed" THEN id END) AS Completed'),
											DB::raw('COUNT(*) AS Total'))
										->ourTasks()
										->first();

			$data['checklist_overview'] = Checklist::select(DB::raw('COUNT(CASE WHEN status = "Running" THEN id END) AS Running'), 
											DB::raw('COUNT(CASE WHEN status = "Completed" THEN id END) AS Completed'),
											DB::raw('COUNT(*) AS Total'))
										->ourChecklists()
										->first();

			$data['avg_completion_time'] = Checklist::completed()
										->ourChecklists()										
										->sum(DB::raw('TIMESTAMPDIFF(DAY,start_date,completed_at)'));

			$data['on_time'] = Checklist::select(array('id'))
									->ourChecklists()
									->whereRaw('due_date >= completed_at')
									->completed()->count();

			$data['checklist_reminders'] = ChecklistReminder::select(array('clients.company_name',
																		'checklists.title','checklists.due_date',
																		'checklist_reminders.notify_date',
																		'users.first_name','users.last_name','users.email'))
															->leftJoin('clients','clients.id', '=', 'checklist_reminders.client_id')
															->leftJoin('checklists','checklists.id', '=', 'checklist_reminders.checklist_id')
															->leftJoin('users','users.id', '=', 'checklist_reminders.user_id')
															->next()
															->whereIn('checklist_reminders.user_id', $employees)
															->limit(50)
															->get();
															
           /*$data['myAssignments'] = Assignment::select(array('assignments.task_id', 'tasks.title', 'tasks.start_date', 'tasks.due_date','tasks.status', DB::raw('round(( 30/50 * 100 ),2) as res')))
								->leftJoin('tasks', 'tasks.id', '=', 'assignments.task_id')
								->myAssignment()
								->orderBy('assignments.created_at', 'DESC')->limit(50)->get();*/
			$data['myAssignments'] = Checklist::MyAssignment()
					// ->ourClients()
					->select('checklists.*')
					->orderBy('checklists.created_at', 'DESC')->limit(50)->get();					


			$data['activities'] = RecentActivity::with('user')
											->ourActivities()
											->orderBy('created_at', 'DESC')												
											->limit(20)->get();

			return View::make('private.company-admin-dashboard', $data);
		}
		else
		{
			$data['title'] = 'User Dashboard :: Easychecklist ABC';

			$data['activities'] = RecentActivity::with('user')
											->ourActivities()
											->orderBy('created_at', 'DESC')											
											->limit(20)->get();

			$data['myAssignments'] = Assignment::select(array('assignments.task_id', 'tasks.title', 'tasks.start_date', 'tasks.due_date','tasks.status'))
								->leftJoin('tasks', 'tasks.id', '=', 'assignments.task_id')
								->myAssignment()
								->orderBy('assignments.created_at', 'DESC')->limit(50)->get();

			return View::make('private.company-user-dashboard', $data);
		}
	}
	public function basicInfo()
	{
		$data['title'] = 'Manage Profile';
		$data['pricings'] = Pricing::lists('package_name', 'id');
		$data['user'] = User::findorFail(user_id());

		return View::make('private.info', $data);
	}
	public function all()
	{
		$data['title'] = 'Manage Profile';
		$data['users'] = User::myOrganization()->get();
		// $data['users'] = User::owner()
		// 					->orWhere(function($query)
		// 				        {
		// 				            $query->where('created_by', '=', Auth::user()->created_by)
		// 				                  ->where('created_by', '!=', '0');
		// 				        })
		// 					->get();

		return View::make('private.users', $data);
	}
	public function updateProfile()
	{
		$user = User::findOrFail(user_id());
		$user->fill(Input::all());
		$user->save();

		RecentActivity::create([
			'user_id' => user_id(),
			'type' => 'profile',
			'activity' => 'has a updated profile',
			'organization_id' => organization_id()
		]);

		return Redirect::route('basic-info')
				->with('message', 'Profie Updated Successfully !')
				->with('alertType', 'success');
	}
	public function changeAvatar()
	{		
		if(Input::hasFile('photo'))
		{
			$user = User::findOrFail(user_id());
			/*image manipulation part -starts*/
			$file_name = $user->id.'-'.Input::file('photo')->getClientOriginalName();

			$image = Image::make(Input::file('photo')->getRealPath());

			File::exists(user_photos_path()) or File::makeDirectory(user_photos_path());

			$image->save(user_photos_path() . $file_name)
					->resize(320, 240)
					->save(user_photos_path() . $file_name);
			/*image manipulation part -ends*/
			$user->photo = $file_name; // $file_name assigned as the value of 'photo' field 
			$user->save();
		}		

		return Redirect::route('basic-info')
				->with('message', 'Your avatar has been updated !')
				->with('alertType', 'success');
	}
	public function changeUserPass()
	{
		$user = User::findorFail(user_id());
		$currentPass = Input::get('current-pass');

		if(Hash::check($currentPass, $user->password))
		{
			$newPass = Input::get('new-pass');
			$rePass = Input::get('re-pass');
			if($newPass == $rePass)
			{
				$user->password = Hash::make($rePass);
				$user->save();

				return Redirect::route('profile')
							->with('message', 'Password Changed Successfully !')
							->with('alertType', 'success');
			}
			else
			{
				return Redirect::back()
						->with('message', 'Make sure that new password and retype password fields are same')
						->with('alertType', 'danger');
			}				
		}
		else
		{
			return Redirect::back()
					->with('message', 'Given one is not current password. Try with the correct one.')
					->with('alertType', 'danger');
		}			
	}

	/*create new user for company - role :77*/
	public function addNewUser()
	{
		$data['title'] = 'Create New User';
		return View::make('private.add-new-user', $data);		
	}
	public function saveUserInfo()
	{
		$subscription_type = User::select(array('stripe_plan'))->where('email', Auth::user()->organization_id)->first();
		$total_user = User::myOrganization()->count();

		switch ($subscription_type->stripe_plan) {
			case 'monthly':
				$max_user = 5;
				break;
			case 'yearly':
				$max_user = 5;
				break;
			case 'monthly2':
				$max_user = 15;
				break;
			case 'yearly2':
				$max_user = 15;
				break;
			case 'monthly3':
				$max_user = 25;
				break;
			case 'yearly3':
				$max_user = 25;
				break;
			
			default:
				$max_user = 0;
				break;
		}

		if($total_user < $max_user)
		{
			$user = new User;
			$user->fill(Input::except(array('password','photo')));		
			$user->password = Hash::make(Input::get('password'));
			$user->role = '77';
			$user->created_by = user_id();
			$user->organization_id = organization_id();
			if(Input::hasFile('photo'))
			{
				/*image manipulation part -starts*/
				$file_name = 'user-'.time().'-'.Input::file('photo')->getClientOriginalName();

				$image = Image::make(Input::file('photo')->getRealPath());

				File::exists(user_photos_path()) or File::makeDirectory(user_photos_path());

				$image->save(user_photos_path() . $file_name)
						->resize(320, 240)
						->save(user_photos_path() . $file_name);
				/*image manipulation part -ends*/
				$user->photo = $file_name; // $file_name assigned as the value of 'photo' field 
			}
			$user->save();

			/*Add Event Recent Activities -Starts*/
			$highlight = '<strong>'.$user->first_name.' '.$user->last_name.'</strong>';
			RecentActivity::create([
				'user_id' => user_id(),
				'type' => 'user',
				'activity' => 'created a new user named '.$highlight,
				'organization_id' => organization_id()
			]);
			/*Add Event Recent Activities -Ends*/

			/*send an welcome mail to newly created user*/
			$data['mail_title'] = 'Welcome to Easychecklist ABC';
			$data['intro_msg'] = 'Following are your temporary login info for our system:';
			$data['temp_email'] = Input::get('email');
			$data['temp_password'] = Input::get('password');
			Mail::send('emails.welcome-company-user', $data, function($message)
			{
			    $message->from(Auth::user()->email, 'Easychecklist ABC');
			    $message->subject('Welcome To EasychecklistABC');
			    $message->to(Input::get('email'));		    
			});
			/*mail section ends*/

			return Redirect::route('users')
					->with('message', 'New user addedd successfully.')
					->with('alertType', 'success');
		}
		else
		{
			return Redirect::route('users')
					->with('message', 'Sorry ! Max. number of user already added as per your subscription plan.')
					->with('alertType', 'danger');
		}		
	}
	public function userOverview($id)
	{
		$data['title'] = 'User Overview';
		$data['user'] = User::findorFail($id);

		return View::make('private.user-profile', $data);
	}
	/*create new user section ends*/
	public function userInfoUpdate($id)
	{
		$user = User::findorFail($id);
		$user->fill(Input::except(array('password', 'photo')));
		if(Input::hasFile('photo'))
		{
			/*image manipulation part -starts*/
			$file_name = 'user-'.time().'-'.Input::file('photo')->getClientOriginalName();

			$image = Image::make(Input::file('photo')->getRealPath());

			File::exists(user_photos_path()) or File::makeDirectory(user_photos_path());

			$image->save(user_photos_path() . $file_name)
					->resize(320, 240)
					->save(user_photos_path() . $file_name);
			/*image manipulation part -ends*/
			$user->photo = $file_name; // $file_name assigned as the value of 'photo' field
		}
		$user->save();

		return Redirect::back()
					->with('User profile info updated successfully.')
					->with('alertType', 'success');
	}
	public function deleteUser($id)
	{
		$user = User::findorFail($id);
		if($user->created_by == user_id())
		{
			$user->delete();

			/*Add Event Recent Activities -Starts*/
			$highlight = '<strong>'.$user->first_name.' '.$user->last_name.'</strong>';
			RecentActivity::create([
				'user_id' => user_id(),
				'type' => 'delete',
				'activity' => 'deleted a user named '.$highlight,
				'organization_id' => organization_id()
			]);
			/*Add Event Recent Activities -Ends*/

			return Redirect::back()
					->with('message', 'User deleted successfully !')
					->with('alertType', 'success');
		}
		else
			return Redirect::back()
					->with('message', 'Sorry, You do not have sufficient permissions to do that.')
					->with('alertType', 'danger');
	}
}