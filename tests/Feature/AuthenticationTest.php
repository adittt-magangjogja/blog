<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_first_admin_can_register_and_is_logged_in(): void
    {
        $password = 'a-long-test-password';

        $response = $this->post(route('first-admin.store'), [
            'name' => 'Blog Admin',
            'email' => 'admin@example.test',
            'password' => $password,
            'password_confirmation' => $password,
        ]);

        $response->assertRedirect(route('posts.index'));
        $this->assertAuthenticated();
        $this->assertDatabaseCount('users', 1);
        $this->assertTrue(Hash::check($password, User::query()->firstOrFail()->password));
    }

    public function test_first_admin_registration_is_closed_after_an_account_exists(): void
    {
        User::factory()->create();

        $this->get(route('first-admin.create'))->assertRedirect(route('login'));

        $this->post(route('first-admin.store'), [
            'name' => 'Another Admin',
            'email' => 'another@example.test',
            'password' => 'another-long-test-password',
            'password_confirmation' => 'another-long-test-password',
        ])->assertRedirect(route('login'));

        $this->assertDatabaseCount('users', 1);
    }

    public function test_admin_login_authenticates_with_valid_credentials(): void
    {
        $password = 'a-long-test-password';
        User::factory()->create([
            'email' => 'admin@example.test',
            'password' => Hash::make($password),
        ]);

        $response = $this->post(route('login.store'), [
            'email' => 'admin@example.test',
            'password' => $password,
        ]);

        $response->assertRedirect(route('posts.index'));
        $this->assertAuthenticated();
    }

    public function test_login_rejects_invalid_credentials_without_authenticating(): void
    {
        User::factory()->create([
            'email' => 'admin@example.test',
            'password' => Hash::make('a-long-test-password'),
        ]);

        $response = $this->from(route('login'))->post(route('login.store'), [
            'email' => 'admin@example.test',
            'password' => 'incorrect-test-password',
        ]);

        $response->assertRedirect(route('login'));
        $response->assertSessionHasErrors([
            'email' => 'Email atau kata sandi tidak sesuai.',
        ]);
        $this->assertGuest();
    }

    public function test_guest_cannot_view_or_change_admin_articles(): void
    {
        $post = Post::query()->create([
            'title' => 'Artikel privat',
            'slug' => 'artikel-privat',
            'content' => 'Isi artikel.',
        ]);

        $this->get(route('posts.create'))->assertRedirect(route('login'));
        $this->get(route('posts.edit', $post))->assertRedirect(route('login'));
        $this->post(route('posts.store'), [
            'title' => 'Artikel baru',
            'slug' => 'artikel-baru',
            'content' => 'Isi baru.',
        ])->assertRedirect(route('login'));
        $this->put(route('posts.update', $post), [
            'title' => 'Judul diubah',
            'slug' => 'artikel-privat',
            'content' => 'Isi diubah.',
        ])->assertRedirect(route('login'));
        $this->delete(route('posts.destroy', $post))->assertRedirect(route('login'));

        $this->assertDatabaseCount('posts', 1);
        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Artikel privat',
        ]);
    }

    public function test_guest_can_read_articles(): void
    {
        $post = Post::query()->create([
            'title' => 'Artikel publik',
            'slug' => 'artikel-publik',
            'content' => 'Isi artikel publik.',
        ]);

        $this->get(route('posts.index'))->assertOk()->assertSee('Artikel publik');
        $this->get(route('posts.show', $post))->assertOk()->assertSee('Isi artikel publik.');
    }
}
