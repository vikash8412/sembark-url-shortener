<?php

namespace App\Http\Controllers;

use App\Models\ShortUrl;
use Illuminate\Http\Request;

class ShortUrlController extends Controller
{
    public function index(Request $request)
    {
        $shortUrls = ShortUrl::visibleTo($request->user())
            ->with(['user:id,name', 'company:id,name'])
            ->latest()
            ->paginate(10);

        return view('short-urls.index', compact('shortUrls'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'original_url' => ['required', 'url:http,https', 'max:2048'],
        ]);

        $user = $request->user();

        $shortUrl = ShortUrl::create([
            'company_id' => $user->company_id,
            'user_id' => $user->id,
            'original_url' => $validated['original_url'],
            'code' => ShortUrl::generateUniqueCode(),
        ]);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Short URL created: '.$shortUrl->short_link);
    }

    /**
     * Public route - no auth needed.
     */
    public function redirect(string $code)
    {
        $shortUrl = ShortUrl::where('code', $code)->firstOrFail();

        $shortUrl->increment('hits');

        return redirect()->away($shortUrl->original_url);
    }
}
