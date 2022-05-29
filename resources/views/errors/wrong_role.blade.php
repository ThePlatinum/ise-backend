@extends('layouts.master')

@section('content')
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header text-center">Wrong Page</div>

        <div class="card-body d-flex flex-column justify-content-center align-items-center">
          <p>
            Oops! You don't have permission to access this page.
          </p>
          <a href="/" class="btn btn-outline-danger"> Back to Login </a>
        </div>
      </div>
    </div>
  </div>

</div>
@endsection