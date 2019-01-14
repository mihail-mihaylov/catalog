<?php

namespace Tests\Feature\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
//    TODO: Not finished
//    public function testRequiresEmailAndLogin()
//    {
//        $this->json('POST', 'api/login')
//            ->assertStatus(422)
//            ->assertJson([
//                'email' => ['The email field is required.'],
//                'password' => ['The password field is required.'],
//            ]);
//    }
//
//
//    public function testUserLoginsSuccessfully()
//    {
//        $user = factory(User::class)->create([
//            'email' => 'testlogin@user.com',
//            'password' => bcrypt('takeaway'),
//        ]);
//
//        $payload = ['email' => 'testlogin@user.com', 'password' => 'takeaway'];
//
//        $this->json('POST', 'api/login', $payload)
//            ->assertStatus(200)
//            ->assertJsonStructure([
//                'data' => [
//                    'id',
//                    'name',
//                    'email',
//                    'created_at',
//                    'updated_at',
//                ],
//            ]);
//
//    }
}
