@extends('layouts/default')

@section('content')

	<div class="page-content">
		<!-- BEGIN PAGE HEADER-->
		<div class="row">
			<div class="col-md-12">
				<!-- BEGIN PAGE TITLE & BREADCRUMB-->
				<h3 class="page-title">
				Howdy ! <small>system admin</small>
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
						<a href="{{ URL::route('profile') }}">System</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						<a href="#">Admin</a>
					</li>
					<li class="pull-right">
						<div data-placement="top" class="dashboard-date-range tooltips" id="dashboard-report-range" style="display: block;">
							<i class="icon-calendar"></i>
							<span>{{ date('F j, Y') }}</span>							
						</div>
					</li>
				</ul>
				<!-- END PAGE TITLE & BREADCRUMB-->
			</div>
		</div>
		<!-- END PAGE HEADER-->
		<!-- BEGIN PAGE CONTENT-->
			<div class="row">
				<div class="col-md-5">
					<div class="portlet box green">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-user"></i>Form :: Create New System Admin
							</div>
						</div>
						<div class="portlet-body form">
							<!-- BEGIN FORM-->							
							{{ Form::open(array('route' => 'create-new-admin', 'class' => 'form-horizontal')) }}
								<div class="form-body">
									<div class="form-group">										
										{{ Form::label('first_name', 'First Name', array('class' => 'col-md-3 control-label')) }}
										<div class="col-md-6">											
											{{ Form::text('first_name', null, array('placeholder' => 'e.g. John', 'required' => 'required', 'class' => 'form-control input-circle')) }}
										</div>
									</div>
									<div class="form-group">										
										{{ Form::label('middle_name', 'Middle Name', array('class' => 'col-md-3 control-label')) }}
										<div class="col-md-6">											
											{{ Form::text('middle_name', null, array('class' => 'form-control input-circle')) }}
										</div>
									</div>
									<div class="form-group">										
										{{ Form::label('last_name', 'Last Name', array('class' => 'col-md-3 control-label')) }}
										<div class="col-md-6">											
											{{ Form::text('last_name', null, array('placeholder' => 'e.g. Doe', 'required' => 'required', 'class' => 'form-control input-circle')) }}
										</div>
									</div>
									<div class="form-group">										
										{{ Form::label('email', 'Email', array('class' => 'col-md-3 control-label')) }}
										<div class="col-md-6">											
											{{ Form::text('email', null, array('placeholder' => 'e.g. johndoe@gmail.com', 'required' => 'required', 'class' => 'form-control input-circle')) }}
										</div>
									</div>
									<div class="form-group">										
										{{ Form::label('password', 'Password', array('class' => 'col-md-3 control-label')) }}
										<div class="col-md-6">											
											{{ Form::password('password', array('placeholder' => '******', 'required' => 'required', 'class' => 'form-control input-circle')) }}
										</div>
									</div>																	
								</div>
								<div class="form-actions fluid">
									<div class="col-md-offset-3 col-md-9">
										<button class="btn btn-circle blue" type="submit">Create</button>
										<button class="btn btn-circle default" type="reset">Reset</button>
									</div>
								</div>
							{{ Form::close() }}
							<!-- END FORM-->
						</div>
					</div>
				</div>
				<div class="col-md-7">
					<div class="portlet box blue">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-group"></i>Current List
							</div>
						</div>
						<div class="portlet-body">
							<table class="table table-hover">
							<thead>
							<tr>
								<th>#</th>
								<th>Name</th>
								<th>Email</th>
								<th>Created at</th>
								<th>Action</th>								
							</tr>
							</thead>
							<tbody>
								@if($users)
									{{-- */$i=1;/* --}}
									@foreach($users as $user)
										<tr>
											<td>{{ $i }}</td>
											<td>{{ $user->first_name.' '.@$user->middle_name.' '.$user->last_name }}</td>
											<td>{{ $user->email }}</td>
											<td>{{ date('d-m-Y', strtotime($user->created_at)) }}</td>
											<td>
												<a class="btn default btn-xs green-stripe" href="{{ URL::route('sys-admin.update', $user->id) }}">
													Update 
												</a>&nbsp;&nbsp;
												<a class="btn default btn-xs red-stripe" href="{{ URL::route('user.delete', $user->id) }}">
													Delete 
												</a>												
											</td>
										</tr>
									{{-- */$i++;/* --}}
									@endforeach
								@endif
							</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		<!-- END PAGE CONTENT-->
	</div>

@stop