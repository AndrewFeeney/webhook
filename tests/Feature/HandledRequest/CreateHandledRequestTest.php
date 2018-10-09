<?php

namespace Tests\Feature\HandledRequest;

use App\Models\Webhook;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateHandledRequestTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function when_a_webhook_endpoint_receives_an_http_request_a_handled_request_is_created()
    {
        $this->withoutExceptionHandling();

        $webhook = factory(Webhook::class)->create();

        $response = $this->get($webhook->url());

        $response->assertSuccessful();

        $this->assertDatabaseHas('handled_requests', [
            'webhook_id' => $webhook->id,
            'method'     => 'GET',
            'query'      => json_encode([]),
            'content'    => '',
            'json'       => null,
        ]);
    }
}
