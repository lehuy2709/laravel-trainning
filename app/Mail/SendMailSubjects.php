<?php

namespace App\Mail;

use App\Models\Subject;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMailSubjects extends Mailable
{
    use Queueable, SerializesModels;
    protected $subjects;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Subject $subjects)
    {
        //
        $this->subjects = $subjects;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subjectsNotYet = $this->subjects;
        return $this->view('emails.sendMailSubjects',compact('subjectsNotYet'));
    }
}
