<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register(){
        // Test d'inscription
        $response = $this->post('/api/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        // Vérifier que l'utilisateur est bien enregistré dans la base de données
        $this->assertDatabaseHas('users', [
            'email' => 'john@example.com',
        ]);

        // Vérifier que l'utilisateur est bien authentifié
        $this->assertAuthenticated();
    }

    public function test_user_can_login(){
        $response = $this->post('/api/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);
        $response = $this->post('/api/logout');

        // Test de connexion
        $response = $this->post('/api/login', [
            'email' => 'john@example.com',
            'password' => 'password123',
        ]);
        // Vérifier que l'utilisateur est bien authentifié
        $this->assertAuthenticated();
    }

    public function test_user_can_logout(){
        $response = $this->post('/api/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);
        $this->assertAuthenticated();

        // Test de déconnexion
        $response = $this->post('/api/logout');


        // Vérifier que l'utilisateur n'est plus authentifié
        $this->assertGuest();
    }
}
