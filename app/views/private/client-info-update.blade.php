@extends('layouts/default')

@section('content')

	<div class="page-content">
			<!-- BEGIN PAGE HEADER-->
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN PAGE TITLE & BREADCRUMB-->
					<h3 class="page-title">
					Client Profile <small>update client info</small>
					</h3>

					<!--Display Flash Messages-->
			        @if(Session::has('message'))
			            <div class="alert alert-{{ Session::get('alertType') }}">
			                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
			                <p>{{ Session::get('message') }}</p>
			            </div>
			        @endif

					<ul class="page-breadcrumb breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="#">Home</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="#">Company</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="#">Clients</a>
						</li>
					</ul>
					<!-- END PAGE TITLE & BREADCRUMB-->
				</div>
			</div>
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
			<div class="row profile-account">
				<div class="col-md-3">
					<ul class="ver-inline-menu tabbable margin-bottom-10">
						<li class="active">
							<a data-toggle="tab" href="#tab_1-1">
							<i class="fa fa-cog"></i> Current info </a>
							<span class="after">
							</span>
						</li>
					</ul>
				</div>
				<div class="col-md-9">
					<div class="tab-content">
						<div id="tab_1-1" class="tab-pane active">
							{{ Form::model($client, array('route' => array('client.update', $client->id), 'role' => 'form', 'files' => 'true')) }}
								<div class="form-group">
									<div class="fileinput fileinput-new" data-provides="fileinput">
										<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
											@if($client->photo)
													<img src="{{ URL::asset('images/clients/'.$client->photo.'') }}" class="img-responsive" alt="Photo"/>
												@else
													<img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt=""/>
											@endif												
										</div>
										<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;">
										</div>
										<div>
											<span class="btn default btn-file">
											<span class="fileinput-new">
											Select image </span>
											<span class="fileinput-exists">
											Change </span>
											<input type="file" name="photo">
											</span>
											<a href="#" class="btn default fileinput-exists" data-dismiss="fileinput">
											Remove </a>
										</div>
									</div>
									<div class="clearfix margin-top-10">
										<span class="label label-danger">
										NOTE! </span>&nbsp;&nbsp;
										<span>
										Attached image thumbnail is supported in Latest Firefox, Chrome, Opera, Safari and Internet Explorer 10 only </span>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											{{ Form::label('company_name', 'Company Name', array('class' => 'control-label')) }}

											{{ Form::text('company_name', null, array('class' => 'form-control', 'required' => 'required')) }}
										</div>
									</div>
								</div>

								<div class="input_fields_wrap">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												{{ Form::label('contact_name', 'Contact Name', array('class' => 'control-label')) }}

												{{ Form::text('contact_name', null, array('class' => 'form-control')) }}
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												{{ Form::label('email', 'Email Address', array('class' => 'control-label')) }}

												{{ Form::email('email', null, array('class' => 'form-control', 'style' => 'width:80%; float: left;','required' => 'required')) }}
												<button style="float: left; padding-left: 5px; padding-right: 5px;" class="btn blue add_field_button">Add More</button>
											</div>
										</div>
									</div>

								@if($contacts)
									@foreach($contacts as $contact)	
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label">Contact Name</label>
												<input class="form-control" type="text" name="contact_namearr_{{$contact->id}}" value="{{$contact->contact_name}}">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label">Email Address</label>
												<input class="form-control" type="email" style="width:80%; float: left;" required="required" value="{{$contact->contact_email}}" name="emailarr_{{$contact->id}}">
												<button class="btn red remove_field" style="float: left; padding-left: 5px; padding-right: 5px;">Remove</button>
											</div>
										</div>
									</div>									
									@endforeach
								@endif
								</div> <!-- End of input_fields_wrap -->

								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											{{ Form::label('phone', 'Office Phone', array('class' => 'control-label')) }}

											{{ Form::text('phone', null, array('class' => 'form-control', 'placeholder' => '+1 646 580', 'required' => 'required')) }}
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											{{ Form::label('mobile', 'Mobile', array('class' => 'control-label')) }}

											{{ Form::text('mobile', null, array('class' => 'form-control', 'placeholder' => '987 654 321', 'required' => 'required')) }}
										</div>
									</div>
								</div>


								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											{{ Form::label('address', 'Office Location', array('class' => 'control-label')) }}

											{{ Form::text('address', null, array('class' => 'form-control', 'required' => 'required')) }}
										</div>
									</div>
								</div>
								<div class="margiv-top-10">
									<button type="submit" class="btn green">Save Changes</button>
									<button type="reset" class="btn default">Cancel</button>
								</div>
							{{ Form::close() }}
						</div>
					</div>
				</div>
				<!--end col-md-9-->
			</div>
		<!-- END PAGE CONTENT-->
		</div>

@stop