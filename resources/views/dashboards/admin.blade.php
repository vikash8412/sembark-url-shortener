@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <h2>Company - {{ $user->company?->name }}</h2>

    @include('partials.generate-form')

    <div class="d-flex justify-content-between align-items-center mt-4 mb-2">
        <h6 class="text-primary mb-0">
            Team Members
            <a href="{{ route('short-urls.index') }}" class="small fw-normal ms-2">
                All company URLs ({{ $companyUrlCount }})
            </a>
        </h6>

        <button class="btn btn-app" data-bs-toggle="modal" data-bs-target="#inviteMemberModal">
            Invite
        </button>
    </div>

    @include('partials.team-members-table', ['currentUserId' => $user->id])

    @include('modals.invite-member')
@endsection
