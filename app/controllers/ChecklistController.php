<?php

class ChecklistController extends BaseController{
	/*used for cheklist setup, view checklist etc.*/

	public function addChecklist()
	{
		$data['title'] = 'Create New Checklist';
		$data['users'] = User::select('id', DB::raw('CONCAT(`first_name`, " ", `middle_name` , " ", `last_name`) AS full_name'))
							->myOrganization()
							->lists('full_name', 'id');
		$data['clients'] = Client::ourClients()->lists('company_name', 'id');
			
		return View::make('private.add-new-checklist', $data);
	}
	public function saveChecklistInfo()
	{	
		
		$checklist = new Checklist;
		$checklist->fill(Input::except(array('created_by','organization_id')));
		$checklist->created_by = user_id();
		$checklist->organization_id = organization_id();
		$checklist->internal_notes = Input::get('internal_notes');
		$checklist->notes_to_client = Input::get('notes_to_client');
		$checklist->save();

		//added for commit only

		/*Email Reminders -Starts*/
		$user_id = Input::get('user_id');
		$client_id = Input::get('client_id');
		$checklist_id = $checklist->id;
		$send_to = Input::get('send_to');
		$start_date = Input::get('start_date');
		$due_date = Input::get('due_date');
		$type = Input::get('email_reminders');
		$sendToClients = json_encode(Input::get('sendToClients'));

		
		switch ($type) {
			case 'weekly':				
				while ($due_date > $start_date) {
					if(date('Y-m-d', strtotime($start_date . " +1 week")) < $due_date)
					{
						$reminder = new ChecklistReminder;
						$reminder->user_id = $user_id;
						$reminder->client_id = $client_id;
						$reminder->send_to = $send_to;
						$reminder->send_to_clients = $sendToClients;
						$reminder->checklist_id = $checklist_id;
						$reminder->notify_date = date('Y-m-d', strtotime($start_date . " +1 week"));
						$reminder->save();		
						$start_date = $reminder->notify_date;				
					}
					else
					{
						$start_date = $due_date;
					}					
				}
				break;
			case 'monthly':
				while ($due_date > $start_date) {
					if(date('Y-m-d', strtotime($start_date . " +1 month")) < $due_date)
					{
						$reminder = new ChecklistReminder;
						$reminder->user_id = $user_id;
						$reminder->client_id = $client_id;
						$reminder->checklist_id = $checklist_id;
						$reminder->send_to = $send_to;
						$reminder->send_to_clients = $sendToClients;
						$reminder->notify_date = date('Y-m-d', strtotime($start_date . " +1 month"));
						$reminder->save();	
						$start_date = $reminder->notify_date;					
					}
					else
					{
						$start_date = $due_date;
					}
				}
				break;
			
			default:
				while ($due_date > $start_date) {
					if(date('Y-m-d', strtotime($start_date . " +1 day")) < $due_date)
					{
						$reminder = new ChecklistReminder;
						$reminder->user_id = $user_id;
						$reminder->client_id = $client_id;
						$reminder->checklist_id = $checklist_id;
						$reminder->send_to = $send_to;
						$reminder->send_to_clients = $sendToClients;
						$reminder->notify_date = date('Y-m-d', strtotime($start_date . " +1 day"));
						$reminder->save();
						$start_date = $reminder->notify_date;
					}
					else
					{
						$start_date = $due_date;
					}				
				}
				break;
		}
		/*Email Reminders -Ends*/

		/*Add Event Recent Activities -Starts*/
		$highlight = '<strong>'.$checklist->title.'</strong>';
		RecentActivity::create([
			'user_id' => user_id(),
			'type' => 'checklist',
			'activity' => 'created a new checklist with title of '.$highlight,
			'organization_id' => organization_id()
		]);
		/*Add Event Recent Activities -Ends*/

		/*fetch last inserted checklist info and send those
		 data to create new task to this checklist*/
		$data['title'] = 'Add Task';
		$data['to_checklist'] = Checklist::where('id', $checklist->id)->lists('title', 'id');
		$data['checklist'] = Checklist::findorFail($checklist->id);

		$data['users'] = User::select('id', DB::raw('CONCAT(`first_name`, " ", `middle_name` , " ", `last_name`) AS full_name'))
							->myOrganization()								
							->lists('full_name', 'id');
				
		return View::make('private.assign-new-task', $data);
	}	
	public function showChecklist()
	{
		$data['title'] = 'My Checklist';
		$data['checklist'] = Checklist::ourChecklists()
								// ->ourClients()
								->with('tasks')
								->select('checklists.*', 'clients.company_name')
								->leftJoin('clients', 'clients.id', '=', 'checklists.client_id')
								->orderBy('created_at', 'DESC')
								->paginate(3);

		$data['clients'] = Client::ourClients()
								->lists('company_name', 'id');	

		$data['users'] = User::myOrganization()				
							->select('id', DB::raw('CONCAT(`first_name`, " ", `middle_name` , " ", `last_name`) AS full_name'))
							->lists('full_name', 'id');

		$data['activities'] = RecentActivity::ourActivities()
											->with('user')
											->limit(20)->orderBy('created_at', 'DESC')->get();

		return View::make('private.view-checklist', $data);		
	}
	public function demoChecklist()
	{
		$data['title'] = 'Demo Checklist';
		$system_admin = User::systemAdmin()->lists('id');
		$data['checklist'] = Checklist::with('tasks')
								->select('checklists.*', 'clients.company_name')
								->leftJoin('clients', 'clients.id', '=', 'checklists.client_id')
								->orderBy('created_at', 'DESC')
								->whereIn('checklists.created_by', $system_admin)
								->get();

		$data['clients'] = Client::ourClients()
								->lists('company_name', 'id');	

		$data['users'] = User::myOrganization()				
							->select('id', DB::raw('CONCAT(`first_name`, " ", `middle_name` , " ", `last_name`) AS full_name'))
							->lists('full_name', 'id');

		$data['activities'] = RecentActivity::ourActivities()
											->with('user')
											->limit(20)->orderBy('created_at', 'DESC')->get();

		return View::make('private.view-demo-checklist', $data);		
	}
	public function editChecklist($id)
	{
		$data['title'] = 'Edit Checklist';
		$data['checklist'] = Checklist::findorFail($id);

		$data['clients'] = Client::ourClients()->lists('company_name', 'id');
		$data['users'] = User::myOrganization()
							->select('id', DB::raw('CONCAT(`first_name`, " ", `middle_name` , " ", `last_name`) AS full_name'))
							->lists('full_name', 'id');
		return View::make('private.checklist-update', $data);
	}
	public function updateChecklistInfo($id)
	{
		$checklist = Checklist::findorFail($id);

		$activities = array();
		if(Input::get('title') != $checklist->title){
			array_push($activities, 'renamed checklist <strong>'.$checklist->title.'</strong> to <strong>'.Input::get('title').'</strong>');
		}
		if(Input::get('due_date') != $checklist->due_date){
			array_push($activities, 'changed checklist due date '.$checklist->due_date.' to '.Input::get('due_date'));
		}
		if(Input::get('status') != $checklist->status){
			array_push($activities, 'renamed checklist '.$checklist->title.' status from '.$checklist->status.' to '.Input::get('status'));
		}
		if(Input::get('user_id') != $checklist->user_id){
			$user_name = DB::table('users')->select('first_name','last_name')->where('id', Input::get('user_id'))->first();
			array_push($activities, 'assigned '.$checklist->title.' to '.$user_name->first_name.' '.$user_name->last_name);
		}
		if(Input::get('link_to_folder') != $checklist->link_to_folder){
			array_push($activities, 'changed the file url of '.$checklist->title);
		}
		// dd($activities);
		if(count($activities)){
			foreach($activities as $activity){
				RecentActivity::create([
					'user_id' => user_id(),
					'type' => 'checklist',
					'activity' => $activity,
					'organization_id' => organization_id()
				]);
			}
		}

		//$checklist->fill(Input::all());
		//$checklist->save();

		return Redirect::route('view-checklist')
				->with('message', 'Checklist info updated successfully !')
				->with('alertType', 'success');
	}
	public function deleteChecklist($id)
	{
		$checklist = Checklist::findorFail($id);
		if($checklist->created_by == user_id())
		{
			$checklist->delete();
			$tasks = Task::where('checklist_id', '=', $id)->delete();

			/*Add Event Recent Activities -Starts*/
			$highlight = '<strong>'.$checklist->title.'</strong>';
			RecentActivity::create([
				'user_id' => user_id(),
				'type' => 'delete',
				'activity' => 'deleted a checklist named '.$highlight,
				'organization_id' => organization_id()
			]);
			/*Add Event Recent Activities -Ends*/

			return Redirect::route('view-checklist')
					->with('message', 'Checklist deleted from checklist !')
					->with('alertType', 'success');
		}
		else
		{
			return Redirect::route('view-checklist')
					->with('message', 'Sorry ! You do not have sufficient permission to delete this Checklist.')
					->with('alertType', 'danger');
		}
	}
	public function copyChecklist($id)
	{
		$data['title'] = 'Copy Checklist';
		$data['checklist'] = Checklist::findorFail($id);				
		$data['clients'] = Client::ourClients()->lists('company_name', 'id');
		$data['users'] = User::myOrganization()
							->select('id', DB::raw('CONCAT(`first_name`, " ", `middle_name` , " ", `last_name`) AS full_name'))
							->lists('full_name', 'id');
		return View::make('private.copy-new-checklist', $data);
	}
	public function saveCopiedChecklist($id)
	{
		$checklist = new Checklist;
		$checklist->fill(Input::except(array('created_by','organization_id')));
		$checklist->created_by = user_id();
		$checklist->organization_id = organization_id();
		$checklist->save();

		$haveTasks = Task::where('checklist_id', '=', $id)->get();
		foreach($haveTasks as $hT)
		{
			$task = new Task;
			$task->checklist_id = $checklist->id;
			$task->title = $hT->title;
			$task->start_date = $hT->start_date;
			$task->due_date = $hT->due_date;
			$task->user_id = $hT->user_id;
			$task->link_to_folder= $hT->link_to_folder;
			$task->description = $hT->description;
			$task->created_by = user_id();
			$task->save();
		} 

		RecentActivity::create([
			'user_id' => user_id(),
			'type' => 'checklist',
			'activity' => 'copied checklist<strong>'.$checklist->title.'</strong>',
			'organization_id' => organization_id()
		]);

		return Redirect::route('view-checklist')
						->with('message', 'Checklist and its associated tasks are copied.')
						->with('alertType', 'success');
	}
	public function importCSV()
	{
		if(Input::hasFile('csv'))
		{
			Excel::load(Input::file('csv'), function($reader) {
			    $results = $reader->get();

			    // dd($results->toArray());
			   	foreach($results as $data)
			   	{
			   		$checklist = new Checklist;
			   		$checklist->title = $data->title;
			   		$checklist->start_date = $data->startdate;
			   		$checklist->due_date = $data->duedate;
			   		$checklist->link_to_folder = $data->linktofolder;
			   		$checklist->description = $data->description;
			   		$checklist->organization_id = organization_id();
			   		$checklist->created_by = user_id();
			   		$checklist->save();

			   		/*Add Event Recent Activities -Starts*/
					$highlight = '<strong>'.$checklist->title.'</strong>';
					RecentActivity::create([
						'user_id' => user_id(),
						'type' => 'checklist',
						'activity' => 'created a new checklist with title of '.$highlight,
						'organization_id' => organization_id()
					]);
					/*Add Event Recent Activities -Ends*/

			   	}			   				   
			});

			RecentActivity::create([
				'user_id' => user_id(),
				'type' => 'checklist',
				'activity' => 'import some checklist',
				'organization_id' => organization_id()
			]);

			return Redirect::route('view-checklist')
						->with('message', 'Checklist imported successfully.')
						->with('alertType', 'success');
		}
		else
		{
			return Redirect::route('view-checklist')
						->with('message', 'No csv found !')
						->with('alertType', 'danger');
		}
	}

