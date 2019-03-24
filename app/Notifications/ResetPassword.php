<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;

use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;

class ResetPassword extends ResetPasswordNotification
{
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Ré-initialisation de mot de passe pour ' . config('app.name'))
            ->line('Vous recevez ce message car nous avons reçu une demande de ré-initialisation de mot de passe pour votre compte.')
            ->action('Choisir un nouveau mot de passe', url('password/reset', $this->token))
            ->line("Si vous n'avez pas demandé à ré-initialiser votre mot de passe, aucune action n'est nécessaire de votre part.");
    }
}
