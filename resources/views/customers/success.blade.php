@extends('customers.layouts.app')

@section('content')
<div class="container">
    <h1>Success</h1>
    <h3><a href="{{ URL::to('/home') }}">Go to Home Page</a></h3>
</div>
@endsection
