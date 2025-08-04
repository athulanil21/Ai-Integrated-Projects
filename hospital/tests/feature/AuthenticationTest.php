<?php

namespace Tests\Feature;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;

class AuthenticationTest extends CIUnitTestCase
{
    use DatabaseTestTrait, FeatureTestTrait;

    protected $migrate = true;
    protected $refresh = true;
    protected $seed = 'TestSeeder';

    public function testLoginPageLoads()
    {
        $response = $this->get('auth/login');
        
        $response->assertOK();
        $response->assertSee('Login');
        $response->assertSee('Email');
        $response->assertSee('Password');
    }

    public function testLoginWithValidCredentials()
    {
        $response = $this->post('auth/login', [
            'email' => 'admin@test.com',
            'password' => 'password123'
        ]);

        $response->assertRedirect();
        $this->assertTrue(session()->get('is_logged_in'));
        $this->assertEquals('admin@test.com', session()->get('email'));
    }

    public function testLoginWithInvalidCredentials()
    {
        $response = $this->post('auth/login', [
            'email' => 'invalid@test.com',
            'password' => 'wrongpassword'
        ]);

        $response->assertRedirect();
        $this->assertFalse(session()->get('is_logged_in'));
    }

    public function testRegistrationWithValidData()
    {
        $userData = [
            'username' => 'newuser',
            'email' => 'newuser@test.com',
            'password' => 'password123',
            'confirm_password' => 'password123',
            'role_id' => 3
        ];

        $response = $this->post('auth/register', $userData);
        
        $response->assertRedirect();
        
        // Verify user was created
        $userModel = model('UserModel');
        $user = $userModel->where('email', 'newuser@test.com')->first();
        $this->assertNotNull($user);
        $this->assertEquals('newuser', $user['username']);
    }

    public function testProtectedRouteRedirectsWhenNotLoggedIn()
    {
        $response = $this->get('dashboard');
        
        $response->assertRedirect();
        $response->assertRedirectTo('/auth/login');
    }
}
