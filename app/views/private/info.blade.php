@extends('layouts/default')

@section('content')
	@if(Auth::user()->role == '99')
		{{--*/$isSuperAdmin = true;/*--}}
		@else
			{{--*/$isSuperAdmin = false;/*--}}
	@endif
	<div class="page-content">
			<!-- BEGIN PAGE HEADER-->
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN PAGE TITLE & BREADCRUMB-->
					<h3 class="page-title">
					@if(Auth::user()->role == '99') 
						User's Company 
						@else
							User
					@endif 
					Profile <small>manage profile</small>
					</h3>
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
							<li>
								<a href="#tab_1_3" data-toggle="tab">
								Account </a>
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
												<!-- <a href="#" class="profile-edit">
												edit </a> -->
												@else
													<img src="http://www.placehold.it/245x200/EFEFEF/AAAAAA&amp;text=no+image" alt=""/>
											@endif
											</li>
											<li>
												<a href="#">
												Messages <span>
												3 </span>
												</a>
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
							<div class="tab-pane" id="tab_1_3">
								<div class="row profile-account">
									<div class="col-md-3">
										<ul class="ver-inline-menu tabbable margin-bottom-10">
											<li class="active">
												<a data-toggle="tab" href="#tab_1-1">
												<i class="fa fa-cog"></i> Personal info </a>
												<span class="after">
												</span>
											</li>
											<li>
												<a data-toggle="tab" href="#tab_2-2">
												<i class="fa fa-picture-o"></i> Change Avatar </a>
											</li>
											<li>
												<a data-toggle="tab" href="#tab_3-3">
												<i class="fa fa-lock"></i> Change Password </a>
											</li>
											@if($isSuperAdmin)
												<li>
													<a data-toggle="tab" href="#tab_3-4">
													<i class="fa fa-shopping-cart"></i> Subscription Status </a>
												</li>
											@endif
										</ul>
									</div>
									<div class="col-md-9">
										<div class="tab-content">
											<div id="tab_1-1" class="tab-pane active">
												{{ Form::model($user, array('route' => 'profile', 'role' => 'form')) }}
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
														{{ Form::label('phone', 'Office Phone', array('class' => 'control-label')) }}

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

														{{ Form::textarea('about', null, array('class' => 'form-control', 'placeholder' => 'Hi ! I am ...', 'rows' => '3', 'required' => 'required')) }}
													</div>
													<div class="margiv-top-10">
														<button type="submit" class="btn green">Save Changes</button>
														<button type="reset" class="btn default">Cancel</button>
													</div>
												{{ Form::close() }}
											</div>
											<div id="tab_2-2" class="tab-pane">
												<p>
													 Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod.
												</p>
												{{ Form::open(array('route' => 'change-avatar', 'role' => 'form', 'files' => 'true')) }}
													<div class="form-group">
														<div class="fileinput fileinput-new" data-provides="fileinput">
															<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
																@if($user->photo)
																	<img src="{{ URL::asset('images/profile/'.$user->photo.'') }}" alt="Photo"/>
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
													<div class="margin-top-10">
														<button type="submit" class="btn green">Submit</button>
														<button type="reset" class="btn default">Cancel</button>
													</div>
												{{ Form::close() }}
											</div>
											<div id="tab_3-3" class="tab-pane">
												{{ Form::open(array('route' => 'change-user-pass')) }}
													<div class="form-group">
														{{ Form::label('current-pass', 'Current Password', array('class' => 'control-label')) }}
														{{ Form::password('current-pass', array('class' => 'form-control')) }}
													</div>
													<div class="form-group">
														{{ Form::label('new-pass', 'New Password', array('class' => 'control-label')) }}
														{{ Form::password('new-pass', array('class' => 'form-control')) }}
													</div>
													<div class="form-group">
														{{ Form::label('re-pass', 'Re-type New Password', array('class' => 'control-label')) }}
														{{ Form::password('re-pass', array('class' => 'form-control')) }}
													</div>
													<div class="margin-top-10">
														<button type="submit" class="btn green">Save Changes</button>
														<button type="reset" class="btn default">Cancel</button>
													</div>
												{{ Form::close() }}
											</div>
											@if($isSuperAdmin)
												<div id="tab_3-4" class="tab-pane">
													@if($user->stripe_active == '1')
														<div class="portlet light">
															<div class="portlet-title">
																<div class="caption">
																	<i class="fa fa-times font-yellow-casablanca"></i>
																	<span class="caption-subject bold font-yellow-casablanca uppercase">
																	Cancell Subscriptions </span>
																</div>
															</div>
															<div class="portlet-body">
																{{ Form::open(array('route' => 'cancel-subscription')) }}		
																	<div class="margin-top-10">
																		<button type="submit" class="btn red">Cancel Subscription</button>
																	</div>
																{{ Form::close() }}
															</div>
														</div>
														@else
															<div class="portlet light">
																<div class="portlet-title">
																	<div class="caption">
																		<i class="fa fa-check font-yellow-casablanca"></i>
																		<span class="caption-subject bold font-yellow-casablanca uppercase">
																		Resume Subscriptions </span>
																	</div>
																</div>
																<div class="portlet-body">
																	{{ Form::open(array('route' => 're-subscription')) }}		
																		<div class="col-md-5">
																			<div class="margin-top-10">																			
																				<button type="submit" class="btn green">Click To Resume Subscription</button>
																			</div>
																		</div>
																	{{ Form::close() }}
																</div>
															</div>
													@endif																								
													@if($user->stripe_active == '1')
														<div class="portlet light">
															<div class="portlet-title">
																<div class="caption">
																	<i class="icon-paper-plane font-yellow-casablanca"></i>
																	<span class="caption-subject bold font-yellow-casablanca uppercase">
																	Update Plans </span>															
																</div>
															</div>
															<div class="portlet-body">
																{{ Form::model($user, array('route' => 'upgrade-plan')) }}		
																	<div class="col-md-5">
																		<div class="margin-top-10">
																			<p>{{ Form::select('pricing_id', array('' => '-- Select Plan --')+$pricings, null, array('class' => 'form-control select2me', 'required' => 'required')) }}</p>
																			<button type="submit" class="btn green">Upgrade</button>
																		</div>
																	</div>
																{{ Form::close() }}
															</div>
														</div>
													@endif												
												</div>
											@endif
										</div>
									</div>
									<!--end col-md-9-->
								</div>
							</div>
							<!--end tab-pane-->
						</div>
					</div>
					<!--END TABS-->
				</div>
			</div>
			<!-- END PAGE CONTENT-->
		</div>

@stop