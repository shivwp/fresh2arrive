<nav class="sidebar sidebar-offcanvas" id="sidebar">
	<ul class="nav">
		<li class="nav-item">
			<a class="nav-link" href="{{ route('admin.dashboard') }}">
				<i class="mdi mdi-grid-large menu-icon"></i>
				<span class="menu-title">Dashboard</span>
			</a>
		</li>

		<li class="nav-item {{ request()->is('admin/users*') ? 'active' : '' }}">
			<a class="nav-link" data-bs-toggle="collapse" href="#user" aria-expanded="{{ request()->is('admin/users*') ? 'true' : 'false' }}" aria-controls="user">
				<i class="menu-icon mdi mdi-account-circle-outline"></i>
				<span class="menu-title">Users Management</span>
				<i class="menu-arrow"></i>
			</a>
			<div class="collapse {{ request()->is('admin/users*') ? 'show' : '' }}" id="user">
				<ul class="nav flex-column sub-menu">
				<li class="nav-item"> <a class="nav-link {{ request()->is('admin/users*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}"> Users </a></li>
				</ul>
			</div>
		</li>

		<li class="nav-item">
			<a class="nav-link" data-bs-toggle="collapse" href="#bank" aria-expanded="false" aria-controls="bank">
				<i class="mdi mdi-bank menu-icon"></i>
				<span class="menu-title">Banks</span>
				<i class="menu-arrow"></i>
			</a>
			<div class="collapse" id="bank">
				<ul class="nav flex-column sub-menu">
				<li class="nav-item"> <a class="nav-link" href="/banks"> Bank's List </a></li>
				</ul>
			</div>
		</li>

		<li class="nav-item">
			<a class="nav-link" href="{{ route('admin.setting.index') }}">
				<i class="mdi mdi-settings menu-icon"></i>
				<span class="menu-title">Setting</span>
			</a>
		</li>

		<li class="nav-item {{ request()->is('admin/pages*') ? 'active' : '' }}">
			<a class="nav-link" href="{{ route('admin.pages.index') }}">
				<i class="mdi mdi-file menu-icon"></i>
				<span class="menu-title">Pages</span>
			</a>
		</li>

		<li class="nav-item {{ request()->is('admin/categories*') ? 'active' : '' }}">
			<a class="nav-link" href="{{ route('admin.categories.index') }}">
				<i class="mdi mdi-file menu-icon"></i>
				<span class="menu-title">Categories</span>
			</a>
		</li>

		<li class="nav-item">
			<a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
				<i class="mdi mdi-power menu-icon"></i>
				<span class="menu-title">Logout</span>
			</a>
			<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
				@csrf
			</form>
		</li>

	</ul>
</nav>