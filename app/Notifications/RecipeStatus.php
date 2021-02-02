<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Recipe;
use App\Models\User;

class RecipeStatus extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The user model.
     *
     * @var App\Models\User
     */
    private $user;

    /**
     * The recipe model.
     *
     * @var App\Models\Recipe
     */
    private $recipe;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user, Recipe $recipe)
    {
        $this->user = $user;
        $this->recipe = $recipe;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $titles = [
            'pending' => 'Terima Kasih Sudah Mengupload Resep di Dapur Keju Prochiz',
            'approved' => 'Selamat Resep Anda Telah Kami Setujui',
            'rejected' => 'Mohon Maaf, Resep Anda Tidak Kami Setujui',
        ];

        $params = [
            'name' => $this->user->name,
            'recipe' => $this->recipe,
            'title' => $titles[$this->recipe->status],
        ];

        return (new MailMessage)
                    ->from('info@dapurkejuprochiz.com', 'Dapur Keju Prochiz')
                    ->subject($titles[$this->recipe->status])
                    ->markdown('mail.recipe-status', $params);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
