@extends('layouts/default')

@section('content')

	<div class="page-content">
		<!-- BEGIN PAGE HEADER-->
		<div class="row">
			<div class="col-md-12">
				<!-- BEGIN PAGE TITLE & BREADCRUMB-->
				<h3 class="page-title">
				Dashboard <small>Super admin</small>
				</h3>

				<ul class="page-breadcrumb breadcrumb">
					<li></li>
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
			<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
				<div class="dashboard-stat blue-madison">
					<div class="visual">
						<i class="fa fa-list"></i>
					</div>
					<div class="details">
						<div class="number">
							 {{ $task_overview->Completed .' / '. $task_overview->Total }}
						</div>
						<div class="desc">
							 Tasks
						</div>
					</div>
					<a href="#" class="more">
					<!-- View more <i class="m-icon-swapright m-icon-white"></i> -->&nbsp;
					</a>
				</div>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
				<div class="dashboard-stat red-intense">
					<div class="visual">
						<i class="fa fa-check"></i>
					</div>
					<div class="details">
						<div class="number">
							 {{ $checklist_overview->Completed .' / '. $checklist_overview->Total }}
						</div>
						<div class="desc">
							 Checklists
						</div>
					</div>
					<a href="#" class="more">
					<!-- View more <i class="m-icon-swapright m-icon-white"></i> -->&nbsp;
					</a>
				</div>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
				<div class="dashboard-stat green-haze">
					<div class="visual">
						<i class="fa fa-clock-o"></i>
					</div>
					<div class="details">
						<div class="number">
							@if($checklist_overview->Completed)
								{{ intval($avg_completion_time / $checklist_overview->Completed) }} Days
							@endif	 
						</div>
						<div class="desc">
							 Avg. Completion Time
						</div>
					</div>
					<a href="#" class="more">
					<!-- View more <i class="m-icon-swapright m-icon-white"></i> -->&nbsp;
					</a>
				</div>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
				<div class="dashboard-stat purple-plum">
					<div class="visual">
						<i class="fa fa-clock-o"></i>
					</div>
					<div class="details">
						<div class="number">
							@if($checklist_overview->Completed)
							 	{{ intval(($on_time*100) / $checklist_overview->Completed) }} %
							@endif
						</div>
						<div class="desc">
							 On Time
						</div>
					</div>
					<a href="#" class="more">
					<!-- View more <i class="m-icon-swapright m-icon-white"></i> -->&nbsp;
					</a>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-8">
				<div class="row">
					<div class="col-md-12">
						<div class="portlet box red">
							<div class="portlet-title">
								<div class="caption">
									<i class="fa fa-list-ul"></i>My Checklist
								</div>
							</div>
							<div class="portlet-body">
								<table class="table table-striped table-bordered table-hover" id="sample_2">
								<thead>
								<tr>								
									<th>Checklist Name</th>
									<th>Start Date</th>
									<th>Due Date</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
								</thead>
								<tbody>
								@if($myAssignments)
									@foreach($myAssignments as $Assignment)
										<tr class="odd gradeX">								
											<td><a href="{{ URL::route('checklist.update', $Assignment->id) }}"><strong>{{ $Assignment->title }}</strong></a></td>									
											<td>
												<span class="label label-sm label-info">
													{{ date('d/m/y', strtotime($Assignment->start_date)) }}
												</span>
											</td>
											<td>
												<span class="label label-sm label-warning">
													{{ date('d/m/y', strtotime($Assignment->due_date)) }}
												</span>
											</td>
											<th>
												@if($Assignment->status == 'Running')
													<span class="label label-sm label-danger">{{$Assignment->status}}</span>
													@else
													<span class="label label-sm label-success">{{$Assignment->status}}</span>	
												@endif
											</th>
											<td>								
												@if($Assignment->status == 'Running')
												<a title="mark as complete" href="{{URL::route('task.complete', $Assignment->task_id)}}">
													<i class="fa fa-check"></i> <strong>Mark as Completed</strong>
												</a>
													@else											
														<i class="fa fa-check"></i> <strong>Accomplished</strong>
												@endif
											</td>
											<td>
												<span class="label label-sm label-warning">
													{{ $Assignment->res }}
												</span>
											</td>


										</tr>
									@endforeach
								@endif
								</tbody>
								</table>
								<div class="pagination">
									
								</div>
							</div>
						</div>
					</div>




					<div class="col-md-12">
						<div class="portlet box yellow">
							<div class="portlet-title">
								<div class="caption">
									<i class="fa fa-clock-o"></i>Email Reminders
								</div>
							</div>
							<div class="portlet-body">
								<table class="table table-striped table-bordered table-hover" id="sample_2">
								<thead>
								<tr>								
									<th>Client Name</th>
									<th>Checklist Name</th>
									<th>Next Reminder</th>
									<th>Email</th>
									<th>Due Date</th>
									<th>Assigned To</th>
								</tr>
								</thead>
								<tbody>
								@if($checklist_reminders)
									@foreach($checklist_reminders as $reminder)
										<tr class="odd gradeX">								
											<td><a href="#">{{ $reminder->company_name }}</a></td>
											<td>{{ $reminder->title }}</td>
											<td>{{ date('d/m/y', strtotime($reminder->notify_date)) }}</td>
											<td><a href="mailto:{{$reminder->email}}">{{ $reminder->email }}</a></td>
											<td>{{ date('d/m/y', strtotime($reminder->due_date)) }}</td>
											<td><a href="#">{{ $reminder->first_name.' '.$reminder->last_name }}</a></td>
										</tr>
									@endforeach
								@endif
								</tbody>
								</table>
								<div class="pagination">
									
								</div>
							</div>
						</div>
					</div>
				</div>
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
								@if(count($activities))
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
		</div>
		<!-- END PAGE CONTENT-->

	</div>

@stop