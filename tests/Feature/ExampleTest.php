<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');
        $response->assertSeeText("Welcome");

        $response->assertStatus(200);
    }

    public function CheckDocumentationText()
    {
        $response = $this->get('/');
        $response->assertSeeText("Documentation");

        $response->assertStatus(200);
    }
}
