<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class ManageProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_view_the_profile_page(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('profile.edit'))
            ->assertOk()
            ->assertSee('Manage your profile');
    }

    public function test_guest_is_redirected_from_the_profile_page(): void
    {
        $this->get(route('profile.edit'))
            ->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_update_profile_details_and_replace_avatar(): void
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'role' => 'agent',
            'company_name' => 'Old Agency',
            'phone' => '+233 20 000 0000',
            'avatar_path' => 'storage/avatars/1/old-avatar.jpg',
        ]);

        Storage::disk('public')->put('avatars/1/old-avatar.jpg', 'old-avatar');

        $response = $this->actingAs($user)->put(route('profile.update'), [
            'name' => 'Updated Agent',
            'email' => 'updated-agent@example.com',
            'phone' => '+233 55 111 2222',
            'company_name' => 'Updated Agency',
            'avatar' => UploadedFile::fake()->image('avatar.jpg', 800, 800),
        ]);

        $response
            ->assertRedirect(route('profile.edit'))
            ->assertSessionHas('status', 'Profile updated.');

        $user->refresh();

        $this->assertSame('Updated Agent', $user->name);
        $this->assertSame('updated-agent@example.com', $user->email);
        $this->assertSame('+233 55 111 2222', $user->phone);
        $this->assertSame('Updated Agency', $user->company_name);
        $this->assertStringStartsWith('storage/avatars/' . $user->id . '/', $user->avatar_path);
        $this->assertFalse(Storage::disk('public')->exists('avatars/1/old-avatar.jpg'));
        $this->assertTrue(Storage::disk('public')->exists(Str::after($user->avatar_path, 'storage/')));
    }

    public function test_authenticated_user_can_change_their_password(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->put(route('profile.password'), [
            'current_password' => 'password',
            'password' => 'new-secure-password',
            'password_confirmation' => 'new-secure-password',
        ]);

        $response
            ->assertRedirect(route('profile.edit') . '#password')
            ->assertSessionHas('password_status', 'Password updated.');

        $this->assertTrue(Hash::check('new-secure-password', $user->fresh()->password));
    }

    public function test_password_update_requires_the_correct_current_password(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from(route('profile.edit'))
            ->put(route('profile.password'), [
                'current_password' => 'wrong-password',
                'password' => 'new-secure-password',
                'password_confirmation' => 'new-secure-password',
            ]);

        $response
            ->assertRedirect(route('profile.edit'))
            ->assertSessionHasErrors(['current_password']);

        $this->assertTrue(Hash::check('password', $user->fresh()->password));
    }
}
