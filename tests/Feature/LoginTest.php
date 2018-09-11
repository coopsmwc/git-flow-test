<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testRoot()
    {
        $response = $this->get('/');
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }
    
    public function testLoginLink()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }
    
    public function testLogin()
    {
        $response = $this->post('/login', ['email' => 'm@c.com', 'password' => 'password']);
        $response->assertStatus(302);
        $response->assertRedirect('/companies');
    }
    
    public function testLoginError()
    {
        $response = $this->post('/login', ['email' => 'm@c.com', 'password' => 'password1']);
        $response->assertStatus(302);
        $response->assertRedirect('/');
    }
    
    public function testLogout()
    {
        $response = $this->get('/logout');
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }
}
