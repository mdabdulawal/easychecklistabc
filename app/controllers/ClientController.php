<?php

class ClientController extends BaseController{
	/*used for client setup, create clients etc.*/
	public function all()
	{
		$data['title'] = 'Manage Clients';

		$data['total_clients'] = Client::ourClients()->count();
		$data['clients'] = Client::ourClients()
							->paginate(10);

		return View::make('private.clients', $data);
	}
	public function addClient()
	{
		return View::make('private.add-new-client')
				->with('title', 'Add New Client');
	}
	public function importCSVClientInfo()
	{
		//$client = new Client;
	
		if(Input::hasFile('csv'))
		{
			Excel::load(Input::file('csv'), function($reader) {
			    $results = $reader->get();

			     //$i = count($results);
			    
			   	foreach($results as $data)
			   	{
			   		
			   		$client = new Client;
			   		$client->company_name = $data->companyname;
			   		$client->contact_name = $data->contactname;
			   		$client->email = $data->email;
			   		$client->phone = $data->phone;
			   		$client->mobile = $data->mobile;
			   		$client->address = $data->address;
			   		$client->organization_id = organization_id();
			   		$client->created_by = user_id();
			   		$client->save();
			   		
					RecentActivity::create([
						'user_id' => user_id(),
						'type' => 'client',
						'activity' => 'created a new client.',
						'organization_id' => organization_id()
					]);
					/*Add Event Recent Activities -Ends*/
			   	}			   				   
			});

			RecentActivity::create([
				'user_id' => user_id(),
				'type' => 'client',
				'activity' => 'import some client',
				'organization_id' => organization_id()
			]);

			return Redirect::route('clients')
				->with('message', 'Client info saved successfully.')
				->with('alertType', 'success');
		}
		else
		{
			return Redirect::route('clients')
						->with('message', 'No csv found !')
						->with('alertType', 'danger');
		}

		/*Add Event Recent Activities -Starts*/
		

		
	}
	public function saveClientInfo()
	{
		$client = new Client;
		$client->fill(Input::except(array('photo', 'organization_id', 'contact_namearr', 'emailarr')));
		$client->created_by = user_id();
		$client->organization_id = organization_id();
		if(Input::hasFile('photo'))
		{
			/*image manipulation part -starts*/
			$file_name = 'client-'.time().'-'.Input::file('photo')->getClientOriginalName();

			$image = Image::make(Input::file('photo')->getRealPath());

			File::exists(client_photos_path()) or File::makeDirectory(client_photos_path());

			$image->save(client_photos_path() . $file_name)
					->resize(320, 240)
					->save(client_photos_path() . $file_name);
			/*image manipulation part -ends*/
			$client->photo = $file_name; // $file_name assigned as the value of 'photo' field 
		}
		$client->save();

		$additionalContact  = Input::get('contact_namearr');
		$additionalEmail = Input::get('emailarr');

		if($additionalContact){
			for($i=0; $i< count($additionalContact); $i++){
				if($additionalContact[$i]!='' && $additionalEmail[$i]!=''){
					$contact = new ClientsContact;
					$contact->client_id = $client->id;
					$contact->contact_name = $additionalContact[$i];
					$contact->contact_email = $additionalEmail[$i];
					$contact->save();

				}
				//echo $additionalContact[$i].' '.$additionalEmail[$i];
			}			
		}		
		
		/*Add Event Recent Activities -Starts*/
		RecentActivity::create([
			'user_id' => user_id(),
			'type' => 'client',
			'activity' => 'created a new client.',
			'organization_id' => organization_id()
		]);
		/*Add Event Recent Activities -Ends*/

		return Redirect::route('clients')
				->with('message', 'Client info saved successfully.')
				->with('alertType', 'success');
	}
	
	public function additionalContact(){
		$clientID  = Input::get('clientID');
		$clients_contacts = DB::table('clients_contacts')->where('client_id', $clientID)->get();
		$clients_info = DB::table('clients')->where('id', $clientID)->first();

		return View::make('private.clientDropdown')
				->with('clients_contacts', $clients_contacts )
				->with('clients_info', $clients_info );


	}

