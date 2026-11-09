@extends('layouts.app')
@section('content')
<h1>{{ $user->exists ? 'Edit User' : 'Create User' }}</h1>
<form method="POST" action="{{ $user->exists ? route('users.update', $user) : route('users.store') }}" enctype="multipart/form-data">
@csrf
@if($user->exists) @method('PUT') @endif
<label for="username">Username</label><input id="username" name="username" type="text" maxlength="255" value="{{ old('username', $user->username) }}" required>
@error('username')<p class="field-error">{{ $message }}</p>@enderror
<label for="full_name">Full name</label><input id="full_name" name="full_name" type="text" maxlength="255" value="{{ old('full_name', $user->full_name) }}" required>
@error('full_name')<p class="field-error">{{ $message }}</p>@enderror
<label for="avatar">Avatar (optional)</label>
<img class="avatar preview" src="{{ $user->avatar ? Storage::disk('public')->url($user->avatar) : asset('images/avatar-placeholder.svg') }}" alt="Current avatar">
<input id="avatar" name="avatar" type="file" accept="image/jpeg,image/png">
<p class="hint">JPG or PNG, up to 2 MB and 4096 × 4096 pixels. Saved as a 256 × 256 thumbnail. Leave blank to keep your current avatar. After an error, select the file again.</p>
@error('avatar')<p class="field-error">{{ $message }}</p>@enderror
<div class="actions"><button type="submit">Save User</button><a href="{{ route('users.index') }}">Cancel</a></div></form>
@endsection
