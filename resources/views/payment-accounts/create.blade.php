@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto px-4 py-8">

    <div class="mb-6">
        <h1 class="text-2xl font-bold">
            Add Payment Account
        </h1>

        <p class="text-sm text-gray-500 mt-1">
            Add an account where your withdrawals can be sent.
        </p>
    </div>

    @if ($errors->any())
        <div class="mb-6 rounded-lg bg-red-50 border border-red-200 p-4 text-red-700">
            <ul class="list-disc list-inside text-sm space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="mb-6 rounded-lg bg-green-50 border border-green-200 p-4 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <form
        method="POST"
        action="{{ route('payment-accounts.store') }}"
        id="payment-account-form"
        class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm"
    >

        @csrf

        {{-- Payment Method --}}
        <div class="mb-6">

            <label
                for="payment_method_id"
                class="block text-sm font-semibold mb-2"
            >
                Payment Method
            </label>

            <select
                id="payment_method_id"
                name="payment_method_id"
                class="w-full rounded-lg border border-gray-300 px-3 py-2"
                required
            >

                <option value="">
                    Select payment method
                </option>

                @foreach ($paymentMethods as $method)

                    <option
                        value="{{ $method->id }}"
                        data-fields="{{ json_encode($method->fields ?? [], JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_HEX_TAG) }}"
                        @selected(old('payment_method_id') == $method->id)
                    >
                        {{ $method->name }}
                    </option>

                @endforeach

            </select>

        </div>

        {{-- Dynamic Fields --}}
        <div
            id="payment-fields"
            class="space-y-5"
        ></div>

        {{-- Buttons --}}
        <div class="flex items-center justify-between mt-8">

            <a
                href="{{ route('payment-accounts.index') }}"
                class="text-sm text-gray-600 hover:text-gray-900"
            >
                Cancel
            </a>

            <button
                type="submit"
                id="save-payment-account"
                class="inline-flex items-center justify-center px-5 py-2 rounded-lg bg-primary-600 text-black font-semibold hover:bg-primary-700 disabled:opacity-50 disabled:cursor-not-allowed"
            >
                Save Payment Account
            </button>

        </div>

    </form>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const methodSelect =
        document.getElementById('payment_method_id');

    const fieldsContainer =
        document.getElementById('payment-fields');

    const form =
        document.getElementById('payment-account-form');

    const submitButton =
        document.getElementById('save-payment-account');

    function escapeHtml(value) {
        const div = document.createElement('div');
        div.textContent = value ?? '';
        return div.innerHTML;
    }

    function renderFields() {

        fieldsContainer.innerHTML = '';

        const option =
            methodSelect.options[
                methodSelect.selectedIndex
            ];

        if (!option || !option.value) {
            return;
        }

        let fields = [];

        try {
            fields =
                JSON.parse(
                    option.dataset.fields || '[]'
                );
        } catch (error) {
            console.error(
                'Unable to parse payment method fields:',
                error
            );

            return;
        }

        if (!Array.isArray(fields)) {
            return;
        }

        fields.forEach(function (field) {

            if (!field.name) {
                return;
            }

            const wrapper =
                document.createElement('div');

            const label =
                document.createElement('label');

            label.className =
                'block text-sm font-semibold mb-2';

            label.setAttribute(
                'for',
                'account_' + field.name
            );

            label.textContent =
                field.label ||
                field.name.replaceAll('_', ' ');

            wrapper.appendChild(label);

            let input;

            if (field.type === 'textarea') {

                input =
                    document.createElement('textarea');

                input.rows = 4;

            } else {

                input =
                    document.createElement('input');

                input.type =
                    field.type || 'text';
            }

            input.id =
                'account_' + field.name;

            input.name =
                'account_details[' +
                field.name +
                ']';

            input.className =
                'w-full rounded-lg border border-gray-300 px-3 py-2';

            input.required =
                field.required === true;

            input.maxLength = 1000;

            const oldValue =
                @json(old('account_details', []));

            if (
                oldValue &&
                typeof oldValue === 'object' &&
                oldValue[field.name] !== undefined
            ) {
                input.value =
                    oldValue[field.name];
            }

            wrapper.appendChild(input);

            fieldsContainer.appendChild(wrapper);
        });
    }

    methodSelect.addEventListener(
        'change',
        renderFields
    );

    /*
    |--------------------------------------------------------------------------
    | Prevent double submission
    |--------------------------------------------------------------------------
    */

    form.addEventListener('submit', function () {

        submitButton.disabled = true;

        submitButton.textContent =
            'Saving...';

    });

    /*
    |--------------------------------------------------------------------------
    | Render existing selection after validation failure
    |--------------------------------------------------------------------------
    */

    renderFields();

});
</script>

@endsection