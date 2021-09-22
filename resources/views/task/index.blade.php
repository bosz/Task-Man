@extends('layouts.app')

@section('extra_css')
    <style>
        ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }
    </style>
@endsection

@section('content')
    <div class="alert alert-secondary text-center"><h2 class="m-0">My tasks</h2></div>
    <div class="row">
        <div class="col-9">
            <form action="{{ route('task.index') }}" onchange=" $(this).submit() ">
                <select name="project_id" class="form-control">
                    <option value> -- Select / all projects -- </option>
                    @foreach ($projects as $project)
                        <option {{ Request::get('project_id') == $project->id ? 'selected' : '' }} value="{{ $project->id }}">{{ $project->name }}</option>
                    @endforeach
                </select>
            </form>
        </div>
        <div class="col-3">
            <button type="button" class="btn btn-primary btn-block" data-toggle="modal" id="btnToOpenStoreUpdateForm">
                New task
            </button>
        </div>
    </div>
    

    <div class="table-responsive mt-3 mb-3">
        <ul id="sortable">
        @forelse ($tasks as $task)
            <li class="ui-state-default mb-2 task-card" data-task-id="{{ $task->id }}">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div>
                            <span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
                            {{ $task->id }} {{ $task->name }} 
                            
                        </div>
                        <div>
                            {{ $task->schedule_date }}
                        </div>
                        <div>
                            <form action="{{ route('task.drop', ['id' => $task->id]) }}" method="post">

                                <a 
                                    href="#"
                                    data-id="{{ $task->id }}"
                                    data-name="{{ $task->name }}"
                                    data-priority="{{ $task->priority }}"
                                    data-schedule_date="{{ $task->schedule_date }}"
                                    data-project_id="{{ $task->project_id }}"
                                    class="edit-task text text-info"
                                >
                                    Edit
                                </a> | 
    
                                @csrf
                                <input type="hidden" name="_method" value="DELETE">
                                <button onclick="$(this).submit()" type="submit" class="text text-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                
                    <div class="card-body">
                        
                        <p><b>Priority:</b> {{ ucfirst($task->priority) }}</p>
                        <p><b>Executed on:</b> {{ $task->executed_date ?? 'Pending' }}</p>
                        <p><b>Project:</b> {{ $task->project->name }}</p>
                    </div>
                </div>
            </li>
        @empty
        <div><p class="m-4 text text-danger text-center">No task scheduled yet</p></div>
        @endforelse

        <div class="paginator text text-center">
            {{ $tasks->links() }}
        </div>
        </ul> 
    </div>



    {{-- Add task modal --}}
    <div class="modal fade" id="newTaskModal" tabindex="-1" aria-labelledby="newTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
              <form action="{{ route('task.store') }}" method="post" id="storeUpdateTaskForm" 
                data-update-action="{{ route('task.update') }}"
                data-store-action="{{ route('task.store') }}"
                >
                <input type="hidden" name="task_id" id="taskID">
                @csrf
                    <div class="modal-header">
                    <h5 class="modal-title" id="newTaskModalLabel">Add a task</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                    </div>
                    <div class="modal-body">
                        
                        <div class="mb-3">
                            <label for="nameID" class="form-label">Name</label>
                            <input required type="text" class="form-control" id="nameID" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="priorityID" class="form-label">Priority</label>
                            <select required class="form-control" id="priorityID" name="priority">
                                <option value>- Select priority - </option>
                                @foreach (['normal', 'urgent', 'high'] as $priority)
                                    <option value="{{ $priority }}">{{ ucfirst($priority) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="scheduleDateDateID" class="form-label">Schedule Date</label>
                            <input required type="date" class="form-control" id="scheduleDateDateID" name="schedule_date_date">
                        </div>
                        <div class="mb-3">
                            <label for="scheduleDateTimeID" class="form-label">Schedule Date</label>
                            <input required type="time" class="form-control" id="scheduleDateTimeID" name="schedule_date_time">
                        </div>
                        <div class="mb-3">
                            <label for="projectIDID" class="form-label">Schedule for</label>
                            <select required class="form-control" id="projectIDID" name="project_id">
                                <option value> - Select project - </option>
                                @foreach ($projects as $project)
                                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                    <div class="modal-footer">
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

@section('extra_js')

<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });

    $(function() {
        $( "#sortable" ).sortable({
            update: function( event, ui ) {
                let ids = [];
                $('.task-card').each(function(i, obj) {
                    let id = $(this).data('task-id');
                    if (id) { ids.unshift(id); }
                });

                $.ajax({
                    url: '{{ route('task.reorder') }}' , 
                    data: {ids}, 
                    type: 'POST', 
                    beforeSend: function() {
                        // Before submit
                    },
                    success: function(result){
                        console.log('Reorder returned', result)
                    }, 
                    error: function(data){
                        // handle error
                    }
                })

                // Make ajax request
            }
        });
        $( "#sortable" ).disableSelection();
    });

    $('#btnToOpenStoreUpdateForm').click(function(e){
        let form = $('#storeUpdateTaskForm');
            form.attr('action', form.data('store-action'))
            $('#taskID').val('')
            $('#nameID').val('')
            $('#priorityID').val('')
            $('#scheduleDateDateID').val('')
            $('#scheduleDateTimeID').val('')
            $('#projectIDID').val('')
            $('#newTaskModal').modal();
    })

    $('.edit-task').click(function(e) {
        e.preventDefault();
        let _this = $(this);
        let form = $('#storeUpdateTaskForm');
        form.attr('action', form.data('update-action'))


        // Collect data
        let id = _this.data('id');
        let name = _this.data('name');
        let priority = _this.data('priority');
        let schedule_date = _this.data('schedule_date');
        let project_id = _this.data('project_id');


        let sch_time = moment(schedule_date).format('H:mm:ss');
        let sch_date = moment(schedule_date).format('YYYY-MM-DD');
        console.log(sch_date, sch_time);

        $('#taskID').val(id)
        $('#nameID').val(name)
        $('#priorityID').val(priority)
        $('#scheduleDateDateID').val(sch_date)
        $('#scheduleDateTimeID').val(sch_time)
        $('#projectIDID').val(project_id)

        // Fill up the form fields

        $('#newTaskModal').modal();
    })
</script>
@endsection