<div class="col-lg-4 mb-4">

    <div class="card shadow-sm">

        <div class="card-body">

            <h5>

                {{ $task->title }}

            </h5>

            <p>

                {{ $task->description }}

            </p>

            <hr>

            <strong>

                Reward

            </strong>

            ${{ number_format($task->reward,4) }}

            <br>

            <strong>

                Type

            </strong>

            {{ ucfirst($task->task_type) }}

            <br>

            <strong>

                Time

            </strong>

            {{ $task->estimated_seconds }} sec

            <br><br>

            @if($task->status=='pending')

                <span class="badge bg-warning">

                    Pending

                </span>

            @elseif($task->status=='started')

                <span class="badge bg-primary">

                    In Progress

                </span>

            @else

                <span class="badge bg-success">

                    Completed

                </span>

            @endif

            <hr>

            @if($task->status=='pending')

                <button
                    class="btn btn-primary w-100 start-task"
                    data-id="{{ $task->id }}">

                    Start Task

                </button>

            @elseif($task->status=='started')

                <button
                    class="btn btn-success w-100 complete-task"
                    data-id="{{ $task->id }}">

                    Complete Task

                </button>

            @else

                <button
                    class="btn btn-secondary w-100"
                    disabled>

                    Reward Paid

                </button>

            @endif

        </div>

    </div>

</div>