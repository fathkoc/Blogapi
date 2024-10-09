<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Blog;
use App\Models\Category;
use App\Services\ContentModerationService;
use Mockery;
use App\Http\Middleware\VerifyCsrfToken;

class BlogApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Blog oluşturma işlemi test edilir.
     */
    public function test_blog_creation()
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);
        // Geçerli bir kategori oluşturuyoruz
        $category = Category::factory()->create();

        $response = $this->postJson('/blogs', [
            'title' => 'Test Blog',
            'content' => 'Bu bir test blog içeriğidir.',
            'author' => 'Test Author',
            'image' => 'test-image-url.jpg',
            'category_id' => $category->id, // Oluşturulan kategorinin id'sini kullanıyoruz
        ]);

        $response->assertStatus(201);
        $response->assertJson([
            'title' => 'Test Blog',
            'author' => 'Test Author',
        ]);
    }

    /**
     * Mikroservis entegrasyonu ile içerik denetimi test edilir.
     */
    public function test_content_moderation_service()
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);
        $category = Category::factory()->create();

        // Mocking ContentModerationService
        $moderationServiceMock = Mockery::mock(ContentModerationService::class);
        $this->app->instance(ContentModerationService::class, $moderationServiceMock);

        // Mocked response
        $moderationServiceMock->shouldReceive('moderateContent')
            ->once()
            ->with('Bu bir test blog içeriğidir.')
            ->andReturn([
                'status' => 'approved',
                'message' => 'İçerik uygun.'
            ]);

        $response = $this->postJson('/blogs', [
            'title' => 'Test Blog',
            'content' => 'Bu bir test blog içeriğidir.',
            'author' => 'Test Author',
            'image' => 'test-image-url.jpg',
            'category_id' => $category->id,
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('blogs', ['title' => 'Test Blog']);
    }

    /**
     * Uygunsuz içerik tespiti durumunda blog kaydının reddedilmesi test edilir.
     */
    public function test_content_rejection_due_to_inappropriate_content()
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);
        $category = Category::factory()->create();

        // Mocking ContentModerationService
        $moderationServiceMock = Mockery::mock(ContentModerationService::class);
        $this->app->instance(ContentModerationService::class, $moderationServiceMock);

        // Mocked response for rejected content
        $moderationServiceMock->shouldReceive('moderateContent')
            ->once()
            ->with('Uygunsuz içerik.')
            ->andReturn([
                'status' => 'rejected',
                'message' => 'İçerik uygunsuz bulundu.'
            ]);

        $response = $this->postJson('/blogs', [
            'title' => 'Uygunsuz Blog',
            'content' => 'Uygunsuz içerik.',
            'author' => 'Test Author',
            'image' => 'test-image-url.jpg',
            'category_id' => $category->id,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['content']);
    }
}
