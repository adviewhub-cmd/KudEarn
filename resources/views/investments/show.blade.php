@extends('layouts.app')

@section('content')

<div class="container py-5">

    @if(session('success'))

        <div class="alert alert-success">
            {{ session('success') }}
        </div>

    @endif

    <div class="row">

        <div class="col-lg-8">

            <div class="card shadow-sm mb-4">

                <div class="card-body">

                    <h3 class="fw-bold">
                        {{ $investment->plan_name }}
                    </h3>

                    <p class="text-muted">
                        Investment #{{ $investment->id }}
                    </p>

                    <hr>

                    <div class="row">

                        <div class="col-md-6 mb-4">
                            <small class="text-muted">
                                Investment Amount
                            </small>

                            <h5>
                                ${{ number_format($investment->amount, 2) }}
                            </h5>
                        </div>

                        <div class="col-md-6 mb-4">
                            <small class="text-muted">
                                Daily Reward
                            </small>

                            <h5>
                                ${{ number_format(
                                    $investment->daily_reward,
                                    2
                                ) }}
                            </h5>
                        </div>

                        <div class="col-md-6 mb-4">
                            <small class="text-muted">
                                Tasks Per Day
                            </small>

                            <h5>
                                {{ $investment->tasks_per_day }}
                            </h5>
                        </div>

                        <div class="col-md-6 mb-4">
                            <small class="text-muted">
                                Reward Per Task
                            </small>

                            <h5>
                                ${{ number_format(
                                    $investment->reward_per_task,
                                    4
                                ) }}
                            </h5>
                        </div>

                        <div class="col-md-6 mb-4">
                            <small class="text-muted">
                                Duration
                            </small>

                            <h5>
                                {{ $investment->duration_days }} days
                            </h5>
                        </div>

                        <div class="col-md-6 mb-4">
                            <small class="text-muted">
                                Status
                            </small>

                            <h5>
                                {{ ucfirst($investment->status) }}
                            </h5>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection