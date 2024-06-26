	<div class="pre-loader"></div>
	<div class="header clearfix">
		<div class="header-right">
			<div class="brand-logo">
				<a href="{{ url('/') }}">
					Shipping System
				</a>
			</div>
			<div class="menu-icon">
				<span></span>
				<span></span>
				<span></span>
				<span></span>
			</div>
			
			<div class="user-info-dropdown">
				<div class="dropdown">
					<a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
						<span class="user-icon"><i class="fa fa-user-o"></i></span>
						<span class="user-name"> {{ Auth::user()->name }}</span>
					</a>
					<div class="dropdown-menu dropdown-menu-right">
						<a class="dropdown-item" href="/setting"><i class="fa fa-cog" aria-hidden="true"></i> Setting</a>
						<a class="dropdown-item" href="{{ route('logout') }}"  onclick="event.preventDefault();
						document.getElementById('logout-form').submit();">
							<i class="fa fa-sign-out" aria-hidden="true"></i> Log Out
						</a>

						<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none" >
							@csrf
						</form>
					</div>
				</div>
			</div>
			
		</div>
	</div>