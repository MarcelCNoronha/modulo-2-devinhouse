<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Plan;

class SendWelcomeEmailToUser extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */

    public $user;
    public $description;
    public $limit;

    public function __construct(User $user)
    {
        $this->user = $user;
        
        // Inicializa a variável $plan
        $plan = null;

        // Captura informações do plano associado ao usuário
        try {
            $plan = Plan::findOrFail($user->plan_id);
            $this->description = $plan->description;
            $this->limit = $plan->limit;

        } catch (ModelNotFoundException $exception) {
            // Lidar com o caso em que o plano não é encontrado
            $this->description = 'Plano não encontrado';
            $this->limit = null;
        }
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Bem vindo a Academia FitManage Tech',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.welcomeUser',
        );
        echo "name", "plan", "limit";
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        // passar os anexos
        return [];
    }
}

