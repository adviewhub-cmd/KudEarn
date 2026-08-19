@extends('layouts.app')

@section('content')

<div
    class="max-w-3xl mx-auto px-4 py-8"
    x-data="paymentAccountEditForm()"
>

    <div class="mb-6">

        <h1 class="text-2xl font-bold">
            Edit Payment Account
        </h1>

        <p class="text-sm text-gray-500 mt-1">
            Update your withdrawal payment details.
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

    <form
        method="POST"
        action="{{ route('payment-accounts.update', $paymentAccount) }}"
        class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm"
    >

        @csrf
        @method('PUT')

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
                x-model="selectedMethod"
                @change="updateFields()"
                class="w-full rounded-lg border-gray-300"
                required
            >

                @foreach ($paymentMethods as $method)

                    <option
                        value="{{ $method->id }}"
                        data-fields='@json($method->fields ?? [])'
                        @selected(
                            $paymentAccount->payment_method_id === $method->id
                        )
                    >
                        {{ $method->name }}
                    </option>

                @endforeach

            </select>

        </div>

        <div class="space-y-5">

            <template
                x-for="field in fields"
                :key="field.name"
            >

                <div>

                    <label
                        class="block text-sm font-semibold mb-2"
                        x-text="field.label"
                    ></label>

                    <input
                        x-show="
                            field.type === 'text' ||
                            field.type === 'email' ||
                            field.type === 'number'
                        "
                        :type="field.type"
                        :name="'account_details[' + field.name + ']'"
                        :required="field.required"
                        :value="existingValues[field.name] ?? ''"
                        class="w-full rounded-lg border-gray-300"
                    >

                    <textarea
                        x-show="field.type === 'textarea'"
                        :name="'account_details[' + field.name + ']'"
                        :required="field.required"
                        x-text="existingValues[field.name] ?? ''"
                        rows="4"
                        class="w-full rounded-lg border-gray-300"
                    ></textarea>

                </div>

            </template>

        </div>

        <div class="flex items-center justify-between mt-8">

            <a
                href="{{ route('payment-accounts.index') }}"
                class="text-sm text-gray-600 hover:text-gray-900"
            >
                Cancel
            </a>

            <button
                type="submit"
                class="px-5 py-2 rounded-lg bg-primary-600 text-white font-semibold"
            >
                Update Payment Account
            </button>

        </div>

    </form>

</div>

<script>
function paymentAccountEditForm() {
    return {
        selectedMethod:
            '{{ $paymentAccount->payment_method_id }}',

        fields: [],

        existingValues:
            @json($paymentAccount->account_details ?? []),

        init() {
            this.updateFields();
        },

        updateFields() {
            const select =
                document.getElementById(
                    'payment_method_id'
                );

            const option =
                select.options[
                    select.selectedIndex
                ];

            if (
                !option ||
                !option.dataset.fields
            ) {
                this.fields = [];
                return;
            }

            try {
                this.fields =
                    JSON.parse(
                        option.dataset.fields
                    );
            } catch (error) {
                this.fields = [];
            }
        }
    };
}
</script>

@endsection