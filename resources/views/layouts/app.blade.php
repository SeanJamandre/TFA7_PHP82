<!DOCTYPE html>
<html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>TFA7 Laravel POS</title><link rel="stylesheet" href="{{ asset('css/app.css') }}"></head>
<body><header><strong>TFA7 Laravel POS</strong><nav><a href="{{ route('customers.index') }}">Customers</a><a href="{{ route('users.index') }}">User Accounts</a></nav></header>
<main>@if(session('success'))<div class="notice" role="status">{{ session('success') }}</div>@endif
@if($errors->any())<div class="errors" role="alert"><strong>Please correct the following:</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
@yield('content')</main><footer>IT0049 · Forms, Validation and File Upload</footer></body></html>
