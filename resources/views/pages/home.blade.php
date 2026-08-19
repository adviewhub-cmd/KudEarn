@extends('layouts.app')

@section('content')

<section class="bg-primary text-white py-5">

    <div class="container">

        <div class="row align-items-center">

            <div class="col-lg-6">

                <h1 class="display-4 fw-bold">

                    Earn Daily Rewards
                    By Completing Tasks

                </h1>

                <p class="lead mt-4">

                    Invest in a plan, complete your daily tasks and receive
                    rewards for every completed task.

                </p>

                <a href="{{ route('register') }}"
                   class="btn btn-warning btn-lg">

                    Get Started

                </a>

            </div>

            <div class="col-lg-6 text-center">

                <img
                    src="https://placehold.co/600x400?text=KUD.EARN"
                    class="img-fluid rounded shadow">

            </div>

        </div>

    </div>

</section>

<section class="py-5">

    <div class="container">

        <div class="row text-center">

            <div class="col-md-3">
                <h2>$0</h2>
                <p>Total Deposits</p>
            </div>

            <div class="col-md-3">
                <h2>$0</h2>
                <p>Total Withdrawals</p>
            </div>

            <div class="col-md-3">
                <h2>0</h2>
                <p>Members</p>
            </div>

            <div class="col-md-3">
                <h2>0</h2>
                <p>Tasks Completed</p>
            </div>

        </div>

    </div>

</section>

@endsection