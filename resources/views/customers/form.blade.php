@extends('layouts.app')
@section('content')
<h1>{{ $customer->exists ? 'Edit Customer' : 'Create Customer' }}</h1>
<form method="POST" action="{{ $customer->exists ? route('customers.update', $customer) : route('customers.store') }}" enctype="multipart/form-data">
@csrf
@if($customer->exists) @method('PUT') @endif
<label for="full_name">Full name</label><input id="full_name" name="full_name" type="text" maxlength="255" value="{{ old('full_name', $customer->full_name) }}" required>
@error('full_name')<p class="field-error">{{ $message }}</p>@enderror
<label for="email">Email</label><input id="email" name="email" type="email" maxlength="255" value="{{ old('email', $customer->email) }}" required>
@error('email')<p class="field-error">{{ $message }}</p>@enderror
<div class="actions"><button type="submit">Save Customer</button><a href="{{ route('customers.index') }}">Cancel</a></div></form>
@endsection
