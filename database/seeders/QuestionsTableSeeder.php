<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class QuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $questions = [
            ['content' => 'What is your favorite hobby?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'If you could travel anywhere, where would you go?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'What is your dream job?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'What is your favorite book?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'Who is your role model?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'What is your favorite movie?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'What is your biggest accomplishment?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'What is your favorite food?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'What is your favorite sport?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'If you could have any superpower, what would it be?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'What is your favorite song?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'What is the most interesting place you have visited?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'What is your favorite season?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'What is your favorite animal?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'What is your favorite color?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'What is your favorite childhood memory?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'What is your favorite holiday?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'What is your biggest fear?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'What is your favorite quote?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'If you could meet any historical figure, who would it be?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'What is your favorite TV show?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'What is your favorite subject in school?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'What is your favorite type of music?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'What is your favorite drink?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'What is your favorite dessert?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'What is your favorite type of weather?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'What is your favorite type of cuisine?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'What is your favorite game?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'What is your favorite way to relax?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'What is your favorite type of art?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];

        DB::table('questions')->insert($questions);
    }
}
