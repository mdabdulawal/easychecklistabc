<ul class="page-sidebar-menu" data-auto-scroll="true" data-slide-speed="200">
	<!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
	<li class="sidebar-toggler-wrapper">
		<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
		<div class="sidebar-toggler">
		</div>
		<!-- END SIDEBAR TOGGLER BUTTON -->
	</li>
	<!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->
	<li class="sidebar-search-wrapper">
		<!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
		<!-- DOC: Apply "sidebar-search-bordered" class the below search form to have bordered search box -->
		<!-- DOC: Apply "sidebar-search-bordered sidebar-search-solid" class the below search form to have bordered & solid search box -->
		<form class="sidebar-search" action="extra_search.html" method="POST">
			<a href="javascript:;" class="remove">
			<i class="icon-close"></i>
			</a>
			<div class="input-group">
				<input type="text" class="form-control" placeholder="Search...">
				<span class="input-group-btn">
				<a href="javascript:;" class="btn submit"><i class="icon-magnifier"></i></a>
				</span>
			</div>
		</form>
		<!-- END RESPONSIVE QUICK SEARCH FORM -->
	</li>
	@if(Auth::user()->role == '100')
		<li class="start ">
			<a href="javascript:;">
			<i class="icon-home"></i>
			<span class="title">Dashboard</span>
			<span class="arrow "></span>
			</a>
			<ul class="sub-menu">			
				<li>
					<a href="{{ URL::route('profile') }}">
					<i class="icon-user"></i>
					System Dashboard</a>
				</li>
				<li>
					<a href="{{ URL::route('system-admin') }}">
					<i class="fa fa-group"></i>
					System Admin</a>
				</li>
				<li>
					<a href="{{ URL::route('pricing') }}">
					<i class="fa fa-shopping-cart"></i>
					Pricing List</a>
				</li>
				<li>
					<a href="{{ URL::route('paid-users') }}">
					<i class="fa fa-group"></i>
					Paid Users</a>
				</li>
				<li>
					<a href="{{ URL::route('demo-templates') }}">
					<i class="fa fa-file"></i>
					Templates</a>
				</li>								
			</ul>
		</li>
		@else
			<li>
				<a href="{{ URL::route('profile') }}">
				<i class="icon-bar-chart"></i>
				Dashboard</a>
			</li>
	@endif	
	@if(in_array(Auth::user()->role, array('99','77')))
		<li>
			<a href="javascript:;">
				<i class="icon-settings"></i>
				<span class="title">Manage</span>
				<span class="arrow "></span>
			</a>
			<ul class="sub-menu">
				<li>
					<a href="{{ URL::route('basic-info') }}">
					<i class="fa fa-info"></i>
					Information</a>
				</li>
				<li>
					<a href="{{ URL::route('users') }}">
					<i class="fa fa-group"></i>
					Users</a>
				</li>
				<li>
					<a href="{{ URL::route('clients') }}">
					<i class="fa fa-group"></i>
					Clients</a>
				</li>
			</ul>
		</li>
		<li>
			<a href="javascript:;">
				<i class="icon-pencil"></i>
				<span class="title">Checklists</span>
				<span class="arrow "></span>
			</a>
			<ul class="sub-menu">
				<li>
					<a href="{{ URL::route('view-checklist') }}">
					<i class="icon-bar-chart"></i>
					View Checklists</a>
				</li>
				<li>
					<a href="{{ URL::route('create-new-checklist') }}">
					<i class="icon-pencil"></i>
					Create Checklist</a>
				</li>
				<li>
					<a href="{{ URL::route('add-new-task') }}">
					<i class="icon-pencil"></i>
					Create Tasks</a>
				</li>
				<li>
					<a href="{{ URL::route('view-demo-checklist') }}">
					<i class="fa fa-file"></i>
					Templates</a>
				</li>
			</ul>
		</li>
	@endif
</ul>