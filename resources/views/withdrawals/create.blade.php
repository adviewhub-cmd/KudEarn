@extends('layouts.app')

@section('content')

<div class="container py-4">

    <div class="row justify-content-center">

        <div class="col-lg-8">

            <div class="card shadow-sm">

                {{-- ==========================================================
                     HEADER
                =========================================================== --}}

                <div class="card-header">

                    <h4 class="mb-0">
                        Withdraw Funds
                    </h4>

                </div>


                <div class="card-body">

                    {{-- ======================================================
                         SUCCESS MESSAGE
                    ======================================================= --}}

                    @if(session('success'))

                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>

                    @endif


                    {{-- ======================================================
                         VALIDATION ERRORS
                    ======================================================= --}}

                    @if($errors->any())

                        <div class="alert alert-danger">

                            <ul class="mb-0">

                                @foreach($errors->all() as $error)

                                    <li>
                                        {{ $error }}
                                    </li>

                                @endforeach

                            </ul>

                        </div>

                    @endif


                    {{-- ======================================================
                         WALLET
                    ======================================================= --}}

                    <div class="alert alert-info">

                        <strong>
                            Withdrawable Balance:
                        </strong>

                        ${{ number_format(
                            (float) ($wallet?->withdrawable_balance ?? 0),
                            2
                        ) }}

                    </div>


                    {{-- ======================================================
                         WITHDRAWAL STATUS
                    ======================================================= --}}

                    @if(!$settings->withdrawal_enabled)

                        <div class="alert alert-warning">

                            Withdrawals are currently disabled.

                        </div>

                    @elseif(!$withdrawalsAvailable)

                        <div class="alert alert-warning">

                            Withdrawals are not available today.

                            @if($nextWithdrawalDate)

                                <br>

                                <strong>
                                    Next withdrawal:
                                </strong>

                                {{ $nextWithdrawalDate->format(
                                    'l, F j, Y'
                                ) }}

                            @endif

                        </div>

                    @elseif($paymentAccounts->isEmpty())

                        {{-- ==================================================
                             NO PAYMENT ACCOUNT
                        =================================================== --}}

                        <div class="alert alert-warning">

                            <strong>
                                No withdrawal payment account found.
                            </strong>

                            <div class="mt-2">

                                You must add a payment account before
                                requesting a withdrawal.

                            </div>

                            <div class="mt-3">

                                <a
                                    href="{{ route('payment-accounts.create') }}"
                                    class="btn btn-primary"
                                >
                                    Add Payment Account
                                </a>

                            </div>

                        </div>

                    @else

                        {{-- ==================================================
                             WITHDRAWAL FORM
                        =================================================== --}}

                        <form
                            method="POST"
                            action="{{ route('withdrawals.store') }}"
                        >

                            @csrf


                            {{-- ==================================================
                                 WITHDRAWAL AMOUNT
                            =================================================== --}}

                            <div class="mb-3">

                                <label
                                    for="withdrawal_amount_id"
                                    class="form-label"
                                >
                                    Withdrawal Amount
                                </label>

                                <select
                                    name="withdrawal_amount_id"
                                    id="withdrawal_amount_id"
                                    class="form-select"
                                    required
                                >

                                    <option value="">
                                        Select amount
                                    </option>

                                    @foreach($amounts as $amount)

                                        <option
                                            value="{{ $amount->id }}"
                                            @selected(
                                                old('withdrawal_amount_id')
                                                == $amount->id
                                            )
                                        >

                                            ${{ number_format(
                                                (float) $amount->amount,
                                                2
                                            ) }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>


                            {{-- ==================================================
                                 PAYMENT ACCOUNT
                            =================================================== --}}

                            <div class="mb-3">

                                <label
                                    for="payment_account_id"
                                    class="form-label"
                                >

                                    Withdrawal Payment Account

                                </label>


                                <select
                                    name="payment_account_id"
                                    id="payment_account_id"
                                    class="form-select"
                                    required
                                >

                                    <option value="">
                                        Select payment account
                                    </option>


                                    @foreach($paymentAccounts as $account)

                                        @php

                                            $methodName =
                                                $account
                                                    ->paymentMethod
                                                    ?->name
                                                ?? 'Payment Method';

                                        @endphp


                                        <option
                                            value="{{ $account->id }}"
                                            @selected(
                                                old('payment_account_id')
                                                == $account->id
                                            )
                                        >

                                            {{ $methodName }}

                                            @if($account->is_default)

                                                — Default

                                            @endif

                                        </option>

                                    @endforeach

                                </select>


                                <div class="form-text">

                                    Select one of your saved payment accounts.
                                    Your saved payment details will be used
                                    for this withdrawal.

                                </div>


                                <div class="mt-2">

                                    <a
                                        href="{{ route('payment-accounts.index') }}"
                                        class="small"
                                    >
                                        Manage Payment Accounts
                                    </a>

                                    <span class="text-muted mx-1">
                                        |
                                    </span>

                                    <a
                                        href="{{ route('payment-accounts.create') }}"
                                        class="small"
                                    >
                                        Add New Account
                                    </a>

                                </div>

                            </div>


                            {{-- ==================================================
                                 SELECTED ACCOUNT PREVIEW
                            =================================================== --}}

                            <div
                                id="payment-account-preview"
                                class="card mb-3"
                                style="display: none;"
                            >

                                <div class="card-header">

                                    <strong>
                                        Selected Payment Account
                                    </strong>

                                </div>


                                <div
                                    class="card-body"
                                    id="payment-account-preview-body"
                                >

                                </div>

                            </div>


                            {{-- ==================================================
                                 FEE INFORMATION
                            =================================================== --}}

                            <div class="alert alert-secondary">

                                <strong>
                                    Withdrawal Fee:
                                </strong>


                                @if($settings->fee_type === 'percentage')

                                    {{ number_format(
                                        (float) $settings->fee_value,
                                        2
                                    ) }}%

                                @else

                                    ${{ number_format(
                                        (float) $settings->fee_value,
                                        2
                                    ) }}

                                @endif


                                <br>


                                <small>

                                    The fee is deducted from the withdrawal
                                    payout. Your wallet reserves the full
                                    requested amount.

                                </small>

                            </div>


                            {{-- ==================================================
                                 MINIMUM BALANCE
                            =================================================== --}}

                            <div class="mb-3">

                                <small class="text-muted">

                                    Minimum withdrawable balance:

                                    <strong>

                                        ${{ number_format(
                                            (float)
                                            $settings
                                                ->minimum_withdrawable_balance,
                                            2
                                        ) }}

                                    </strong>

                                </small>

                            </div>


                            {{-- ==================================================
                                 SUBMIT
                            =================================================== --}}

                            <button
                                type="submit"
                                class="btn btn-primary w-100"
                            >

                                Save & Request Withdrawal

                            </button>


                        </form>

                    @endif


                    {{-- ======================================================
                         HISTORY
                    ======================================================= --}}

                    <div class="mt-3 text-center">

                        <a
                            href="{{ route('withdrawals.index') }}"
                        >
                            View Withdrawal History
                        </a>

                    </div>


                </div>

            </div>

        </div>

    </div>

</div>


{{-- ========================================================================
     PAYMENT ACCOUNT PREVIEW
============================================================================ --}}

@if($paymentAccounts->isNotEmpty())

<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {

        const select =
            document.getElementById(
                'payment_account_id'
            );


        const preview =
            document.getElementById(
                'payment-account-preview'
            );


        const previewBody =
            document.getElementById(
                'payment-account-preview-body'
            );


        if (
            !select ||
            !preview ||
            !previewBody
        ) {
            return;
        }



        const accounts =
            @json($paymentAccountPayload);


        /*
        |--------------------------------------------------------------------------
        | HTML Escape
        |--------------------------------------------------------------------------
        */

        function escapeHtml(value) {

            const div =
                document.createElement('div');

            div.textContent =
                value ?? '';

            return div.innerHTML;
        }


        /*
        |--------------------------------------------------------------------------
        | Format Field Name
        |--------------------------------------------------------------------------
        */

        function formatFieldName(key) {

            return String(key)
                .replaceAll('_', ' ')
                .replace(
                    /\b\w/g,
                    function (letter) {
                        return letter.toUpperCase();
                    }
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Render Selected Payment Account
        |--------------------------------------------------------------------------
        */

        function renderAccount() {

            const id =
                parseInt(
                    select.value,
                    10
                );


            const account =
                accounts.find(
                    function (item) {

                        return (
                            Number(item.id)
                            === id
                        );

                    }
                );


            /*
            |--------------------------------------------------------------------------
            | No Account Selected
            |--------------------------------------------------------------------------
            */

            if (!account) {

                preview.style.display =
                    'none';

                previewBody.innerHTML =
                    '';

                return;
            }


            /*
            |--------------------------------------------------------------------------
            | Payment Method
            |--------------------------------------------------------------------------
            */

            let html =

                '<div class="mb-3">' +

                    '<small class="text-muted">' +
                        'PAYMENT METHOD' +
                    '</small>' +

                    '<div class="fw-bold">' +

                        escapeHtml(
                            account.method
                        ) +

                    '</div>' +

                '</div>';


            /*
            |--------------------------------------------------------------------------
            | Account Details
            |--------------------------------------------------------------------------
            */

            const details =
                account.details || {};


            Object.entries(details).forEach(
                function ([key, value]) {

                    if (
                        value === null ||
                        value === undefined ||
                        value === ''
                    ) {
                        return;
                    }


                    html +=

                        '<div class="mb-3">' +

                            '<small class="text-muted">' +

                                escapeHtml(
                                    formatFieldName(key)
                                ) +

                            '</small>' +

                            '<div>' +

                                '<strong>' +

                                    escapeHtml(
                                        String(value)
                                    ) +

                                '</strong>' +

                            '</div>' +

                        '</div>';

                }
            );


            /*
            |--------------------------------------------------------------------------
            | Default Account
            |--------------------------------------------------------------------------
            */

            if (account.is_default) {

                html +=

                    '<div class="mt-2">' +

                        '<span class="badge bg-success">' +

                            'Default Payment Account' +

                        '</span>' +

                    '</div>';

            }


            /*
            |--------------------------------------------------------------------------
            | Display
            |--------------------------------------------------------------------------
            */

            previewBody.innerHTML =
                html;

            preview.style.display =
                'block';

        }


        /*
        |--------------------------------------------------------------------------
        | Account Selection
        |--------------------------------------------------------------------------
        */

        select.addEventListener(
            'change',
            renderAccount
        );


        /*
        |--------------------------------------------------------------------------
        | Initial Account
        |--------------------------------------------------------------------------
        */

        renderAccount();

    }
);

</script>

@endif

@endsection