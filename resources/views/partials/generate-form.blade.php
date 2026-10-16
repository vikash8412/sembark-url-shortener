<h6 class="text-primary">Generate Short URL</h6>

<form method="POST" action="{{ route('short-urls.store') }}" class="border border-dark bg-white p-3 mb-4">
    @csrf

    <label for="original_url" class="form-label small">Long URL</label>

    <div class="d-flex gap-2">
        <input type="url" name="original_url" id="original_url" class="form-control"
               placeholder="e.g. https://sembark.com/travel-software/features/best-itinerary-builder"
               value="{{ old('original_url') }}" required>

        <button type="submit" class="btn btn-app px-4">Generate</button>
    </div>
</form>
