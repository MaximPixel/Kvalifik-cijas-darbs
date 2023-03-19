<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="{{ route('index') }}">My Website</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact</a>
                </li>
            @if (auth()->user())
                <li class="nav-item">
                    <span class="nav-link">{{ auth()->user()->id ?? "?" }}</span>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('auth.logout') }}">Logout</a>
                </li>
            @else
            <li class="nav-item">
                <a class="nav-link" href="{{ route('auth.login') }}">Login</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('auth.register') }}">Register</a>
            </li>
            @endif
            </ul>
        </div>
    </div>
</nav>