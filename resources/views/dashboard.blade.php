@extends('layouts.member')

@section('content')

<div class="container py-5">

    <div class="row g-4">

        {{-- Wallet --}}
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">

                    <p class="text-muted mb-1">
                        Wallet Balance
                    </p>

                    <h2 class="fw-bold">
                        ${{ number_format(auth()->user()->wallet?->balance ?? 0, 2) }}
                    </h2>

                    <a
                        href="{{ route('deposits.create') }}"
                        class="btn btn-primary mt-3"
                    >
                        Deposit Funds
                    </a>
                    
                    <a
                        href="{{ route('transactions.index') }}"
                        class="inline-block mt-4 bg-gray-800 text-white px-4 py-2 rounded-lg"
                    >
                        Transaction History
                    </a>
                </div>
            </div>
        </div>


        {{-- Investments --}}
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">

                    <p class="text-muted mb-1">
                        Active Investments
                    </p>

                    <h2 class="fw-bold">
                        {{ auth()->user()->investments()->where('status', 'active')->count() }}
                    </h2>

                    <a
                        href="{{ url('/plans') }}"
                        class="btn btn-success mt-3"
                    >
                        Invest Now
                    </a>

                </div>
            </div>
        </div>


        {{-- Deposits --}}
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">

                    <p class="text-muted mb-1">
                        Total Deposits
                    </p>

                    <h2 class="fw-bold">
                        ${{ number_format(
                            auth()->user()->deposits()
                                ->where('status', 'approved')
                                ->sum('amount'),
                            2
                        ) }}
                    </h2>

                    <a
                        href="{{ route('deposits.index') }}"
                        class="btn btn-dark mt-3"
                    >
                        Deposit History
                    </a>

                </div>
            </div>
        </div>

    </div>
{{-- Transaction History --}}
<div class="bg-white shadow-sm sm:rounded-lg mt-6">

    <div class="p-6 border-b">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-900">
                    Recent Transactions
                </h3>

                <p class="text-sm text-gray-500 mt-1">
                    Your latest wallet activity
                </p>
            </div>

            <a
                href="{{ route('transactions.index') }}"
                class="text-sm text-indigo-600 hover:text-indigo-800"
            >
                View All
            </a>
        </div>
    </div>

    @php
        $transactions = auth()->user()
            ->transactions()
            ->latest()
            ->limit(10)
            ->get();
    @endphp

    @if($transactions->count())

        <div class="overflow-x-auto">

            <table class="min-w-full divide-y divide-gray-200">

                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                            Date
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                            Type
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                            Description
                        </th>

                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">
                            Amount
                        </th>

                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">
                            Balance
                        </th>
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200">

                    @foreach($transactions as $transaction)

                        <tr>

                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $transaction->created_at->format('d M Y H:i') }}
                            </td>

                            <td class="px-6 py-4 text-sm">
                                {{ ucfirst(str_replace('_', ' ', $transaction->type)) }}
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $transaction->description ?? '-' }}
                            </td>

                            <td class="px-6 py-4 text-sm text-right font-semibold">
                                {{ $transaction->amount >= 0 ? '+' : '' }}${{ number_format($transaction->amount, 2) }}
                            </td>

                            <td class="px-6 py-4 text-sm text-right">
                                ${{ number_format($transaction->balance_after, 2) }}
                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    @else

        <div class="p-6 text-center text-gray-500">
            No wallet transactions yet.
        </div>

    @endif

</div>

    {{-- Welcome --}}
    <div class="card shadow-sm border-0 mt-4">
        <div class="card-body p-4">

            <h3 class="fw-bold">
                Welcome to KUD.EARN
            </h3>

            <p class="text-muted mb-0">
                Hello {{ auth()->user()->name }}.
                Manage your wallet, investments and daily earning
                activities from your dashboard.
            </p>

        </div>
    </div>

</div>

@endsection