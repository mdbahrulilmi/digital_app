<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Auth;

// Member
use App\Models\Member;
use Illuminate\Support\Facades\Hash;

// Pake Livewire
use Livewire\Livewire;
use App\Livewire\Auth\MemberLogin;

class LoginMemberTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_login_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }
    
    public function test_member_can_login_with_valid_credentials(): void
    {
        Livewire::test(MemberLogin::class)
            ->set('whatsapp', '12345678')
            ->set('password', '12345678')
            ->call('login');
        
        $this->assertTrue(Auth::guard('member')->check());
    }
    
    public function test_member_cant_login_with_invalid_credentials(): void
    {
        Livewire::test(MemberLogin::class)
            ->set('whatsapp', '12345678')
            ->set('password', '87654321')
            ->call('login');
        
        $this->assertTrue(Auth::guard('member')->check());
    }
}
