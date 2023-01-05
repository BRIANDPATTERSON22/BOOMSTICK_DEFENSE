<?php

namespace App\Http\Controllers\Site;

use App\ProductReview;
use App\Http\Requests\Site\ReviewRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class ReviewController extends Controller
{
    public function __construct(ProductReview $review)
    {
        $this->review = $review;

        $this->option = Cache::get('optionCache');
        // $this->middleware('auth');
    }

    public function post_review(ReviewRequest $request, $pid)
    {
        // dd($request->all());
        
        if(session('user')) {
            $user_id = Auth::id();
        }
        else{
            $user_id = null;
        }

        $this->review->fill($request->all());
        $this->review->product_id = $pid;
        $this->review->user_id = $user_id;
        $this->review->save();

        //Get all the data and store it inside Store Variable
        // $data = [
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'phone' => $request->phone,
        //     'enquiry' => $request->review,
        //     'siteEmail' => $this->option->site_email,
        //     'siteName' => $this->option->name,
        //     ];

        //---SEND ENQUIRY EMAIL TO ADMIN---//
        // Mail::send('emails.review.enquiry', $data, function($message) use ($data)
        // {
        //     $message->subject('Review Enquiry - '.$data['siteName']);
        //     $message->from('no-reply@ezbooking.io', $data['name']);
        //     $message->to($data['siteEmail'], $data['siteName'].' Admin');

        // });

        //---SEND ACKNOWLEDGEMENT EMAIL TO USER---//
        // Mail::send('emails.review.confirmation', $data, function($message) use ($data)
        // {
        //     $message->subject('Review Confirmation - '.$data['siteName']);
        //     $message->from('no-reply@ezbooking.io', $data['siteName'].' Admin');
        //     $message->to($data['email']);

        // });

        return redirect()->back()->with('success', 'Your review has been successfully received, We will review you soon');
    }
}