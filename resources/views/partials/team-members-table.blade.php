{{-- expects: $teamMembers (paginator), optional $currentUserId to highlight that row --}}
<div class="table-responsive">
    <table class="table table-sm table-bordered bg-white align-middle mb-2">
        <thead>
            <tr class="text-secondary small">
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Total Generated URLs</th>
                <th>Total URL Hits</th>
            </tr>
        </thead>
        <tbody>
            {{-- invited but not joined yet - shown on the first page only --}}
            @if ($teamMembers->onFirstPage())
                @foreach ($pendingInvites ?? [] as $invite)
                    <tr class="text-secondary">
                        <td>
                            {{ $invite->name ?? '-' }}
                            @include('partials.invite-status-badge', ['invitation' => $invite])
                        </td>
                        <td>{{ $invite->email }}</td>
                        <td class="text-capitalize">{{ $invite->role }}</td>
                        <td>-</td>
                        <td>-</td>
                    </tr>
                @endforeach
            @endif

            @forelse ($teamMembers as $member)
                @php($isMe = $member->id === ($currentUserId ?? null))

                <tr @class(['table-warning fw-semibold' => $isMe])>
                    <td>
                        {{ $member->name }}
                        @if ($isMe)
                            <span class="badge bg-secondary ms-1">Me</span>
                        @endif
                    </td>
                    <td>{{ $member->email }}</td>
                    <td class="text-capitalize">{{ $member->role }}</td>
                    <td>
                        <a href="{{ route('users.short-urls', $member) }}">{{ $member->short_urls_count }}</a>
                    </td>
                    <td>{{ (int) $member->short_urls_sum_hits }}</td>
                </tr>
            @empty
                @if (collect($pendingInvites ?? [])->isEmpty())
                    <tr>
                        <td colspan="5" class="text-center text-secondary">
                            No team members yet.
                        </td>
                    </tr>
                @endif
            @endforelse
        </tbody>
    </table>
</div>

<div class="d-flex justify-content-between align-items-center small">
    <span>Showing {{ $teamMembers->count() }} of total {{ $teamMembers->total() }}</span>
    {{ $teamMembers->links('pagination::simple-bootstrap-5') }}
</div>
