<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnswerQuestionRequest;
use App\Http\Requests\InviteUserRequest;
use App\Http\Requests\StoreAtmoshpereRequest;
use App\Http\Requests\UpdateAtmosphereRequest;
use App\Models\Atmosphere;
use App\Models\Question;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AtmosphereController extends Controller
{
    public function index(Request $request) {
        $atmosphere = $request->user()->atmospheres;
        return response()->json($atmosphere);
    }
    
    public function store(StoreAtmoshpereRequest $request) {
        $validated = $request->validated();

        $atmosphere = Atmosphere::create([
            'name' => $validated->name,
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

    public function update(UpdateAtmosphereRequest $request, Atmosphere $atmosphere)
    {
        $validated = $request->validated();

        if ($request->user()->id !== $atmosphere->creator_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $atmosphere->update(['name' => $validated->name]);

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

    public function invite(InviteUserRequest $request, Atmosphere $atmosphere)
    {
        if ($request->user()->id !== $atmosphere->creator_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validated();

        $user = User::where('private_key', $validated->private_key)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        if ($atmosphere->users()->count() >= 5) {
            return response()->json(['message' => 'Atmosphere is full'], 400);
        }

        $atmosphere->users()->attach($user->id, ['joined_at' => now()]);

        return response()->json(['message' => 'User invited successfully']);
    }

    public function removeUser(Atmosphere $atmosphere, User $user)
    {
        if (Auth::user()->id !== $atmosphere->creator_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

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
        if (!$atmosphere->users->contains(Auth::user()->id)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $questions = $atmosphere->questions()->with('answers')->get();
        return response()->json($questions);
    }

    public function answerQuestion(AnswerQuestionRequest $request, Atmosphere $atmosphere, Question $question)
    {
        if (!$atmosphere->users->contains(Auth::user()->id)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validated();

        $answer = $question->answers()->create([
            'user_id' => $request->user()->id,
            'answer_content' => $validated->answer_content,
            'rating' => 0,
        ]);

        return response()->json(['message' => 'Question answered successfully', 'answer' => $answer]);
    }
}