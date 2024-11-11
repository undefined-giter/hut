<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactFormRequest;
use App\Mail\ContactAutoResponseMail;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class ContactController extends Controller
{
    public function index(): Response
    {
        $adminPhone = config('admin.phone');
        
        return inertia('Contact/index', [
            'user' => Auth::user(),
            'adminPhoneHref' => $adminPhone,
            'adminPhone' => format_phone_number($adminPhone),
        ]);
    }

    /**
     * Send contact mail
     */
    public function send(ContactFormRequest $request): RedirectResponse
    {
        try {
            $validatedData = $request->validated();

            Mail::to(config('admin.email'))->send(new ContactMail(
                $validatedData['name'],
                $validatedData['email'],
                $validatedData['phone'],
                $validatedData['message']
            ));

            Mail::to($validatedData['email'])->send(new ContactAutoResponseMail(
                $validatedData['name']
            ));

            Session::flash('success', ['Votre message a bien été envoyé.<br>Nous reviendrons vers vous dans les plus brefs délais.']);
        } catch (\Exception $e) {
            Session::flash('error', ['Une erreur s\'est produite lors de l\'envoi de votre message. Veuillez nous contacter directement par mail ou par téléphone svp.']);
        }

        return redirect()->route(Auth::check() ? 'profile' : 'gallery');
    }
}
