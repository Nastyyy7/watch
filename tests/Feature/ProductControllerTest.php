<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;


class ProductControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testIndex(): void
    {
        $response = $this->get(route('products.index'));
        $response->assertStatus(200);
    }


    public function testShow()
    {
        $product = Product::all()->random(1)->firstOrFail();
        $response = $this->get(route('products.show', [
            'product' => $product->id,
        ]));
        $response->assertStatus(200);
    }

}
