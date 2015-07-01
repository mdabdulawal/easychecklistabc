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
						<a href="#">Paid User</a>
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
				<div class="col-md-12">
					<div class="portlet box blue">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-shopping-cart"></i>Paid user list
							</div>
						</div>
						<div class="portlet-body">
							<table class="table table-hover">
							<thead>
							<tr>
								<th>#</th>
								<th>Customer ID</th>
								<th>Name</th>
								<th>Email</th>
								<th>Start Date</th>
								<th>Trial Ends</th>
								<th>Type</th>
								<th>Status</th>
								<th>Action</th>								
							</tr>
							</thead>
							<tbody>
								@if($users)
									{{-- */$i=1;/* --}}
									@foreach($users as $user)
										<tr>
											<td>{{ $i }}</td>
											<td>{{ $user->stripe_id }}</td>
											<td>{{ $user->first_name.' '.@$user->middle_name.' '.$user->last_name }}</td>
											<td>{{ $user->email }}</td>
											<td>{{ $user->created_at->format('M d, Y') }}</td>
											<td>
												@if(in_array($user->pricing_id, array('2','4','6')))
													@if($user->trial_ends_at)
														{{ date('M d, Y', strtotime($user->trial_ends_at)) }}
													@endif
												@endif
											</td>
											<td>{{ $user->package_name }}</td>											
											<td>
												@if($user->stripe_active == '1')
														<span class="label label-success">Subscribed</span>
													@else
														<span class="label label-danger">Cancelled</span>
												@endif
											</td>
											<td>
												<p>
													<a class="btn default btn-xs red-stripe" href="{{ URL::route('user.upgrade', $user->id) }}">
														Upgrade
													</a>
												</p>
												<p>
													<a class="btn default btn-xs green-stripe" href="{{ URL::route('user.delete', $user->id) }}">
														Delete 
													</a>
												</p>
											</td>
										</tr>
									{{-- */$i++;/* --}}
									@endforeach
								@endif
							</tbody>
							</table>
							<div class="pagination">
								{{ $users->links(); }}
							</div>
						</div>
					</div>
				</div>
			</div>
		<!-- END PAGE CONTENT-->
	</div>

@stop