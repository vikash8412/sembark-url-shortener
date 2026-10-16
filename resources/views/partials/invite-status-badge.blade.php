{{-- expects: $invitation (nullable). Shows nothing once accepted --}}
@if ($invitation)
    @switch($invitation->status())
        @case('pending')
            <span class="badge bg-warning text-dark ms-1"
                  title="Invited, expires {{ $invitation->expires_at->format('d M Y') }}">Pending</span>
            @break
        @case('expired')
            <span class="badge bg-secondary ms-1"
                  title="Invite expired on {{ $invitation->expires_at->format('d M Y') }}">Expired</span>
            @break
    @endswitch
@endif
