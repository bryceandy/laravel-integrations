<?php

namespace Tests\Feature\Services\Sms;

use App\Exceptions\ConfigurationNotFoundException;
use App\Models\User;
use App\Services\Sms\Beem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class BeemTest extends TestCase
{
    use RefreshDatabase;

    /** #[Test] */
    public function test_an_exception_is_thrown_if_api_key_or_secret_key_are_missing(): void
    {
        Config::set('beem.api_key', null);
        Config::set('beem.secret_key', null);

        $this->expectException(ConfigurationNotFoundException::class);

        $beem = new Beem;

        $beem->send(phoneNumbers: '255700000000', message: 'Test message');
    }

    /** #[Test] */
    public function test_sms_is_sent_using_beem_api(): void
    {
        Config::set('beem.api_key', 'fake_api_key');
        Config::set('beem.secret_key', 'fake_secret_key');
        Config::set('beem.source', 'fake_source');

        Http::fake();
        User::factory()->create(['id' => 1, 'phone_number' => '255700000001']);
        User::factory()->create(['id' => 2, 'phone_number' => '255700000002']);

        $beem = new Beem;
        $beem->send(['255700000001', '255700000002'], 'Test message');

        Http::assertSent(fn ($request) => $request->hasHeader('Authorization', 'Basic '.base64_encode('fake_api_key:fake_secret_key')) &&
            $request->url() === 'https://apisms.beem.africa/v1/send' &&
            $request['message'] === 'Test message' &&
            $request['source_addr'] === 'fake_source' &&
            $request['recipients'] === [
                [
                    'recipient_id' => '1',
                    'dest_addr' => '255700000001',
                ],
                [
                    'recipient_id' => '2',
                    'dest_addr' => '255700000002',
                ],
            ]
        );
    }
}
