@extends('layouts/default')

@section('content')

	<div class="page-content">
			<!-- BEGIN PAGE HEADER-->
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN PAGE TITLE & BREADCRUMB-->
					<h3 class="page-title">
					User Profile <small>user profile overview</small>
					</h3>
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="{{ URL::route('profile') }}">Home</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="{{ URL::route('users') }}">Users</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="#">Details</a>
						</li>
					</ul>
					<!-- END PAGE TITLE & BREADCRUMB-->
				</div>
			</div>
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
			<div class="row profile">
				<div class="col-md-12">
					<!--BEGIN TABS-->
					<div class="tabbable tabbable-custom tabbable-full-width">
						<!--Display Flash Messages-->
				        @if(Session::has('message'))
				            <div class="alert alert-{{ Session::get('alertType') }}">
				                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
				                <p>{{ Session::get('message') }}</p>
				            </div>
				        @endif
						<ul class="nav nav-tabs">
							<li class="active">
								<a href="#tab_1_1" data-toggle="tab">
								Overview </a>
							</li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane active" id="tab_1_1">
								<div class="row">
									<div class="col-md-3">
										<ul class="list-unstyled profile-nav">
											<li>
											@if($user->photo)
												<img src="{{ URL::asset('images/profile/'.$user->photo.'') }}" class="img-responsive" alt="Photo"/>
												@else
													<img src="http://www.placehold.it/245x200/EFEFEF/AAAAAA&amp;text=no+image" alt=""/>
											@endif
											</li>
										</ul>
									</div>
									<div class="col-md-9">
										<div class="row">
											<div class="col-md-12 profile-info">
												<h1>
													{{ $user->first_name.' '.@$user->middle_name.' '.$user->last_name }}
												</h1>
												<p>
													 {{ $user->about }}
												</p>
												<p>
													<a href="mailto: {{ $user->email }}">
														{{ $user->email }}
													</a>
												</p>
												<ul class="list-inline">
													<li>
														<i class="fa fa-map-marker"></i> 
														{{ $user->address }}
													</li>
													<li>
														<i class="fa fa-phone"></i>
														{{ $user->phone }}
													</li>
													<li>
														<i class="fa fa-mobile"></i>
														{{ $user->mobile }}
													</li>
												</ul>
											</div>
											<!--end col-md-12-->
										</div>
										<!--end row-->										
									</div>
								</div>
							</div>
							<!--tab_1_2-->						
							<!--end tab-pane-->
						</div>
					</div>
					<!--END TABS-->
				</div>
			</div>
			<div class="row">
				<div class="col-md-3"></div>
				<div class="col-md-9">
					<div class="tab-content">
						<div id="tab_1-1" class="tab-pane active">
							{{ Form::model($user ,array('route' => array('user.update', $user->id), 'role' => 'form', 'files' => 'true')) }}
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
											Change image </span>
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

								<div class="form-group">
									{{ Form::label('first_name', 'First Name', array('class' => 'control-label')) }}

									{{ Form::text('first_name', null, array('class' => 'form-control', 'placeholder' => 'John', 'required' => 'required')) }}
								</div>
								<div class="form-group">
									{{ Form::label('middle_name', 'Middle Name', array('class' => 'control-label')) }}

									{{ Form::text('middle_name', null, array('class' => 'form-control')) }}
								</div>
								<div class="form-group">
									{{ Form::label('last_name', 'Last Name', array('class' => 'control-label')) }}

									{{ Form::text('last_name', null, array('class' => 'form-control', 'placeholder' => 'Doe', 'required' => 'required')) }}
								</div>
								<div class="form-group">
									{{ Form::label('email', 'Email Address', array('class' => 'control-label')) }}

									{{ Form::email('email', null, array('class' => 'form-control', 'required' => 'required')) }}
								</div>								
								<div class="form-group">
									{{ Form::label('phone', 'Phone', array('class' => 'control-label')) }}

									{{ Form::text('phone', null, array('class' => 'form-control', 'placeholder' => '+1 646 580', 'required' => 'required')) }}
								</div>
								<div class="form-group">
									{{ Form::label('mobile', 'Mobile', array('class' => 'control-label')) }}

									{{ Form::text('mobile', null, array('class' => 'form-control', 'placeholder' => '987 654 321', 'required' => 'required')) }}
								</div>
								<div class="form-group">
									{{ Form::label('address', 'Address', array('class' => 'control-label')) }}

									{{ Form::text('address', null, array('class' => 'form-control', 'required' => 'required')) }}
								</div>
								<div class="form-group">
									{{ Form::label('about', 'About', array('class' => 'control-label')) }}

									{{ Form::textarea('about', null, array('class' => 'form-control', 'placeholder' => 'Lorem ipsum dolor sit amet...' ,'rows' => '3', 'required' => 'required')) }}
								</div>
								<div class="margiv-top-10">
									<button type="submit" class="btn green">Save Changes</button>
									<button type="reset" class="btn default">Cancel</button>
								</div>
							{{ Form::close() }}
						</div>
					</div>
				</div>
			</div>
			<!-- END PAGE CONTENT-->
		</div>

@stop