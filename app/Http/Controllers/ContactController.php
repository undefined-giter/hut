<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactFormRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ContactController extends Controller
{
    public function index()
    {
        return inertia('Contact/index', ['user' => Auth::user()]);
    }

    public function send(ContactFormRequest $request)
    {
        $validatedData = $request->validated();

        Mail::to('leo.ripert@gmail.com')->send(new ContactMail(
            $validatedData['name'],
            $validatedData['email'],
            $validatedData['message']
        ));

        Session::flash('success', ['Votre message a bien été envoyé.<br>Nous reviendrons vers vous dans les plus brefs délais.']);

        if (Auth::check()) {
            return Inertia::location(route('profile.edit'));
        } else {
            return Inertia::location(route('gallery'));
        }
    }
}
