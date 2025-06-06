<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\UserAnswer;
use App\Models\TestSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class TestController extends Controller
{

    public function info()
    {
        return view('test.start');  // Bu yerda "Boshlash" tugmasi bor
    }

    // Testni boshlash (POST)
    public function startTest()
    {
        $user = Auth::user();

        // Test sessiyasini yaratish yoki kerak bo'lsa boshqa ish qilish
        // Lekin sizda vaqt kerak emas, shuning uchun oddiy yo'naltirish qilamiz

        return redirect()->route('test.take');
    }

    // Test savollari chiqadigan sahifa
    public function takeTest()
    {
        $questions = Question::inRandomOrder()->limit(200)->get();

        return view('test.take', compact('questions'));
    }

    // Javobni saqlash API
    public function saveAnswer(Request $request)
    {
        $request->validate([
            'question_id' => 'required|exists:questions,id',
            'selected_option' => 'required|in:A,B,C,D',
        ]);

        $user = Auth::user();

        $question = Question::findOrFail($request->question_id);

        $is_correct = strtoupper($request->selected_option) === strtoupper($question->correct_option);

        UserAnswer::updateOrCreate(
            [
                'user_id' => $user->id,
                'question_id' => $question->id,
            ],
            [
                'selected_option' => strtoupper($request->selected_option),
                'is_correct' => $is_correct,
            ]
        );

        return response()->json([
            'success' => true,
            'is_correct' => $is_correct,
            'correct_option' => $question->correct_option,
        ]);
    }

    public function submitTest(Request $request)
    {
        dd($request->all());
        // $user = Auth::user();

        // $testSessionId = $request->input('test_session_id');
        // $testSession = TestSession::findOrFail($testSessionId);

        // if ($testSession->user_id !== $user->id) {
        //     abort(403, 'Ruxsat yo‘q');
        // }

        // $answers = $request->input('answers'); // ['question_id' => 'A', ...]

        // foreach ($answers as $questionId => $selectedOption) {
        //     $question = Question::find($questionId);

        //     if (!$question) continue;

        //     $isCorrect = strtoupper($selectedOption) === strtoupper($question->correct_option);

        //     UserAnswer::updateOrCreate(
        //         [
        //             'user_id' => $user->id,
        //             'question_id' => $questionId,
        //         ],
        //         [
        //             'selected_option' => strtoupper($selectedOption),
        //             'is_correct' => $isCorrect,
        //         ]
        //     );
        // }

        // $testSession->status = 'completed';
        // $testSession->finished_at = now();
        // $testSession->save();

        // return redirect()->route('test.result', $testSession->id);
    }

    public function showResult(TestSession $testSession)
    {
        $user = Auth::user();

        if ($testSession->user_id !== $user->id) {
            abort(403, 'Ruxsat yo‘q');
        }

        $answers = UserAnswer::where('user_id', $user->id)
                             ->whereIn('question_id', Question::pluck('id'))
                             ->get();

        $correctCount = $answers->where('is_correct', true)->count();

        return view('test.result', compact('testSession', 'answers', 'correctCount'));
    }
}
