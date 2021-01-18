<?php

namespace App;

class Subscription
{
    public function __construct(protected Gateway $gateway, protected Mailer $mailer)
    {
        //
    }

    public function create(User $user)
    {
        // create the subscription through Stripe.
        $receipt = $this->gateway->create();

        // Update the local user record.
        $user->markAsSubscribed();

        // Send a welcome email or dispatch event.
        $this->mailer->deliver('Your receipt number is: ' . $receipt);
    }
}
