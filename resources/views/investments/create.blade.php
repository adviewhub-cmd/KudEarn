@extends('layouts.app')

@section('content')

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-md-8">

            {{-- Page heading --}}
            <div class="mb-4">
                <h2 class="fw-bold">
                    Confirm Investment
                </h2>

                <p class="text-muted">
                    Review the investment details before activation.
                </p>
            </div>


            {{-- Plan Card --}}
            <div class="card shadow-sm border-0">

                <div class="card-body p-4">

                    <h3 class="fw-bold mb-3">
                        {{ $plan->name }}
                    </h3>

                    <p class="text-muted">
                        {{ $plan->description }}
                    </p>


                    {{-- Plan Information --}}
                    <div class="row g-3 mt-3">

                        <div class="col-md-6">

                            <div class="bg-light rounded p-3">

                                <small class="text-muted">
                                    Investment Amount
                                </small>

                                <h4 class="fw-bold mb-0">
                                    ${{ number_format($plan->investment_amount, 2) }}
                                </h4>

                            </div>

                        </div>


                        <div class="col-md-6">

                            <div class="bg-light rounded p-3">

                                <small class="text-muted">
                                    Duration
                                </small>

                                <h4 class="fw-bold mb-0">
                                    {{ $plan->duration_days }} days
                                </h4>

                            </div>

                        </div>


                        <div class="col-md-6">

                            <div class="bg-light rounded p-3">

                                <small class="text-muted">
                                    Daily Reward
                                </small>

                                <h4 class="fw-bold mb-0">
                                    ${{ number_format($plan->daily_reward, 2) }}
                                </h4>

                            </div>

                        </div>


                        <div class="col-md-6">

                            <div class="bg-light rounded p-3">

                                <small class="text-muted">
                                    Available Wallet Balance
                                </small>

                                <h4 class="fw-bold mb-0">
                                    ${{ number_format($balance, 2) }}
                                </h4>

                            </div>

                        </div>

                    </div>


                    {{-- Insufficient Balance --}}
                    @if($balance < $plan->investment_amount)

                        <div class="alert alert-danger mt-4">

                            <strong>Insufficient wallet balance.</strong>

                            <p class="mb-2 mt-2">
                                You need
                                <strong>
                                    ${{ number_format(
                                        $plan->investment_amount - $balance,
                                        2
                                    ) }}
                                </strong>
                                more to activate this investment.
                            </p>

                            <a
                                href="{{ route('deposits.create') }}"
                                class="btn btn-primary"
                            >
                                Deposit Funds
                            </a>

                        </div>

                    @else

                        {{-- Confirmation --}}
                        <div class="alert alert-success mt-4">

                            Your wallet has sufficient funds to activate this
                            investment.

                        </div>


                        <form
                            method="POST"
                            action="{{ route('investments.store', $plan) }}"
                        >

                            @csrf

                            <div class="form-check mb-4">

                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="confirmation"
                                    value="1"
                                    id="confirmation"
                                    required
                                >

                                <label
                                    class="form-check-label"
                                    for="confirmation"
                                >
                                    I confirm that I want to invest
                                    <strong>
                                        ${{ number_format(
                                            $plan->investment_amount,
                                            2
                                        ) }}
                                    </strong>
                                    from my wallet.
                                </label>

                            </div>


                            <button
                                type="submit"
                                class="btn btn-success btn-lg"
                            >
                                <i class="bi bi-check-circle"></i>
                                Confirm & Activate Investment
                            </button>

                        </form>

                    @endif

                </div>

            </div>

        </div>

    </div>

</div>

@endsection