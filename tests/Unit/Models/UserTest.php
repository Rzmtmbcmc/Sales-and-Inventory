<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_be_created()
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
            'role' => 'manager'
        ]);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('Test User', $user->name);
        $this->assertEquals('test@example.com', $user->email);
        $this->assertEquals('manager', $user->role);
    }

    public function test_user_password_is_hashed()
    {
        $user = User::create([
            'name' => 'Hash Test',
            'email' => 'hash@example.com',
            'password' => Hash::make('plainpassword'),
            'role' => 'owner'
        ]);

        $this->assertNotEquals('plainpassword', $user->password);
        $this->assertTrue(Hash::check('plainpassword', $user->password));
    }

    public function test_user_has_valid_roles()
    {
        $managerUser = User::create([
            'name' => 'Manager User',
            'email' => 'manager@example.com',
            'password' => Hash::make('password'),
            'role' => 'manager'
        ]);

        $ownerUser = User::create([
            'name' => 'Owner User',
            'email' => 'owner@example.com',
            'password' => Hash::make('password'),
            'role' => 'owner'
        ]);

        $this->assertEquals('manager', $managerUser->role);
        $this->assertEquals('owner', $ownerUser->role);
    }

    public function test_user_email_is_unique()
    {
        User::create([
            'name' => 'First User',
            'email' => 'unique@example.com',
            'password' => Hash::make('password'),
            'role' => 'manager'
        ]);

        $this->expectException(\Illuminate\Database\QueryException::class);

        User::create([
            'name' => 'Second User',
            'email' => 'unique@example.com', // Same email
            'password' => Hash::make('password'),
            'role' => 'owner'
        ]);
    }

    public function test_user_fillable_attributes()
    {
        $user = new User();
        $fillable = $user->getFillable();
        
        $expectedFillable = [
            'name',
            'email',
            'password',
            'role'
        ];

        $this->assertEquals($expectedFillable, $fillable);
    }

    public function test_user_hidden_attributes()
    {
        $user = User::create([
            'name' => 'Hidden Test',
            'email' => 'hidden@example.com',
            'password' => Hash::make('password'),
            'role' => 'manager'
        ]);

        $userArray = $user->toArray();
        
        $this->assertArrayNotHasKey('password', $userArray);
        $this->assertArrayNotHasKey('remember_token', $userArray);
    }

    public function test_user_email_verification_cast()
    {
        $user = User::create([
            'name' => 'Cast Test',
            'email' => 'cast@example.com',
            'password' => Hash::make('password'),
            'role' => 'manager',
            'email_verified_at' => now()
        ]);

        $this->assertInstanceOf(\Carbon\Carbon::class, $user->email_verified_at);
    }
}