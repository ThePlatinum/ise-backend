@extends('layouts.app')

@section('content')
<div class="d-flex flex-column">
  <div class="header bg-light p-3">
    <h5>Settings</h5>
  </div>

  <div class="page p-3 flex-grow-1">

    @if(session()->has('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}
    </div>
    @endif

  </div>
</div>
@endsection