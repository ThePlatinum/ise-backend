@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="row header bg-light p-3">
    <h5>Tasks</h5>
  </div>

    <div class="">
      <div class="float-right">
        <a href="" class="btn btn-seconday">Back</a>
      </div>
    </div>

  <div class="p-3">

    <div class="card card-body table-responsive">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Id</th>
            <th>User</th>
            <th>Title</th>
            <th>Description</th>
            <th>Price</th>
            <th>Status</th>
            <th>Created At</th>
            <th> </th>
          </tr>
        </thead>
        <tbody>
          @foreach($all as $task)
          <tr>
            <td>{{$task->id}}</td>
            <td>{{$task['user']->username ?? $task['user']->fullname}}</td>
            <td>{{$task->name}}</td>
            <td>{{$task->description}}</td>
            <td> {{$task->currency}}{{$task->price}}</td>
            <td>{{$task->status}}</td>
            <td>
              {{ date_format($task->created_at, 'D d, M-Y') }} <br>
              Date_Interval
            </td>
            <td>
              <a href="{{route('tasks.view', $task->id)}}" class="btn btn-primary">
                <i class="bx bx-show"></i>
              </a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <div class="d-flex justify-content-center">
      <nav class="text-center p-3" aria-label="Paginations">
        <ul class="pagination">
          {{ $all->links() }}
        </ul>
      </nav>
    </div>

  </div>
</div>
@endsection