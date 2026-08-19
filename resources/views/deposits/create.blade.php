@extends('layouts.app')

@section('content')

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-md-7">

            <div class="card shadow-sm border-0">

                <div class="card-body p-4">

                    <h2 class="fw-bold mb-4">
                        Make a Deposit
                    </h2>

                    @if ($errors->any())
                        <div class="alert alert-danger">

                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>

                        </div>
                    @endif

                    <form
                        method="POST"
                        action="{{ route('deposits.store') }}"
                        enctype="multipart/form-data"
                    >

                        @csrf

                        <div class="mb-3">

                            <label class="form-label">
                                Deposit Amount
                            </label>

                            <input
                                type="number"
                                name="amount"
                                class="form-control"
                                min="1"
                                step="0.01"
                                value="{{ old('amount') }}"
                                required
                            >

                        </div>


                        <div class="mb-3">

                            <label class="form-label">
                                Payment Method
                            </label>

                            <select
                                name="payment_method"
                                class="form-select"
                                required
                            >

                                <option value="">
                                    Select payment method
                                </option>

                                <option value="Bank Transfer">
                                    Bank Transfer
                                </option>

                                <option value="Crypto">
                                    Cryptocurrency
                                </option>

                                <option value="Mobile Money">
                                    Mobile Money
                                </option>

                                <option value="Other">
                                    Other
                                </option>

                            </select>

                        </div>


                        <div class="mb-3">

                            <label class="form-label">
                                Payment Reference
                            </label>

                            <input
                                type="text"
                                name="reference"
                                class="form-control"
                                value="{{ old('reference') }}"
                                placeholder="Enter transaction reference"
                                required
                            >

                        </div>


                        <div class="mb-4">

                            <label class="form-label">
                                Payment Proof
                            </label>

                            <input
                                type="file"
                                name="proof"
                                class="form-control"
                                accept=".jpg,.jpeg,.png,.pdf"
                            >

                            <small class="text-muted">
                                JPG, PNG or PDF. Maximum 5MB.
                            </small>

                        </div>


                        <button
                            type="submit"
                            class="btn btn-primary w-100"
                        >
                            Submit Deposit Request
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection