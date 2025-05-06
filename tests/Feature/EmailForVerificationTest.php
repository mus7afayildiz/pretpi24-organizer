<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;
use Illuminate\Auth\Notifications\VerifyEmail;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\Test;

class EmailForVerificationTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function user_receives_verification_email_upon_registration(): void
    {
        Notification::fake();

        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        // Après l'inscription, l'utilisateur devrait recevoir une notification de vérification
        $user = User::where('email', 'test@example.com')->first();
        Notification::assertSentTo($user, VerifyEmail::class);

        // Vous devriez être dirigé vers l'écran d'attente de vérification
        $response->assertRedirect('/dashboard');
    }

    #[Test]
    public function email_is_not_verified_with_invalid_hash(): void
    {
        $user = User::factory()->unverified()->create();

        $invalidVerificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(60),
            [
                'id' => $user->getKey(),
                'hash' => sha1('invalid@example.com'), // hachage erroné
            ]
        );

        $response = $this->actingAs($user)->get($invalidVerificationUrl);

        $this->assertFalse($user->fresh()->hasVerifiedEmail());
        $response->assertStatus(403); // ou redirection de page d'erreur
    }

    #[Test]
    public function verified_user_can_access_dashboard(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertOk();
    }

    #[Test]
    public function email_can_be_verified(): void
    {
        $user = User::factory()->unverified()->create();

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(60),
            ['id' => $user->getKey(), 'hash' => sha1($user->getEmailForVerification())]
        );

        event(new Verified($user));

        $response = $this->actingAs($user)->get($verificationUrl);

        $response->assertRedirect('/dashboard?verified=1');
        $this->assertTrue($user->fresh()->hasVerifiedEmail());
    }

}
