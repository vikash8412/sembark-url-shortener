@extends('layouts.app')

@section('title', 'Member Dashboard')

@section('content')
    <h2>{{ $user->name }}</h2>

    @include('partials.generate-form')

    <h6 class="text-primary">Generated Short URLs</h6>

    @include('partials.short-url-table')
@endsection
