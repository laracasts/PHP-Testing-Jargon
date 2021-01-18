<?php

namespace Tests;

use App\Gateway;
use App\Mailer;
use App\Subscription;
use App\User;
use PHPUnit\Framework\TestCase;

class SubscriptionTest extends TestCase
{
    /** @test */
    function it_creates_a_stripe_subscription()
    {
        $this->markTestSkipped();
    }

    /** @test */
    function creating_a_subscription_marks_the_user_as_subscribed()
    {
        $subscription = new Subscription(
            $this->createMock(Gateway::class),
            $this->createMock(Mailer::class)
        );

        $user = new User("JohnDoe");

        $this->assertFalse($user->isSubscribed());

        $subscription->create($user);

        $this->assertTrue($user->isSubscribed());
    }

    /** @test */
    function it_delivers_a_receipt()
    {
        $gateway = $this->createMock(Gateway::class);
        $gateway->method('create')->willReturn('receipt-stub');

        $mailer = $this->createMock(Mailer::class);
        $mailer
            ->expects($this->once())
            ->method('deliver')
            ->with('Your receipt number is: receipt-stub');

        $subscription = new Subscription($gateway, $mailer);

        $subscription->create(new User("JohnDoe"));
    }
}
