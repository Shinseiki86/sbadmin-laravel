 <li class="dd-item dd3-item" data-id="{{$item['MENU_ID']}}">
	@include('auth.menu.item', [ 'item' => $item ])
	@if ($item['submenu'] != [])
		<ol class="dd-list">
			@foreach ($item['submenu'] as $submenu)
				@if ($submenu['submenu'] == [])
					<li class="dd-item dd3-item" data-id="{{$submenu['MENU_ID']}}">
						@include('auth.menu.item', [ 'item' => $submenu ])
					</li>
				@else
					@include('auth.menu.menu-list', [ 'item' => $submenu ])
				@endif
			@endforeach
		</ol>
	@endif
</li>
