@extends('layouts.app')

@section('content')

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-7">

            <div class="card shadow-sm">

                <div class="card-body p-4">

                    <h2 class="fw-bold mb-4">
                        Confirm Investment
                    </h2>

                    <div class="mb-4">

                        <h4>{{ $plan->name }}</h4>

                        <p class="text-muted">
                            {{ $plan->description }}
                        </p>

                    </div>

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <strong>Investment</strong>
                            <div>
                                ${{ number_format($plan->investment_amount, 2) }}
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <strong>Duration</strong>
                            <div>
                                {{ $plan->duration_days }} days
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <strong>Tasks Per Day</strong>
                            <div>
                                {{ $plan->tasks_per_day }}
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <strong>Daily Reward</strong>
                            <div>
                                ${{ number_format($plan->daily_reward, 2) }}
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <strong>Reward Per Task</strong>
                            <div>
                                ${{ number_format($plan->reward_per_task, 4) }}
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <strong>Configured Total Reward</strong>
                            <div>
                                ${{ number_format($plan->total_profit, 2) }}
                            </div>
                        </div>

                    </div>

                    <hr>

                    <form method="POST"
                          action="{{ route('investments.store', $plan) }}">

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
                                for="confirmation">

                                I have reviewed the investment terms
                                and understand that the displayed rewards
                                are based on the configured plan terms.

                            </label>

                        </div>

                        @error('confirmation')
                            <div class="text-danger mb-3">
                                {{ $message }}
                            </div>
                        @enderror

                        <div class="d-flex gap-2">

                            <a href="{{ route('plans') }}"
                               class="btn btn-secondary">
                                Cancel
                            </a>

                            <button
                                type="submit"
                                class="btn btn-primary flex-grow-1">

                                Confirm Investment

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection