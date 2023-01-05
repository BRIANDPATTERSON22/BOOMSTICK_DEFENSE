<?php

namespace App\Jobs;

use App\ProfilePost;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class PostImageResize implements ShouldQueue
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
        if(Storage::exists('profiles/'.$this->post->profile_id.'/posts/'.$this->post->image)) {
            $image = Storage::url('profiles/' . $this->post->profile_id . '/posts/' . $this->post->image);
            //Small
            if (!Storage::exists('profiles/' . $this->post->profile_id . '/posts/small_' . $this->post->image)) {
                $imagepath = 'profiles/' . $this->post->profile_id . '/posts/small_' . $this->post->image;
                $smallimg = Image::make($image)->widen(100, function ($constraint) {
                    $constraint->upsize();
                })->encode('jpg');
                Storage::put($imagepath, $smallimg->__toString(), 'public');
            }
            //Medium
            if (!Storage::exists('profiles/' . $this->post->profile_id . '/posts/medium_' . $this->post->image)) {
                $imagepath = 'profiles/' . $this->post->profile_id . '/posts/medium_' . $this->post->image;
                $smallimg = Image::make($image)->widen(600, function ($constraint) {
                    $constraint->upsize();
                })->encode('jpg');
                Storage::put($imagepath, $smallimg->__toString(), 'public');
            }
        }
    }
}
