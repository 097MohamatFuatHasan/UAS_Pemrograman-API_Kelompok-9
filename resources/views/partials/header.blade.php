<header class="navbar navbar-expand-lg navbar-light" style="background-color: #38a169;">
    <div class="container">
        <a class="navbar-brand text-white fw-bold" href="{{ url('/') }}">
            <i class="bi bi-house"></i> HotelBooking
        </a>
        <button class="navbar-toggler border-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            @auth
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ auth()->user()->role === 'admin' ? route('admin.hotels.index') : route('hotels.index') }}">
                        <i class="bi bi-house-door"></i> Hotels
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ auth()->user()->role === 'admin' ? route('admin.bookings.index') : route('bookings.index') }}">
                        <i class="bi bi-calendar-check"></i> Bookings
                    </a>
                </li>
            </ul>
            @endauth

            <ul class="navbar-nav ms-auto">
                @auth
                    @if(auth()->user()->role === 'admin')
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('admin.dashboard') }}">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                    @endif
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i> {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('bookings.index') }}">
                                    <i class="bi bi-journal-bookmark"></i> My Bookings
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="bi bi-box-arrow-right"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('login') }}">
                            <i class="bi bi-box-arrow-in-right"></i> Login
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('register') }}">
                            <i class="bi bi-pencil-square"></i> Register
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</header>
