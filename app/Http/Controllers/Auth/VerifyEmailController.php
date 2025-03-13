<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    // public function __invoke(EmailVerificationRequest $request, int $id): RedirectResponse
    public function __invoke(EmailVerificationRequest $request, int $id): JsonResponse
    {
        $user = User::query()->findOrFail($id);
        // return json_encode($user);
        if ($user->hasVerifiedEmail()) {
            // return redirect()->intended(
            //     config('app.frontend_url').RouteServiceProvider::HOME.'?verified=1'
            // );
            return response()->json(
                ['redirect'=>config('app.frontend_url')]
            );
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        // return redirect()->intended(
        //     config('app.frontend_url').RouteServiceProvider::HOME.'?verified=1'
        // );
        return response()->json(
            ['redirect'=>config('app.frontend_url')]
        );
    }
}
