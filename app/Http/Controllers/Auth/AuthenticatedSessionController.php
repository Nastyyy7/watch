<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    // public function store(LoginRequest $request): Response
    public function store(LoginRequest $request): JsonResponse|Response
        // public function store(LoginRequest $request): JsonResponse
    {
        // $request->authenticate();
        // $request->session()->regenerate();
        $user = User::query() ->where('email', '=', $request->only('email'))->firstOrFail();
        // return response(json_encode($user->tokens()->firstOrFail()));
        if ($user->hasVerifiedEmail()) {
            if ($user->tokens()->count()>0) {
                $user->tokens()->delete();
            }
            $giveToken = $user -> createToken('watch', ['select-product', 'delete-product'])->plainTextToken;
            return response()->json(['token'=>$giveToken]);
                // return redirect()->intended(RouteServiceProvider::HOME);
        }

        // return response()->noContent();
        return response()->noContent()->setStatusCode(403);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): Response
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->noContent();
    }
}
