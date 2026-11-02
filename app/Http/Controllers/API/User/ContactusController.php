<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use PhpParser\Node\Scalar\String_;

class ContactusController extends Controller
{
    use ApiResponse;

    public function send_email(ContactUs $contact_us)
    {
        $message    = 'New Contact Form';
        Mail::to('sandipsarke96@gmail.com')->send(new \App\Mail\ContactMail($contact_us, $message));
        return true;
    }

    public function contactSubmit(Request $request)
    {

        $request->validate([
            'name'      => 'required',
            'email'     => 'required|email',
            'subject'   => 'required',
            'message'   => 'required',
        ]);


        $contact_us = Contactus::create([
            'user_id' => auth()->id(),
            'name'    => $request->name,
            'email'   => $request->email,
            'phone'   => $request->phone,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        // $this->send_email($contact_us);

        if (!$contact_us) {
            return $this->error('Some thing is wrong', 404);
        }

        return $this->success('Data save successfully',$contact_us, 200);
    }
}
