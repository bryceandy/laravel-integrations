# Laravel Integrations

![Tests](https://github.com/bryceandy/laravel-integrations/actions/workflows/test.yml/badge.svg?event=push)
![Coverage](https://coveralls.io/repos/github/bryceandy/laravel-integrations/badge.svg?branch=main)
![GitHub issues](https://img.shields.io/github/issues/bryceandy/laravel-integrations)

## Requirements

This project requires a minimum of;
- Laravel 11
- PHP 8.3

## Available Integrations

We are going to cover a lot of services and their options. Send a PR or request in discussions if you want to add a particular integration.

1. [SMS](#sms-integrations)
    - [Beem SMS](#Beem-bulk-sms)
    - [Twilio SMS](#twilio-sms)
2. [Payment Integrations](#payment-integrations)

### SMS Integrations

#### Beem Bulk SMS

* Using Beem APIs you can send bulk SMS to a group of users or a single user.
* By default the SMS implementation is using Beem, but you can change this later on if necessary. To send an SMS in a job;

```php
use App\Services\Sms\SmsProvider;

public function handle(SmsProvider $smsProvider): void
{
    $smsProvider->send(
        phoneNumbers: [$phoneNumber1],
        message: 'Test message',
    );
}
```

### Payment Integrations
