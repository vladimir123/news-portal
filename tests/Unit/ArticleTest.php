<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Article;
use App\Models\User;
use App\Models\Comment;


class ArticleTest extends TestCase
{
    public function test_can_create_article_instance()
    {
        $article = new Article([
            'title' => 'Test Article',
            'content' => 'Test content',
            'excerpt' => 'Test excerpt',
            'user_id' => 1
        ]);

        $this->assertEquals('Test Article', $article->title);
        $this->assertEquals('Test content', $article->content);
        $this->assertEquals('Test excerpt', $article->excerpt);
        $this->assertEquals(1, $article->user_id);
    }

    public function test_article_fillable_attributes()
    {
        $article = new Article();
        $expected = ['title', 'content', 'excerpt', 'user_id'];

        $this->assertEquals($expected, $article->getFillable());
    }

    public function test_article_uses_correct_table()
    {
        $article = new Article();
        $this->assertEquals('articles', $article->getTable());
    }

    public function test_article_has_user_relationship()
    {
        $article = new Article();

        // Проверяем, что метод user() существует
        $this->assertTrue(method_exists($article, 'user'));
        $this->assertTrue(method_exists($article, 'comments'));
        $this->assertTrue(method_exists($article, 'approvedComments'));
    }
}
