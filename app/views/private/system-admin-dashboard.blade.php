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
						<a href="#">Manage</a>
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
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat blue-madison">
						<div class="visual">
							<i class="fa fa-shopping-cart"></i>
						</div>
						<div class="details">
							<div class="number">
								 {{ $paid_user }}
							</div>
							<div class="desc">
								 Paid User
							</div>
						</div>
						<a href="{{ URL::route('paid-users') }}" class="more">
						View more <i class="m-icon-swapright m-icon-white"></i>
						</a>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat red-intense">
						<div class="visual">
							<i class="fa fa-group"></i>
						</div>
						<div class="details">
							<div class="number">
								 {{ $system_admin }}
							</div>
							<div class="desc">
								 System Admin
							</div>
						</div>
						<a href="{{ URL::route('system-admin') }}" class="more">
						View more <i class="m-icon-swapright m-icon-white"></i>
						</a>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat green-haze">
						<div class="visual">
							<i class="fa fa-group"></i>
						</div>
						<div class="details">
							<div class="number">
								 {{ $company_user }}
							</div>
							<div class="desc">
								 Company User
							</div>
						</div>
						<a href="#" class="more">
						View more <i class="m-icon-swapright m-icon-white"></i>
						</a>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat purple-plum">
						<div class="visual">
							<i class="fa fa-shopping-cart"></i>
						</div>
						<div class="details">
							<div class="number">
								 {{ $pricing }}
							</div>
							<div class="desc">
								 Pricing Package
							</div>
						</div>
						<a href="{{ URL::route('pricing') }}" class="more">
						View more <i class="m-icon-swapright m-icon-white"></i>
						</a>
					</div>
				</div>
			</div>
		<!-- END PAGE CONTENT-->
	</div>

@stop