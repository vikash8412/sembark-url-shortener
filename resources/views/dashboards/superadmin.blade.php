
@extends('layouts.app')

@section('title', 'SuperAdmin Dashboard')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1"> {{ $user->name }} </h2>
        </div>

        <button class="btn btn-app" data-bs-toggle="modal" data-bs-target="#inviteClientModal" >
            Invite New Client
        </button>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-secondary">Total Clients</h6>
                    <h3>{{ $totalClients }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-secondary">Total Admins</h6>
                    <h3>{{ $totalAdmins }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-secondary">Total Users</h6>
                    <h3>{{ $totalUsers }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-secondary">Total Short URLs</h6>
                    <h3>{{ $totalShortUrls }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <h5>Clients</h5>

            <div class="table-responsive">
                <table class="table table-sm table-bordered bg-white align-middle mb-2" id="clients-table">
                    <thead>
                        <tr>
                            <th>Client Name</th>
                            <th>Users</th>
                            <th>Total Generated URLs</th>
                            <th>Total URL Hits</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($companies as $company)
                            <tr>
                                <td>
                                    {{ $company->name }}
                                    @include('partials.invite-status-badge', ['invitation' => $company->clientInvitation])
                                    @if ($company->clientInvitation)
                                        <div class="small text-secondary">{{ $company->clientInvitation->email }}</div>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('companies.users', $company) }}">{{ $company->users_count }}</a>
                                </td>
                                <td>
                                    <a href="{{ route('companies.short-urls', $company) }}">{{ $company->short_urls_count }}</a>
                                </td>
                                <td>{{ (int) $company->short_urls_sum_hits }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-secondary">
                                    No companies available.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center small">
                <span>Showing {{ $companies->count() }} of total {{ $companies->total() }}</span>
                {{ $companies->links('pagination::simple-bootstrap-5') }}
            </div>
        </div>
    </div>

    @include('modals.invite')
@endsection
