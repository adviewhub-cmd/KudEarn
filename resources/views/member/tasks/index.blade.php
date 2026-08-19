@extends('layouts.app')

@section('content')

<div class="container py-4">

    {{-- ================================================================ --}}
    {{-- PAGE HEADER --}}
    {{-- ================================================================ --}}

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="mb-1">
                Today's Daily Tasks
            </h2>

            <p class="text-muted mb-0">
                Complete your assigned tasks to earn rewards.
            </p>
        </div>

        <div>
            <span class="badge bg-primary fs-6">
                {{ $tasks->count() }} Tasks
            </span>
        </div>

    </div>


    {{-- ================================================================ --}}
    {{-- PROGRESS --}}
    {{-- ================================================================ --}}

    @php
        $completedTasks = $tasks
            ->where('status', 'completed')
            ->count();

        $totalTasks = $tasks->count();

        $progress = $totalTasks > 0
            ? round(($completedTasks / $totalTasks) * 100)
            : 0;
    @endphp

    <div class="card shadow-sm mb-4">

        <div class="card-body">

            <div class="d-flex justify-content-between mb-2">

                <strong>
                    Today's Progress
                </strong>

                <span>
                    {{ $completedTasks }} / {{ $totalTasks }}
                </span>

            </div>

            <div class="progress" style="height: 10px;">

                <div
                    class="progress-bar bg-success"
                    role="progressbar"
                    style="width: {{ $progress }}%;"
                    aria-valuenow="{{ $progress }}"
                    aria-valuemin="0"
                    aria-valuemax="100"
                ></div>

            </div>

        </div>

    </div>


    {{-- ================================================================ --}}
    {{-- TASK LIST --}}
    {{-- ================================================================ --}}

    @if ($tasks->isEmpty())

        <div class="card shadow-sm">

            <div class="card-body text-center py-5">

                <h4>
                    No Tasks Available
                </h4>

                <p class="text-muted mb-0">
                    You have no daily tasks available today.
                </p>

            </div>

        </div>

    @else

        <div class="row g-4">

            @foreach ($tasks as $task)

                @php

                    $completion = $task->completion;

                    $estimatedSeconds = max(
                        1,
                        (int) ($task->estimated_seconds ?? 20)
                    );

                    $isCompleted =
                        $task->status === 'completed';

                    $isStarted =
                        $task->status === 'started';

                    $startedAt = $completion?->started_at
                        ?? $task->started_at;

                    $startedAtTimestamp = $startedAt
                        ? $startedAt->timestamp
                        : null;

                    $taskType = strtolower(
                        (string) ($task->task_type ?? 'none')
                    );

                    $taskUrl = $task->task_url;

                    $hasContent =
                        ! empty($taskUrl)
                        && in_array(
                            $taskType,
                            ['website', 'video'],
                            true
                        );

                @endphp


                <div class="col-12 col-md-6 col-lg-4">

                    <div
                        class="card h-100 shadow-sm daily-task-card"
                        id="task-card-{{ $task->id }}"

                        data-task-id="{{ $task->id }}"
                        data-status="{{ $task->status }}"
                        data-task-type="{{ $taskType }}"
                        data-task-url="{{ $taskUrl }}"
                        data-estimated-seconds="{{ $estimatedSeconds }}"
                        data-started-at="{{ $startedAtTimestamp }}"
                        data-heartbeat-url="{{ route('daily-tasks.heartbeat', $task) }}"
                    >


                        {{-- ================================================= --}}
                        {{-- CARD HEADER --}}
                        {{-- ================================================= --}}

                        <div class="card-header d-flex justify-content-between align-items-center">

                            <span class="badge bg-primary">
                                Task {{ $task->task_number }}
                            </span>


                            @if ($isCompleted)

                                <span class="badge bg-success">
                                    Completed
                                </span>

                            @elseif ($isStarted)

                                <span class="badge bg-warning text-dark">
                                    In Progress
                                </span>

                            @else

                                <span class="badge bg-secondary">
                                    Pending
                                </span>

                            @endif

                        </div>


                        {{-- ================================================= --}}
                        {{-- CARD BODY --}}
                        {{-- ================================================= --}}

                        <div class="card-body d-flex flex-column">


                            {{-- TITLE --}}

                            <h5 class="card-title">

                                {{ $task->title }}

                            </h5>


                            {{-- DESCRIPTION --}}

                            @if ($task->description)

                                <p class="card-text text-muted">

                                    {{ $task->description }}

                                </p>

                            @endif


                            {{-- INSTRUCTIONS --}}

                            @if ($task->instructions)

                                <div class="alert alert-light small">

                                    <strong>
                                        Instructions:
                                    </strong>

                                    <div class="mt-1">
                                        {{ $task->instructions }}
                                    </div>

                                </div>

                            @endif


                            {{-- ================================================= --}}
                            {{-- TASK INFORMATION --}}
                            {{-- ================================================= --}}

                            <div class="mb-3">

                                <div class="d-flex justify-content-between mb-2">

                                    <span>
                                        Reward
                                    </span>

                                    <strong class="text-success">

                                        ${{ number_format(
                                            (float) $task->reward,
                                            4
                                        ) }}

                                    </strong>

                                </div>


                                <div class="d-flex justify-content-between">

                                    <span>
                                        Required Time
                                    </span>

                                    <strong>

                                        {{ $estimatedSeconds }}
                                        seconds

                                    </strong>

                                </div>

                            </div>


                            {{-- ================================================= --}}
                            {{-- OPEN WEBSITE / VIDEO --}}
                            {{-- ================================================= --}}

                            @if ($hasContent)

                                <button
                                    type="button"

                                    class="btn btn-outline-primary w-100 mb-3 open-task-content-btn"

                                    data-task-id="{{ $task->id }}"

                                    data-task-type="{{ $taskType }}"

                                    data-task-url="{{ $taskUrl }}"
                                >

                                    @if ($taskType === 'video')

                                        ▶ Open Video

                                    @else

                                        🌐 Open Website

                                    @endif

                                </button>

                            @endif


                            {{-- ================================================= --}}
                            {{-- TIMER --}}
                            {{-- ================================================= --}}

                            <div
                                id="timer-box-{{ $task->id }}"

                                class="alert alert-warning text-center mb-3
                                @if (! $isStarted)
                                    d-none
                                @endif"
                            >

                                <div class="small text-muted">
                                    Time Remaining
                                </div>

                                <div
                                    id="timer-{{ $task->id }}"
                                    class="fs-2 fw-bold"
                                >
                                    {{ $estimatedSeconds }}
                                </div>

                                <div class="small">
                                    seconds
                                </div>

                            </div>

                            <div
                                id="visibility-warning-{{ $task->id }}"
                                class="alert alert-warning d-none small mb-3"
                            ></div>


                            {{-- ================================================= --}}
                            {{-- START BUTTON --}}
                            {{-- ================================================= --}}

                            @if (! $isStarted && ! $isCompleted)

            <button
                type="button"

                class="btn btn-primary w-100 start-task-btn"

                data-task-id="{{ $task->id }}"

                data-start-url="{{ route(
                    'daily-tasks.start',
                    $task
                ) }}"

                data-complete-url="{{ route(
                    'daily-tasks.complete',
                    $task
                ) }}"

                data-task-url="{{ $task->task_url }}"

                data-task-type="{{ $task->task_type }}"
            >
                START TASK
            </button>

                            @endif


                            {{-- ================================================= --}}
                            {{-- COMPLETE BUTTON --}}
                            {{-- ================================================= --}}

                            @if ($isStarted)

                                <button
                                    type="button"
                                    id="complete-btn-{{ $task->id }}"
                                    class="btn btn-success w-100 complete-task-btn"
                                    data-task-id="{{ $task->id }}"
                                    data-complete-url="{{ route('daily-tasks.complete', $task) }}"
                                    data-task-url="{{ $task->task_url }}"
                                    data-task-type="{{ $taskType }}"
                                    disabled
                                >
                                    WAIT {{ $estimatedSeconds }}s
                                </button>

                            @endif


                            {{-- ================================================= --}}
                            {{-- COMPLETED --}}
                            {{-- ================================================= --}}

                            @if ($isCompleted)

                                <button
                                    type="button"

                                    class="btn btn-outline-success w-100"

                                    disabled
                                >

                                    ✓ TASK COMPLETED

                                </button>

                            @endif


                            {{-- ================================================= --}}
                            {{-- MESSAGE --}}
                            {{-- ================================================= --}}

                            <div
                                id="task-message-{{ $task->id }}"

                                class="alert d-none mt-3 mb-0"
                            ></div>


                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    @endif

