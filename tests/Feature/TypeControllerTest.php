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
        $type=Type::factory()->create();
        $response = $this->get(route('types.show', [
            'type' => $type->id,
        ]));
        $response->assertStatus(200);
    }

    public function testUpdate()
    {
        $type=Type::factory()->create();
        $data = $type->toArray();
        $data['name']='dsdfgh';
        var_dump($data);
        $response = $this->patch(route('types.update', [
            'type' => $type->id,
        ]),$data);
        $response->assertStatus(204);
    } 

    public function testDestroy()
    {
        $type=Type::factory()->create();
        $response = $this->delete(route('types.destroy', [
            'type' => $type->id,
        ]));
        $response->assertStatus(204);
    }  
      
}
