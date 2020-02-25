<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;

class APIMaintenance extends Mailable
{
    use Queueable, SerializesModels;

    private $username, $request;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($username, Request $request)
    {
        $this->username=$username;
        $this->request=$request;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.notification')->subject($this->request->subject)->with(["username"=>$this->username,"reason"=>$this->request->reason]);
    }
}
