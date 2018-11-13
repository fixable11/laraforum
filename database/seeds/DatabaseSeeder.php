<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {


        factory(App\Category::class, 6)->create()->each(function ($category){

            $user = factory(App\User::class)->create();

            factory(App\Channel::class, 5)->create(['category_id' => $category->id])
                ->each(function ($channel) use ($user){

                    factory(App\Thread::class, 5)->create([
                            'channel_id' => $channel->id,
                            'user_id' => $user->id,
                        ]);

                });
        });
    }
}
