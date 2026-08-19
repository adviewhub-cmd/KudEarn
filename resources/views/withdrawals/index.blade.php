@extends('layouts.app')

@section('content')

<div class="container py-4">

    <div class="card shadow-sm">

        <div class="card-header d-flex justify-content-between align-items-center">

            <h4 class="mb-0">
                Withdrawal History
            </h4>

            <a
                href="{{ route('withdrawals.create') }}"
                class="btn btn-primary"
            >
                New Withdrawal
            </a>

        </div>

        <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if($withdrawals->count())

                <div class="table-responsive">

                    <table class="table table-bordered table-hover">

                        <thead>

                            <tr>
                                <th>Reference</th>
                                <th>Amount</th>
                                <th>Fee</th>
                                <th>Net Amount</th>
                                <th>Method</th>
                                <th>Status</th>
                                <th>Requested</th>
                            </tr>

                        </thead>

                        <tbody>

                            @foreach($withdrawals as $withdrawal)

                                <tr>

                                    <td>
                                        <strong>
                                          <a
                                            href="{{ route(
                                                'withdrawals.show',
                                                $withdrawal->id
                                            ) }}"
                                            class="fw-bold text-decoration-none"
                                        >
                                            {{ $withdrawal->reference }}
                                        </a>
                                        </strong>
                                    </td>

                                    <td>
                                        ${{ number_format(
                                            (float) $withdrawal->amount,
                                            2
                                        ) }}
                                    </td>

                                    <td>
                                        ${{ number_format(
                                            (float) $withdrawal->fee,
                                            2
                                        ) }}
                                    </td>

                                    <td>
                                        ${{ number_format(
                                            (float) $withdrawal->net_amount,
                                            2
                                        ) }}
                                    </td>

                                    <td>
                                        {{ $withdrawal->method }}
                                    </td>

                                    <td>

                                        @php
                                            $statusClass = match (
                                                $withdrawal->status
                                            ) {
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

                                        <span
                                            class="badge {{ $statusClass }}"
                                        >
                                            {{ ucfirst(
                                                $withdrawal->status
                                            ) }}
                                        </span>

                                    </td>

                                    <td>
                                        {{ optional(
                                            $withdrawal->requested_at
                                        )->format(
                                            'M d, Y H:i'
                                        ) }}
                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

                <div class="mt-3">

                    {{ $withdrawals->links() }}

                </div>

            @else

                <div class="text-center py-5">

                    <h5>
                        No withdrawals yet
                    </h5>

                    <p class="text-muted">
                        Your withdrawal history will appear here.
                    </p>

                    <a
                        href="{{ route('withdrawals.create') }}"
                        class="btn btn-primary"
                    >
             @extends('layouts.app')

@section('content')

<div class="container py-4">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="mb-1">
                Withdrawal History
            </h2>

            <p class="text-muted mb-0">
                View and track all your withdrawal requests.
            </p>
        </div>

        <a
            href="{{ route('withdrawals.create') }}"
            class="btn btn-primary"
        >
            Withdraw Funds
        </a>

    </div>


    {{-- Success Message --}}
    @if(session('success'))

        <div class="alert alert-success">
            {{ session('success') }}
        </div>

    @endif

    @if ($errors->any())
    <div class="alert alert-danger">

        <strong>
            Withdrawal request could not be submitted.
            You already have a pending withdrawal request. Please wait until it has been processed before submitting another withdrawal.
        </strong>

        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>

    </div>
    @endif

    {{-- Error Message --}}
    @if(session('error'))

        <div class="alert alert-danger">
            {{ session('error') }}
        </div>

    @endif


    {{-- Statistics --}}
    <div class="row g-3 mb-4">

        <div class="col-md-4 col-lg-2">
            <div class="card h-100">
                <div class="card-body">
                    <small class="text-muted">
                        Pending
                    </small>

                    <h4 class="mb-0 mt-1">
                        {{ $pendingCount }}
                    </h4>
                </div>
            </div>
        </div>


        <div class="col-md-4 col-lg-2">
            <div class="card h-100">
                <div class="card-body">
                    <small class="text-muted">
                        Approved
                    </small>

                    <h4 class="mb-0 mt-1">
                        {{ $approvedCount }}
                    </h4>
                </div>
            </div>
        </div>


        <div class="col-md-4 col-lg-2">
            <div class="card h-100">
                <div class="card-body">
                    <small class="text-muted">
                        Rejected
                    </small>

                    <h4 class="mb-0 mt-1">
                        {{ $rejectedCount }}
                    </h4>
                </div>
            </div>
        </div>


        <div class="col-md-6 col-lg-2">
            <div class="card h-100">
                <div class="card-body">
                    <small class="text-muted">
                        Requested
                    </small>

                    <h4 class="mb-0 mt-1">
                        ${{ number_format($totalRequested, 2) }}
                    </h4>
                </div>
            </div>
        </div>


        <div class="col-md-6 col-lg-2">
            <div class="card h-100">
                <div class="card-body">
                    <small class="text-muted">
                        Approved
                    </small>

                    <h4 class="mb-0 mt-1">
                        ${{ number_format($totalApproved, 2) }}
                    </h4>
                </div>
            </div>
        </div>


        <div class="col-md-6 col-lg-2">
            <div class="card h-100">
                <div class="card-body">
                    <small class="text-muted">
                        Rejected
                    </small>

                    <h4 class="mb-0 mt-1">
                        ${{ number_format($totalRejected, 2) }}
                    </h4>
                </div>
            </div>
        </div>

    </div>


    {{-- Withdrawal History --}}
    <div class="card">

        <div class="card-header">
            <strong>
                Withdrawal Requests
            </strong>
        </div>


        <div class="card-body p-0">

            @if($withdrawals->count())

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead>

                            <tr>

                                <th>
                                    Reference
                                </th>

                                <th>
                                    Amount
                                </th>

                                <th>
                                    Fee
                                </th>

                                <th>
                                    Net Amount
                                </th>

                                <th>
                                    Method
                                </th>

                                <th>
                                    Status
                                </th>

                                <th>
                                    Requested
                                </th>

                                <th>
                                    Processed
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                        @foreach($withdrawals as $withdrawal)

                            <tr>

                                {{-- Reference --}}
                                <td>

                                    <strong>
                                     <a
                                    href="{{ route(
                                        'withdrawals.show',
                                        $withdrawal->id
                                    ) }}"
                                    class="fw-bold text-decoration-none"
                                >
                                    {{ $withdrawal->reference }}
                                </a>
                                    </strong>

                                </td>


                                {{-- Amount --}}
                                <td>
                                    ${{ number_format(
                                        (float) $withdrawal->amount,
                                        2
                                    ) }}
                                </td>


                                {{-- Fee --}}
                                <td>

                                    ${{ number_format(
                                        (float) $withdrawal->fee,
                                        2
                                    ) }}

                                </td>


                                {{-- Net --}}
                                <td>

                                    <strong>
                                        ${{ number_format(
                                            (float) $withdrawal->net_amount,
                                            2
                                        ) }}
                                    </strong>

                                </td>


                                {{-- Method --}}
                                <td>
                                    {{ $withdrawal->method }}
                                </td>


                                {{-- Status --}}
                                <td>

                                    @if($withdrawal->status === 'pending')

                                        <span class="badge bg-warning text-dark">
                                            Pending
                                        </span>

                                    @elseif($withdrawal->status === 'approved')

                                        <span class="badge bg-success">
                                            Approved
                                        </span>

                                    @elseif($withdrawal->status === 'rejected')

                                        <span class="badge bg-danger">
                                            Rejected
                                        </span>

                                    @else

                                        <span class="badge bg-secondary">
                                            {{ ucfirst($withdrawal->status) }}
                                        </span>

                                    @endif

                                </td>


                                {{-- Requested --}}
                                <td>

                                    @if($withdrawal->requested_at)

                                        {{ $withdrawal->requested_at->format(
                                            'M d, Y H:i'
                                        ) }}

                                    @else

                                        {{ $withdrawal->created_at?->format(
                                            'M d, Y H:i'
                                        ) }}

                                    @endif

                                </td>


                                {{-- Processed --}}
                                <td>

                                    @if($withdrawal->processed_at)

                                        {{ $withdrawal->processed_at->format(
                                            'M d, Y H:i'
                                        ) }}

                                    @else

                                        <span class="text-muted">
                                            —
                                        </span>

                                    @endif

                                </td>

                            </tr>


                            {{-- Rejection Information --}}
                            @if(
                                $withdrawal->status === 'rejected'
                                && $withdrawal->admin_note
                            )

                                <tr>

                                    <td colspan="8">

                                        <div class="alert alert-danger mb-0">

                                            <strong>
                                                Withdrawal rejected:
                                            </strong>

                                            {{ $withdrawal->admin_note }}

                                            <br>

                                            <small>
                                                The full requested amount was
                                                refunded to your withdrawable
                                                balance.
                                            </small>

                                        </div>

                                    </td>

                                </tr>

                            @endif


                            {{-- Approved Information --}}
                            @if(
                                $withdrawal->status === 'approved'
                            )

                                <tr>

                                    <td colspan="8">

                                        <div class="alert alert-success mb-0">

                                            <strong>
                                                Withdrawal approved.
                                            </strong>

                                            Net payout:

                                            <strong>
                                                ${{ number_format(
                                                    (float) $withdrawal->net_amount,
                                                    2
                                                ) }}
                                            </strong>

                                            @if($withdrawal->approved_at)

                                                on
                                                {{ $withdrawal->approved_at->format(
                                                    'M d, Y H:i'
                                                ) }}

                                            @endif

                                        </div>

                                    </td>

                                </tr>

                            @endif


                            {{-- Pending Information --}}
                            @if(
                                $withdrawal->status === 'pending'
                            )

                                <tr>

                                    <td colspan="8">

                                        <div class="alert alert-warning mb-0">

                                            <strong>
                                                Withdrawal pending.
                                            </strong>

                                            Your request is awaiting
                                            administrator processing.

                                        </div>

                                    </td>

                                </tr>

                            @endif

                        @endforeach

                        </tbody>

                    </table>

                </div>


                {{-- Pagination --}}
                <div class="p-3">

                    {{ $withdrawals->links() }}

                </div>

            @else

                <div class="text-center py-5">

                    <h5>
                        No withdrawals yet
                    </h5>

                    <p class="text-muted">
                        Your withdrawal requests will appear here.
                    </p>

                    <a
                        href="{{ route('withdrawals.create') }}"
                        class="btn btn-primary"
                    >
                        Make Your First Withdrawal
                    </a>

                </div>

            @endif

        </div>

    </div>

</div>

@endsection           Make a Withdrawal
                    </a>

                </div>

            @endif

        </div>

    </div>

</div>

@endsection