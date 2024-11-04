<?php

namespace Tests\Feature;

use App\Models\Status;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StatusControllerTest extends TestCase
{
    public function testIndex(): void
    {
        $response = $this->get(route('statuses.index'));
        $response->assertStatus(200);
    }

    public function testStore(): void
    {
        $data = Status::factory()->make([
        ])->toArray();
        $response = $this->post(route('statuses.store'), $data);
        $response->assertStatus(201);
    }

    public function testShow()
    {
        $status = Status::all()->random(1)->firstOrFail();
        $response = $this->get(route('statuses.show', [
            'status' => $status->id,
        ]));
        $response->assertStatus(200);
    }

}

