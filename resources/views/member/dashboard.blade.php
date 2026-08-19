@extends('layouts.member')

@section('title','Dashboard')

@section('page-title')

Dashboard

@endsection

@section('content')

<div class="mb-4">

    <h2>

        Welcome back,

        {{ auth()->user()->name }}

        👋

    </h2>

    <p class="text-muted">

        Here's an overview of your account today.

    </p>

</div>

    <div class="row">

    <x-ui.stat-card
        title="Wallet Balance"
        :value="'$' . number_format($wallet->balance, 2)"
        icon="bi-wallet2"
        color="success"
    />

    <x-ui.stat-card
        title="Total Investment"
        :value="'$' . number_format($totalInvestment, 2)"
        icon="bi-graph-up"
        color="primary"
    />

    <x-ui.stat-card
        title="Today's Earnings"
        :value="'$' . number_format($todayEarnings, 2)"
        icon="bi-cash-stack"
        color="warning"
    />

    <x-ui.stat-card
        title="Pending Tasks"
        :value="$pendingTasks"
        icon="bi-check2-square"
        color="info"
    />

</div>

</div>

<x-ui.progress-card
    title="Today's Task Progress"
    :completed="$completedTasks"
    :total="$tasks->count()"
/>

<div class="row">

    <div class="col-lg-6">

        <div class="row">

            @foreach($investments as $investment)

                <div class="col-md-6 mb-4">

                    <x-ui.investment-card
                        :investment="$investment"
                    />

                </div>

            @endforeach

        </div>

    </div>

    <div class="col-lg-6">

        <x-ui.transaction-table
            :transactions="$transactions"
        />

    </div>

</div>

@endsection