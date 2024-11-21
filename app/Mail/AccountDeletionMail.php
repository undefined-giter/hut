<?php

namespace App\Mail;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Bus\Queueable;
use App\Models\User;
use App\Models\Reservation;
use App\Models\AdminComment;

class AccountDeletionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $reservations;
    public $adminComments;
    public $isAdmin;

    /**
     * Create a new message instance.
     *
     * @param User $user
     * @param Collection|Reservation[] $reservations
     * @param Collection|AdminComment[] $adminComments
     * @param bool $isAdmin
     */
    public function __construct(User $user, Collection $reservations, Collection $adminComments, bool $isAdmin)
    {
        $this->user = $user;
        $this->reservations = $reservations;
        $this->adminComments = $adminComments;
        $this->isAdmin = $isAdmin;
    }

    public function build()
    {
        $adminEmail = config('admin.email');
        $adminPhoneHref = config('admin.phone');
        $adminPhone = format_phone_number($adminPhoneHref);

        return $this->subject("Cabane - Suppression de compte et réservations annulées")
                    ->view('emails.accountDeleted')
                    ->with([
                        'user' => $this->user,
                        'reservations' => $this->reservations,
                        'adminComments' => $this->adminComments,
                        'isAdmin' => $this->isAdmin,
                        'adminEmail' => $adminEmail,
                        'adminPhoneHref' => $adminPhoneHref,
                        'adminPhone' => $adminPhone,
                    ]);
    }
}
