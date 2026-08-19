@extends('layouts.app')

@section('content')

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                Transaction History
            </h2>

            <p class="text-muted mb-0">
                View all wallet transactions.
            </p>
        </div>

        <a href="{{ route('dashboard') }}" class="btn btn-dark">
            <i class="bi bi-arrow-left"></i>
            Dashboard
        </a>

    </div>


    {{-- Wallet Summary --}}
    <div class="row mb-4">

        <div class="col-md-4">

            <div class="card shadow-sm border-0">

                <div class="card-body">

                    <small class="text-muted">
                        Current Wallet Balance
                    </small>

                    <h3 class="fw-bold mt-2 mb-0">
                        ${{ number_format(auth()->user()->wallet?->balance ?? 0, 2) }}
                    </h3>

                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card shadow-sm border-0">

                <div class="card-body">

                    <small class="text-muted">
                        Total Deposited
                    </small>

                    <h3 class="fw-bold mt-2 mb-0">
                        ${{ number_format(auth()->user()->wallet?->total_deposited ?? 0, 2) }}
                    </h3>

                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card shadow-sm border-0">

                <div class="card-body">

                    <small class="text-muted">
                        Total Transactions
                    </small>

                    <h3 class="fw-bold mt-2 mb-0">
                        {{ $transactions->total() }}
                    </h3>

                </div>

            </div>

        </div>

    </div>


    {{-- Transactions --}}
    <div class="card shadow-sm border-0">

        <div class="card-header bg-white py-3">

            <h5 class="fw-bold mb-0">
                Wallet Transaction Ledger
            </h5>

        </div>


        <div class="card-body p-0">

            @if($transactions->count())

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">

                            <tr>

                                <th>Date</th>

                                <th>Type</th>

                                <th>Description</th>

                                <th>Reference</th>

                                <th>Amount</th>

                                <th>Balance After</th>

                                <th>Status</th>

                            </tr>

                        </thead>


                        <tbody>

                            @foreach($transactions as $transaction)

                                <tr>

                                    <td>
                                        {{ $transaction->created_at->format('d M Y') }}

                                        <br>

                                        <small class="text-muted">
                                            {{ $transaction->created_at->format('H:i') }}
                                        </small>
                                    </td>


                                    <td>

                                        @if($transaction->type === 'deposit')

                                            <span class="badge bg-success">
                                                Deposit
                                            </span>

                                        @elseif($transaction->type === 'investment')

                                            <span class="badge bg-danger">
                                                Investment
                                            </span>

                                        @elseif($transaction->type === 'earning')

                                            <span class="badge bg-primary">
                                                Earning
                                            </span>

                                        @else

                                            <span class="badge bg-secondary">
                                                {{ ucfirst($transaction->type) }}
                                            </span>

                                        @endif

                                    </td>


                                    <td>
                                        {{ $transaction->description }}
                                    </td>


                                    <td>
                                        <small class="font-monospace">
                                            {{ $transaction->reference }}
                                        </small>
                                    </td>


                                    <td>

                                        @if(in_array($transaction->type, ['deposit', 'earning', 'credit']))

                                            <span class="text-success fw-bold">
                                                +${{ number_format($transaction->amount, 2) }}
                                            </span>

                                        @else

                                            <span class="text-danger fw-bold">
                                                -${{ number_format($transaction->amount, 2) }}
                                            </span>

                                        @endif

                                    </td>


                                    <td class="fw-semibold">

                                        ${{ number_format($transaction->balance_after, 2) }}

                                    </td>


                                    <td>

                                        @if($transaction->status === 'completed')

                                            <span class="badge bg-success">
                                                Completed
                                            </span>

                                        @elseif($transaction->status === 'pending')

                                            <span class="badge bg-warning text-dark">
                                                Pending
                                            </span>

                                        @elseif($transaction->status === 'failed')

                                            <span class="badge bg-danger">
                                                Failed
                                            </span>

                                        @else

                                            <span class="badge bg-secondary">
                                                {{ ucfirst($transaction->status) }}
                                            </span>

                                        @endif

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>


                {{-- Pagination --}}

                @if($transactions->hasPages())

                    <div class="p-3 border-top">

                        {{ $transactions->links() }}

                    </div>

                @endif


            @else

                <div class="text-center py-5">

                    <i class="bi bi-receipt fs-1 text-muted"></i>

                    <h5 class="mt-3">
                        No transactions yet
                    </h5>

                    <p class="text-muted">
                        Your wallet transactions will appear here.
                    </p>

                    <a
                        href="{{ route('deposits.create') }}"
                        class="btn btn-primary"
                    >
                        Make a Deposit
                    </a>

                </div>

            @endif

        </div>

    </div>

</div>

@endsection