@extends('layouts.app')

@section('content')

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="mb-1">
                Withdrawal Details
            </h2>

            <p class="text-muted mb-0">
                View the complete details of your withdrawal request.
            </p>
        </div>

        <a
            href="{{ route('withdrawals.index') }}"
            class="btn btn-outline-secondary"
        >
            Back to History
        </a>

    </div>

    @php

        $statusClass = match ($withdrawal->status) {
            'pending' =>
                'bg-warning text-dark',

            'approved' =>
                'bg-success',

            'rejected' =>
                'bg-danger',

            default =>
                'bg-secondary',
        };

    @endphp

    <div class="row g-4">

        {{-- Main Details --}}
        <div class="col-lg-8">

            <div class="card shadow-sm">

                <div class="card-header d-flex justify-content-between align-items-center">

                    <strong>
                        Withdrawal Request
                    </strong>

                    <span class="badge {{ $statusClass }}">
                        {{ ucfirst($withdrawal->status) }}
                    </span>

                </div>

                <div class="card-body">

                    <div class="row g-3">

                        <div class="col-md-6">
                            <small class="text-muted">
                                Reference
                            </small>

                            <div class="fw-bold">
                                {{ $withdrawal->reference }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <small class="text-muted">
                                Withdrawal Method
                            </small>

                            <div class="fw-bold">
                                {{ $withdrawal->method }}
                            </div>
                        </div>

                        <div class="col-md-4">
                            <small class="text-muted">
                                Requested Amount
                            </small>

                            <div class="fs-5 fw-bold">
                                ${{ number_format(
                                    (float) $withdrawal->amount,
                                    2
                                ) }}
                            </div>
                        </div>

                        <div class="col-md-4">
                            <small class="text-muted">
                                Withdrawal Fee
                            </small>

                            <div class="fs-5">
                                ${{ number_format(
                                    (float) $withdrawal->fee,
                                    2
                                ) }}
                            </div>
                        </div>

                        <div class="col-md-4">
                            <small class="text-muted">
                                Net Payout
                            </small>

                            <div class="fs-5 fw-bold text-success">
                                ${{ number_format(
                                    (float) $withdrawal->net_amount,
                                    2
                                ) }}
                            </div>
                        </div>

                    </div>

                    <hr>

                    <h6 class="mb-3">
                        Payment Details
                    </h6>

                    <div class="bg-light rounded p-3">
                        <pre class="mb-0"
                             style="white-space: pre-wrap; word-break: break-word;">{{ $withdrawal->account_details }}</pre>
                    </div>
                {{-- Transaction Information --}}
<div class="card shadow-sm mt-4">

    <div class="card-header">
        <strong>
            Transaction Information
        </strong>
    </div>

    <div class="card-body">

        @if($withdrawalTransaction)

            <div class="row g-3">

                <div class="col-md-6">

                    <small class="text-muted">
                        Transaction Reference
                    </small>

                    <div class="fw-bold">
                        {{ $withdrawalTransaction->reference }}
                    </div>

                </div>

                <div class="col-md-3">

                    <small class="text-muted">
                        Amount
                    </small>

                    <div class="fw-bold">
                        ${{ number_format(
                            abs((float) $withdrawalTransaction->amount),
                            2
                        ) }}
                    </div>

                </div>

                <div class="col-md-3">

                    <small class="text-muted">
                        Status
                    </small>

                    <div>
                        <span class="badge bg-success">
                            {{ ucfirst(
                                $withdrawalTransaction->status
                            ) }}
                        </span>
                    </div>

                </div>

            </div>

        @else

            <div class="text-muted">
                Withdrawal transaction has not been recorded yet.
            </div>

        @endif

    </div>

</div>

            </div>

        </div>

        {{-- Timeline --}}
        <div class="col-lg-4">

            <div class="card shadow-sm">

                <div class="card-header">
                    <strong>
                        Withdrawal Timeline
                    </strong>
                </div>

                <div class="card-body">

                    <div class="mb-3">

                        <small class="text-muted">
                            Requested
                        </small>

                        <div>
                            {{ $withdrawal->requested_at?->format(
                                'M d, Y H:i'
                            ) ?? $withdrawal->created_at?->format(
                                'M d, Y H:i'
                            ) }}
                        </div>

                    </div>

                    @if($withdrawal->approved_at)

                        <div class="mb-3">

                            <small class="text-muted">
                                Approved
                            </small>

                            <div class="text-success fw-bold">
                                {{ $withdrawal->approved_at->format(
                                    'M d, Y H:i'
                                ) }}
                            </div>

                        </div>

                    @endif

                    @if($withdrawal->rejected_at)

                        <div class="mb-3">

                            <small class="text-muted">
                                Rejected
                            </small>

                            <div class="text-danger fw-bold">
                                {{ $withdrawal->rejected_at->format(
                                    'M d, Y H:i'
                                ) }}
                            </div>

                        </div>

                    @endif

                    @if($withdrawal->processed_at)

                        <div class="mb-3">

                            <small class="text-muted">
                                Processed
                            </small>

                            <div class="fw-bold">
                                {{ $withdrawal->processed_at->format(
                                    'M d, Y H:i'
                                ) }}
                            </div>

                        </div>

                    @endif

                    @if($withdrawal->status === 'pending')

                        <div class="alert alert-warning mb-0">

                            <strong>
                                Pending
                            </strong>

                            <br>

                            Your withdrawal is awaiting
                            administrator processing.

                        </div>

                    @elseif($withdrawal->status === 'approved')

                        <div class="alert alert-success mb-0">

                            <strong>
                                Withdrawal Approved
                            </strong>

                            <br>

                            Net payout:

                            <strong>
                                ${{ number_format(
                                    (float) $withdrawal->net_amount,
                                    2
                                ) }}
                            </strong>

                        </div>

                    @elseif($withdrawal->status === 'rejected')

                        <div class="alert alert-danger mb-0">

                            <strong>
                                Withdrawal Rejected
                            </strong>

                            @if($withdrawal->admin_note)

                                <hr>

                                <div>
                                    {{ $withdrawal->admin_note }}
                                </div>

                            @endif

                            <hr>

                            <small>
                                The full requested amount was refunded
                                to your withdrawable balance.
                            </small>

                        </div>

                    @endif

                </div>
                
            </div>

        </div>

    </div>

</div>
                @if($refundTransaction)

    <div class="card shadow-sm mt-4">

        <div class="card-header">
            <strong>
                Refund Information
            </strong>
        </div>

        <div class="card-body">

            <div class="alert alert-success">

                <strong>
                    Refund Completed
                </strong>

                <br>

                ${{ number_format(
                    (float) $refundTransaction->amount,
                    2
                ) }}

                was refunded to your
                withdrawable balance.

            </div>

            <div class="row g-3">

                <div class="col-md-6">

                    <small class="text-muted">
                        Refund Reference
                    </small>

                    <div class="fw-bold">
                        {{ $refundTransaction->reference }}
                    </div>

                </div>

                <div class="col-md-3">

                    <small class="text-muted">
                        Amount
                    </small>

                    <div class="fw-bold text-success">
                        +${{ number_format(
                            (float) $refundTransaction->amount,
                            2
                        ) }}
                    </div>

                </div>

                <div class="col-md-3">

                    <small class="text-muted">
                        Status
                    </small>

                    <div>
                        <span class="badge bg-success">
                            {{ ucfirst(
                                $refundTransaction->status
                            ) }}
                        </span>
                    </div>

                </div>

            </div>

        </div>

    </div>

@endif

@if(
    $withdrawal->status === 'rejected'
    && $withdrawal->admin_note
)

    <div class="card shadow-sm mt-4">

        <div class="card-header">
            <strong>
                Administrator Note
            </strong>
        </div>

        <div class="card-body">

            <div class="alert alert-danger mb-0">

                {{ $withdrawal->admin_note }}

            </div>

        </div>

    </div>

@endif
@endsection