<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Partner;
use App\Models\User;

class PartnerStatus extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The user model.
     *
     * @var App\Models\User
     */
    private $user;

    /**
     * The partner model.
     *
     * @var App\Models\Partner
     */
    private $partner;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user, Partner $partner)
    {
        $this->user = $user;
        $this->partner = $partner;
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
            'pending' => 'Terima Kasih Sudah Mendaftarkan Kuliner Anda sebagai Partner di Dapur Keju Prochiz',
            'approved' => 'Selamat Kuliner Anda Telah Kami Setujui sebagai Partner di Dapur Keju Prochiz',
            'rejected' => 'Mohon Maaf, Kuliner Anda Tidak Kami Setujui sebagai Partner di Dapur Keju Prochiz',
        ];

        $params = [
            'name' => $this->user->name,
            'partner' => $this->partner,
            'title' => $titles[$this->partner->status],
        ];

        return (new MailMessage)
                    ->from('info@dapurkejuprochiz.com', 'Dapur Keju Prochiz')
                    ->subject($titles[$this->partner->status])
                    ->markdown('mail.partner-status', $params);
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
