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


class AtmosphereController extends Controller
{
    public function index(Request $request) {
        $atmosphere = $request->user()->atmospheres;
        return response()->json($atmosphere);
    }
    
    public function store(StoreAtmoshpereRequest $request) {
        $validated = $request->validated();

        $atmosphere = Atmosphere::create([
            'name' => $validated['name'],
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

    public function show(Atmosphere $atmosphere) {
        return response()->json($atmosphere->load('users'));
    }

    public function update(UpdateAtmosphereRequest $request, Atmosphere $atmosphere) {
        $validated = $request->validated();

        if ($request->user()->id !== $atmosphere->creator_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $atmosphere->update(['name' => $validated['name']]);

        return response()->json(['atmosphere' => $atmosphere]);
    }

    public function destroy(Request $request, Atmosphere $atmosphere) {
        if ($request->user()->id !== $atmosphere->creator_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $atmosphere->delete();

        return response()->json(['message' => 'Atmosphere deleted successfully']);
    }

    public function invite(InviteUserRequest $request, Atmosphere $atmosphere) {
        if ($request->user()->id !== $atmosphere->creator_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validated();

        $user = User::where('private_key', $validated['private_key'])->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        if ($atmosphere->users->contains($user->id)) {
            return response()->json(['message' => 'User already in atmosphere'], 400);
        }

        if ($atmosphere->users()->count() >= 5) {
            return response()->json(['message' => 'Atmosphere is full'], 400);
        }

        $atmosphere->users()->attach($user->id, ['joined_at' => now()]);

        return response()->json(['message' => 'User invited successfully']);
    }

    public function removeUser(Atmosphere $atmosphere, User $user) {
        if (Auth::user()->id !== $atmosphere->creator_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $atmosphere->users()->detach($user->id);
        return response()->json(['message' => 'User removed from atmosphere']);
    }

    public function generateQuestion(Request $request, Atmosphere $atmosphere) {
        $user = $request->user();

        // Check if the user is part of the atmosphere
        if (!$atmosphere->users->contains($user->id)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Check if there are any unanswered questions in the atmosphere
        $unansweredQuestions = $atmosphere->questions()
            ->whereDoesntHave('answers', function ($query) use ($atmosphere) {
                $query->whereIn('answered_by', $atmosphere->users->pluck('id'));
            })->exists();

        if ($unansweredQuestions) {
            return response()->json(['message' => 'You cannot generate a new question until all existing questions have been answered by all users'], 403);
        }

        // Check if it is the user's turn to generate a question
        $lastQuestion = $atmosphere->questions()->latest('pivot_created_at')->first();
        $lastUserId = $lastQuestion ? $lastQuestion->pivot->created_by : null;
        $nextUserId = $this->getNextUserId($atmosphere, $lastUserId);

        if ($nextUserId !== $user->id) {
            return response()->json(['message' => 'It is not your turn to generate a question'], 403);
        }

        // Select a random question
        $question = Question::inRandomOrder()->first();
        $atmosphere->questions()->attach($question->id, ['created_by' => $user->id]);

        return response()->json(['message' => 'Question generated successfully', 'question' => $question]);
    }

    private function getNextUserId(Atmosphere $atmosphere, $lastUserId) {
        $users = $atmosphere->users->pluck('id')->toArray();
        if (is_null($lastUserId)) {
            return $users[0];
        }

        $currentIndex = array_search($lastUserId, $users);
        $nextIndex = ($currentIndex + 1) % count($users);

        return $users[$nextIndex];
    }

    public function getQuestions(Request $request, Atmosphere $atmosphere)
    {

        $user = $request->user();

        // Check if the user is part of the atmosphere
        if (!$atmosphere->users->contains($user->id)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $questions = $atmosphere->questions()->with('answers')->get();
        return response()->json($questions);
    }

    public function answerQuestion(AnswerQuestionRequest $request, Atmosphere $atmosphere, Question $question)
    {
        $user = $request->user();

        if (!$atmosphere->users->contains($user->id)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $createdByUser = $atmosphere->questions()->where('question_id', $question->id)->wherePivot('created_by', $user->id)->exists();
        if (!$createdByUser) {
            return response()->json(['message' => 'You can only answer questions you generated'], 403);
        }

        $validated = $request->validated();

        $answer = $question->answers()->create([
            'answered_by' => $request->user()->id,
            'answer_content' => $validated['answer_content'],
            'rating' => 0,
        ]);

        return response()->json(['message' => 'Question answered successfully', 'answer' => $answer]);
    }

    public function getJoinedAtmospheres(Request $request)
    {
        $user = $request->user();

        $joinedAtmospheres = $user->atmospheres()->get();

        return response()->json($joinedAtmospheres);
    }
}