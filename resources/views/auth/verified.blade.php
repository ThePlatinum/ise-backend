@extends('layouts.master')

@section('content')
<div class="container">
  <div class="text-center">
    <h1> Awesomeness! </h1>
    <p> You have successfully verified your email address. </p>
    <a href="{{ env('APP_FRONT', 'localhost:3000') }}" class="btn btn-primary"> Login </a>
  </div>
</div>
@endsection
