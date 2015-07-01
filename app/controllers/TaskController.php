<?php

class TaskController extends BaseController{
	/*used for task setup, view tasks etc.*/

	public function addTask($id)
	{
		$data['title'] = 'Attach New Task';
		$data['to_checklist'] = Checklist::where('id', $id)->lists('title', 'id');
		$data['checklist'] = Checklist::findorFail($id);

		$data['users'] = User::select('id', DB::raw('CONCAT(`first_name`, " ", `middle_name` , " ", `last_name`) AS full_name'))
							->myOrganization()
							->lists('full_name', 'id');			

		return View::make('private.assign-new-task', $data);
	}
	public function addNewTask()
	{
		$data['title'] = 'Create New Task';
		$data['checklists'] = Checklist::ourChecklists()->lists('title', 'id');

		$data['users'] = User::select('id', DB::raw('CONCAT(`first_name`, " ", `middle_name` , " ", `last_name`) AS full_name'))
							->myOrganization()
							->lists('full_name', 'id');

		return View::make('private.add-new-task', $data);
	}
	public function saveTaskInfo()
	{
		$task = new Task;
		$task->fill(Input::except(array('created_by','organization_id')));
		$task->created_by = user_id();
		$task->organization_id = organization_id();
		$task->internal_notes = Input::get('internal_notes');
		$task->notes_to_client = Input::get('notes_to_client');
		$task->save();

		$assignment = new Assignment;
		$assignment->task_id = $task->id;
		$assignment->user_id = Input::get('user_id');
		$assignment->save();

		/*Email Reminders -Starts*/
		$user_id = Input::get('user_id');
		$client_id = '0'; //bit confusing
		$task_id = $task->id;
		$start_date = Input::get('start_date');
		$send_to = Input::get('send_to');
		$due_date = Input::get('due_date');
		$type = Input::get('email_reminders');

		$send_to_clients = json_encode(Input::get('sendToClients'));
		
		switch ($type) {
			case 'weekly':				
				while ($due_date > $start_date) {
					if(date('Y-m-d', strtotime($start_date . " +1 week")) < $due_date)
					{
						$reminder = new TaskReminder;
						$reminder->user_id = $user_id;
						$reminder->client_id = $client_id;
						$reminder->send_to = $send_to;
						$reminder->send_to_clients = $send_to_clients;
						$reminder->task_id = $task_id;
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
						$reminder = new TaskReminder;
						$reminder->user_id = $user_id;
						$reminder->client_id = $client_id;
						$reminder->send_to = $send_to;
						$reminder->send_to_clients = $send_to_clients;
						$reminder->task_id = $task_id;
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
						$reminder = new TaskReminder;
						$reminder->user_id = $user_id;
						$reminder->client_id = $client_id;
						$reminder->send_to = $send_to;
						$reminder->send_to_clients = $send_to_clients;
						$reminder->task_id = $task_id;
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
		$highlight = '<strong>'.$task->title.'</strong>';
		RecentActivity::create([
			'user_id' => user_id(),
			'type' => 'task',
			'activity' => 'created a new task with title of '.$highlight,
			'organization_id' => organization_id()
		]);
		/*Add Event Recent Activities -Ends*/

		return Redirect::route('view-checklist')
				->with('message', 'Congratulation ! Task info added to checklist successfully.')
				->with('alertType', 'success');
	}
	public function showChecklist()
	{
		$data['title'] = 'My Checklist';
		$data['checklist'] = Checklist::ourChecklists()
								->select('checklists.*', 'clients.company_name')
								->leftJoin('clients', 'clients.id', '=', 'checklists.client_id')
								->get();
		// dd($data);
		return View::make('private.view-checklist', $data);		
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
	public function updateTaskInfo($id)
	{
		$task = Task::findorFail($id);
		$task->fill(Input::except(array('updated_at')));
		$task->updated_at = date('Y-m-d H:i:s');
		$task->save();

		// if(Input::get('status') == 'Completed')
		// {
		// 	$assignment = Assignment::where('task_id', $id)->first();
		// 	$assignment->status = 'Completed';
		// 	$assignment->save;
		// }

		return Redirect::route('view-checklist')
				->with('message', 'Task info updated successfully !')
				->with('alertType', 'success');
	}
	public function deleteTask($id)
	{
		$task = Task::findorFail($id);
		if($task->created_by == user_id())
		{
			$task->delete();

			/*Add Event Recent Activities -Starts*/
			$highlight = '<strong>'.$task->title.'</strong>';
			RecentActivity::create([
				'user_id' => user_id(),
				'type' => 'delete',
				'activity' => 'deleted a task named '.$highlight,
				'organization_id' => organization_id()
			]);
			/*Add Event Recent Activities -Ends*/

			return Redirect::route('view-checklist')
					->with('message', 'Task deleted from checklist !')
					->with('alertType', 'success');
		}
		else
		{
			return Redirect::route('view-checklist')
					->with('message', 'Sorry ! You do not have sufficient permission to delete this task.')
					->with('alertType', 'danger');
		}
	}
	public function copyTask($id)
	{
		$data['title'] = 'Copy Task';
		$data['task'] = Task::findorFail($id);
		$data['checklist'] = Checklist::ourChecklists()->lists('title', 'id');				
		$data['users'] = User::myOrganization()
							->select('id', DB::raw('CONCAT(`first_name`, " ", `middle_name` , " ", `last_name`) AS full_name'))
							->lists('full_name', 'id');
		return View::make('private.copy-new-task', $data);
	}
	public function show($id)
	{
		$data['title'] = 'Task Overview';
		$data['task'] = Task::findorFail($id);

		return View::make('private.task-overview', $data);
	}
	public function changeStatus($id)
	{
		$task = Task::findorFail($id);
		$task->status = 'Completed';
		$task->save();

		$assignment = Assignment::where('task_id', $id)->where('user_id', user_id())->first();
		$assignment->status = 'Completed';
		$assignment->save();

		return Redirect::route('profile')
					->with('message', 'Task status changed to completed.')
					->with('alertType', 'success');
	}
}