	public function filterChecklist()
	{
		if(Input::has('filter_by'))
		{
			if(Input::get('filter_by') == 'due_date'){
				$order_by = 'checklists.due_date';
				$asc_desc = 'DESC';
			}
			else if(Input::get('filter_by') == 'checklist'){
				$order_by = 'checklists.title';
				$asc_desc = 'ASC';
			}
			else{
				$order_by = 'clients.company_name';
				$asc_desc = 'ASC';
			}
		}

		
		$searchKey = Input::get('search_by');
		$filter_by = Input::get('filter_by');
		$data['searchKey'] = $searchKey; 
		$data['filter_by'] = $filter_by; 

			$data['title'] = 'My Checklist';

  if(Input::get('filter_by') == 'completed'){
			 $query = Checklist::ourChecklists()
						// ->ourClients()
						->with('tasks')
						->select('checklists.*', 'clients.company_name', DB::raw('round((((SELECT count(tasks.id) as task_count FROM tasks WHERE tasks.status="Completed" AND tasks.checklist_id=checklists.id)*100)/(SELECT count(tasks.id) as task_count2 FROM tasks WHERE tasks.checklist_id=checklists.id) ),2)as tesr') )
						->leftJoin('clients', 'clients.id', '=', 'checklists.client_id')
						->leftJoin('tasks', 'tasks.checklist_id', '=', 'checklists.id');
						
						if(Input::get('search_by') != ''){
							$query->where('checklists.title', 'LIKE', '%'.$searchKey.'%');
        					$query->orWhere('clients.company_name', 'LIKE', '%'.$searchKey.'%');
        					$query->orWhere('tasks.title', 'LIKE', '%'.$searchKey.'%');
						}
						$query->orderBy('tesr', 'DESC');

  }
  else{
		 $query = Checklist::ourChecklists()
					// ->ourClients()
					->with('tasks')
					->select('checklists.*', 'clients.company_name')
					->leftJoin('clients', 'clients.id', '=', 'checklists.client_id')
					->leftJoin('tasks', 'tasks.checklist_id', '=', 'checklists.id');
					if(Input::get('filter_by') !=''){
						$query->orderBy($order_by, $asc_desc);
					}

					if(Input::get('search_by') != ''){
						$query->where('checklists.title', 'LIKE', '%'.$searchKey.'%');
    					$query->orWhere('clients.company_name', 'LIKE', '%'.$searchKey.'%');
    					$query->orWhere('tasks.title', 'LIKE', '%'.$searchKey.'%');
					}
					 	
  }





			$data['checklist'] =$query->limit(10)->get();

			$data['clients'] = Client::ourClients()
									->lists('company_name', 'id');	

			$data['users'] = User::myOrganization()				
								->select('id', DB::raw('CONCAT(`first_name`, " ", `middle_name` , " ", `last_name`) AS full_name'))
								->lists('full_name', 'id');

			$data['activities'] = RecentActivity::ourActivities()
												->with('user')
												->limit(20)->orderBy('created_at', 'DESC')->get();

			return View::make('private.filter-checklist', $data);

		
	}

