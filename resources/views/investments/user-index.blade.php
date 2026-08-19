@extends('layouts.app')

@section('content')

<div class="container py-5">

    <h1 class="fw-bold mb-4">
        My Investments
    </h1>

    @forelse($investments as $investment)

        <div class="card mb-3 shadow-sm">
            <div class="card-body">

                <h4 class="fw-bold">
                    {{ $investment->plan_name }}
                </h4>

                <p class="mb-1">
                    Investment:
                    <strong>
                        ${{ number_format($investment->amount, 2) }}
                    </strong>
                </p>

                <p class="mb-1">
                    Duration:
                    <strong>
                        {{ $investment->duration_days }} days
                    </strong>
                </p>

                <p class="mb-1">
                    Daily Reward:
                    <strong>
                        ${{ number_format($investment->daily_reward, 2) }}
                    </strong>
                </p>

                <p class="mb-0">
                    Status:
                    <strong>
                        {{ ucfirst($investment->status) }}
                    </strong>
                </p>

            </div>
        </div>

    @empty

        <div class="alert alert-info">
            You don't have any investments yet.
        </div>

        <a href="{{ route('plans') }}" class="btn btn-primary">
            View Investment Plans
        </a>

    @endforelse

</div>

@endsection