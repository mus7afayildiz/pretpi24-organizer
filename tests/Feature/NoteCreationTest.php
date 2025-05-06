<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AttachmentController;

class NoteCreationTest extends TestCase
{
    use RefreshDatabase; // La base de données est réinitialisée après chaque test
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/test');

        // TestResponse içeriğini dökmek
        dd($response->getContent());  // veya echo $response->getContent();

        // Beklenen sonucu kontrol et
        $response->assertStatus(200);
    }

    // public function test_notes_store_route_exists()
    // {
    //     $user = User::factory()->create(['email_verified_at' => now()]);
    //     $this->actingAs($user);

    //     $response = $this->post('/notes', [
    //         'title' => 'Test Title',
    //         'content_markdown' => 'Test Content',
    //     ]);

    //     dd($response->status()); // Hangi status kodu döndüğünü gör
    // }

    // public function test_user_can_create_note()
    // {
    //     // 1. Kullanıcı oluştur
    //     $user = User::factory()->create([
    //         'email_verified_at' => now(),
    //     ]);

    //     // 2. Oturum aç
    //     $this->actingAs($user);

    //     // 3. Form verileri
    //     $formData = [
    //         'title' => 'Test Note Title',
    //         'content_markdown' => 'This is a test content',
    //     ];

    //     // 4. POST isteği gönder
    //     $response = $this->post(route('notes.store'), $formData);

    //     // 5. Yönlendirme kontrolü
    //     $response->assertRedirect(route('notes.index'));

    //     // 6. Veritabanında kontrol et
    //     $this->assertDatabaseHas('t_note', [
    //         'title' => 'Test Note Title',
    //         'content_markdown' => 'This is a test content',
    //         'user_id' => $user->id,
    //     ]);
    // }

    // public function test_user_can_create_note2()
    // {
    //     $user = User::factory()->create([
    //         'email_verified_at' => now(),
    //     ]);

    //     $this->actingAs($user);

    //     $formData = [
    //         'title' => 'Test Note Title',
    //         'content_markdown' => 'This is a test content',
    //     ];

    //     $response = $this->post(route('notes.store'), $formData);

    //     // Buraya geçici olarak şu satırları ekle
    //     echo $response->getStatusCode();
    //     dump($response->getContent());

    //     $response->assertRedirect(route('notes.index'));
    // }

}
