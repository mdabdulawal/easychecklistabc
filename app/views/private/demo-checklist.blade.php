@extends('layouts/default')

@section('content')
<style type="text/css">
	.fsz12{
		font-size: 12px;
	}
	.fsz16{
		font-size: 16px;
	}
	.strong{
		font-weight: bold;
	}
	.panel-title a{
		text-decoration: none;
	}
	.sm-icon-list{
		padding-right: 10px;
	}
	.sm-icon{
		padding: 5px 7px;
		border: #999 1px solid;
		color: #fff;
		background-color: #333; 
	}
	.task-tab{
		background: #eaeaea;
	}
	.r-c-icon{
		padding: 5px 7px;
	}
	.white{
		background: #fff;
	}
</style>
	<div class="page-content">
			<!-- BEGIN PAGE HEADER-->
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN PAGE TITLE & BREADCRUMB-->
					<h3 class="page-title">
					Demo Checklists <small>view checklist details</small>
					</h3>

					<ul class="page-breadcrumb breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="{{URL::route('profile')}}">Home</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="#">Checklist</a>
						</li>
					</ul>
					<!-- END PAGE TITLE & BREADCRUMB-->

					<!--Display Flash Messages-->
			        @if(Session::has('message'))
			            <div class="alert alert-{{ Session::get('alertType') }}">
			                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
			                <p>{{ Session::get('message') }}</p>
			            </div>
			        @endif

				</div>
			</div>
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
			<div class="row profile-account">
				<div class="col-md-6">

					<!-- BEGIN ACCORDION PORTLET-->
					<div class="portlet box red">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-list"></i> Demo Checklist
							</div>						
						</div>
						<div class="portlet-body">
							<div class="panel-group accordion" id="accordion1">
								@if($checklist)
									{{-- */$i=1;/* --}}
									@foreach($checklist as $cl)
										<div class="panel panel-default">
											<div class="panel-heading">
												<div class="panel-title">
													<p class="fsz12 text-left">
														{{-- */$t = 0;/* --}}
														@if(count(@$cl->tasks))															
															@foreach($cl->tasks as $cltc)
																@if($cltc->status == 'Completed')
																	{{-- */$t++;/* --}}
																@endif
															@endforeach
														@endif
														&nbsp; {{ $t; }} / {{ count(@$cl->tasks) }}
													</p>
													<p class="text-center">
														<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapse_3_{{$i}}">
															<span class="text-warning fsz12">{{ date('F j, Y', strtotime($cl->due_date)) }}</span><br>
															<span class="fsz16 strong">{{ $cl->title }}</span><br>
															<span class="text-success fsz12">{{ $cl->company_name }}</span>
														</a>														
													</p>													
													<p class="sm-icon-list text-right">
														<a href="{{ URL::route('checklist.copy', $cl->id) }}" title="copy"><span class="fsz12 strong sm-icon">c</span></a>
														<a href="{{ URL::route('task.add', $cl->id) }}" title="task"><span class="fsz12 strong sm-icon">t</span></a>
														<a href="#"><span class="fsz12 strong sm-icon" title="email reminders">e</span></a>
														<a href="{{ URL::route('checklist.update', $cl->id) }}" title="update"><span class="fsz12 strong sm-icon">u</span></a>
														<a href="#basic{{$i}}" data-toggle="modal" title="delete"><span class="fsz12 strong sm-icon">x</span></a>
													</p>
													<!--modal starts-->
													<div class="modal fade" id="basic{{$i}}" tabindex="-1" role="basic" aria-hidden="true">
														<div class="modal-dialog">
															<div class="modal-content">
																<div class="modal-header">
																	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
																	<h4 class="modal-title">Delete Checklist</h4>
																</div>
																<div class="modal-body">
																	 Are you sure want to delete ?
																</div>
																<div class="modal-footer">
																	{{ Form::open(array('route' => array('checklist.delete', $cl->id))) }}
																	<button type="button" class="btn default" data-dismiss="modal">Cancel</button>
																	<button type="submit" id="confirm-delete" class="btn red">Delete</button>
																	{{ Form::close() }}
																</div>
															</div>
															<!-- /.modal-content -->
														</div>
														<!-- /.modal-dialog -->
													</div>
													<!-- /.modal -->
													<!--modal ends-->
												</div>
											</div>
											<div id="collapse_3_{{$i}}" class="panel-collapse collapse">
												<div class="panel-body">
													@if(count($cl->tasks))
														<div class="panel-group accordion" id="accordion3">
															@if($cl->tasks)
																{{-- */$j=1;/* --}}
																@foreach($cl->tasks as $clt)
																	<div class="panel panel-default task-tab">
																		<div class="panel-heading">
																			<div class="panel-title task-tab">
																				<p class="text-left">
																					<span class="r-c-icon">{{ $i.'.'.$j }}</span><br>
																					@if($clt->status == 'Running')
																						<i class="r-c-icon fa fa-times"></i>
																						@else
																							<i class="r-c-icon glyphicon glyphicon-ok"></i>
																					@endif
																				</p>
																				<p class="text-center">
																					<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_{{$i.$j}}">
																						<span class="text-warning fsz12">
																							@if($clt->status == 'Completed')
																								{{ 'Completed' }}
																								@else
																									Due Date: {{ date('F j, Y', strtotime($clt->due_date)) }}
																							@endif
																						</span><br>
																						<span class="fsz16 strong">{{ $clt->title }}</span><br>
																					</a>														
																				</p>																				
																				<p class="sm-icon-list text-right task-tab">
																					<a href="#" title="task information"><span class="fsz12 strong sm-icon">i</span></a>
																					<a href="{{ URL::route('task.copy', $clt->id) }}" title="copy/duplicate task"><span class="fsz12 strong sm-icon">c</span></a>
																					<a href="{{ URL::route('task.delete', $clt->id) }}" title="delete task"><span class="fsz12 strong sm-icon">x</span></a>
																				</p>
																			</div>
																		</div>
																		<div id="collapse_3_{{$i.$j}}" class="panel-collapse collapse">
																			<div class="panel-body white">
																			<h3 class="form-section text-center">Task Attributes</h3>
																			<div class="portlet-body form">	
																			<!-- BEGIN FORM-->
																			{{ Form::model($clt, array('route' => array('task.update', $clt->id), 'class' => 'form-horizontal')) }}
																				<div class="form-body">	
																					<div class="form-group">										
																						{{ Form::label('start_date', 'Start Date', array('class' => 'col-md-3 control-label')) }}
																						<div class="col-md-6">											
																							<div data-date-format="yyyy-mm-dd" class="input-group date date-picker">
																								{{ Form::text('start_date', null, array('readonly' => '', 'class' => 'form-control')) }}
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
																								<span class="input-group-btn">
																								<button type="button" class="btn default"><i class="fa fa-calendar"></i></button>
																								</span>
																							</div>
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
																						{{ Form::label('status', 'Status', array('class' => 'col-md-3 control-label')) }}
																						<div class="col-md-6">
																							{{ Form::select('status', array('' => '-- Select Status --', 'Running' => 'Running', 'Completed' => 'Completed'), null, array('class' => 'form-control select2me', 'required' => 'required')) }}
																						</div>
																					</div>
																					<div class="form-group">										
																						{{ Form::label('created_at', 'Created at', array('class' => 'col-md-3 control-label')) }}
																						<div class="col-md-6">											
																							<div data-date-format="yyyy-mm-dd" class="input-group date date-picker">
																								{{ Form::text('created_at', null, array('readonly' => '', 'class' => 'form-control')) }}
																								<span class="input-group-btn">
																								<button type="button" class="btn default"><i class="fa fa-calendar"></i></button>
																								</span>
																							</div>
																						</div>
																					</div>
																					<div class="form-group">										
																						{{ Form::label('updated_at', 'Recent activity', array('class' => 'col-md-3 control-label')) }}
																						<div class="col-md-6">											
																							<div data-date-format="yyyy-mm-dd" class="input-group date date-picker">
																								{{ Form::text('updated_at', null, array('readonly' => '', 'class' => 'form-control')) }}
																								<span class="input-group-btn">
																								<button type="button" class="btn default"><i class="fa fa-calendar"></i></button>
																								</span>
																							</div>
																						</div>
																					</div>
																				</div>
																				<div class="form-actions fluid">
																					<div class="col-md-offset-3 col-md-9">
																						<button class="btn btn-circle blue" type="submit">Update</button>
																						<button class="btn btn-circle default" type="reset">Cancel</button>
																					</div>
																				</div>
																			{{ Form::close() }}
																			<!-- END FORM-->
																			</div>
																			</div>
																		</div>
																	</div>
																	{{-- */$j++;/* --}}
																@endforeach
															@endif
														</div>
														@else
															{{ 'No Tasks Available' }}
													@endif
												</div>
											</div>
										</div>
										{{-- */$i++;/* --}}
									@endforeach
								@endif
							</div>
						</div>
					</div>
					<!-- END ACCORDION PORTLET-->
				</div>
				<div class="col-md-6">
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
							{{ Form::open(array('route' => 'create-new-demo-checklist', 'class' => 'form-horizontal')) }}
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
												<span class="input-group-btn">
												<button type="button" class="btn default"><i class="fa fa-calendar"></i></button>
												</span>
											</div>
										</div>
									</div>
									<div class="form-group">										
										{{ Form::label('client_id', 'Client Name', array('class' => 'col-md-3 control-label')) }}
										<div class="col-md-6">
											{{ Form::select('client_id', array('' => '-- Select Client Name --'), null, array('class' => 'form-control select2me')) }}
										</div>
									</div>
									<div class="form-group">										
										{{ Form::label('user_id', 'Assigned To', array('class' => 'col-md-3 control-label')) }}
										<div class="col-md-6">
											{{ Form::select('user_id', array('' => '-- Select Employee Name --'), null, array('class' => 'form-control select2me')) }}
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
										{{ Form::label('email_reminders', 'Email Reminders', array('class' => 'col-md-6 control-label')) }}
										<div class="col-md-3">
											{{ Form::select('email_reminders', array('' => '-- Select Reminder Type --', 'daily' => 'Daily', 'weekly' => 'Weekly', 'monthly' => 'Monthly'), null, array('class' => 'form-control select2me')) }}
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
		<!-- END PAGE CONTENT-->
		</div>

@stop