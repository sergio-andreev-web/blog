<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition()
    {
        $user = User::inRandomOrder()->first();

        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraphs(3, true),
            'user_id' => $user ? $user->id : User::factory(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Post $post) {
            $tags = Tag::inRandomOrder()->limit(rand(1, 10))->pluck('id')->toArray();
            $post->tags()->sync($tags);
        });
    }
}
