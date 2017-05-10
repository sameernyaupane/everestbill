<?php
namespace EverestBill\Listeners;

use Illuminate\Mail\Mailer;
use EverestBill\Domains\User;
use EverestBill\Mail\CompleteCheckout;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use EverestBill\Events\UserRegisteredThroughCustomerFlow;

class SendCompleteCheckoutEmail
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
     * @param  UserRegistered  $event
     * @return void
     */
    public function handle(UserRegisteredThroughCustomerFlow $event)
    {
        $user = $this->user->findById($event->userId);

        $user->activationCode = $user->activations()->first()->code;

        $this->mail->to($user->email)->send(new CompleteCheckout($user));
    }
}
