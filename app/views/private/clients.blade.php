@extends('layouts/default')

@section('content')

	<div class="page-content">
		<!-- BEGIN PAGE HEADER-->
		<div class="row">
			<div class="col-md-12">
				<!-- BEGIN PAGE TITLE & BREADCRUMB-->
				<h3 class="page-title">
				Client <small>manage clients</small>
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
					Total of {{ $total_clients }} clients </span>
					<a href="{{ URL::route('add-new-client') }}" class="btn icn-only green">
					Add New Client <i class="m-icon-swapright m-icon-white"></i>
					</a>

					<a style="text-decoration:none; color: #FFF;"  class="btn icn-only green" href="#portlet-config" data-toggle="modal">
									<i class="fa fa-copy"></i> Import Clients
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
							Latest Clients </a>
						</li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="tab_1_11">
							<div class="portlet-body">
								<table class="table table-striped table-bordered table-advance table-hover">
								<thead>
								<tr>
									<th>
										<i class="fa fa-briefcase"></i> Company Name
									</th>
									<th class="hidden-xs">
										<i class="fa fa-user"></i> Contact Name
									</th>
									<th>
										<i class="fa fa-phone"></i> Phone
									</th>
									<th>
										Actions
									</th>
								</tr>
								</thead>
								<tbody>
								@if($clients)
									@foreach($clients as $client)
										<tr>
											<td>
												<a href="#">{{ $client->company_name }}</a>
											</td>
											<td class="hidden-xs">
												 {{ $client->contact_name }}
											</td>
											<td>
												<span class="label label-success label-sm">
													{{ $client->phone }}
												</span>
											</td>
											<td>
												<a class="btn default btn-xs green-stripe" href="{{ URL::route('client.overview', $client->id) }}">
												View </a>&nbsp;&nbsp;
												<a class="btn default btn-xs red-stripe" href="{{ URL::route('client.delete', $client->id) }}">
												Delete </a>
											</td>																	
										</tr>
									@endforeach
								@endif
								</tbody>
								</table>
								<div class="pagination">
									{{ $clients->links() }}
								</div>
							</div>
						</div>
						<!--tab-pane-->
					</div>
				</div>
			</div>	
		</div>
		<!-- END PAGE CONTENT-->
	</div>

<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
					<div class="modal fade" id="portlet-config" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
									<h4 class="modal-title">Import Clients</h4>
								</div>
								<div class="modal-body">
									 <p style="color: #FC0000;">
									 	<strong>companyname, contactname, email, phone, mobile, address -</strong> fields are manadatory in your csv file. <br>
									 </p>
									 <!-- BEGIN FORM-->
									{{ Form::open(array('route' => 'import-client', 'class' => 'form-horizontal', 'files' => 'true')) }}
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

@stop