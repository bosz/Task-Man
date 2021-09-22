@extends('layouts.app')

@section('content')
    <div class="p-3 alert alert-secondary text-center"><h2 class="m-0">My projects</h2></div>
    {{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newTaskModal">
        New Project
    </button> --}}

    <div class="row m-0">
    @foreach ($projects as $project)
        <div class="col-4 p-2">
          <div class="card">
            <div class="card card-header">
              {{ $project->name }}
            </div>
            <div class="card-body">
              <p>{{ $project->tasks()->count() }} tasks</p>
              @if($project->tasks()->count())
              <a href="{{ route('task.index', ['project_id' => $project->id]) }}"> See tasks</a>
              @endif
            </div>
          </div>
        </div>
    @endforeach
    </div>

    {{-- Add task modal --}}
    <div class="modal fade" id="newTaskModal" tabindex="-1" aria-labelledby="newTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
              <form action="{{ route('task.store') }}" method="post">
                @csrf
                    <div class="modal-header">
                    <h5 class="modal-title" id="newTaskModalLabel">Add a task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    ...
                    </div>
                    <div class="modal-footer">
                    {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> --}}
                    <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
          </div>
        </div>
      </div>
    {{-- Add task modal --}}



    {{-- Edit task modal --}}
    {{-- Edit task modal --}}
@endsection