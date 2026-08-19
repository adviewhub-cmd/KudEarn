@extends('layouts.app')

@section('content')

<section class="py-5 bg-light">

<div class="container">

<div class="row align-items-center">

<div class="col-lg-6">

<h1 class="display-4 fw-bold">

Earn Daily Rewards by Completing Tasks

</h1>

<p class="lead mt-4">

Join KUD.EARN, invest in a plan, complete daily tasks, and earn rewards based on your activity.

</p>

<a href="{{ route('register') }}" class="btn btn-primary btn-lg mt-3">

Start Earning

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

<h2>$500K+</h2>

<p>Total Rewards Paid</p>

</div>

<div class="col-md-3">

<h2>10,000+</h2>

<p>Members</p>

</div>

<div class="col-md-3">

<h2>100+</h2>

<p>Daily Tasks</p>

</div>

<div class="col-md-3">

<h2>99%</h2>

<p>User Satisfaction</p>

</div>

</div>

</div>

</section>

@endsection