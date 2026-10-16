@extends('layouts.app')

@section('title', 'Accept Invitation')

@section('content')
    <h6 class="text-primary">Join {{ $invitation->company->name }}</h6>
    <p class="small text-secondary">
        You were invited as <strong>{{ $invitation->role }}</strong> ({{ $invitation->email }}).
        Set your name and password to continue.
    </p>

    <form method="POST" action="{{ route('invitations.accept', $invitation->token) }}" style="max-width: 320px;">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label small">Name</label>
            <input type="text" name="name" id="name" class="form-control"
                   value="{{ old('name', $invitation->name) }}" required autofocus>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label small">Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label small">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation"
                   class="form-control" required>
        </div>

        <button type="submit" class="btn btn-app">Create Account</button>
    </form>
@endsection
