<li>
	<img src="{{ $user->genavatar() }}" alt="{{ $user->name }}" class="gravatar"/>
	<a href="{{ route('users.show', $user->id )}}" class="username">{{ $user->name }}</a>

	@can('checkIsAdmin',$user)
	<form action="{{ route('users.destroy', $user->id) }}" method="post">
		{{ csrf_field() }}
		{{ method_field('DELETE') }}
		<button type="submit" class="btn btn-sm btn-danger delete-btn">删除</button>
	</form>
	@endcan
</li>
