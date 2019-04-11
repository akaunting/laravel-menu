<li class="dropdown-submenu {{ $item->hasActiveOnChild() ? 'active' : '' }}">
	<a tabindex="-1" href="#">{{ $child->title }}</a>
	<ul class="dropdown-menu">
		@foreach ($child->childs as $item)
			@if ($item->hasChilds())
				@include('menu::child.dropdown', ['child' => $item])
			@else
				@include('menu::child.item', compact('item'))
			@endif
		@endforeach
	</ul>
</li>
