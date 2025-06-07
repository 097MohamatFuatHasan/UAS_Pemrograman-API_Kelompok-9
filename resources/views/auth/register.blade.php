@extends('layouts.app')

@section('title', 'Register')

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

    .register-icon {
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
                <i class="fas fa-user-plus register-icon"></i>
                <h2 class="text-success mt-2">Create an Account</h2>
                <p class="text-muted">Join us and start booking your stay today</p>
            </div>

            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="fas fa-user text-success"></i></span>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="fas fa-envelope text-success"></i></span>
                                <input type="email" class="form-control" name="email" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="fas fa-lock text-success"></i></span>
                                <input type="password" class="form-control" name="password" required>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <button type="submit" class="btn btn-green px-4">Register</button>
                            <a href="{{ route('login') }}" class="text-muted small">Already have an account?</a>
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
