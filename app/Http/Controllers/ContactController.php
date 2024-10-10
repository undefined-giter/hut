<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactFormRequest;
use App\Mail\AutoResponseMail;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ContactController extends Controller
{
    protected $adminEmail = 'leo.ripert@gmail.com';
    
    public function index()
    {
        return inertia('Contact/index', ['user' => Auth::user()]);
    }

    public function send(ContactFormRequest $request)
    {
        $validatedData = $request->validated();

        try {
            // Envoi de l'e-mail à l'administrateur (toi)
            Mail::to($this->adminEmail)->send(new ContactMail(
                $validatedData['name'],
                $validatedData['email'],
                $validatedData['phone'],
                $validatedData['message']
            ));

            // Envoi de l'e-mail de réponse automatique à l'utilisateur
            Mail::to($validatedData['email'])->send(new AutoResponseMail(
                $validatedData['name'],
                $this->adminEmail
            ));

            Session::flash('success', ['Votre message a bien été envoyé.<br>Nous reviendrons vers vous dans les plus brefs délais.']);
        } catch (\Exception $e) {
            Session::flash('error', ['Une erreur s\'est produite lors de l\'envoi de votre message. Veuillez nous contacter directement depuis votre mail ou par téléphone svp.']);
        }

        return redirect()->route(Auth::check() ? 'profile' : 'gallery');
    }
}
