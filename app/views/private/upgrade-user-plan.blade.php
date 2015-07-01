@extends('layouts/default')

@section('content')

	<div class="page-content">
			<!-- BEGIN PAGE HEADER-->
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN PAGE TITLE & BREADCRUMB-->
					<h3 class="page-title">
					Plan <small>upgrade user plan</small>
					</h3>
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="#">Home</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="#">Plan</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="#">Upgrade</a>
						</li>
					</ul>
					<!-- END PAGE TITLE & BREADCRUMB-->
				</div>
			</div>
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
			<div class="row profile">
				<div class="col-md-12">
					@if(Session::has('message'))
			            <div class="alert alert-{{ Session::get('alertType') }}">
			                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
			                <p>{{ Session::get('message') }}</p>
			            </div>
			        @endif
					<div class="portlet box blue">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-gift"></i>Form :: {{ $title }}
							</div>
						</div>
						<div class="portlet-body form">
							<!-- BEGIN FORM-->							
							{{ Form::model($user, array('route' => array('user.upgrade', $user->id))) }}	
								<div class="form-body">								
									<div class="form-group">										
										{{ Form::label('pricing_id', 'Upgrade '.$user->email.' To', array('class' => 'col-md-3 control-label')) }}
										<div class="col-md-6">											
											{{ Form::select('pricing_id', array('' => '-- Select Plan --')+$pricings, null, array('class' => 'form-control select2me', 'required' => 'required')) }}
										</div>
									</div>									
								</div>
								<div class="form-actions fluid">
									<div class="col-md-offset-3 col-md-9">
										<button class="btn btn-circle blue" type="submit">Upgrade</button>
										<button class="btn btn-circle default" type="reset">Reset</button>
									</div>
								</div>	
							{{ Form::close() }}
							<!-- END FORM-->
						</div>
					</div>
				</div>
			</div>
			<!-- END PAGE CONTENT-->
		</div>

@stop