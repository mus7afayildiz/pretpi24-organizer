<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class ShowPagesTest extends TestCase
{
    #[Test]
    public function homepage_displays_successfully(): void
    {
        $response = $this->get('/');  // Doğru rotayı kullanın
        // HTTP 200 döndüğünden emin ol
        $response->assertStatus(200);

        // Sayfa içeriğinde belirli bir metin var mı? (optional)
        //$response->assertSee('Laravel'); // veya welcome.blade.php'deki bir içerik
    }

    #[Test]
    public function login_page_displays_successfully(): void
    {
        $response = $this->get('/login');  // Doğru rotayı kullanın
        // HTTP 200 döndüğünden emin ol
        $response->assertStatus(200);

        // Sayfa içeriğinde belirli bir metin var mı? (optional)
        //$response->assertSee('Laravel'); // veya welcome.blade.php'deki bir içerik
    }

    #[Test]
    public function register_page_displays_successfully(): void
    {
        $response = $this->get('/register');  // Doğru rotayı kullanın
        // HTTP 200 döndüğünden emin ol
        $response->assertStatus(200);

        // Sayfa içeriğinde belirli bir metin var mı? (optional)
        //$response->assertSee('Laravel'); // veya welcome.blade.php'deki bir içerik
    }

}
