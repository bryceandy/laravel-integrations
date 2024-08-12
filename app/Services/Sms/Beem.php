<?php

declare(strict_types=1);

namespace App\Services\Sms;

use App\Exceptions\ConfigurationNotFoundException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Throwable;

final class Beem implements SmsProvider
{
    /**
     * @throws Throwable
     * @throws ConnectionException
     */
    public function send(array|string $phoneNumbers, string $message): void
    {
        $this->ensureConfigurationExists();

        $recipients = $this->fetchRecipients($phoneNumbers);

        Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic '.base64_encode(config('beem.api_key').':'.config('beem.secret_key')),
        ])
            ->post('https://apisms.beem.africa/v1/send', [
                'encoding' => 0,
                'source_addr' => config('beem.source'),
                'message' => $message,
                'recipients' => $recipients,
            ]);
    }

    /**
     * @throws Throwable
     */
    public function ensureConfigurationExists(): mixed
    {
        return throw_if(! config('beem.api_key') || ! config('beem.secret_key'), new ConfigurationNotFoundException('Beem API key and secret key must be set in the configuration.'));
    }

    /**
     * Use the provided phone number(s) to provide Beem with recipients
     */
    private function fetchRecipients($phoneNumbers): array
    {
        $users = DB::table('users')
            ->whereIn('phone_number', is_array($phoneNumbers) ? $phoneNumbers : [$phoneNumbers])
            ->get(['id', 'phone_number']);

        return $users->map(function ($user) {
            return [
                'recipient_id' => (string) $user->id,
                'dest_addr' => $user->phone_number,
            ];
        })->toArray();
    }
}
