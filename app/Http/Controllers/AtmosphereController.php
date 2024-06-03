<?php

namespace App\Http\Controllers;

use App\Models\Atmosphere;
use App\Models\Question;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AtmosphereController extends Controller
{
    public function create(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $atmosphere = Atmosphere::create([
            'name' => $request->name
        ]);

        $atmosphere->users($request->user()->id, ['joined_at' => now()]);

        return response()->json(['message' => 'Atmosphere created successfully', 'atmosphere' => $atmosphere], 201);
    }

    public function invite(Request $request, Atmosphere $atmosphere) {
        $request->validate([
            'private_key' => 'required|string',
        ]);

        $user = User::where('private_key', $request->private_key)->firstorFail();

        if ($atmosphere->users()->count() >= 5) {
            return response()->json(['message' => 'Atmosphere is full'], 400);
        }

        $atmosphere->users()->attach($user->id, ['jointed_at' => now()]);
    }

    public function removeUser(Atmosphere $atmosphere, User $user) {
        $atmosphere->users()->detach($user->id);
        return response()->json(['message' => 'User removed from atmosphere']);
    }

    public function generateQuestion(Request $request, Atmosphere $atmosphere) {
        $question = Question::inRandomOrder()->first();

        $atmosphere->questions()->attach($question->id);

        return response()->json(['message' => 'Question generated successfully', 'question' => $question]);
    }

    public function getQuestions(Atmosphere $atmosphere)
    {
        $questions = $atmosphere->questions()->get();
        return response()->json($questions);
    }

    public function answerQuestion(Request $request, Atmosphere $atmosphere, Question $question)
    {
        $request->validate([
            'answer_content' => 'required|string',
        ]);

        $answer = $question->answers()->create([
            'user_id' => $request->users()->id,
            'answer_content' => $request->answer_content,
            'rating' => 0,
        ]);

        return response()->json(['message' => 'Question answered successfully', 'answer' => $answer]);
    }
}