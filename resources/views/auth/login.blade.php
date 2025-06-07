@extends('layouts.app')

@section('title', 'Login')

@section('content')
<style>
    body {
        background: #eafaf1;
    }

    .card {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 4px 20px rgba(0, 128, 0, 0.1);
    }

    .btn-green {
        background-color: #4CAF50;
        border: none;
        color: white;
    }

    .btn-green:hover {
        background-color: #45a049;
    }

    .form-label {
        font-weight: 500;
    }

    .form-control {
        border-radius: 0.5rem;
    }

    .hotel-icon {
        font-size: 3rem;
        color: #4CAF50;
    }

    .error-alert {
        background-color: #f8d7da;
        border: 1px solid #f5c2c7;
        border-radius: 0.5rem;
        padding: 1rem;
        color: #842029;
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="text-center mb-4">
                <i class="fas fa-hotel hotel-icon"></i>
                <h2 class="text-success mt-2">Welcome Back</h2>
                <p class="text-muted">Login to book your next stay</p>
            </div>

            <div class="card">
                <div class="card-body">
                    <form id="login-form" method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="fas fa-envelope text-success"></i></span>
                                <input type="email" class="form-control" name="email" id="email" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="fas fa-lock text-success"></i></span>
                                <input type="password" class="form-control" name="password" id="password" required>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <button type="submit" class="btn btn-green px-4">Login</button>
                            <a href="{{ route('register') }}" class="text-muted small">Don't have an account?</a>
                        </div>
                    </form>

                    @if ($errors->any())
                        <div class="mt-3 error-alert">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
document.getElementById('login-form').addEventListener('submit', function(e) {
    e.preventDefault(); // Uncomment this only if using API-based login
    Custom JS login (if using axios API)
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    axios.post('/api/login', { email, password })
        .then(response => {
            localStorage.setItem('authToken', response.data.access_token);
            window.location.href = '/';
        })
        .catch(error => {
            alert('Login failed. Please check your credentials.');
            console.error(error);
        });
});
</script>
@endsection
