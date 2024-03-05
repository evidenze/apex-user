<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use DateTime;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\ClientRepository;
use Illuminate\Support\Facades\Hash;

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected $personalAccessToken;
    protected $user;
    protected $headers = [];

    protected function setUp(): void
    {
        parent::setUp();
        $clientRepository = new ClientRepository();
        $client = $clientRepository->createPersonalAccessClient(
            null,
            'Test Personal Access Client',
            'http://localhost:8000'
        );

        DB::table('oauth_personal_access_clients')->insert([
            'client_id' => $client->id,
            'created_at' => new DateTime,
            'updated_at' => new DateTime,
        ]);

        $this->user = User::factory()->create();
        $token = $this->user->createToken('TestToken')->accessToken;
        $this->headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
        ];
    }


    public function testUserRegistration()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['status', 'message', 'data']);
    }

    public function testUserLogin()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['status', 'message', 'data']);
    }

    public function testUserLogout()
    {
        $response = $this->withHeaders($this->headers)->postJson('/api/logout');

        $response->assertStatus(200)
            ->assertJsonStructure(['status', 'message', 'data']);
    }

    public function testGetAllUsers()
    {
        $response = $this->withHeaders($this->headers)->getJson('/api/users');

        $response->assertStatus(200)
            ->assertJsonStructure(['data']);
    }

    public function testGetSingleUser()
    {
        $user = User::factory()->create();

        $response = $this->withHeaders($this->headers)->getJson('/api/users/' . $user->id);

        $response->assertStatus(200)
            ->assertJsonStructure(['status', 'message', 'data']);
    }

    public function testCreateUser()
    {
        $response = $this->withHeaders($this->headers)->postJson('/api/users', [
            'name' => 'New User',
            'email' => 'newuser@example.com',
            'password' => 'password123',
            'role' => 'user',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure(['status', 'message', 'data']);
    }

    public function testUpdateUser()
    {
        $user = User::factory()->create();

        $response = $this->withHeaders($this->headers)->putJson('/api/users/' . $user->id, [
            'name' => 'Updated Name',
            'email' => 'newuser@example.com',
            'role' => 'user',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['status', 'message', 'data']);
    }

    public function testDeleteUser()
    {
        $user = User::factory()->create();

        $response = $this->withHeaders($this->headers)->deleteJson('/api/users/' . $user->id);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
