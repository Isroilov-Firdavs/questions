<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\UserAnswer;
use App\Models\TestSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class TestController extends Controller
{
    public function indexDashboard()
    {
        return view('dashboard');
    }

    // Testni boshlash - yangi session yaratish va boshlash vaqtini yozish
    public function startTest()
    {
        $testSession = TestSession::create([
            'user_id' => Auth::id(),
            'started_at' => Carbon::now(),
        ]);

        return redirect()->route('test.take', ['session' => $testSession->id]);
    }

    // Test savollarini ko'rsatish
    public function takeTest(TestSession $session)
    {
        $questions = Question::inRandomOrder()->limit(50)->get();

        // User faqat o'z sessionini ko'ra olishi kerak
        if ($session->user_id !== Auth::id()) {
            abort(403);
        }

        // Agar test tugagan bo'lsa, redirect natijalarga
        if ($session->finished_at) {
            return redirect()->route('test.result', ['session' => $session->id]);
        }

        return view('test.take', compact('questions', 'session'));
    }

    // Javob saqlash (AJAX uchun)
    public function saveAnswer(Request $request, TestSession $session)
    {
        // Foydalanuvchining o‘z sessiyasi ekanligini va test hali yakunlanmaganligini tekshirish
        if ($session->user_id !== Auth::id() || $session->finished_at) {
            return response()->json(['error' => 'Unauthorized or test finished'], 403);
        }

        $validated = $request->validate([
            'question_id' => 'required|exists:questions,id',
            'selected_option' => 'required|in:a,b,c,d',
        ]);

        $question = Question::findOrFail($validated['question_id']);
        $is_correct = $question->correct_option === $validated['selected_option'];

        // Javobni saqlaymiz (update yoki create)
        UserAnswer::updateOrCreate(
            [
                'test_session_id' => $session->id,
                'question_id' => $validated['question_id'],
            ],
            [
                'selected_option' => $validated['selected_option'],
                'is_correct' => $is_correct,
            ]
        );

        return response()->json([
            'success' => true,
            'is_correct' => $is_correct,
            'correct_option' => $question->correct_option,
        ]);
    }

    public function finishTest(TestSession $session)
    {
        if ($session->user_id !== Auth::id() || $session->finished_at) {
            abort(403);
        }

        $session->update([
            'finished_at' => Carbon::now(),
        ]);

        // Redirect o‘rniga front-endga URLni yuboramiz:
        return response()->json([
            'redirect_url' => route('test.result', ['session' => $session->id])
        ]);
    }


    // Test natijalarini ko'rsatish
    public function showResult(TestSession $session)
    {
        if ($session->user_id !== Auth::id()) {
            abort(403);
        }

        $answers = $session->userAnswers()->with('question')->get();

        return view('test.result', compact('answers', 'session'));
    }

    // User dashboard - barcha test sessionlar va natijalar
    public function userDashboard()
    {
        $sessions = TestSession::where('user_id', Auth::id())->withCount(['userAnswers as correct_count' => function ($query) {
            $query->where('is_correct', true);
        }])->get();

        return view('dashboard.user', compact('sessions'));
    }

    // Admin dashboard - barcha user testlari va natijalar
    public function adminDashboard()
    {
        $sessions = TestSession::with('user', 'userAnswers')->get();

        return view('dashboard.admin', compact('sessions'));
    }
}
