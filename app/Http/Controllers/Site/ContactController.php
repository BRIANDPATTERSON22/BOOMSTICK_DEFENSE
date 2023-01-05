<?php

namespace App\Http\Controllers\Site;

use App\Page;
use App\Contact;
use App\Http\Requests\Site\ContactRequest;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;

class ContactController extends Controller
{

    public function __construct(Contact $contact, Page $page)
    {
        $this->module = "contact";
        $this->option = Cache::get('optionCache');
        $this->data = $contact;
        $this->page = $page;
        $this->middleware('guest');
    }

    public function get_contact()
    {
        $module = $this->module;
        $page = $this->page->where('slug', 'like', '%'.$module.'%')->where('status', 1)->first();

        if($page) {
            return view('site.' . $module . '.contact', compact('page'));
        }
        else{
            return view('site.errors.404');
        }
    }

    public function post_contact(ContactRequest $request)
    {
        $option = $this->option;

        $this->data->fill($request->all());
        $this->data->status = 1;
        $this->data->save();

        try {
            //Get all the data and store it inside Store Variable
            $data = [
                'name' => $request->first_name,
                'email' => $request->email,
                'phone' => $request->phone_no,
                'subject' => $request->subject,
                'enquiry' => $request->inquiry,
                'contactReason' => $request->contact_reason,
                'orderNo' => $request->order_no,
                'siteEmail' => $option->email,
                'siteName' => $option->name,
                ];

            //---SEND ENQUIRY EMAIL TO ADMIN---//
            Mail::send('emails.contact.enquiry', $data, function($message) use ($data)
            {
                $message->subject(config('default.contactReason')[$data['contactReason']] . ' - '.$data['siteName'])
                    ->from($data['email'] , $data['name'])
                    ->to($data['siteEmail'], $data['siteName']);
            });

            //---SEND ACKNOWLEDGEMENT EMAIL TO USER---//
            Mail::send('emails.contact.confirmation', $data, function($message) use ($data)
            {
                $message->subject('Enquiry Confirmation - '.$data['siteName'])
                    ->from($data['siteEmail'], $data['siteName'])
                    ->to($data['email'], $data['name']);
            });
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Enquiry sending failed! Please try again.');
        }

        return redirect('/')->with('success', 'Your Enquiry has been successfully received, We will contact you soon');
    }
}