<?php

namespace Tests\Feature;

use App\Models\Type;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TypeControllerTest extends TestCase
{
    // use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function testIndex(): void
    {
        $response = $this->get(route('types.index'));
        $response->assertStatus(200);
    }

    public function testStore(): void
    {
        $data = Type::factory()->make([
        ])->toArray();
        $response = $this->post(route('types.store'), $data);
        $response->assertStatus(201);
    }

    public function testShow()
    {
        $type = Type::all()->random(1)->firstOrFail();
        $response = $this->get(route('types.show', [
            'type' => $type->id,
        ]));
        $response->assertStatus(200);
    }
}
