@props([
    'investment'
])

<div class="card-modern p-4 h-100">

    <h5>

        {{ $investment->plan_name }}

    </h5>

    <hr>

    <div class="mb-2">

        Investment

    </div>

    <strong>

        ${{ number_format($investment->amount,2) }}

    </strong>

    <hr>

    <div>

        Daily Reward

    </div>

    <strong class="text-success">

        ${{ number_format($investment->daily_reward,2) }}

    </strong>

    <hr>

    <span class="badge bg-success">

        {{ ucfirst($investment->status) }}

    </span>

</div>