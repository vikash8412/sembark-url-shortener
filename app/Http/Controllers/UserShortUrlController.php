<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

/**
 * Short urls created by one user. SuperAdmin can open any user,
 * Admin only users of their own company.
 */
class UserShortUrlController extends Controller
{
    public function index(Request $request, User $member)
    {
        $user = $request->user();

        if ($user->isAdmin() && $member->company_id !== $user->company_id) {
            abort(403, 'This user is not in your company.');
        }

        $shortUrls = $member->shortUrls()
            ->latest()
            ->paginate(10);

        return view('users.short-urls', compact('member', 'shortUrls'));
    }
}
