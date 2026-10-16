<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;

class AcceptInvitationController extends Controller
{
    public function show(string $token)
    {
        $invitation = $this->findValidInvitation($token);

        return view('auth.accept-invitation', compact('invitation'));
    }

    public function store(Request $request, string $token)
    {
        $invitation = $this->findValidInvitation($token);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        if (User::where('email', $invitation->email)->exists()) {
            abort(409, 'An account with this email already exists.');
        }

        $user = DB::transaction(function () use ($invitation, $validated) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $invitation->email,
                'password' => $validated['password'],
                'company_id' => $invitation->company_id,
                'role' => $invitation->role,
            ]);

            $invitation->update(['accepted_at' => now()]);

            return $user;
        });

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }

    private function findValidInvitation(string $token): Invitation
    {
        $invitation = Invitation::with('company')
            ->where('token', $token)
            ->firstOrFail();

        if ($invitation->isAccepted() || $invitation->isExpired()) {
            abort(410, 'This invitation link is no longer valid.');
        }

        return $invitation;
    }
}
