<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Contracts\Factory;
use Laravel\Socialite\Contracts\Provider;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\followingRedirects;
use function Pest\Laravel\get;

uses(RefreshDatabase::class);

test('', function () {
    Socialite::swap(new class implements Factory {
        public function driver($driver = null)
        {
            return new class implements Provider {
                public function redirect(): RedirectResponse
                {
                    return new RedirectResponse(route('social.callback', ['provider' => 'google']));
                }

                public function user(): User
                {
                    $user = new User();
                    $user->name = 'John Doe';
                    $user->email = 'john.doe@example.com';

                    return $user;
                }
            };
        }
    });

    // This allows us to follow the redirect to the callback route and dashboard
    followingRedirects();

    get(route('social.login', ['provider' => 'google']))
        ->assertStatus(200);

    assertDatabaseHas('users', [
        'name' => 'John Doe',
        'email' => 'john.doe@example.com'
    ]);
});
