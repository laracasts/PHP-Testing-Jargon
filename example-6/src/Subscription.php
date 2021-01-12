<?php

namespace App;

class Subscription
{
    public function __construct(protected Gateway $gateway)
    {
        //
    }

    public function create(User $user)
    {
        // create the subscription through Stripe.
        $this->gateway->create();

        // Update the local user record.
        $user->markAsSubscribed();

        // Send a welcome email or dispatch event.
    }
}
