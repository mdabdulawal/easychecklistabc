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
						<a href="#">Pricing</a>
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
				<div class="col-md-6">
					<div class="portlet box green">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-shopping-cart"></i>Form :: Create New Package
							</div>
						</div>
						<div class="portlet-body form">
							<!-- BEGIN FORM-->							
							{{ Form::model($pricing, array('route' => array('pricing.update', $pricing->id), 'class' => 'form-horizontal')) }}
								<div class="form-body">
									<div class="form-group">										
										{{ Form::label('package_name', 'Package Name', array('class' => 'col-md-3 control-label')) }}
										<div class="col-md-6">											
											{{ Form::text('package_name', null, array('placeholder' => 'Type Package Name', 'required' => 'required', 'class' => 'form-control input-circle')) }}
										</div>
									</div>
									<div class="form-group">										
										{{ Form::label('price', 'Price', array('class' => 'col-md-3 control-label')) }}
										<div class="col-md-6">											
											{{ Form::text('price', null, array('placeholder' => 'Enter Price', 'required' => 'required', 'class' => 'form-control input-circle')) }}
										</div>
									</div>									
								</div>
								<div class="form-actions fluid">
									<div class="col-md-offset-3 col-md-9">
										<button class="btn btn-circle blue" type="submit">Update</button>
										<button class="btn btn-circle default" type="reset">Reset</button>
									</div>
								</div>
							{{ Form::close() }}
							<!-- END FORM-->
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="portlet box blue">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-shopping-cart"></i>Current Packages
							</div>
						</div>
						<div class="portlet-body">
							<table class="table table-hover">
							<thead>
							<tr>
								<th>#</th>
								<th>Package Name</th>
								<th>Price</th>
								<th>Action</th>								
							</tr>
							</thead>
							<tbody>
								@if($pricings)
									{{-- */$i=1;/* --}}
									@foreach($pricings as $pricing)
										<tr>
											<td>{{ $i }}</td>
											<td>{{ $pricing->package_name }}</td>
											<td>$ {{ $pricing->price }}</td>
											<td>
												<a class="btn default btn-xs green-stripe" href="{{ URL::route('pricing.update', $pricing->id) }}">
													Update 
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