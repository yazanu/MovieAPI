<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([

            'name' => 'bob',

            'email' => 'bob@gmail.com',

            'password' => bcrypt('12345678'),

        ]);

        DB::table('genres')
            ->insert([
            ['name' => 'Action', 'created_at' => Carbon::now()],
            ['name' => 'Comedy', 'created_at' => Carbon::now()],
            ['name' => 'Drama', 'created_at' => Carbon::now()],
            ['name' => 'Fantasy', 'created_at' => Carbon::now()],
            ['name' => 'Horror', 'created_at' => Carbon::now()],
            ['name' => 'Mystery', 'created_at' => Carbon::now()],
            ['name' => 'Romance', 'created_at' => Carbon::now()],
            ['name' => 'Thriller', 'created_at' => Carbon::now()],
        ]);

        DB::table('movies')
        ->insert([
            [
                "cover_image" => "/4HodYYKEIsGOdinkGi2Ucz6X9i0.jpg",
                "genres" => 1,
                "title" => "Spider-Man: Across the Spider-Verse",
                "summary" => "After reuniting with Gwen Stacy, Brooklyn’s full-time, friendly neighborhood Spider-Man is catapulted across the Multiverse, where he encounters the Spider Society, a team of Spider-People charged with protecting the Multiverse’s very existence. But when the heroes clash on how to handle a new threat, Miles finds himself pitted against the other Spiders and must set out on his own to save those he loves most.",
                "created_at" => "2023-05-31",
                "rating" => 8,
                "author" => "Zayn",
                "pdf_link" => "abc.com/pdf/1",
                "user_id" => 1,
            ],
            [
                "cover_image" => "/2vFuG6bWGyQUzYS9d69E5l85nIz.jpg",
                "genres" => 2,
                "title" => "Transformers: Rise of the Beasts",
                "summary" => "When a new threat capable of destroying the entire planet emerges, Optimus Prime and the Autobots must team up with a powerful faction known as the Maximals. With the fate of humanity hanging in the balance, humans Noah and Elena will do whatever it takes to help the Transformers as they engage in the ultimate battle to save Earth.",
                "created_at" => "2023-06-06",
                "rating" => 8,
                "author" => "Zayn",
                "pdf_link" => "abc.com/pdf/1",
                "user_id" => 1,
            ],
            [
                "cover_image" => "/tTfnd2VrlaZJSBD9HUbtSF3CqPJ.jpg",
                "genres" => 4,
                "title" => "Barbie",
                "summary" => "Barbie and Ken are having the time of their lives in the colorful and seemingly perfect world of Barbie Land. However, when they get a chance to go to the real world, they soon discover the joys and perils of living among humans.",
                "created_at" => "2023-07-19",
                "rating" => 8,
                "author" => "Hailey Cooper",
                "pdf_link" => "abc.com/pdf/1",
                "user_id" => 1,
            ],
            [
                "cover_image" => "/yF1eOkaYvwiORauRCPWznV9xVvi.jpg",
                "genres" => 5,
                "title" => "The Flash",
                "summary" => "When his attempt to save his family inadvertently alters the future, Barry Allen becomes trapped in a reality in which General Zod has returned and there are no Super Heroes to turn to. In order to save the world that he is in and return to the future that he knows, Barry's only hope is to race for his life. But will making the ultimate sacrifice be enough to reset the universe?",
                "created_at" => "2023-06-13",
                "rating" => 8,
                "author" => "Zayn",
                "pdf_link" => "abc.com/pdf/1",
                "user_id" => 1,
            ],
            [
                "cover_image" => "/hPcP1kv6vrkRmQO3YgV1H97FE5Q.jpg",
                "genres" => 6,
                "title" => "Insidious: The Red Door",
                "summary" => "To put their demons to rest once and for all, Josh Lambert and a college-aged Dalton Lambert must go deeper into The Further than ever before, facing their family's dark past and a host of new and more horrifying terrors that lurk behind the red door.",
                "created_at" => "2023-07-05",
                "rating" => 8,
                "author" => "Zayn Tian",
                "pdf_link" => "abc.com/pdf/1",
                "user_id" => 1,
            ],
            [
                "cover_image" => "/bz66a19bR6BKsbY8gSZCM4etJiK.jpg",
                "genres" => 4,
                "title" => "The Flood",
                "summary" => "A horde of giant hungry alligators is unleashed on a group of in-transit prisoners and their guards after a massive hurricane floods Louisiana.",
                "created_at" => "2023-07-14",
                "rating" => 8,
                "author" => "Zayn",
                "pdf_link" => "abc.com/pdf/1",
                "user_id" => 1,
            ],
            [
                "cover_image" => "/zN41DPmPhwmgJjHwezALdrdvD0h.jpg",
                "genres" => 7,
                "title" => "Meg 2: The Trench",
                "summary" => "An exploratory dive into the deepest depths of the ocean of a daring research team spirals into chaos when a malevolent mining operation threatens their mission and forces them into a high-stakes battle for survival.",
                "created_at" => "2023-08-02",
                "rating" => 8,
                "author" => "Zayn Tain",
                "pdf_link" => "abc.com/pdf/1",
                "user_id" => 1,
            ],
            [
                "cover_image" => "/znUYFf0Sez5lUmxPr3Cby7TVJ6c.jpg",
                "genres" => 12,
                "title" => "The Little Mermaid",
                "summary" => "The youngest of King Triton’s daughters, and the most defiant, Ariel longs to find out more about the world beyond the sea, and while visiting the surface, falls for the dashing Prince Eric. With mermaids forbidden to interact with humans, Ariel makes a deal with the evil sea witch, Ursula, which gives her a chance to experience life on land, but ultimately places her life – and her father’s crown – in jeopardy.",
                "created_at" => "2023-05-18",
                "rating" => 8,
                "author" => "Hailey Cooper",
                "pdf_link" => "abc.com/pdf/1",
                "user_id" => 1,
            ],
        ]);

        DB::table('movie_tags')
            ->insert([
            ['movie_id' => 1, 'tag_id' => 1, 'created_at' => Carbon::now()],
            ['movie_id' => 1, 'tag_id' => 4, 'created_at' => Carbon::now()],
            ['movie_id' => 2, 'tag_id' => 2, 'created_at' => Carbon::now()],
            ['movie_id' => 2, 'tag_id' => 3, 'created_at' => Carbon::now()],
            ['movie_id' => 2, 'tag_id' => 5, 'created_at' => Carbon::now()],
            ['movie_id' => 3, 'tag_id' => 5, 'created_at' => Carbon::now()],
            ['movie_id' => 4, 'tag_id' => 1, 'created_at' => Carbon::now()],
            ['movie_id' => 4, 'tag_id' => 5, 'created_at' => Carbon::now()],
            ['movie_id' => 5, 'tag_id' => 2, 'created_at' => Carbon::now()],
            ['movie_id' => 5, 'tag_id' => 7, 'created_at' => Carbon::now()],
            ['movie_id' => 6, 'tag_id' => 7, 'created_at' => Carbon::now()],
            ['movie_id' => 7, 'tag_id' => 7, 'created_at' => Carbon::now()],
            
        ]);
    }
}
 