<nav role="navigation" style="margin-bottom: 0; margin-top: -1px;">
	<div class="navbar-default sidebar" role="navigation">

		<div class="sidebar-nav navbar-collapse" id="sidebar-area">
			<ul class="nav" id="sidebar">

				@rinclude('menu-left-search')

				@if(isset($menusLeft))
                @foreach ($menusLeft as $key => $item)
					{{-- @if(Entrust::can(['usuarios-*', 'roles-*', 'permisos-*'])) --}}
	                    @if ($item['MENU_PARENT'] != 0)
	                        @break
	                    @endif
	                    @include('layouts.menu.menu-left-list', ['item' => $item])
	                {{-- @endif --}}
                @endforeach
				@endif
			</ul>
		</div>
		<!-- /.sidebar-collapse -->
	</div>
</nav>
<!-- /.navbar-static-side -->

@if(isset($menuColors))
@push('head')
	<style type="text/css">
		#sidebar-area .nav>li>a:hover, #sidebar-area .nav>li>a:focus, #sidebar-area .nav>li:hover, #sidebar-area .nav>li:focus, #sidebar-area .nav>li.active {
			background-color: {{$menuColors['colorBackgroundActive']}};
		}
		.sidebar ul li {
			border-bottom: 1px solid {{$menuColors['colorBorder']}};
			background-color: {{$menuColors['colorBackground']}};
		}
		.sidebar ul li i.fa {
			color: {{$menuColors['colorIcon']}};
		}
		#sidebar-area .nav>li>a:hover>i.fa, #sidebar-area .nav>li>a:focus>i.fa, #sidebar-area .nav>li:hover>i.fa, #sidebar-area .nav>li:focus>i.fa, #sidebar-area .nav>li.active>i.fa {
			color: {{$menuColors['colorIconActive']}};
		}
	</style>
@endpush
@endif
