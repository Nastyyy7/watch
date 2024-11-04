<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    public function testIndex(): void
    {
        $response = $this->get(route('orders.index'));
        $response->assertStatus(200);
    }
}
