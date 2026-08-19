@extends('layouts.app')

@section('content')

<div class="container">

    <h2 class="mb-4">

        Today's Tasks

    </h2>

    <div class="mb-4">

        <h5>

            Progress

        </h5>

        <div class="progress">

            <div
                class="progress-bar"

                style="width: {{ $totalTasks ? ($completedTasks/$totalTasks)*100 : 0 }}%;">

                {{ $completedTasks }}/{{ $totalTasks }}

            </div>

        </div>

    </div>

    <div class="row">

        @foreach($tasks as $task)

            @include('member.tasks.card')

        @endforeach

    </div>

</div>

@endsection