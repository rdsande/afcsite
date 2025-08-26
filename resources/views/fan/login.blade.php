@extends('layouts.app')

@section('title', 'Fan Login - AZAM FC')

@section('content')
<div class="uk-section uk-section-default">
    <div class="uk-container uk-container-small">
        <div class="uk-card uk-card-default uk-card-body uk-box-shadow-large">
            <div class="uk-text-center uk-margin-bottom">
                <h1 class="uk-heading-medium uk-text-primary">Welcome Back!</h1>
                <p class="uk-text-lead">Login to your AZAM FC fan account</p>
            </div>

            @if ($errors->any())
            <div class="uk-alert-danger" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <ul class="uk-list">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if (session('success'))
            <div class="uk-alert-success" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p>{{ session('success') }}</p>
            </div>
            @endif

            <form method="POST" action="{{ route('fan.login.submit') }}" class="uk-form-stacked">
                @csrf

                <!-- Phone Number -->
                <div class="uk-margin">
                    <label class="uk-form-label" for="phone">Phone Number</label>
                    <div class="uk-form-controls">
                        <input class="uk-input uk-form-large" id="phone" name="phone" type="tel"
                            placeholder="Enter your phone number" value="{{ old('phone') }}" required>
                    </div>
                </div>

                <!-- Password -->
                <div class="uk-margin">
                    <label class="uk-form-label" for="password">Password</label>
                    <div class="uk-form-controls">
                        <input class="uk-input uk-form-large" id="password" name="password"
                            type="password" placeholder="Enter your password" required>
                    </div>
                </div>

                <div class="uk-margin uk-text-center">
                    <button class="uk-button uk-button-primary uk-button-large uk-width-1-1" type="submit">
                        <span uk-icon="sign-in"></span> Login
                    </button>
                </div>

                <div class="uk-text-center uk-margin">
                    <p>Don't have an account? <a href="{{ route('fan.register') }}" class="uk-link">Register here</a></p>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection