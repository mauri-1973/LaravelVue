<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmailInfo extends Mailable
{
    use Queueable, SerializesModels;

    public array $content;

    public function __construct(array $content) {
        $this->content = $content;
    }

    
    public function build()
     {
         $user['name'] = $this->content['nombre'];
         $user['pass'] = $this->content['pass'];
         $user['email'] = $this->content['email'];
         $user['mensaje'] = $this->content['mensaje'];
 
         return $this->from("contacto@mymasesoreslegales.cl", "Contacto Nueva Plataforma")
         ->subject($this->content['asunto'])
         ->view('emails.notificaciones', ['user' => $user]);
     }
}
