<?php

namespace App\Http\Controllers;

use App\Models\Atmosphere;
use App\Models\Question;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AtmosphereController extends Controller
{
    public function index(Request $request) {
        $atmosphere = $request->user()->atmospheres;
        return response()->json($atmosphere);
    }
    
    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $atmosphere = Atmosphere::create([
            'name' => $request->name,
            'creator_id' => $request->user()->id,
        ]);

        $atmosphere->users()->attach($request->user()->id, ['joined_at' => now()]);

        return response()->json(['atmosphere' => $atmosphere], 201);
    }

    public function getCreatedAtmospheres(Request $request) {
        $user = $request->user();
        $createdAtmospheres = $user->createdAtmospheres()->get();

        return response()->json($createdAtmospheres);
    }

    public function show(Atmosphere $atmosphere)
    {
        return response()->json($atmosphere->load('users'));
    }

    public function update(Request $request, Atmosphere $atmosphere)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        if ($request->user()->id !== $atmosphere->creator_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $atmosphere->update(['name' => $request->name]);

        return response()->json(['atmosphere' => $atmosphere]);
    }

    public function destroy(Request $request, Atmosphere $atmosphere)
    {
        if ($request->user()->id !== $atmosphere->creator_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $atmosphere->delete();

        return response()->json(['message' => 'Atmosphere deleted successfully']);
    }

    public function invite(Request $request, Atmosphere $atmosphere)
    {
        $request->validate([
            'private_key' => 'required|string',
        ]);

        $user = User::where('private_key', $request->private_key)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        if ($atmosphere->users()->count() >= 5) {
            return response()->json(['message' => 'Atmosphere is full'], 403);
        }

        $atmosphere->users()->attach($user->id, ['joined_at' => now()]);

        return response()->json(['message' => 'User invited successfully']);
    }

    public function removeUser(Atmosphere $atmosphere, User $user)
    {
        $atmosphere->users()->detach($user->id);
        return response()->json(['message' => 'User removed from atmosphere']);
    }

    public function generateQuestion(Request $request, Atmosphere $atmosphere)
    {
        if (!$atmosphere->users->contains($request->user()->id)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $pendingQuestionForUser = $atmosphere->questions()
        ->whereHas('answers', function ($query) use ($request) {
            $query->where('user_id', $request->user()->id);
        })->doesntExist();

        $allAnswered = $atmosphere->questions()
        ->whereDoesntHave('answers', function ($query) use ($atmosphere) {
            $query->whereIn('user_id', $atmosphere->users->pluck('id'));
        })->doesntExist();

        if (!$allAnswered && !$pendingQuestionForUser) {
            return response()->json(['message' => 'You cannot generate a new question until all users have answered their current questions'], 403);
        }
        
        $question = Question::inRandomOrder()->first();
        $atmosphere->questions()->attach($question->id);

        return response()->json(['message' => 'Question generated successfully', 'question' => $question]);

    }

    public function getQuestions(Atmosphere $atmosphere)
    {
        $questions = $atmosphere->questions()->with('answers')->get();
        return response()->json($questions);
    }

    public function answerQuestion(Request $request, Atmosphere $atmosphere, Question $question)
    {
        $request->validate([
            'answer_content' => 'required|string',
        ]);

        $answer = $question->answers()->create([
            'user_id' => $request->user()->id,
            'answer_content' => $request->answer_content,
            'rating' => 0,
        ]);

        return response()->json(['message' => 'Question answered successfully', 'answer' => $answer]);
    }
}