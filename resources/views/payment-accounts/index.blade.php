@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto px-4 py-8">

    <div class="flex items-center justify-between mb-6">

        <div>
            <h1 class="text-2xl font-bold">
                Payment Accounts
            </h1>

            <p class="text-sm text-gray-500 mt-1">
                Manage the accounts you use to receive withdrawals.
            </p>
        </div>

        <a
            href="{{ route('payment-accounts.create') }}"
            class="inline-flex items-center px-4 py-2 rounded-lg bg-primary-600 text-white font-semibold hover:bg-primary-700"
        >
            Add Payment Account
        </a>

    </div>

    @if (session('success'))
        <div class="mb-6 rounded-lg bg-green-50 border border-green-200 p-4 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if ($accounts->isEmpty())

        <div class="rounded-xl border border-gray-200 bg-white p-8 text-center">

            <h2 class="text-lg font-semibold">
                No payment accounts yet
            </h2>

            <p class="mt-2 text-sm text-gray-500">
                Add a payment account before requesting a withdrawal.
            </p>

            <a
                href="{{ route('payment-accounts.create') }}"
                class="inline-block mt-5 px-5 py-2 rounded-lg bg-primary-600 text-black font-semibold"
            >
                Add Your First Account
            </a>

        </div>

    @else

        <div class="grid gap-5 md:grid-cols-2">

            @foreach ($accounts as $account)

                <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">

                    <div class="flex items-start justify-between">

                        <div>
                            <h2 class="text-lg font-bold">
                                {{ $account->paymentMethod->name }}
                            </h2>

                            @if ($account->is_default)
                                <span class="inline-block mt-2 px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                    Default
                                </span>
                            @endif

                            @if ($account->is_verified)
                                <span class="inline-block mt-2 px-2 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                    Verified
                                </span>
                            @endif
                        </div>

                    </div>

                    <div class="mt-5 space-y-3">

                        @foreach ($account->account_details ?? [] as $key => $value)

                            <div>
                                <div class="text-xs uppercase tracking-wide text-gray-400">
                                    {{ str_replace('_', ' ', $key) }}
                                </div>

                                <div class="font-medium break-all">
                                    {{ $value }}
                                </div>
                            </div>

                        @endforeach

                    </div>

                    <div class="flex flex-wrap gap-2 mt-6">

                        <a
                            href="{{ route('payment-accounts.edit', $account) }}"
                            class="px-4 py-2 rounded-lg border border-gray-300 text-sm font-medium hover:bg-gray-50"
                        >
                            Edit
                        </a>

                        @if (! $account->is_default)

                            <form
                                method="POST"
                                action="{{ route('payment-accounts.default', $account) }}"
                            >
                                @csrf

                                <button
                                    type="submit"
                                    class="px-4 py-2 rounded-lg border border-blue-300 text-blue-600 text-sm font-medium hover:bg-blue-50"
                                >
                                    Make Default
                                </button>
                            </form>

                        @endif

                        <form
                            method="POST"
                            action="{{ route('payment-accounts.destroy', $account) }}"
                            onsubmit="return confirm('Delete this payment account?')"
                        >
                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="px-4 py-2 rounded-lg border border-red-300 text-red-600 text-sm font-medium hover:bg-red-50"
                            >
                                Delete
                            </button>
                        </form>

                    </div>

                </div>

            @endforeach

        </div>

    @endif

</div>

@endsection