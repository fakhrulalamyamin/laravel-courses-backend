<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Author;
use App\Models\Course;
use App\Models\Platform;
use App\Models\Review;
use App\Models\Series;
use App\Models\Topic;
use App\Models\User;
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
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        User::create([
            'name' => 'Admin',
            'email' => 'yamin@hujursmart.com',
            'password' => bcrypt('password'),
            'type' => 1,
        ]);


        // make series
        $series = [
            [
                'name' => 'Laravel',
                'slug' => 'laravel',
                'image' => 'https://laravel-courses.test/img/laravel.png'
            ],
            [
                'name' => 'PHP',
                'slug' => 'php',
                'image' => 'https://laravel-courses.test/img/php.png'
            ],
            [
                'name' => 'Vue JS',
                'slug' => 'vuejs',
                'image' => 'https://laravel-courses.test/img/vue.png'
            ],
            [
                'name' => 'Alpine JS',
                'slug' => 'alpinejs',
                'image' => 'https://laravel-courses.test/img/alpine.png'
            ],
        ];

        foreach ($series as $item) {
            Series::create([
                'name' => $item['name'],
                'image' => $item['image'],
                'slug' => $item['slug']
            ]);
        }

        // make topics
        $topics = ['Eloquent', 'Validation', 'Refactoring', 'Testing', 'Authentication'];

        foreach ($topics as $topic) {

            $slug = strtolower(str_replace(' ', '-', $topic));

            Topic::create([
                'name' => $topic,
                'slug' => $slug
            ]);
        }

        // make platforms
        $platforms = ['Shikhun.net', 'Laracasts', 'Laravel Daily', 'Laravel Courses'];

        foreach ($platforms as $platform) {

            $slug = strtolower(str_replace(' ', '-', $platform));

            Platform::create([
                'name' => $platform,
                'slug' => $slug
            ]);
        }

        // make authors
        // $authors = ['Rasel Ahmed', 'Jefry Way', 'Brad Traversy'];

        // foreach ($authors as $author) {
        //     Author::create([
        //         'name' => $author
        //     ]);
        // }
        Author::factory(10)->create();

        User::factory(50)->create();

        Course::factory(100)->create();

        $courses = Course::all();

        foreach($courses as $course) {
            $topics = Topic::all()->random(rand(1, 5))->pluck('id')->toArray();
            $course->topics()->attach($topics);

            $authors = Author::all()->random(rand(1, 3))->pluck('id')->toArray();
            $course->authors()->attach($authors);

            $series = Series::all()->random(rand(1, 4))->pluck('id')->toArray();
            $course->series()->attach($series);
        }

        Review::factory(100)->create();

    }
}
