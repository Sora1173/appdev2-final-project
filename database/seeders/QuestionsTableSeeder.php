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
            ['content' => 'What do you want to know about someone that you\'ve been to scared to ask?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'What needs to happen fr you to put courage over comfort?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'Where is a lack of courage holding you back?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'Where is your feer of responsibility preventing you from taking the next step?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'How are you able to love someone you don\'t agree with?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'What would it take to remove the biggest obstacle between you and your goals?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'How do oyu let yourself down?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'What negative trait do you publicly laugh about, but secretly know you have to fix?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'What conversation do you need to have to set yourself free?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'Who is the strongest person you know, and how do you wish you were more like them', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'What is the saddest memory from your childhood?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'What would you hope would be said in your eulogy?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'What is your social media weakness?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'Describe a time when you let someone down', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'When did a guardian angel show up in your life?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'What song best defines your life?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'How do you intentionally upset others?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'In what ways are you bad with money?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'What event in your past are you too scared to talk about?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'Tell me about a prank that went horribly wrong!', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'Is violence ever acceptable?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'What beliefs would you want to pass onto your children or grandchildren?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'Why is there still poverty in the 21st century?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'What is your North Star?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'Will higher taxes or more philanthropy solve the world\'s problems?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'Which groups do you have a negative bias towards?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'Describe a time when it\'s right to pursue power/money over people?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'Describe a belief you\'d still hold tight, even if someone showed you evidence to the contrary?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'What beliefs have you adopted from othere people that don\'t serve you now?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'What affirmation do you need to wire into your programming?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'What would you do for work even if you weren\'t paid for it?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'Where are you settling when you could be thriving?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'What kind of mentor do you need to help you level up your life?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'What do people say you can\'t do that you\'re sure you could if you really tried?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'What skill do you need to acquire to achieve your next goal?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'What\'s at the top of your bucket lists, and how will you make that happen?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'What\'s your secret success strategy?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'Fast forward 20 years...what does life looks like now?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'Where are you making work the reason for not achieving your dreams?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'What part do you want to play in solving a global problem?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'Which teacher had the biggest impact on you and why?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'Where in your life do you feel misunderstood?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'Describe a time when you were your own worst enemy.', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'If people cam with a warning label, what would yours say?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'How do you best receive criticism?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'What act of self-care should become a non-negotiable in your life?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'If someone wanted to annoy you easily, what would they have to do?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'Other than the financial rewards, what else have you gained in your current work?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'In what ways are you like your parents?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'What would you refuse to give up even if you were offered $10 million?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'Describe a time when you need extreme courage to keep going because others gave up.', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'What book has had a profound impact on your life and why?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'What are the daly rituals you swear by and think everyone else should explore too?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'Would you rather win 1,000,000 pesos or earn 1,000,000 pesos?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'What piece of advice would you give your younger self if you could?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'Describe a time in youre life when the phrase "when it rains, it pours" applied?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'Describe a time when you believed giving up was the right thing to do, but regretted it in hindsight.', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'As a child, what rules were made to be broken?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'If you could only leave your children one life lesson, what would it be?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['content' => 'Which trip changed your life for the better?', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];

        DB::table('questions')->insert($questions);
    }
}
