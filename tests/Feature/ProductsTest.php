<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductsTest extends TestCase
{

    use RefreshDatabase;

    public function test_empty_product()
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        $response->assertSeeText("Tidak ada produk");
    }

    public function test_product_exist()
    {
        $product = Product::create([
            'name' => 'Susu Ultramilk',
            'price' => 8000
        ]);

        $response = $this->get('/');
        $response->assertStatus(200);

        $response->assertDontSee("Tidak ada produk");
        $response->assertSee($product->name);

        $viewProduct = $response->viewData('products');
        $this->assertEquals($product->name,$viewProduct->first()->name);

    }
}
