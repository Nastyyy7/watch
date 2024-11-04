<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReviewControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testIndex(): void
    {
        $response = $this->get('/api/v1/reviews/');
        $response->assertStatus(200);
    }
}
