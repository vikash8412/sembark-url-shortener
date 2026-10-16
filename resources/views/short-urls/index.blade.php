@extends('layouts.app')

@section('title', 'Short URLs')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h6 class="text-primary mb-0">Generated Short URLs</h6>
        <a href="{{ route('dashboard') }}" class="small">&larr; Back to dashboard</a>
    </div>

    @include('partials.short-url-table', [
        'showCompany' => auth()->user()->isSuperAdmin(),
        'showOwner' => ! auth()->user()->isMember(),
    ])
@endsection
