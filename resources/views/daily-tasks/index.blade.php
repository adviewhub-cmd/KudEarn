@extends('layouts.app')

@section('content')

<div class="container py-4">

    <div class="mb-4">
        <h2>Daily Tasks</h2>
        <p class="text-muted">
            Complete your daily tasks and earn rewards directly to your wallet.
        </p>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if($tasks->isEmpty())

        <div class="alert alert-info text-center">
            You currently have no active investment tasks.
        </div>

    @else

        @php
            $groupedTasks = $tasks->groupBy('user_investment_id');
        @endphp

        @foreach($investments as $investment)

            @php
                $investmentTasks = $groupedTasks->get(
                    $investment->id,
                    collect()
                );

                $completedCount = $investmentTasks
                    ->filter(fn($task) => $task->completion !== null)
                    ->count();

                $totalTasks = $investmentTasks->count();

                $plan = $investment->investmentPlan;
            @endphp

            @if($investmentTasks->isNotEmpty())

                <div class="card mb-4 shadow-sm">

                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">

                            <div>
                                <h4 class="mb-1">
                                    {{ $plan->name ?? $investment->plan_name }}
                                </h4>

                                <small class="text-muted">
                                    Investment:
                                    ${{ number_format($investment->amount, 2) }}
                                </small>
                            </div>

                            <div>
                                <strong>
                                    {{ $completedCount }}/{{ $totalTasks }}
                                    Completed
                                </strong>
                            </div>

                        </div>
                    </div>

                    <div class="card-body">

                        @foreach($investmentTasks as $task)

                            <div class="border rounded p-3 mb-3">

                                <div class="row align-items-center">

                                    <div class="col-md-8">

                                        <h5 class="mb-1">
                                            Task {{ $task->task_number }}:
                                            {{ $task->title }}
                                        </h5>

                                        @if($task->description)
                                            <p class="text-muted mb-2">
                                                {{ $task->description }}
                                            </p>
                                        @endif

                                        <strong>
                                            Reward:
                                            ${{ number_format($task->reward, 4) }}
                                        </strong>

                                    </div>

                                    <div class="col-md-4 text-md-end mt-3 mt-md-0">

                                        @if($task->completion)

                                            <button
                                                type="button"
                                                class="btn btn-success"
                                                disabled
                                            >
                                                ✓ Completed
                                            </button>

                                            @if($task->completion->completed_at)
                                                <div class="small text-muted mt-1">
                                                    Completed
                                                    {{ $task->completion->completed_at->format('H:i') }}
                                                </div>
                                            @endif

                                        @else

                                            <form
                                                method="POST"
                                                action="{{ route('daily-tasks.complete', $task) }}"
                                            >

                                                @csrf

                                                <button
                                                    type="submit"
                                                    class="btn btn-primary"
                                                >
                                                    Complete Task
                                                </button>

                                            </form>

                                        @endif

                                    </div>

                                </div>

                            </div>

                        @endforeach

                    </div>

                </div>

            @endif

        @endforeach

    @endif

</div>

@endsection