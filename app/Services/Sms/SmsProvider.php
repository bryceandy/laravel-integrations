<?php

declare(strict_types=1);

namespace App\Services\Sms;

interface SmsProvider
{
    /**
     * Deliver an SMS to the given phone number(s)
     */
    public function send(array|string $phoneNumbers, string $message): void;
}