	public function additionalContactByChecklist()
	{
		$cheklist_id = Input::get('checklistId');
		$clientID = Checklist::find($cheklist_id)->client_id;
		$clients_contacts = DB::table('clients_contacts')->where('client_id', $clientID)->get();
		$clients_info = DB::table('clients')->where('id', $clientID)->first();

		return View::make('private.clientDropdown')
				->with('clients_contacts', $clients_contacts )
				->with('clients_info', $clients_info );
	}
	
	
	public function clientOverview($id)
	{
		$data['title'] = 'Client Overview';
		$data['client'] = Client::findorFail($id);

		$data['contacts'] = DB::table('clients_contacts')
							->where('clients_contacts.client_id', $id)
							->get();

		return View::make('private.client-profile', $data);
	}
	public function clientEdit($id)
	{
		$data['title'] = 'Update Client Info';
		$data['client'] = Client::findorFail($id);

		$data['contacts'] = DB::table('clients_contacts')
							->where('clients_contacts.client_id', $id)
							->get();

		return View::make('private.client-info-update', $data);
	}
	public function updateClientInfo($id)
	{
		$client = Client::findorFail($id);

		$client->fill(Input::except(array('photo')));
		if(Input::hasFile('photo'))
		{
			/*image manipulation part -starts*/
			$file_name = 'client-'.time().'-'.Input::file('photo')->getClientOriginalName();

			$image = Image::make(Input::file('photo')->getRealPath());

			File::exists(client_photos_path()) or File::makeDirectory(client_photos_path());

			$image->save(client_photos_path() . $file_name)
					->resize(320, 240)
					->save(client_photos_path() . $file_name);
			/*image manipulation part -ends*/
			$client->photo = $file_name; // $file_name assigned as the value of 'photo' field 
		}
		$client->save();

		$allContacts = DB::table('clients_contacts')
							->where('clients_contacts.client_id', $id)
							->get();

		if($allContacts)
		foreach($allContacts as $contact){
			if(Input::has('contact_namearr_'.$contact->id)){

				$clientContact = ClientsContact::findorFail($contact->id);
				$clientContact->contact_name = Input::get('contact_namearr_'.$contact->id);
				$clientContact->contact_email = Input::get('emailarr_'.$contact->id);
				$clientContact->save();

			}
			else{
				DB::table('clients_contacts')->where('id', $contact->id)->delete();
			}


		}					

		$additionalContact  = Input::get('contact_namearr');
		$additionalEmail = Input::get('emailarr');

		if($additionalContact){
			for($i=0; $i< count($additionalContact); $i++){
				if($additionalContact[$i]!='' && $additionalEmail[$i]!=''){
					$contact = new ClientsContact;
					$contact->client_id = $id;
					$contact->contact_name = $additionalContact[$i];
					$contact->contact_email = $additionalEmail[$i];
					$contact->save();

				}
				//echo $additionalContact[$i].' '.$additionalEmail[$i];
			}			
		}


		return Redirect::route('clients')
				->with('message', 'Client info updated successfully !')
				->with('alertType', 'success');
	}
	public function deleteClient($id)
	{
		$client = Client::findorFail($id);
		if($client->created_by == user_id())
		{
			$client->delete();

			/*Add Event Recent Activities -Starts*/
			RecentActivity::create([
				'user_id' => user_id(),
				'type' => 'delete',
				'activity' => 'deleted a client.',
				'organization_id' => organization_id()
			]);
			/*Add Event Recent Activities -Ends*/

			return Redirect::back()
					->with('message', 'Client deleted successfully !')
					->with('alertType', 'success');
		}
		else
			return Redirect::back()
					->with('message', 'Sorry, You do not have sufficient permissions to do that.')
					->with('alertType', 'danger');
	}
}