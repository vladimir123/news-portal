<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\User;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('email', 'admin@example.com')->first();

        $articles = [
            [
                'title' => 'Welcome to our news portal',
                'excerpt' => "This is the first article on our news portal. We'll be publishing the most current news here.",
                'content' => 'Welcome to our news portal! We are pleased to introduce a new platform for publishing and discussing news. Our portal is built using modern technologies and provides a high level of security and ease of use. Here you can read the latest news, leave comments, and participate in discussions. We hope you find our portal a reliable source of information.',
                'user_id' => $admin->id
            ],
            [
                'title' => 'Lorem Ipsum is simply dummy text of the printing',
                'excerpt' => "able English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum'",
                'content' => "industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets co",
                'user_id' => $admin->id
            ],
            [
                'title' => 'Where does it come from?',
                'excerpt' => '. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, fr',
                'content' => "t the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the In",
                'user_id' => $admin->id
            ]
        ];

        foreach ($articles as $articleData) {
            Article::create($articleData);
        }
    }
}
