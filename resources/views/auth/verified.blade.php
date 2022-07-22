@extends('layouts.master')

@section('content')
<div class="container">
  <div class="text-center">
    <h1> Awesomeness! </h1>
    <p> You have successfully verified your email address. </p>
    <a href="{{ env('app.front', 'http://localhost:3000') }}" class="btn btn-primary px-5"> Login </a>
  </div>
</div>
@endsection
