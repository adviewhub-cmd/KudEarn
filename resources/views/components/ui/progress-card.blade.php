@props([
    'title',
    'completed'=>0,
    'total'=>0,
])

@php

$percentage=$total>0
    ? round(($completed/$total)*100)
    :0;

@endphp

<div class="card-modern p-4 mb-4">

    <div class="d-flex justify-content-between mb-3">

        <h5>

            {{ $title }}

        </h5>

        <span class="badge bg-success">

            {{ $percentage }}%

        </span>

    </div>

    <div class="progress mb-3" style="height:12px;">

        <div

            class="progress-bar progress-bar-striped progress-bar-animated bg-success"

            style="width:{{ $percentage }}%">

        </div>

    </div>

    <div class="row text-center">

        <div class="col">

            <h4>

                {{ $completed }}

            </h4>

            <small>

                Completed

            </small>

        </div>

        <div class="col">

            <h4>

                {{ $total-$completed }}

            </h4>

            <small>

                Remaining

            </small>

        </div>

        <div class="col">

            <h4>

                {{ $total }}

            </h4>

            <small>

                Total

            </small>

        </div>

    </div>

</div>