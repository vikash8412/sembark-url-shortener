@extends('layouts.app')

@section('title', $member->name.' - Short URLs')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">{{ $member->name }} - Generated Short URLs</h2>

        <a href="{{ url()->previous() }}" class="small">&larr; Back</a>
    </div>

    @include('partials.short-url-table')
@endsection
