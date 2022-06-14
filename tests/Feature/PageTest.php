<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PageTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_Heading()
    {
        $response = $this->get('/');

        $response->assertSeeText("Selamat");
        $response->assertStatus(200);
    }
}
