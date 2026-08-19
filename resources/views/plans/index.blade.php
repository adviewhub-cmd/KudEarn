@extends('layouts.app')

@section('content')

<div class="container py-5">

    <div class="text-center mb-5">
        <h1 class="fw-bold">
            Investment Plans
        </h1>

        <p class="text-muted">
            Choose an investment plan that suits your budget and start earning through daily tasks.
        </p>
    </div>


    <div class="row g-4">

        @forelse($plans as $plan)

            <div class="col-md-6 col-lg-4">

                <div class="card h-100 shadow-sm border-0">

                    <div class="card-body p-4">

                        <div class="text-center">

                            <h3 class="fw-bold mb-3">
                                {{ $plan->name }}
                            </h3>

                            <div class="mb-3">
                                <span class="display-5 fw-bold text-primary">
                                    ${{ number_format($plan->investment_amount, 2) }}
                                </span>
                            </div>

                            <p class="text-muted">
                                {{ $plan->description }}
                            </p>

                        </div>


                        <hr>


                        <div class="mb-3">

                            <div class="d-flex justify-content-between mb-2">
                                <span>Duration</span>
                                <strong>
                                    {{ $plan->duration_days }} days
                                </strong>
                            </div>

                            <div class="d-flex justify-content-between mb-2">
                                <span>Tasks Per Day</span>
                                <strong>
                                    {{ $plan->tasks_per_day }}
                                </strong>
                            </div>

                            <div class="d-flex justify-content-between mb-2">
                                <span>Daily Reward</span>
                                <strong class="text-success">
                                    ${{ number_format($plan->daily_reward, 2) }}
                                </strong>
                            </div>

                            <div class="d-flex justify-content-between mb-2">
                                <span>Reward Per Task</span>
                                <strong class="text-success">
                                    ${{ number_format($plan->reward_per_task, 2) }}
                                </strong>
                            </div>

                            <div class="d-flex justify-content-between">
                                <span>Total Profit</span>
                                <strong class="text-success">
                                    ${{ number_format($plan->total_profit, 2) }}
                                </strong>
                            </div>

                        </div>


                        <div class="d-grid mt-4">

                            <a
                                href="{{ route('investments.create', $plan) }}"
                                class="btn btn-primary btn-lg"
                            >
                                Invest Now
                            </a>

                        </div>

                    </div>

                </div>

            </div>

        @empty

            <div class="col-12">

                <div class="alert alert-warning text-center">
                    No investment plans are currently available.
                </div>

            </div>

        @endforelse

    </div>

</div>
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert"
        ></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert"
        ></button>
    </div>
@endif
@endsection