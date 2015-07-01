@extends('layouts/default')

@section('content')

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
					Users <small>manage users</small>
					</h3>
					<!-- END PAGE TITLE & BREADCRUMB-->
				</div>
			</div>
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
			<div class="row">
				<div class="col-md-12">
					@if(Session::has('message'))
			            <div class="alert alert-{{ Session::get('alertType') }}">
			                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
			                <p>{{ Session::get('message') }}</p>
			            </div>
			        @endif
					<div class="add-portfolio">
						<span>
						Total of {{ count($users) }} users </span>
						<a href="{{ URL::route('add-new-user') }}" class="btn icn-only green">
						Add New User <i class="m-icon-swapright m-icon-white"></i>
						</a>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="tabbable tabbable-custom tabbable-custom-profile">
						<ul class="nav nav-tabs">
							<li class="active">
								<a href="#tab_1_11" data-toggle="tab">
								Latest User </a>
							</li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane active" id="tab_1_11">
								<div class="portlet-body">
									<table class="table table-striped table-bordered table-advance table-hover">
									<thead>
									<tr>
										<th>
											<i class="fa fa-user"></i> Name
										</th>
										<th class="hidden-xs">
											<i class="fa fa-envelope"></i> Email Address
										</th>
										<th>
											<i class="fa fa-mobile"></i> Mobile
										</th>
										<th>
											Actions
										</th>
									</tr>
									</thead>
									<tbody>
									@if($users)
										@foreach($users as $cu)
											<tr>
												<td>
													<a href="#">{{ $cu->first_name.' '.@$cu->middle_name.' '.$cu->last_name }}</a>
												</td>
												<td class="hidden-xs">
													 {{ $cu->email }}
												</td>
												<td>
													<span class="label label-success label-sm">
														{{ $cu->mobile }}
													</span>
												</td>
												<td>
													<a class="btn default btn-xs green-stripe" href="{{ URL::route('user.overview', $cu->id) }}">
													View </a> &nbsp;&nbsp;
													<a class="btn default btn-xs red-stripe" href="{{ URL::route('user.delete', $cu->id) }}">
													Delete </a>
												</td>
				
											</tr>
										@endforeach
									@endif
									</tbody>
									</table>
								</div>
							</div>
							<!--tab-pane-->
						</div>
					</div>
				</div>	
			</div>
			<!-- END PAGE CONTENT-->
		</div>

@stop