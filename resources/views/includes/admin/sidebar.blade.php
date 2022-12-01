<nav class="sidebar sidebar-offcanvas" id="sidebar">
	<ul class="nav">
		<li class="nav-item">
			<a class="nav-link" href="/">
				<i class="mdi mdi-grid-large menu-icon"></i>
				<span class="menu-title">Dashboard</span>
			</a>
		</li>

		<li class="nav-item">
			<a class="nav-link" data-bs-toggle="collapse" href="#user" aria-expanded="false" aria-controls="user">
				<i class="menu-icon mdi mdi-account-circle-outline"></i>
				<span class="menu-title">Users Management</span>
				<i class="menu-arrow"></i>
			</a>
			<div class="collapse" id="user">
				<ul class="nav flex-column sub-menu">
				<li class="nav-item"> <a class="nav-link" href="#"> Users </a></li>
				</ul>
			</div>
		</li>

		<li class="nav-item">
			<a class="dropdown-item" href="{{ route('logout') }}"
				onclick="event.preventDefault();
								document.getElementById('logout-form').submit();">
				{{ __('Logout') }}
			</a>

			<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
				@csrf
			</form>
		</li>
	</ul>
</nav>