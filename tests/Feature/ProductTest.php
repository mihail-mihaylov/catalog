<?php

namespace Tests\Feature;

use App\Product;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
//    TODO: Not finished
//    public function testsProductsAreCreatedCorrectly()
//    {
//        $user = factory(User::class)->create();
//        $token = $user->generateToken();
//        $headers = ['Authorization' => "Bearer $token"];
//        $payload = [
//            'name' => 'Lorem',
//            'description' => 'Ipsum',
//        ];
//
//        $this->json('POST', '/api/products', $payload, $headers)
//            ->assertStatus(200)
//            ->assertJson(['id' => 1, 'name' => 'Lorem', 'description' => 'Ipsum']);
//    }
//
//    public function testsProductsAreUpdatedCorrectly()
//    {
//        $user = factory(User::class)->create();
//        $token = $user->generateToken();
//        $headers = ['Authorization' => "Bearer $token"];
//        $product = factory(Product::class)->create([
//            'name' => 'First Product',
//            'description' => 'First description',
//        ]);
//
//        $payload = [
//            'name' => 'Lorem',
//            'description' => 'Ipsum',
//        ];
//
//        $response = $this->json('PUT', '/api/products/' . $product->id, $payload, $headers)
//            ->assertStatus(200)
//            ->assertJson([
//                'id' => 1,
//                'name' => 'Lorem',
//                'description' => 'Ipsum'
//            ]);
//    }
//
//    public function testsProductsAreDeletedCorrectly()
//    {
//        $user = factory(User::class)->create();
//        $token = $user->generateToken();
//        $headers = ['Authorization' => "Bearer $token"];
//        $product = factory(Product::class)->create([
//            'name' => 'First Product',
//            'description' => 'First description',
//        ]);
//
//        $this->json('DELETE', '/api/products/' . $product->id, [], $headers)
//            ->assertStatus(204);
//    }
//
//    public function testProductsAreListedCorrectly()
//    {
//        factory(Product::class)->create([
//            'name' => 'First Product',
//            'description' => 'First description'
//        ]);
//
//        factory(Product::class)->create([
//            'name' => 'Second Product',
//            'description' => 'Second description'
//        ]);
//
//        $user = factory(User::class)->create();
//        $token = $user->generateToken();
//        $headers = ['Authorization' => "Bearer $token"];
//
//        $response = $this->json('GET', '/api/products', [], $headers)
//            ->assertStatus(200)
//            ->assertJson([
//                [ 'name' => 'First Product', 'description' => 'First description' ],
//                [ 'name' => 'Second Product', 'description' => 'Second description' ]
//            ])
//            ->assertJsonStructure([
//                '*' => ['id', 'description', 'name', 'created_at', 'updated_at'],
//            ]);
//    }

}
