@extends('template/dashboardCEO')
@section('title', 'Task')

@section('section')

<div class="col-md-12">
  <div class="card">
    <h5 class="card-header">Register Task Information</h5>
    <div class="card-body">

        <form action="{{ route('ceo.update.task.process', $task->idTask) }}" method="POST">
            @csrf 
            @method('PUT') 

            <div class="mb-4">
                <label class="form-label"><strong>Case Title:</strong></label>
                <input type="text" class="form-control" value="{{ $case->case_title }}" readonly>
            </div>

            <input type="hidden" name="cases_id" value="{{ $case->idCases }}">
            <input type="hidden" name="lawyer_id" value="{{ $case->lawyer_id }}"> 
            <input type="hidden" name="client_id" value="{{ $case->client_id }}"> 

            <div class="mb-4">
                <label class="form-label">Task Title:</label>
                <input type="text" class="form-control" name="title" value="{{ $task->title }}" required>
            </div> 

            <div class="mb-4">
                <label class="form-label">Description:</label>
                <input type="text" class="form-control" name="description" value="{{ $task->description }}" required>
            </div>

            <div class="mb-4">
                <label class="form-label">Due Date:</label>
                <input type="date" class="form-control" name="duedate" value="{{ $task->duedate }}" required>
            </div>  

            <div class="mb-4">
                <label class="form-label">Completed At:</label>
                <input type="date" class="form-control" name="completed_at" value="{{ $task->completed_at }}">
            </div> 

            <div class="text-end">
                <button type="submit" class="btn btn-primary">Submit Task</button>
            </div>
        </form>



    </div>
  </div>
</div>

@endsection