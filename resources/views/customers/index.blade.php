@extends('layouts.app')
@section('content')
<div class="heading"><h1>Customers</h1><a class="button" href="{{ route('customers.create') }}">Create Customer</a></div><div class="table-wrap"><table><thead><tr><th>Full name</th><th>Email</th><th>Action</th></tr></thead><tbody>
@forelse($customers as $customer)<tr><td>{{ $customer->full_name }}</td><td>{{ $customer->email }}</td><td><a href="{{ route('customers.edit', $customer) }}">Edit</a></td></tr>
@empty<tr><td colspan="3">No records yet.</td></tr>@endforelse
</tbody></table></div>
@endsection
