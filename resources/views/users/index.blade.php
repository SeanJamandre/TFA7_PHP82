@extends('layouts.app')
@section('content')
<div class="heading"><h1>User Accounts</h1><a class="button" href="{{ route('users.create') }}">Create User</a></div><div class="table-wrap"><table><thead><tr><th>Avatar</th><th>Username</th><th>Full name</th><th>Action</th></tr></thead><tbody>
@forelse($users as $user)<tr><td><img class="avatar" src="{{ $user->avatar ? Storage::disk('public')->url($user->avatar) : asset('images/avatar-placeholder.svg') }}" alt="Avatar for {{ $user->full_name }}"></td><td>{{ $user->username }}</td><td>{{ $user->full_name }}</td><td><a href="{{ route('users.edit', $user) }}">Edit</a></td></tr>
@empty<tr><td colspan="4">No records yet.</td></tr>@endforelse
</tbody></table></div>
@endsection
