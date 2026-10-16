{{-- expects: $shortUrls (paginator), optional $showOwner, $showCompany --}}
<div class="table-responsive">
    <table class="table table-sm table-bordered bg-white align-middle mb-2" id="short-url-table">
        <thead>
            <tr class="text-secondary small">
                <th>Short URL</th>
                <th>Long URL</th>
                <th>Hits</th>
                @if ($showCompany ?? false)
                    <th>Company</th>
                @endif
                @if ($showOwner ?? false)
                    <th>Created By</th>
                @endif
                <th>Created On</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($shortUrls as $shortUrl)
                <tr>
                    <td>
                        <a href="{{ $shortUrl->short_link }}" target="_blank">{{ $shortUrl->short_link }}</a>
                    </td>
                    <td class="text-truncate" style="max-width: 280px;" title="{{ $shortUrl->original_url }}">
                        {{ $shortUrl->original_url }}
                    </td>
                    <td>{{ $shortUrl->hits }}</td>
                    @if ($showCompany ?? false)
                        <td>{{ $shortUrl->company?->name }}</td>
                    @endif
                    @if ($showOwner ?? false)
                        <td>{{ $shortUrl->user?->name }}</td>
                    @endif
                    <td>{{ $shortUrl->created_at->format('d M \'y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-secondary">
                        No short URLs yet.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="d-flex justify-content-between align-items-center small">
    <span>Showing {{ $shortUrls->count() }} of total {{ $shortUrls->total() }}</span>
    {{ $shortUrls->links('pagination::simple-bootstrap-5') }}
</div>
