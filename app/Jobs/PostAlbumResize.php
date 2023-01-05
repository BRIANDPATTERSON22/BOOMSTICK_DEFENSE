<?php

namespace App\Jobs;

use App\ProfilePhoto;
use App\ProfilePost;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class PostAlbumResize implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $post;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(ProfilePost $post)
    {
        $this->post = $post;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $photos = ProfilePhoto::where('profile_album_id', $this->post->id)->get();

        if(count($photos)>0) {
            foreach ($photos as $oPhoto) {
                if(Storage::exists('profiles/' . $oPhoto->profile_id . '/photos/' . $oPhoto->profile_album_id . '/' . $oPhoto->image)) {
                    $image = Storage::url('profiles/' . $oPhoto->profile_id . '/photos/' . $oPhoto->profile_album_id . '/' . $oPhoto->image);
                    //Small
                    if (!Storage::exists('profiles/' . $oPhoto->profile_id . '/photos/' . $oPhoto->profile_album_id . '/small_' . $oPhoto->image)) {
                        $imagepath = 'profiles/' . $oPhoto->profile_id . '/photos/' . $oPhoto->profile_album_id . '/small_' . $oPhoto->image;
                        $smallimg = Image::make($image)->widen(100, function ($constraint) {
                            $constraint->upsize();
                        })->encode('jpg');
                        Storage::put($imagepath, $smallimg->__toString(), 'public');
                    }
                    //Medium
                    if (!Storage::exists('profiles/' . $oPhoto->profile_id . '/photos/' . $oPhoto->profile_album_id . '/medium_' . $oPhoto->image)) {
                        $imagepath = 'profiles/' . $oPhoto->profile_id . '/photos/' . $oPhoto->profile_album_id . '/medium_' . $oPhoto->image;
                        $smallimg = Image::make($image)->widen(600, function ($constraint) {
                            $constraint->upsize();
                        })->encode('jpg');
                        Storage::put($imagepath, $smallimg->__toString(), 'public');
                    }
                }
            }
        }

    }
}
