<?php

namespace App\Http\Controllers;

use App\Models\Company;

/**
 * SuperAdmin views of a single client - read only.
 */
class CompanyController extends Controller
{
    public function users(Company $company)
    {
        $teamMembers = $company->users()
            ->withCount('shortUrls')
            ->withSum('shortUrls', 'hits')
            ->orderBy('name')
            ->paginate(10);

        $pendingInvites = $company->invitations()
            ->notAccepted()
            ->latest()
            ->get();

        return view('companies.users', compact('company', 'teamMembers', 'pendingInvites'));
    }

    public function shortUrls(Company $company)
    {
        $shortUrls = $company->shortUrls()
            ->with('user:id,name')
            ->latest()
            ->paginate(10);

        return view('companies.short-urls', compact('company', 'shortUrls'));
    }
}
