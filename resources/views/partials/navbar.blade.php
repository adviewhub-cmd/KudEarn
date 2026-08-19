<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container">

        <a class="navbar-brand fw-bold" href="/">
            KUD.EARN
        </a>

        <button class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbar">

            <span class="navbar-toggler-icon"></span>

        </button>

        <div class="collapse navbar-collapse" id="navbar">

            <ul class="navbar-nav ms-auto">

                <li class="nav-item">
                    <a class="nav-link" href="/">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('plans') }}">
    Investment Plans
</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">FAQ</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">Contact</a>
                </li>

                @guest

                    <li class="nav-item ms-3">
                        <a class="btn btn-light"
                           href="{{ route('login') }}">
                            Login
                        </a>
                    </li>

                    <li class="nav-item ms-2">
                        <a class="btn btn-warning"
                           href="{{ route('register') }}">
                            Register
                        </a>
                    </li>

                @endguest

                @auth

                    <li class="nav-item ms-3">
                        <a class="btn btn-warning"
                           href="{{ route('dashboard') }}">
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                        href="{{ route('investments.index') }}">
                            My Investments
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('daily-tasks.index') }}">
                            Daily Tasks
                        </a>
                    </li>
                @endauth

            </ul>

        </div>

    </div>
</nav>