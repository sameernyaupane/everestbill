<?php
namespace EverestBill\Listeners;

use Illuminate\Mail\Mailer;
use EverestBill\Domains\User;
use EverestBill\Mail\Welcome;
use EverestBill\Events\UserRegistered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendWelcomeEmail
{
    /**
     * User model
     * @var object
     */
    private $user;

    /**
     * Mailer instance
     * @var object
     */
    private $mail;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(User $user, Mailer $mail)
    {
        $this->user = $user;
        $this->mail = $mail;
    }

    /**
     * Handle the event.
     *
     * @param  UserRegistered|UserRegisteredThroughCustomerFlow  $event
     * @return void
     */
    public function handle($event)
    {
        $user = $this->user->findById($event->userId);

        $this->mail->to($user->email)->send(new Welcome($user));
    }
}
