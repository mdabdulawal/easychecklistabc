@extends('layouts/default')

@section('content')

	<div class="page-content">
			<!-- BEGIN PAGE HEADER-->
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN PAGE TITLE & BREADCRUMB-->
					<h3 class="page-title">
					Client Profile <small>client profile overview</small>
					</h3>
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="{{URL::route('profile')}}">Home</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="{{ URL::route('clients') }}">Clients</a>
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
											@if($client->photo)
												<img src="{{ URL::asset('images/clients/'.$client->photo.'') }}" class="img-responsive" alt="Photo"/>
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
													{{ $client->company_name }}
												</h1>
												<h3>Contact Name: {{ $client->contact_name }}</h3>
												<p>
													<a href="mailto: {{ $client->email }}">
														{{ $client->email }}
													</a>
												</p>
												<ul class="list-inline">
													<li>
														<i class="fa fa-map-marker"></i> 
														{{ $client->address }}
													</li>
													<li>
														<i class="fa fa-phone"></i>
														{{ $client->phone }}
													</li>
													<li>
														<i class="fa fa-mobile"></i>
														{{ $client->mobile }}
													</li>
												</ul>
												<p>
													<a href="{{URL::route('client.update', $client->id)}}">
														<i class="fa fa-pencil"></i> Update info
													</a>
												</p>
											</div>
											<!--end col-md-12-->
										</div>
										<!--end row-->	


										<div class="row">
					<div class="col-md-12">
					<!-- BEGIN SAMPLE TABLE PORTLET-->
					<div class="portlet box blue">
						<div class="portlet-title">
							<div class="caption"><i class="fa fa-user"></i>Additional Contacts</div>
							<div class="tools">
							</div>
						</div>
						<div class="portlet-body">
							<div class="table-responsive">
								<table class="table table-striped table-bordered table-advance table-hover">
									<thead>
										<tr>
											<th>Name</th>
											<th class="hidden-xs"> Email</th>
										</tr>
									</thead>
									<tbody>
									@if($contacts)
									@foreach($contacts as $contact)
										<tr>
											<td>{{$contact->contact_name}}</td>
											<td class="hidden-xs">{{$contact->contact_email}}</td>
										</tr>
									@endforeach	
									@else
										<tr>
											<td>No contact Found!</td>
											<td class="hidden-xs"></td>
										</tr>
									@endif
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<!-- END SAMPLE TABLE PORTLET-->
				</div>											

										</div>									
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
			<!-- END PAGE CONTENT-->
		</div>

@stop