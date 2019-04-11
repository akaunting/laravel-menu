@foreach ($items as $item)
	@if ($item->hasChilds())
		@include('menu::item.dropdown', compact('item'))
	@else
		@include('menu::item.item', compact('item'))
	@endif
@endforeach
