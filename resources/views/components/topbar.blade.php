<div class="topbar d-flex justify-content-between align-items-center">

    <div>

        <h4 class="mb-0">

            @yield('page-title')

        </h4>

    </div>

    <div class="d-flex align-items-center gap-4">

        <div>

            <strong>

                {{ auth()->user()->name }}

            </strong>

        </div>

    </div>

</div>