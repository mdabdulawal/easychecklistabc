<?php

class TaskRemindersController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /taskreminders
	 *
	 * @return Response
	 */
	public function index()
	{
		$reminders = TaskReminder::select('users.first_name', 'users.email', 'tasks.title', 'tasks.due_date')
								->leftJoin('users', 'users.id', '=', 'task_reminders.user_id')
								->leftJoin('tasks', 'tasks.id', '=', 'task_reminders.task_id')
								->today()
								->get(); 

		if(count($reminders))
		{
			foreach($reminders as $notify)
			{
				$data['mail_title'] = 'Task Reminder :: EasychecklistABC';
				$data['notify_about'] = $notify->title;
				$data['due_date'] = $notify->due_date;	
				$email = $notify->email;		
				
				Mail::send('emails.notify-user', $data, function($message) use ($email)
				{
				    $message->from('info@easychecklistabc.com', 'Easychecklist ABC');
				    $message->subject('Task Reminder :: EasychecklistABC');
				    $message->to($email);		    
				});
			}
		}
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /taskreminders/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /taskreminders
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /taskreminders/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /taskreminders/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /taskreminders/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /taskreminders/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}