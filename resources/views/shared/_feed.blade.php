@if (count($feed_item))
	<ol class="statuses">
		@foreach ($feed_item as $status)
			@include('statuses._status', ['user' => $status->user])
		@endforeach
		{!! $feed_item->render() !!}
	</ol>
@endif
