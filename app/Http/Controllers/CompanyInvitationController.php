<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Invitation;
use App\Notifications\InvitationNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

/**
 * SuperAdmin invites an Admin into a brand new company (client).
 */
class CompanyInvitationController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_name' => ['required', 'string', 'min:2', 'max:255'],
            'admin_email' => ['required', 'email', 'max:255', 'unique:users,email'],
        ], [
            'admin_email.unique' => 'A user with this email already exists.',
        ]);

        $invitation = DB::transaction(function () use ($validated) {
            $company = Company::create([
                'name' => $validated['company_name'],
            ]);

            return $company->invitations()->create([
                'email' => $validated['admin_email'],
                'role' => 'admin',
                'token' => Str::random(64),
                'expires_at' => now()->addDays(7),
            ]);
        });

        Notification::route('mail', $invitation->email)
            ->notify(new InvitationNotification($invitation));

        return redirect()
            ->route('dashboard')
            ->with('success', 'Invitation sent to '.$invitation->email)
            ->with('invite_link', route('invitations.show', $invitation->token));
    }
}
