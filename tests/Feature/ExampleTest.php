<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_basic_test(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_api_authentication(): void
    {
        $user = $this->createUser();
        
        $response = $this->actingAs($user)
                         ->get('/api/v1/user');

        $response->assertStatus(200)
                 ->assertJson(['id' => $user->id]);
    }

    public function test_database_operations(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com'
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com'
        ]);
    }
}