</div>


{{-- ====================================================================== --}}
{{-- JAVASCRIPT --}}
{{-- ====================================================================== --}}

<script>
document.addEventListener('DOMContentLoaded', function () {

    const csrfToken =
        document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

    const countdownTimers = new Map();
    const activeTasks = new Set();

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    function showMessage(taskId, message, type = 'info') {

        const element =
            document.getElementById(`task-message-${taskId}`);

        if (!element) {
            return;
        }

        element.className =
            `alert alert-${type} mt-3 mb-0`;

        element.textContent = message;
    }


    function showVisibilityWarning(taskId, message) {

        const element =
            document.getElementById(
                `visibility-warning-${taskId}`
            );

        if (!element) {
            return;
        }

        element.textContent = message;
        element.classList.remove('d-none');
    }


    function hideVisibilityWarning(taskId) {

        const element =
            document.getElementById(
                `visibility-warning-${taskId}`
            );

        if (element) {
            element.classList.add('d-none');
            element.textContent = '';
        }
    }


    function setTimer(taskId, seconds) {

        const timer =
            document.getElementById(
                `timer-${taskId}`
            );

        if (!timer) {
            return;
        }

        timer.textContent =
            Math.max(0, Math.ceil(seconds));
    }


    function showTimer(taskId) {

        const box =
            document.getElementById(
                `timer-box-${taskId}`
            );

        if (box) {
            box.classList.remove('d-none');
        }
    }


    function hideTimer(taskId) {

        const box =
            document.getElementById(
                `timer-box-${taskId}`
            );

        if (box) {
            box.classList.add('d-none');
        }
    }


    function setTaskStatus(taskId, status) {

        const card =
            document.getElementById(
                `task-card-${taskId}`
            );

        if (card) {
            card.dataset.status = status;
        }
    }


    /*
    |--------------------------------------------------------------------------
    | JSON request helper
    |--------------------------------------------------------------------------
    */

    async function postJson(url, payload = {}) {

        const response =
            await fetch(
                url,
                {
                    method: 'POST',

                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest'
                    },

                    body: JSON.stringify(payload)
                }
            );

        let data = {};

        try {
            data = await response.json();
        } catch (error) {
            data = {};
        }

        if (!response.ok) {

            throw new Error(
                data.message ||
                'The server could not process the request.'
            );
        }

        return data;
    }


    /*
    |--------------------------------------------------------------------------
    | Server heartbeat
    |--------------------------------------------------------------------------
    |
    | IMPORTANT:
    | The task normally opens in another browser tab. Therefore we DO NOT
    | treat "Kud.Earn tab hidden" as fraud. The member is expected to switch
    | to the task website/video tab.
    |
    | Heartbeats are audit information only. The server-side started_at
    | timestamp remains authoritative for reward eligibility.
    |
    */

    async function sendHeartbeat(card, visible) {

        if (!card) {
            return;
        }

        const heartbeatUrl =
            card.dataset.heartbeatUrl;

        if (!heartbeatUrl) {
            return;
        }

        try {

            await postJson(
                heartbeatUrl,
                {
                    visible: Boolean(visible)
                }
            );

        } catch (error) {

            console.warn(
                'Daily task heartbeat failed:',
                error.message
            );
        }
    }


    function startHeartbeat(card) {

        if (!card) {
            return;
        }

        const taskId =
            card.dataset.taskId;

        activeTasks.add(taskId);

        sendHeartbeat(
            card,
            document.visibilityState === 'visible'
        );
    }


    function stopHeartbeat(taskId) {

        activeTasks.delete(
            String(taskId)
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Countdown
    |--------------------------------------------------------------------------
    */

    function startCountdown(
        taskId,
        startedAt,
        estimatedSeconds
    ) {

        const startTime =
            Number(startedAt);

        const duration =
            Number(estimatedSeconds);

        if (!startTime || !duration) {
            return;
        }

        showTimer(taskId);

        if (countdownTimers.has(String(taskId))) {

            clearInterval(
                countdownTimers.get(
                    String(taskId)
                )
            );
        }

        const completeButton =
            document.getElementById(
                `complete-btn-${taskId}`
            );


        function update() {

            const now =
                Math.floor(
                    Date.now() / 1000
                );

            const elapsed =
                Math.max(
                    0,
                    now - startTime
                );

            const remaining =
                Math.max(
                    0,
                    duration - elapsed
                );

            setTimer(
                taskId,
                remaining
            );


            if (completeButton) {

                if (remaining <= 0) {

                    completeButton.disabled =
                        false;

                    completeButton.textContent =
                        'COMPLETE TASK';

                } else {

                    completeButton.disabled =
                        true;

                    completeButton.textContent =
                        `WAIT ${remaining}s`;
                }
            }


            if (remaining <= 0) {

                const timer =
                    countdownTimers.get(
                        String(taskId)
                    );

                if (timer) {

                    clearInterval(timer);

                    countdownTimers.delete(
                        String(taskId)
                    );
                }
            }
        }


        update();

        const timer =
            setInterval(
                update,
                500
            );

        countdownTimers.set(
            String(taskId),
            timer
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Create/attach complete button
    |--------------------------------------------------------------------------
    */

    function ensureCompleteButton(
        taskId,
        completeUrl,
        taskUrl,
        taskType,
        estimatedSeconds
    ) {

        let button =
            document.getElementById(
                `complete-btn-${taskId}`
            );

        if (button) {
            attachCompleteHandler(button);
            return button;
        }


        const card =
            document.getElementById(
                `task-card-${taskId}`
            );

        if (!card) {
            return null;
        }


        const cardBody =
            card.querySelector(
                '.card-body'
            );

        if (!cardBody) {
            return null;
        }


        button =
            document.createElement('button');

        button.type =
            'button';

        button.id =
            `complete-btn-${taskId}`;

        button.className =
            'btn btn-success w-100 complete-task-btn';

        button.dataset.taskId =
            taskId;

        button.dataset.completeUrl =
            completeUrl;

        button.dataset.taskUrl =
            taskUrl || '';

        button.dataset.taskType =
            taskType || 'none';

        button.disabled =
            true;

        button.textContent =
            `WAIT ${estimatedSeconds}s`;


        const timerBox =
            document.getElementById(
                `timer-box-${taskId}`
            );

        if (timerBox) {

            timerBox.insertAdjacentElement(
                'afterend',
                button
            );

        } else {

            cardBody.appendChild(
                button
            );
        }


        attachCompleteHandler(button);

        return button;
    }


    /*
    |--------------------------------------------------------------------------
    | Start task
    |--------------------------------------------------------------------------
    */

    document
        .querySelectorAll('.start-task-btn')
        .forEach(function (button) {

            button.addEventListener(
                'click',
                async function () {

                    const taskId =
                        this.dataset.taskId;

                    const startUrl =
                        this.dataset.startUrl;

                    const completeUrl =
                        this.dataset.completeUrl;

                    const taskUrl =
                        this.dataset.taskUrl;

                    const taskType =
                        this.dataset.taskType || 'none';


                    /*
                    |--------------------------------------------------------------------------
                    | Open the task window immediately.
                    |--------------------------------------------------------------------------
                    */

                    let taskWindow = null;

                    if (taskUrl) {

                        taskWindow =
                            window.open(
                                'about:blank',
                                '_blank'
                            );

                        if (taskWindow) {

                            try {

                                taskWindow.document.write(`
                                    <!doctype html>
                                    <html>
                                    <head>
                                        <meta charset="utf-8">
                                        <title>Starting Task...</title>
                                    </head>
                                    <body style="
                                        font-family: Arial, sans-serif;
                                        padding: 40px;
                                        text-align: center;
                                    ">
                                        <h3>Starting task...</h3>
                                        <p>Please wait...</p>
                                    </body>
                                    </html>
                                `);

                                taskWindow.document.close();

                            } catch (error) {
                                // Navigation below will still be attempted.
                            }
                        }
                    }


                    this.disabled =
                        true;

                    this.textContent =
                        'STARTING...';


                    try {

                        const data =
                            await postJson(
                                startUrl,
                                {}
                            );


                        const completion =
                            data.task_completion || {};

                        const startedAt =
                            data.started_at ||
                            completion.started_at;

                        const estimatedSeconds =
                            Number(
                                data.estimated_seconds ||
                                completion
                                    ?.verification_data
                                    ?.estimated_seconds ||
                                20
                            );


                        if (!startedAt) {

                            throw new Error(
                                'The server did not return a valid task start time.'
                            );
                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Navigate task window.
                        |--------------------------------------------------------------------------
                        */

                        if (
                            taskWindow &&
                            !taskWindow.closed &&
                            taskUrl
                        ) {

                            taskWindow.location.href =
                                taskUrl;

                        }
                        else if (taskUrl) {

                            /*
                            | Popup fallback.
                            |
                            | We keep the member on Kud.Earn if the popup was
                            | blocked instead of unexpectedly navigating away.
                            */

                            showMessage(
                                taskId,
                                'Your browser blocked the task window. Please allow popups for Kud.Earn and click START TASK again.',
                                'warning'
                            );
                        }


                        const card =
                            document.getElementById(
                                `task-card-${taskId}`
                            );


                        if (card) {

                            card.dataset.status =
                                'started';

                            card.dataset.startedAt =
                                Math.floor(
                                    new Date(
                                        startedAt
                                    ).getTime() / 1000
                                );

                            startHeartbeat(card, true);
                        }


                        this.remove();


                        const completeButton =
                            ensureCompleteButton(
                                taskId,
                                completeUrl,
                                taskUrl,
                                taskType,
                                estimatedSeconds
                            );


                        startCountdown(
                            taskId,
                            Math.floor(
                                new Date(
                                    startedAt
                                ).getTime() / 1000
                            ),
                            estimatedSeconds
                        );


                        showMessage(
                            taskId,
                            'Task started. Complete the required time before claiming your reward.',
                            'info'
                        );


                        if (
                            taskUrl &&
                            taskWindow &&
                            !taskWindow.closed
                        ) {

                            showMessage(
                                taskId,
                                'Task opened in a new tab. Complete the required viewing time, then return here to claim your reward.',
                                'info'
                            );
                        }


                        if (completeButton) {

                            completeButton.scrollIntoView({
                                behavior: 'smooth',
                                block: 'nearest'
                            });
                        }

                    } catch (error) {

                        if (
                            taskWindow &&
                            !taskWindow.closed
                        ) {
                            taskWindow.close();
                        }


                        this.disabled =
                            false;

                        this.textContent =
                            'START TASK';


                        showMessage(
                            taskId,
                            error.message,
                            'danger'
                        );
                    }
                }
            );
        });


    /*
    |--------------------------------------------------------------------------
    | Complete task
    |--------------------------------------------------------------------------
    */

    function attachCompleteHandler(button) {

        if (
            button.dataset.handlerAttached === '1'
        ) {
            return;
        }

        button.dataset.handlerAttached =
            '1';


        button.addEventListener(
            'click',
            async function () {

                const taskId =
                    this.dataset.taskId;

                const completeUrl =
                    this.dataset.completeUrl;


                this.disabled =
                    true;

                this.textContent =
                    'VERIFYING...';


                try {

                    const data =
                        await postJson(
                            completeUrl,
                            {}
                        );


                    setTaskStatus(
                        taskId,
                        'completed'
                    );

                    stopHeartbeat(
                        taskId
                    );

                    hideTimer(
                        taskId
                    );

                    hideVisibilityWarning(
                        taskId
                    );


                    this.className =
                        'btn btn-outline-success w-100';

                    this.disabled =
                        true;

                    this.textContent =
                        `✓ CLAIMED +${
                            Number(
                                data.reward || 0
                            ).toFixed(4)
                        }`;


                    showMessage(
                        taskId,
                        `Task completed successfully. You earned $${Number(
                            data.reward || 0
                        ).toFixed(4)}.`,
                        'success'
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | Refresh progress and wallet values.
                    |--------------------------------------------------------------------------
                    */

                    window.setTimeout(
                        function () {
                            window.location.reload();
                        },
                        1200
                    );

                } catch (error) {

                    this.disabled =
                        false;

                    this.textContent =
                        'COMPLETE TASK';


                    showMessage(
                        taskId,
                        error.message,
                        'danger'
                    );
                }
            }
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Existing completion buttons
    |--------------------------------------------------------------------------
    */

    document
        .querySelectorAll('.complete-task-btn')
        .forEach(function (button) {

            attachCompleteHandler(
                button
            );
        });


    /*
    |--------------------------------------------------------------------------
    | Restore started tasks after refresh
    |--------------------------------------------------------------------------
    */

    document
        .querySelectorAll('.daily-task-card')
        .forEach(function (card) {

            const status =
                card.dataset.status;

            const startedAt =
                card.dataset.startedAt;

            const estimatedSeconds =
                Number(
                    card.dataset.estimatedSeconds ||
                    20
                );


            if (
                status === 'started' &&
                startedAt
            ) {

                startHeartbeat(
                    card,
                    true
                );

                ensureCompleteButton(
                    card.dataset.taskId,
                    card.querySelector(
                        '.complete-task-btn'
                    )?.dataset.completeUrl ||
                    `/daily-tasks/${card.dataset.taskId}/complete`,
                    card.dataset.taskUrl,
                    card.dataset.taskType,
                    estimatedSeconds
                );


                startCountdown(
                    card.dataset.taskId,
                    Number(startedAt),
                    estimatedSeconds
                );
            }
        });


    /*
    |--------------------------------------------------------------------------
    | Open task content button
    |--------------------------------------------------------------------------
    */

    document
        .querySelectorAll(
            '.open-task-content-btn'
        )
        .forEach(function (button) {

            button.addEventListener(
                'click',
                function () {

                    const url =
                        this.dataset.taskUrl;

                    if (!url) {
                        return;
                    }

                    window.open(
                        url,
                        '_blank',
                        'noopener,noreferrer'
                    );
                }
            );
        });


    /*
    |--------------------------------------------------------------------------
    | Visibility monitoring
    |--------------------------------------------------------------------------
    |
    | Because task websites/videos open in another tab, hiding this tab is
    | expected. We therefore record visibility for audit purposes but DO NOT
    | invalidate the task merely because this page becomes hidden.
    |
    */

    document.addEventListener(
        'visibilitychange',
        function () {

            document
                .querySelectorAll(
                    '.daily-task-card'
                )
                .forEach(function (card) {

                    if (
                        card.dataset.status !== 'started'
                    ) {
                        return;
                    }


                    if (
                        document.visibilityState === 'hidden'
                    ) {

                        showVisibilityWarning(
                            card.dataset.taskId,
                            'Task is running. You may view the assigned website/video in the other tab. Return here when the required time has elapsed.'
                        );

                    } else {

                        hideVisibilityWarning(
                            card.dataset.taskId
                        );

                        sendHeartbeat(
                            card,
                            true
                        );
                    }
                });
        }
    );

});
</script>


@endsection