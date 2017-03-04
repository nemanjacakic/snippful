<?php

use App\Tag;
use App\User;
use Illuminate\Database\Seeder;

class SnippetsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::whereName('User')->first();

        $snippets = factory(App\Snippet::class, 10)->create(['user_id' => $user->id]);

        $tags = App\Tag::all();

        $snippets->each(function($snippet) use ($tags) {
            $snippet->tags()->saveMany($tags->random( rand(2, 10) )->all());
        });
    }
}
