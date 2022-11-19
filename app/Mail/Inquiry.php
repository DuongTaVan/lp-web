<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Inquiry extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * @var $title
     * @var $course
     * @var $teacherName
     */
    protected $title;
    protected $fullName;
    protected $email;
    protected $type;
    protected $subjectTitle;
    protected $urlImage;
    protected $contentInquiry;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($title, $fullName, $email, $type, $subjectTitle, $contentInquiry, $urlImage)
    {
        $this->title = $title;
        $this->fullName = $fullName;
        $this->email = $email;
        $this->type = $type;
        $this->subjectTitle = $subjectTitle;
        $this->contentInquiry = $contentInquiry;
        $this->urlImage = $urlImage;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->title)
            ->view('client.student-mypage.inquiry-email')
            ->with([
                'fullName' => $this->fullName,
                'email' => $this->email,
                'type' => $this->type,
                'subjectTitle' => $this->subjectTitle,
                'contentInquiry' => $this->contentInquiry,
                'urlImage' => $this->urlImage
            ]);
    }
}
