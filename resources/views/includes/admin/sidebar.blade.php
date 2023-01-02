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

		<li class="nav-item {{ ((request()->is('admin/pages*')) || (request()->is('admin/categories*')) || (request()->is('admin/products*')) || (request()->is('admin/vendor-products*')) || (request()->is('admin/coupons*')) || (request()->is('admin/sliders*')) || (request()->is('admin/faqs*')) || (request()->is('admin/email-templates*')) || (request()->is('admin/coupon-inventories*'))) ? 'active' : '' }}">
			<a class="nav-link" data-bs-toggle="collapse" href="#master" aria-expanded="{{ ((request()->is('admin/pages*')) || (request()->is('admin/categories*')) || (request()->is('admin/products*')) || (request()->is('admin/vendor-products*')) || (request()->is('admin/coupons*')) || (request()->is('admin/sliders*')) || (request()->is('admin/faqs*')) || (request()->is('admin/email-templates*')) || (request()->is('admin/coupon-inventories*'))) ? 'true' : 'false' }}" aria-controls="master">
				<i class="menu-icon mdi mdi-database"></i>
				<span class="menu-title">Master Entries</span>
				<i class="menu-arrow"></i>
			</a>
			<div class="collapse {{ ((request()->is('admin/pages*')) || (request()->is('admin/categories*')) || (request()->is('admin/products*')) || (request()->is('admin/vendor-products*')) || (request()->is('admin/coupons*')) || (request()->is('admin/sliders*')) || (request()->is('admin/faqs*')) || (request()->is('admin/email-templates*')) || (request()->is('admin/coupon-inventories*'))) ? 'show' : '' }}" id="master">
				<ul class="nav flex-column sub-menu">
					<li class="nav-item">
						<a class="nav-link {{ request()->is('admin/pages*') ? 'active' : '' }}" href="{{ route('admin.pages.index') }}"> Pages </a>
					</li>

					<li class="nav-item">
						<a class="nav-link {{ request()->is('admin/categories*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}"> Categories </a>
					</li>

					<li class="nav-item">
						<a class="nav-link {{ request()->is('admin/products*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}"> Products </a>
					</li>

					<li class="nav-item">
						<a class="nav-link {{ request()->is('admin/vendor-products*') ? 'active' : '' }}" href="{{ route('admin.vendor-products.index') }}"> Vendor Products </a>
					</li>
					
					<li class="nav-item">
						<a class="nav-link {{ request()->is('admin/coupons*') ? 'active' : '' }}" href="{{ route('admin.coupons.index') }}"> Coupons </a>
					</li>

					<li class="nav-item">
						<a class="nav-link {{ request()->is('admin/sliders*') ? 'active' : '' }}" href="{{ route('admin.sliders.index') }}"> Slider </a>
					</li>

					<li class="nav-item">
						<a class="nav-link {{ request()->is('admin/faqs*') ? 'active' : '' }}" href="{{ route('admin.faqs.index') }}"> FAQ's </a>
					</li>

					<li class="nav-item">
						<a class="nav-link {{ request()->is('admin/email-templates*') ? 'active' : '' }}" href="{{ route('admin.email-templates.index') }}"> Email Templates </a>
					</li>

					<li class="nav-item">
						<a class="nav-link {{ request()->is('admin/coupon-inventories*') ? 'active' : '' }}" href="{{ route('admin.coupon-inventories.index') }}"> Coupon Inventory </a>
					</li>
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
				<li class="nav-item"> <a class="nav-link" href="{{ route('admin.banks.index') }}"> Bank's List </a></li>
				</ul>
			</div>
		</li>

		<li class="nav-item {{ ((request()->is('admin/site-setting*')) || (request()->is('admin/app-setting*'))) ? 'active' : '' }}">
			<a class="nav-link" data-bs-toggle="collapse" href="#setting" aria-expanded="{{ ((request()->is('admin/site-setting*')) || (request()->is('admin/app-setting*'))) ? 'true' : 'false' }}" aria-controls="setting">
				<i class="mdi mdi-settings menu-icon"></i>
				<span class="menu-title">Settings</span>
				<i class="menu-arrow"></i>
			</a>
			<div class="collapse {{ ((request()->is('admin/site-setting*')) || (request()->is('admin/app-setting*'))) ? 'show' : '' }}" id="setting">
				<ul class="nav flex-column sub-menu">
					<li class="nav-item">
						<a class="nav-link {{ request()->is('admin/site-setting*') ? 'active' : '' }}" href="{{ route('admin.site-setting.index') }}"> Site Setting </a>
					</li>

					<li class="nav-item">
						<a class="nav-link {{ request()->is('admin/app-setting*') ? 'active' : '' }}" href="{{ route('admin.app-setting.index') }}"> App Setting </a>
					</li>
				</ul>
			</div>
		</li>

		<li class="nav-item">
			<a class="nav-link" href="{{ route('admin.orders.index') }}">
				<i class="mdi mdi-settings menu-icon"></i>
				<span class="menu-title">Orders</span>
			</a>
		</li>

		<!-- <li class="nav-item {{ request()->is('admin/pages*') ? 'active' : '' }}">
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

		<li class="nav-item {{ request()->is('admin/products*') ? 'active' : '' }}">
			<a class="nav-link" href="{{ route('admin.products.index') }}">
				<i class="mdi mdi-file menu-icon"></i>
				<span class="menu-title">Products</span>
			</a>
		</li> -->

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