<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request): RedirectResponse
    {
        $request->validate([
            'name'    => ['required', 'string', 'max:255'],
            'email'   => ['required', 'email'],
            'phone'   => ['nullable', 'string', 'max:20'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'min:20', 'max:3000'],
            'type'    => ['required', 'in:general,billing,support,partnership'],
        ]);


        $phoneLine = $request->filled('phone')
        ? "Phone: {$request->phone}\n"
        : '';

        // Send email to admin
        Mail::raw(
            "Contact Form Submission\n\n" .
            "From: {$request->name} ({$request->email})\n" .
            $phoneLine .
            "Type: {$request->type}\n" .
            "Subject: {$request->subject}\n\n" .
            "Message:\n{$request->message}",
            function ($msg) use ($request) {
                $msg->to(config('mail.from.address', 'admin@jobsnepal.com'))
                    ->replyTo($request->email, $request->name)
                    ->subject('[JobsNepal Contact] ' . $request->subject);
            }
        );

        return back()->with('success',
            'Thank you for your message! We will get back to you within 24 hours.');
    }
}
