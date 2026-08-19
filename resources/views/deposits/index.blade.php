@extends('layouts.app')

@section('content')

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2 class="fw-bold mb-0">
            Deposit History
        </h2>

        <a
            href="{{ route('deposits.create') }}"
            class="btn btn-primary"
        >
            New Deposit
        </a>

    </div>


    @if (session('success'))

        <div class="alert alert-success">
            {{ session('success') }}
        </div>

    @endif


    <div class="card shadow-sm border-0">

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover mb-0">

                    <thead>
                        <tr>
                            <th>Reference</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($deposits as $deposit)

                            <tr>

                                <td>
                                    {{ $deposit->reference }}
                                </td>

                                <td>
                                    ${{ number_format($deposit->amount, 2) }}
                                </td>

                                <td>
                                    {{ $deposit->payment_method }}
                                </td>

                                <td>

                                    @if ($deposit->status === 'approved')

                                        <span class="badge bg-success">
                                            Approved
                                        </span>

                                    @elseif ($deposit->status === 'rejected')

                                        <span class="badge bg-danger">
                                            Rejected
                                        </span>

                                    @else

                                        <span class="badge bg-warning text-dark">
                                            Pending
                                        </span>

                                    @endif

                                </td>

                                <td>
                                    {{ $deposit->created_at->format('d M Y H:i') }}
                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="5"
                                    class="text-center py-5 text-muted"
                                >
                                    No deposits found.
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>


    <div class="mt-4">
        {{ $deposits->links() }}
    </div>

</div>

@endsection