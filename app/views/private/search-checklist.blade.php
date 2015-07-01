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
	.taskStatus{
		display: none;
	}
</style>
	<div class="page-content">
			<!-- BEGIN PAGE HEADER-->
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN PAGE TITLE & BREADCRUMB-->
					<h3 class="page-title">
					My Checklists <small>view checklist details</small>
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
				<div class="col-md-8">


					<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
					<div class="modal fade" id="portlet-config" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
									<h4 class="modal-title">Import Checklist</h4>
								</div>
								<div class="modal-body">
									 <p style="color: #FC0000;">
									 	<strong>Title, StartDate, DueDate, LinkToFolder, Description -</strong> fields are manadatory in your csv file. <br>
									 </p>
									 <!-- BEGIN FORM-->
									{{ Form::open(array('route' => 'import-checklist', 'class' => 'form-horizontal', 'files' => 'true')) }}
										<div class="form-body">	
											<div class="form-group">										
												{{ Form::label('csv', 'Select CSV', array('class' => 'col-md-3 control-label')) }}
												<div class="col-md-6">											
													{{ Form::file('csv', null, array('class' => 'form-control', 'required' => 'required')) }}														
												</div>
											</div>
										</div>
										<div class="form-actions fluid">
											<div class="col-md-offset-3 col-md-9">
												<button class="btn btn-circle blue" type="submit">Import</button>												
											</div>										
										</div><br><br>
									{{ Form::close() }}
									<!-- END FORM-->
								</div>
								<div class="modal-footer">
									<button type="button" class="btn default" data-dismiss="modal">Close</button>
								</div>
							</div>
							<!-- /.modal-content -->
						</div>
						<!-- /.modal-dialog -->
					</div>
					<!-- /.modal -->
					<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
					<div class="row">
						<div class="col-md-6">	
						<!--BEGIN FORM-->
						{{ Form::open(array('route' => 'filter-checklist', 'class' => 'form-horizontal')) }}
							<div class="form-body">						
								<div class="form-group">																		
									<div class="col-md-8">
										{{ Form::select('filter_by', array('' => '-- Filter By --', 'due_date' => 'Due Date', 'company_name' => 'Client Name'), null, array('class' => 'form-control select2me', 'required' => 'required')) }}									
									</div>
									<div class="col-md-3">									
										<button class="btn btn-circle blue" type="submit">Filter</button>
									</div>
								</div>						
							</div>
						{{ Form::close() }}
						<!-- END FORM-->
						</div>
						
						<div class="col-md-6">	
					{{ Form::open(array('route' => 'search-checklist', 'class' => 'form-horizontal')) }}
							<div class="form-body">						
								<div class="form-group">																		
									<div class="col-md-8">											
											{{ Form::text('search_by', null, array('rows' => '3','placeholder' => 'Search Task List', 'required' => 'required', 'class' => 'form-control input-circle')) }}
										</div>
									<div class="col-md-3">									
										<button class="btn btn-circle blue" type="submit">Search</button>
									</div>
								</div>						
							</div>
						{{ Form::close() }}
						</div>

					</div>

					<!-- BEGIN ACCORDION PORTLET-->
					<div class="portlet box red">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-list"></i>Checklist
							</div>
							<div class="tools">
								<a style="text-decoration:none; color: #FFF;" href="#portlet-config" data-toggle="modal">
									<i class="fa fa-copy"></i> Import Checklist
								</a>
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
														<a href="#" title="information"><span class="fsz12 strong sm-icon">i</span></a>
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
																					<a class="taskStatus" id="runningStatus_{{$clt->id }}" onclick="changeStatus(this.id)" href="javaScript:void(0)" @if($clt->status == 'Running') style="display:block" @endif> <i class="r-c-icon fa fa-times"></i></a>
																						<a class="taskStatus" id="completeStatus_{{$clt->id }}" onclick="changeStatus(this.id)"  href="javaScript:void(0)" @if($clt->status != 'Running') style="display:block" @endif><i class="r-c-icon glyphicon glyphicon-ok"></i></a>
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
																			{{ Form::model($clt, array('route' => array('task.update', $clt->id), 'class' => 'form-horizontal', 'id'=>'tastForm_'.$clt->id)) }}
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
																							{{ Form::select('status', array('' => '-- Select Status --', 'Running' => 'Running', 'Completed' => 'Completed'), null, array('class' => 'form-control select2me', 'id' => 'statusVal_'.$clt->id, 'required' => 'required')) }}
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
				<div class="col-md-4">
					<!-- BEGIN PORTLET-->
				<div class="portlet">
					<div class="portlet-title line">
						<div class="caption">
							<i class="icon-share font-blue-steel"></i>
							<span class="caption-subject font-blue-steel ">Recent Activities</span>
						</div>
					</div>
					<div class="portlet-body" id="chats">
						<div class="scroller" style="height: 435px;" data-always-visible="1" data-rail-visible1="1">
							<ul class="chats">
								@if($activities)
									{{-- */$i = 1;/* --}}										
									@foreach($activities as $activity)																						
										@if($i%2 == 0)
											{{-- */$align = 'out';/* --}}
											@else
												{{-- */$align = 'in';/* --}}
										@endif
										<li class="{{$align}}">
											<img src="{{ URL::asset('images/profile/'.@$activity->user->photo) }}" alt="" class="avatar">
											<div class="message">
												<span class="arrow">
												</span>
												<a class="name" href="#">
													{{ $activity->user->first_name.' '.$activity->user->last_name }}
												 </a>
												<span class="datetime">
												at {{ $activity->created_at->format('H:i a D d') }} </span>
												<span class="body">
													{{ $activity->activity }}
												</span>
											</div>
										</li>
									{{-- */$i++;/* --}}
									@endforeach
									@else
										<p>No Activities Yet !</p>
								@endif
							</ul>
						</div>
					</div>
				</div>
				<!-- END PORTLET-->				
				</div>
			<!--end col-md-4-->
		<!-- END PAGE CONTENT-->
		</div>
	<script>
		 function changeStatus(id){
		 	var arr = id.split('_');
		 	var flug='Completed';
		 	 if(arr[0] == 'runningStatus'){
		 	 	jQuery("#runningStatus_"+arr[1]).hide();
		 	 	jQuery("#completeStatus_"+arr[1]).show();
		 	 	$( "#statusVal_"+arr[1]).val('Completed');
		 	 }
		 	 else{
		 	 	jQuery("#runningStatus_"+arr[1]).show();
		 	 	jQuery("#completeStatus_"+arr[1]).hide();
		 	 	flug='Running';
		 	 	$( "#statusVal_"+arr[1]).val('Running');
		 	 }

		 	 $( "#tastForm_"+arr[1] ).submit();
        } //End of changeStatus.

  
		   
	</script>
@stop