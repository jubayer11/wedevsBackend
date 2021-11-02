<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class usersApiTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;
    use WithoutMiddleware;

    public function testCanCreateUser()
    {
//        $user=factory(User::class)->create();
//        $this->actingAs($user,'api');
        $this->withoutMiddleware();
        $formData = [
            'name' => 'jubayer ahmed',
            'email' => 'ahmed4123@gmail.com',
            'password' => 'wedevs4'
        ];
        $this->withoutExceptionHandling();
        $this->post(route('user.store'), $formData)->assertStatus(200);
//        $this->post(route('user.store'), $formData)->assertStatus(200)->assertJson(['data' => $formData]);

    }

    public function testCanShowUser()
    {
        $this->get(route('user.index'))->assertStatus(200);
    }
    public function testCanShowIndividualUser()
    {
        factory(User::class)->create();
        $this->get(route('user.show',1))->assertStatus(200);
    }
}
