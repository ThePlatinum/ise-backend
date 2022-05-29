@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="row header bg-light p-3">
    <h5>Dashboard</h5>
  </div>

  <div class="py-3">
    <div class="row">
      <div class="col-md-4">
        <div class="card card-body">
          <h5 class="card-title">Users</h5>
          <div class="card-text dc">
            <div class="p-1 count col-md-6">
              {{ $counts['users'] }}
            </div>
            <div class="p-3 col-md-6 dl">
              <div class="d-flex justify-content-between">
                <div class="s-count">{{ $counts['users_identified'] }}</div>
                <a href="" class="btn btn-sm btn-primary">
                  Verified
                </a>
              </div>
              <div class="d-flex justify-content-between">
              <div class="s-count">{{ $counts['users_not_identified'] }}</div>
                <a href="" class="btn btn-sm btn-primary">
                  Unverified
                </a>
              </div>
              <a href="" class="btn btn-sm btn-primary">
                All
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card card-body">
          <h5 class="card-title">Tasks</h5>
          <div class="card-text dc">
            <div class="p-1 count col-md-6">
              {{ $counts['tasks'] }}
            </div>
            <div class="p-3 col-md-6 dl">
              <div class="d-flex justify-content-between">
                <div class="s-count">{{ $counts['tasks_approved'] }}</div>
                <a href="" class="btn btn-sm btn-primary">
                  Approved
                </a>
              </div>
              <div class="d-flex justify-content-between">
              <div class="s-count">{{ $counts['tasks_pending'] }}</div>
                <a href="" class="btn btn-sm btn-primary">
                  Pending
                </a>
              </div>
              <a href="" class="btn btn-sm btn-primary">
                All
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card card-body">
          <h5 class="card-title">Projects</h5>
          <div class="card-text dc">
            <div class="p-1 count col-md-6">
              {{ $counts['projects'] }}
            </div>
            <div class="p-3 col-md-6 dl">
              <div class="d-flex justify-content-between">
                <div class="s-count">{{ $counts['tasks_approved'] }}</div>
                <a href="" class="btn btn-sm btn-primary">
                  Approved
                </a>
              </div>
              <div class="d-flex justify-content-between">
              <div class="s-count">{{ $counts['tasks_pending'] }}</div>
                <a href="" class="btn btn-sm btn-primary">
                  Pending
                </a>
              </div>
              <a href="" class="btn btn-sm btn-primary">
                All
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection