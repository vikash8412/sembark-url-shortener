<?php

namespace App\Http\Controllers;

use App\Notifications\InvitationNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

/**
 * Admin invites another Admin or Member into their own company.
 */
class TeamInvitationController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'role' => ['required', Rule::in(['admin', 'member'])],
        ], [
            'email.unique' => 'A user with this email already exists.',
        ]);

        // company always comes from the logged in admin, never from the request
        $invitation = $request->user()->company->invitations()->create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'token' => Str::random(64),
            'expires_at' => now()->addDays(7),
        ]);

        Notification::route('mail', $invitation->email)
            ->notify(new InvitationNotification($invitation));

        return redirect()
            ->route('dashboard')
            ->with('success', 'Invitation sent to '.$invitation->email)
            ->with('invite_link', route('invitations.show', $invitation->token));
    }
}
