<?php

namespace Tests\Feature\HandledRequest;

use App\Models\HandledRequest;
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

        $response = $this->json('post', $webhook->url().'?test-query=true', ['test-post-parameter' => true], ['test-header' => true]);

        $response->assertSuccessful();

        $this->assertDatabaseHas('handled_requests', [
            'webhook_id' => $webhook->id,
            'method'     => 'POST',
            'query'      => json_encode(['test-query' => 'true']),
            'content'    => json_encode(['test-post-parameter' => true]),
            'json'       => json_encode(['test-post-parameter' => true], JSON_PRETTY_PRINT),
        ]);

        $handledRequest = HandledRequest::orderBy('id', 'desc')->first();

        $this->assertTrue($handledRequest->headers->contains(function ($value, $key) {
            return $key == 'test-header' && $value[0] == 'true';
        }));
    }
}
