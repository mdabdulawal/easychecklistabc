@extends('layouts/default')

@section('content')

	<div class="page-content">
		<!-- BEGIN PAGE HEADER-->
		<div class="row">
			<div class="col-md-12">
				<!-- BEGIN PAGE TITLE & BREADCRUMB-->
				<h3 class="page-title">
				Dashboard <small>user panel</small>
				</h3>
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
							<i class="fa fa-list-ul"></i>Task Overview
						</div>
					</div>
					<div class="portlet-body form">
						<!-- BEGIN FORM-->
						<form role="form" class="form-horizontal">
							<div class="form-body">
								<h2 class="margin-bottom-20"> View Task Info</h2>								
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label col-md-3">Name: </label>
											<div class="col-md-9">
												<p class="form-control-static">
													 {{ $task->title }}
												</p>
											</div>
										</div>
									</div>
									<!--/span-->
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label col-md-3">Start Date: </label>
											<div class="col-md-9">
												<p class="form-control-static">
													 {{ date('j M Y', strtotime($task->start_date)) }}
												</p>
											</div>
										</div>
									</div>
									<!--/span-->
								</div>
								<!--/row-->
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label col-md-3">Description: </label>
											<div class="col-md-9">
												<p class="form-control-static">
													 {{ $task->description }}
												</p>
											</div>
										</div>
									</div>
									<!--/span-->
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label col-md-3">Due Date: </label>
											<div class="col-md-9">
												<p class="form-control-static">
													 {{ date('j M Y', strtotime($task->due_date)) }}
												</p>
											</div>
										</div>
									</div>
									<!--/span-->
								</div>
								<!--/row-->
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label col-md-3">File Location: </label>
											<div class="col-md-9">
												<p class="form-control-static">
													<a href="{{ $task->link_to_folder }}">{{$task->link_to_folder}}</a>
												</p>
											</div>
										</div>
									</div>
									<!--/span-->
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label col-md-3">Created at:</label>
											<div class="col-md-9">
												<p class="form-control-static">
													 {{$task->created_at->format('d M Y')}}
												</p>
											</div>
										</div>
									</div>
									<!--/span-->
								</div>
							</div>
						</form>
						<!-- END FORM-->
					</div>
				</div>
			</div>
		</div>
		<!-- END PAGE CONTENT-->
	</div>

@stop