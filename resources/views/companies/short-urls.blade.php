@extends('layouts.app')

@section('title', $company->name.' - Short URLs')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">{{ $company->name }} - Generated Short URLs</h2>

        <a href="{{ route('dashboard') }}" class="small">&larr; Back to Dashboard</a>
    </div>

    @include('partials.short-url-table', ['showOwner' => true])
@endsection
