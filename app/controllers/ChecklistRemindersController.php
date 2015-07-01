<?php

class ChecklistRemindersController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /checklistreminders
	 *
	 * @return Response
	 */
	public function index()
	{
		$reminders = ChecklistReminder::select('users.first_name', 'users.email', 'checklists.title', 'checklists.due_date', 'clients_contacts.contact_email', 'clients.email AS clintEmail','checklist_reminders.send_to_clients')
								->leftJoin('users', 'users.id', '=', 'checklist_reminders.send_to')
								->leftJoin('clients_contacts', 'clients_contacts.id', '=', 'checklist_reminders.send_to_clients')
								->leftJoin('clients', 'clients.id', '=', 'checklist_reminders.client_id')
								->leftJoin('checklists', 'checklists.id', '=', 'checklist_reminders.checklist_id')
								->today()
								->get();



		$client_contacts = array();
		foreach ($reminders as $key => $value) {
			if(is_array(json_decode($value['send_to_clients']))){				
				$reminders[$key]['send_to_clients'] = json_decode($value['send_to_clients']);
				$client_contacts = array_merge($client_contacts, $reminders[$key]['send_to_clients']);
			}else{
				$reminders[$key]['send_to_clients'] = NULL;
			}
		}
		$client_contacts = array_unique($client_contacts);

		$client_contacts_mails = array();
		foreach (ClientsContact::whereIn('id', $client_contacts)->get() as $value) {
			$client_contacts_mails[$value->id] = $value['contact_email'];
		}

		// return $client_contacts_mails;
		// return $reminders;dd();




		if(count($reminders))
		{
			foreach($reminders as $notify)
			{
				if($notify->email !=''){				
				//echo $notify->email; 
					$data['mail_title'] = 'Checklist Reminder :: EasychecklistABC';
					$data['notify_about'] = $notify->title;
					$data['due_date'] = $notify->due_date;	
					$email = $notify->email;		
					
					Mail::send('emails.notify-user', $data, function($message) use ($email)
					{
					    $message->from('info@easychecklistabc.com', 'Easychecklist ABC');
					    $message->subject('Checklist Reminder :: EasychecklistABC');
					    $message->to($email);		    
					});
				}


				$data['mail_title'] = 'Checklist Reminder :: EasychecklistABC';
				$data['notify_about'] = $notify->title;
				$data['due_date'] = $notify->due_date;	
				if(!$notify->send_to_clients){
					$email = $notify->clintEmail;

					if($email){
						Mail::send('emails.notify-user', $data, function($message) use ($email)
						{
						    $message->from('info@easychecklistabc.com', 'Easychecklist ABC');
						    $message->subject('Checklist Reminder :: EasychecklistABC');
						    $message->to($email);		    
						});
					}
				}
				else{					
					// $email = $notify->contact_email;	
					foreach ($notify->send_to_clients as $value) {

						if(array_key_exists($value, $client_contacts_mails)){

							$email =  $client_contacts_mails[$value];
							Mail::send('emails.notify-user', $data, function($message) use ($email)
							{
							    $message->from('info@easychecklistabc.com', 'Easychecklist ABC');
							    $message->subject('Checklist Reminder :: EasychecklistABC');
							    $message->to($email);		    
							});

						}
					}	
				}


			}
		}





		$reminders = TaskReminder::select('users.first_name', 'users.email', 'tasks.title', 'tasks.due_date', 'task_reminders.send_to_clients')
								->leftJoin('users', 'users.id', '=', 'task_reminders.send_to')
								->leftJoin('tasks', 'tasks.id', '=', 'task_reminders.task_id')
								->today()
								->get();

		// return $reminders;


		$client_contacts = array();
		foreach ($reminders as $key => $value) {
			if(is_array(json_decode($value['send_to_clients']))){				
				$reminders[$key]['send_to_clients'] = json_decode($value['send_to_clients']);
				$client_contacts = array_merge($client_contacts, $reminders[$key]['send_to_clients']);
			}else{
				$reminders[$key]['send_to_clients'] = [];
			}
		}
		$client_contacts = array_unique($client_contacts);

		$client_contacts_mails = array();
		if(!empty($client_contacts)){
			foreach (ClientsContact::whereIn('id', $client_contacts)->get() as $value) {
				$client_contacts_mails[$value->id] = $value['contact_email'];
			}
		}

		// return $reminders;


		if(count($reminders))
		{
			foreach($reminders as $notify)
			{

				foreach ($notify->send_to_clients as $value) {

					if(array_key_exists($value, $client_contacts_mails)){

						$email =  $client_contacts_mails[$value];

						$data['mail_title'] = 'Task Reminder :: EasychecklistABC';
						$data['notify_about'] = $notify->title;
						$data['due_date'] = $notify->due_date;	
						//$email = $notify->email;
						// dd($email);
						
						Mail::send('emails.notify-user', $data, function($message) use ($email)
						{
						    $message->from('info@easychecklistabc.com', 'Easychecklist ABC');
						    $message->subject('Task Reminder :: EasychecklistABC');
						    $message->to($email);		    
						});

					}

				}



				if($notify->email ==''){
					continue;
				}
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
	 * GET /checklistreminders/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /checklistreminders
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /checklistreminders/{id}
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
	 * GET /checklistreminders/{id}/edit
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
	 * PUT /checklistreminders/{id}
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
	 * DELETE /checklistreminders/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}