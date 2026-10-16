<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Company, Invitation, User, ShortUrl};

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->isSuperAdmin()) {
            // clientInvitation gives the admin email + Pending/Expired status
            $companies = Company::with('clientInvitation')
                ->withCount(['users', 'shortUrls'])
                ->withSum('shortUrls', 'hits')
                ->latest()
                ->paginate(10);

            return view('dashboards.superadmin', [
                'user' => $user,
                'companies' => $companies,
                'totalClients' => Company::count(),
                'totalUsers' => User::where('role', 'member')->count(),
                'totalAdmins' => User::where('role', 'admin')->count(),
                'totalShortUrls' => ShortUrl::count(),
            ]);
        }

        if ($user->isAdmin()) {
            $teamMembers = User::where('company_id', $user->company_id)
                ->withCount('shortUrls')
                ->withSum('shortUrls', 'hits')
                ->orderBy('name')
                ->paginate(10);

            $pendingInvites = Invitation::where('company_id', $user->company_id)
                ->notAccepted()
                ->latest()
                ->get();

            return view('dashboards.admin', [
                'user' => $user,
                'teamMembers' => $teamMembers,
                'pendingInvites' => $pendingInvites,
                // urls are opened from the team table (UserShortUrlController)
                'companyUrlCount' => ShortUrl::visibleTo($user)->count(),
            ]);
        }

        if ($user->isMember()) {
            $shortUrls = ShortUrl::visibleTo($user)
                ->latest()
                ->paginate(10);

            return view('dashboards.member', compact('user', 'shortUrls'));
        }

        abort(403, 'Unauthorized role.');
    }
}
