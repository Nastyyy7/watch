<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\User;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    // public function store(Request $request): JsonResponse|RedirectResponse
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
        ]);
        $user = User::query() ->where('email', '=', $request->only('email'))->firstOrFail();
        if ($user->hasVerifiedEmail()) {
            // return redirect()->intended(RouteServiceProvider::HOME);
            return response()->json(['redirect'=>RouteServiceProvider::HOME]);
        }

        $user->sendEmailVerificationNotification();

        return response()->json(['status' => 'verification-link-sent']);
    }
}
