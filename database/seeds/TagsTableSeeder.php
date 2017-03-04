<?php

use App\User;
use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::whereName('User')->first();

        factory(App\Tag::class, 10)->create(['user_id' => $user->id]);
    }
}
