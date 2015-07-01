@extends('layouts/default')

@section('content')

	<div class="page-content">
			<!-- BEGIN PAGE HEADER-->
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN PAGE TITLE & BREADCRUMB-->
					<h3 class="page-title">
					Checklist <small>create new</small>
					</h3>
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="#">Home</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="#">Checklist</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="#">New</a>
						</li>
					</ul>
					<!-- END PAGE TITLE & BREADCRUMB-->
				</div>
			</div>
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
			<div class="row profile">
				<div class="col-md-12">
					@if(Session::has('message'))
			            <div class="alert alert-{{ Session::get('alertType') }}">
			                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
			                <p>{{ Session::get('message') }}</p>
			            </div>
			        @endif
					<div class="portlet box green">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-gift"></i>Form :: Create New Checklist
							</div>
						</div>
						<div class="portlet-body form">
							<!-- BEGIN FORM-->							
							{{ Form::open(array('route' => 'create-new-checklist', 'class' => 'form-horizontal')) }}
								<div class="form-body">
									<div class="form-group">										
										{{ Form::label('title', 'Checklist Name', array('class' => 'col-md-3 control-label')) }}
										<div class="col-md-6">											
											{{ Form::text('title', null, array('placeholder' => 'Type checklist name', 'required' => 'required', 'class' => 'form-control input-circle')) }}
										</div>
									</div>
									<div class="form-group">										
										{{ Form::label('start_date', 'Start Date', array('class' => 'col-md-3 control-label')) }}
										<div class="col-md-6">											
											<div data-date-format="yyyy-mm-dd" class="input-group date date-picker">
												{{ Form::text('start_date', null, array('readonly' => '', 'class' => 'form-control')) }}
												<!-- <input type="text" name="datepicker" readonly="" class="form-control"> -->
												<span class="input-group-btn">
												<button type="button" class="btn default"><i class="fa fa-calendar"></i></button>
												</span>
											</div>
										</div>
									</div>
									<div class="form-group">										
										{{ Form::label('due_date', 'Due Date', array('class' => 'col-md-3 control-label')) }}
										<div class="col-md-6">											
											<div data-date-format="yyyy-mm-dd" class="input-group date date-picker">
												{{ Form::text('due_date', null, array('readonly' => '', 'class' => 'form-control')) }}
												<!-- <input type="text" name="datepicker" readonly="" class="form-control"> -->
												<span class="input-group-btn">
												<button type="button" class="btn default"><i class="fa fa-calendar"></i></button>
												</span>
											</div>
										</div>
									</div>
									<div class="form-group">										
										{{ Form::label('client_id', 'Client Name', array('class' => 'col-md-3 control-label')) }}
										<div class="col-md-6">
											{{ Form::select('client_id', array('' => '-- Select Client Name --')+$clients, null, array('class' => 'form-control select2me', 'id' =>'client_id', 'required' => 'required')) }}
										</div>
									</div>
									<div class="form-group">										
										{{ Form::label('user_id', 'Assigned To', array('class' => 'col-md-3 control-label')) }}
										<div class="col-md-6">
											{{ Form::select('user_id', array('' => '-- Select Employee Name --')+$users, null, array('class' => 'form-control select2me', 'required' => 'required')) }}
										</div>
									</div>
									<div class="form-group">										
										{{ Form::label('link_to_folder', 'Link To Folder', array('class' => 'col-md-3 control-label')) }}
										<div class="col-md-6">											
											{{ Form::text('link_to_folder', null, array('rows' => '3','placeholder' => 'Paste necessary doc links', 'required' => 'required', 'class' => 'form-control input-circle')) }}
										</div>
									</div>
									<div class="form-group">										
										{{ Form::label('description', 'Description', array('class' => 'col-md-3 control-label')) }}
										<div class="col-md-9">
											<div id="editor1_error"></div>											
											{{ Form::textarea('description', null, array('class' => 'wysihtml5 form-control', 'rows' => '6', 'data-error-container' => '#editor1_error')) }}
										</div>
									</div>

									
									<div class="form-group">										
										{{ Form::label('internal_notes', 'Internal Notes', array('class' => 'col-md-3 control-label')) }}
										<div class="col-md-9">
											<div id="editor1_error"></div>											
											{{ Form::textarea('internal_notes', null, array('class' => 'wysihtml5 form-control', 'rows' => '4', 'data-error-container' => '#editor1_error')) }}
										</div>
									</div>


									<div class="form-group">										
										{{ Form::label('notes_to_client', 'Notes to client', array('class' => 'col-md-3 control-label')) }}
										<div class="col-md-9">
											<div id="editor1_error"></div>											
											{{ Form::textarea('notes_to_client', null, array('class' => 'wysihtml5 form-control', 'rows' => '4', 'data-error-container' => '#editor1_error')) }}
										</div>
									</div>
			
					

									<div class="form-group">										
										{{ Form::label('email_reminders', 'Email Reminders', array('class' => 'col-md-3 control-label')) }}
										<div class="col-md-3">
											{{ Form::select('email_reminders', array('' => '-- Select Reminder Type --', 'daily' => 'Daily', 'weekly' => 'Weekly', 'monthly' => 'Monthly'), null, array('class' => 'form-control select2me', 'required' => 'required')) }}
										</div>
									</div>
									<div class="form-group">										
										{{ Form::label('send_to', 'Send To', array('class' => 'col-md-3 control-label')) }}
										<div class="col-md-3">
											{{ Form::select('send_to', array('' => '-- Select Employee Name --')+$users, null, array('class' => 'form-control select2me', 'required' => 'required')) }}
										</div>
									</div>

									<div class="form-group">										
										{{ Form::label('sendToClients', 'Send To Client', array('class' => 'col-md-3 control-label')) }}
										<div id="genList" class="col-md-6">
											{{ Form::select('sendToClients[]', array(), null, array('class' => 'form-control select2me', 'required' => 'required', 'multiple')) }}
										</div>
									</div>

								</div>
								<div class="form-actions fluid">
									<div class="col-md-offset-3 col-md-9">
										<button class="btn btn-circle blue" type="submit">Submit</button>
										<button class="btn btn-circle default" type="reset">Reset</button>
									</div>
								</div>
							{{ Form::close() }}
							<!-- END FORM-->
						</div>
					</div>
				</div>
			</div>
			<!-- END PAGE CONTENT-->
		</div>


<script>

</script>

@stop