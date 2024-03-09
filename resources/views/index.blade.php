@extends('layouts.app')

@section('title', 'The lest of tasks')

@section('content')

<nav class="mb-4">
   <a href="{{ route('tasks.create')}}" class="link">Add Task!</a>
</nav>

@foreach($tasks as $task)
<div>
    <a href="{{route('tasks.show',['task'=>$task->id]) }}"
    @class(['line-through' => $task->completed])>{{ $task->title }}</a>
</div>

@if ($tasks->count()==0)
<div>There are no Tasks</div>
@endif

@endforeach

@if ($tasks->count())
  <nav class="mt-4">
     {{ $tasks->links() }}
  </nav>
@endif

@endsection