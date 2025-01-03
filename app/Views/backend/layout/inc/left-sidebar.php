<div class="left-side-bar">
	<div class="brand-logo">
		<a href="<?= route_to('admin.home') ?>">
			<img src="/images/blog/<?= get_settings()->blog_logo ?>" alt="" class="dark-logo" style="max-height: 60px;" />
			<img src="/images/blog/<?= get_settings()->blog_logo ?>" alt="" class="light-logo" style="max-height: 60px;" />
		</a>
		<div class="close-sidebar" data-toggle="left-sidebar-close">
			<i class="ion-close-round"></i>
		</div>
	</div>
	<div class="menu-block customscroll">
		<div class="sidebar-menu">
			<ul id="accordion-menu">
				<li>
					<a href="<?= route_to('admin.home') ?>" class="dropdown-toggle no-arrow <?= 'admin.home' == current_route_name() ? 'active' : '' ?>">
						<span class="micon bi bi-house"></span>
						<span class="mtext">Home</span>
					</a>
				</li>
				<li>
					<a href="<?= route_to('categories') ?>" class="dropdown-toggle no-arrow <?= 'categories' == current_route_name() ? 'active' : '' ?>">
						<span class="micon bi bi-list"></span>
						<span class="mtext">Categories</span>
					</a>
				</li>
				<li class="dropdown">
					<a href="javascript:;" class="dropdown-toggle">
						<span class="micon bi bi-newspaper"></span>
						<span class="mtext"> Posts </span>
					</a>
					<ul class="submenu">
						<li><a href="<?= route_to('all-posts') ?>" class="<?= 'all-posts' == current_route_name() ? 'active' : '' ?>">All Posts</a></li>
						<li><a href="<?= route_to('new-post') ?>" class="<?= 'new-post' == current_route_name() ? 'active' : '' ?>">Make Post</a></li>
					</ul>
				</li>
				<li>
					<div class="dropdown-divider"></div>
				</li>
				<li>
					<div class="sidebar-small-cap">Settings</div>
				</li>
				<li>
					<a href="<?= route_to('admin.profile'); ?>" class="dropdown-toggle no-arrow <?= 'admin.profile' == current_route_name() ? 'active' : '' ?>">
						<span class="micon bi bi-person"></span>
						<span class="mtext">Profile</span>
					</a>
				</li>
				<li>
					<a href="<?= route_to('settings') ?>" class="dropdown-toggle no-arrow <?= 'settings' == current_route_name() ? 'active' : '' ?>">
						<span class="micon bi bi-gear"></span>
						<span class="mtext">Settings</span>
					</a>
				</li>
			</ul>
		</div>
	</div>
</div>