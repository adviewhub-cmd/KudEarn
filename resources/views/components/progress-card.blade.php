@props([
    'title' => 'Progress',
    'completed' => 0,
    'total' => 0,
])

@php
    $percentage = $total > 0
        ? round(($completed / $total) * 100)
        : 0;
@endphp

<div class="card-modern p-4 mb-4">

    <div class="d-flex justify-content-between align-items-center mb-3">

        <h5 class="mb-0">
            {{ $title }}
        </h5>

        <span class="fw-bold text-success">
            {{ $percentage }}%
        </span>

    </div>

    <div class="progress" style="height: 12px;">

        <div
            class="progress-bar bg-success progress-bar-striped progress-bar-animated"
            role="progressbar"
            style="width: {{ $percentage }}%;"
            aria-valuenow="{{ $percentage }}"
            aria-valuemin="0"
            aria-valuemax="100">

        </div>

    </div>

    <div class="d-flex justify-content-between mt-3">

        <small class="text-muted">

            {{ $completed }} completed

        </small>

        <small class="text-muted">

            {{ $total }} total tasks

        </small>

    </div>
    <x-ui.progress-card
    title="Today's Progress"
    :completed="$completedTasks"
    :total="$tasks->count()"
    />

</div>