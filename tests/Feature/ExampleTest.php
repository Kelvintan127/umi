<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        // '/' is a locale-negotiation entry point: it must redirect to the
        // default locale, not serve a body. See LocaleRedirectController.
        $response = $this->get('/');

        $response->assertRedirect('/en');
    }
}
