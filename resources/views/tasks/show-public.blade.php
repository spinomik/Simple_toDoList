@extends('layouts.layout')

@section('content')
    <div>
        <h1>Task Details</h1>
        <div>
            <h2>Task Name: {{ $task->name }}</h2>
            <p>Description: {{ $task->description }}</p>
            <p>Priority: {{ $task->taskPriority->name }}</p>
            <p>Status: {{ $task->taskStatus->name }}</p>
            <p>Completion Date: {{ $task->completion_date }}</p>
        </div>
    @endsection
