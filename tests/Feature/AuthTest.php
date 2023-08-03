<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call('passport:client --personal --name Testing');
    }

    public function testAUserCanRegisterThroughApi()
    {
        $user = User::factory()->raw();

        $response = $this->postJson(route('api.auth.register'), $user);

        $response->assertStatus(200)->assertJson([
            'message' => __('auth.register.success')
        ]);
    }

    public function testAUserCanLoginThroughApi()
    {
        $user = User::factory()->create([
            'password' => Hash::make('test-password')
        ]);

        $response = $this->postJson(route('api.auth.login'), [
            'email' => $user->email,
            'password' => 'test-password'
        ]);

        $response->assertStatus(200)->assertJson([
            'message' => __('auth.login.success')
        ]);
    }
}
