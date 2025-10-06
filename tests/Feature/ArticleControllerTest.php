<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Article;

class ArticleControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_view_articles_index()
    {
        $user = User::factory()->create();
        Article::factory()->count(3)->create(['user_id' => $user->id]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertViewIs('articles.index');
        $response->assertViewHas('articles');
    }

    public function test_can_view_single_article()
    {
        $user = User::factory()->create();
        $article = Article::factory()->create(['user_id' => $user->id]);

        $response = $this->get("/articles/{$article->id}");

        $response->assertStatus(200);
        $response->assertViewIs('articles.show');
        $response->assertViewHas('article');
        $response->assertSee($article->title);
    }

    public function test_admin_can_create_article()
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->post('/admin/articles', [
            'title' => 'New article',
            'content' => 'New article content',
            'excerpt' => 'New article description'
        ]);

        $response->assertRedirect('/admin/articles');
        $this->assertDatabaseHas('articles', [
            'title' => 'New article',
            'user_id' => $admin->id
        ]);
    }

    public function test_guest_cannot_create_article()
    {
        $response = $this->post('/admin/articles', [
            'title' => 'Guest article',
            'content' => 'Content',
            'excerpt' => 'Description'
        ]);

        $response->assertRedirect('/login');
        $this->assertDatabaseMissing('articles', [
            'title' => 'Guest article'
        ]);
    }
}
