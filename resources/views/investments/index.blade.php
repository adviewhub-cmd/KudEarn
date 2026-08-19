@extends('layouts.app')

@section('content')

<div class="container py-5">

    <div class="text-center mb-5">
        <h1 class="fw-bold">Investment Plans</h1>
        <p class="text-muted">
            Choose the investment plan that suits your goals.
        </p>
    </div>

    <div class="row">

        @forelse($plans as $plan)

        <div class="col-lg-3 col-md-6 mb-4">

            <div class="card shadow-sm h-100">

                <div class="card-body">

                    <h4 class="fw-bold">
                        {{ $plan->name }}
                    </h4>

                    <h2 class="text-primary">
                        ${{ number_format($plan->investment_amount,2) }}
                    </h2>

                    <hr>

                    <p>
                        <strong>Duration:</strong>
                        {{ $plan->duration_days }} Days
                    </p>

                    <p>
                        <strong>Tasks/Day:</strong>
                        {{ $plan->tasks_per_day }}
                    </p>

                    <p>
                        <strong>Daily Reward:</strong>
                        ${{ number_format($plan->daily_reward,2) }}
                    </p>

                    <p>
                        <strong>Reward/Task:</strong>
                        ${{ number_format($plan->reward_per_task,4) }}
                    </p>

                    <p>
                        <strong>Total Reward:</strong>
                        ${{ number_format($plan->total_profit,2) }}
                    </p>

                    <p class="text-muted">
                        {{ $plan->description }}
                    </p>

                </div>

                <div class="card-footer bg-white">

                    @auth

                        <a href="{{ route('investments.create', $plan) }}"
                            class="btn btn-primary w-100">
                                Invest Now
                        </a>

                    @else

                        <a href="{{ route('login') }}" class="btn btn-primary w-100">
                            Login to Invest
                        </a>

                    @endauth

                </div>

            </div>

        </div>

        @empty

            <div class="col-12">
                <div class="alert alert-warning">
                    No investment plans are available.
                </div>
            </div>

        @endforelse

    </div>

</div>

@endsection