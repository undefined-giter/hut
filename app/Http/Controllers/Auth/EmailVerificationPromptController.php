<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     */
    public function __invoke(Request $request): RedirectResponse|Response
    {
        return $request->user()->hasVerifiedEmail()
            ? redirect()->intended(route('login'))
            : Inertia::render('Auth/VerifyEmail', [
                'status' => session('status'),
                'translations' => [
                    'thanks_for_signing_up' => __('verification.thanks_for_signing_up'),
                    'verification_link_sent' => __('verification.verification_link_sent'),
                    'resend_verification_email' => __('verification.resend_verification_email'),
                    'log_out' => __('verification.log_out'),
                ],
            ]);
    }
}
