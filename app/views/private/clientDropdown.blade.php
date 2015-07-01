<select multiple name="sendToClients[]" id="sendToClients"  class="form-control select2me" data-placeholder="Select Clients..." required>
	<option value="">Select Clients...</option>
	<option value="0">{{$clients_info->contact_name}}</option>
	@if($clients_contacts)	
		@foreach($clients_contacts as $clients_contact)
			<option value="{{$clients_contact->id}}">{{$clients_contact->contact_name}}</option>
		@endforeach
	@endif
</select>