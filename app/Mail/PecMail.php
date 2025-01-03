<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PecMail extends Mailable
{
    use Queueable, SerializesModels;
    public $details;
    public $filePath ;
    public $fileName;

    /**
     * Create a new message instance.
     */
    public function __construct($details, $filePath , $fileName)
    {
        $this->details = $details;
        $this->filePath  = $filePath ;
        $this->fileName = $fileName;
    }
    /**
     * Get the message envelope.
     */

    public function build()
    {
        return $this->from(config('mail.from.pec_address'))
            ->subject("COMUNICAZIONE DI OSPITALITA’ IN FAVORE DI CITTADINO EXTRACOMUNITARIO")
            ->view('emails.pec_mail')
            ->with('details', $this->details)
            ->attach($this->filePath, [
              'as' => $this->fileName,
              'mime' => 'application/pdf',
          ]);
    }
}
