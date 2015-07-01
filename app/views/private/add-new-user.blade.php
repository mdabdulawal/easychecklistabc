@extends('layouts/default')

@section('content')

	<div class="page-content">
			<!-- BEGIN PAGE HEADER-->
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN PAGE TITLE & BREADCRUMB-->
					<h3 class="page-title">
					Compnay User Profile <small>add new user</small>
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
							<a href="{{ URL::route('profile') }}">Home</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="#">User</a>
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
							<i class="fa fa-cog"></i> Basic info </a>
							<span class="after">
							</span>
						</li>
					</ul>
				</div>
				<div class="col-md-9">
					<div class="tab-content">
						<div id="tab_1-1" class="tab-pane active">
							{{ Form::open(array('route' => 'add-new-user', 'role' => 'form', 'files' => 'true')) }}
								<div class="form-group">
									<div class="fileinput fileinput-new" data-provides="fileinput">
										<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
											<img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt=""/>
										</div>
										<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;">
										</div>
										<div>
											<span class="btn default btn-file">
											<span class="fileinput-new">
											Select image </span>
											<span class="fileinput-exists">
											Change </span>
											<input type="file" name="photo" required="required">
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

								<div class="form-group">
									{{ Form::label('first_name', 'First Name', array('class' => 'control-label')) }}

									{{ Form::text('first_name', null, array('class' => 'form-control', 'required' => 'required')) }}
								</div>
								<div class="form-group">
									{{ Form::label('middle_name', 'Middle Name', array('class' => 'control-label')) }}

									{{ Form::text('middle_name', null, array('class' => 'form-control')) }}
								</div>
								<div class="form-group">
									{{ Form::label('last_name', 'Last Name', array('class' => 'control-label')) }}

									{{ Form::text('last_name', null, array('class' => 'form-control', 'required' => 'required')) }}
								</div>
								<div class="form-group">
									{{ Form::label('email', 'Email Address', array('class' => 'control-label')) }}

									{{ Form::email('email', null, array('class' => 'form-control', 'required' => 'required')) }}
								</div>
								<div class="form-group">
									{{ Form::label('password', 'Password', array('class' => 'control-label')) }}

									{{ Form::password('password', array('class' => 'form-control', 'required' => 'required')) }}
								</div>
								<div class="form-group">
									{{ Form::label('phone', 'Phone', array('class' => 'control-label')) }}

									{{ Form::text('phone', null, array('class' => 'form-control', 'placeholder' => 'xxx xxx xxxx', 'required' => 'required')) }}
								</div>
								<div class="form-group">
									{{ Form::label('mobile', 'Mobile', array('class' => 'control-label')) }}

									{{ Form::text('mobile', null, array('class' => 'form-control', 'required' => 'required')) }}
								</div>
								<div class="form-group">
									{{ Form::label('address', 'Address', array('class' => 'control-label')) }}

									{{ Form::text('address', null, array('class' => 'form-control', 'required' => 'required')) }}
								</div>
								<div class="form-group">
									{{ Form::label('about', 'About', array('class' => 'control-label')) }}

									{{ Form::textarea('about', null, array('class' => 'form-control', 'placeholder' => 'Write something about you...' ,'rows' => '3', 'required' => 'required')) }}
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