	public function searchChecklist()
	{
		if(Input::has('search_by'))
		{
			$searchKey = Input::get('search_by');
			/*if(Input::get('search_by') == 'due_date'){
				$order_by = 'checklists.due_date';
				$asc_desc = 'DESC';
			}
			else{
				$order_by = 'clients.company_name';
				$asc_desc = 'ASC';
			}	*/		
			$data['title'] = 'My Checklist';
			$data['checklist'] = Checklist::ourChecklists()
									// ->ourClients()
									->with('tasks')
									->select('checklists.*', 'clients.company_name')
									->leftJoin('clients', 'clients.id', '=', 'checklists.client_id')
									->leftJoin('tasks', 'tasks.checklist_id', '=', 'checklists.id')
									->where('checklists.title', 'LIKE', '%'.$searchKey.'%')
                    				->orWhere('clients.company_name', 'LIKE', '%'.$searchKey.'%')
                    				->orWhere('tasks.title', 'LIKE', '%'.$searchKey.'%')
									->limit(10)->get();

			$data['clients'] = Client::ourClients()
									->lists('company_name', 'id');	

			$data['users'] = User::myOrganization()				
								->select('id', DB::raw('CONCAT(`first_name`, " ", `middle_name` , " ", `last_name`) AS full_name'))
								->lists('full_name', 'id');

			$data['activities'] = RecentActivity::ourActivities()
												->with('user')
												->limit(20)->orderBy('created_at', 'DESC')->get();
			return View::make('private.search-checklist', $data);
		}
	}


}