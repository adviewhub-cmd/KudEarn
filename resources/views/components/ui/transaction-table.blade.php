@props([
    'transactions'
])

<div class="card-modern p-4">

    <h5 class="mb-4">

        Recent Transactions

    </h5>

    <table class="table align-middle">

        <thead>

        <tr>

            <th>Reference</th>

            <th>Type</th>

            <th>Amount</th>

            <th>Status</th>

        </tr>

        </thead>

        <tbody>

        @forelse($transactions as $transaction)

            <tr>

                <td>

                    {{ $transaction->reference }}

                </td>

                <td>

                    {{ ucfirst($transaction->type) }}

                </td>

                <td>

                    ${{ number_format($transaction->amount,2) }}

                </td>

                <td>

                    <span class="badge bg-success">

                        {{ ucfirst($transaction->status) }}

                    </span>

                </td>

            </tr>

        @empty

            <tr>

                <td colspan="4">

                    No transactions found.

                </td>

            </tr>

        @endforelse

        </tbody>

    </table>

</div>