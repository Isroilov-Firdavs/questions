<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use Illuminate\Support\Facades\Storage;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $questions = Question::latest()->paginate(20);
        return view('questions.index', compact('questions'));
    }

    public function create()
    {
        return view('questions.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'question' => 'required|string',
            'image' => 'nullable|image',
            'option_a' => 'required',
            'option_b' => 'required',
            'option_c' => 'required',
            'option_d' => 'required',
            'correct_option' => 'required|in:a,b,c,d',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('questions', 'public');
        }

        Question::create($data);

        return redirect()->route('questions.index')->with('success', 'Savol qo‘shildi');
    }

    public function edit(Question $question)
    {
        return view('questions.edit', compact('question'));
    }

    public function update(Request $request, Question $question)
    {
        $data = $request->validate([
            'question' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'required|string',
            'correct_option' => 'required|in:A,B,C,D',
        ]);
        // dd($request->all());

        if ($request->hasFile('image')) {
            if ($question->image) {
                Storage::disk('public')->delete($question->image);
            }
            $data['image'] = $request->file('image')->store('questions', 'public');
        } else {
            $data['image'] = $question->image;
        }


        $question->update($data);

        return redirect()->route('questions.index')->with('success', 'Savol yangilandi');

    }


    public function destroy(Question $question)
    {
        if ($question->image) {
            Storage::delete($question->image);
        }

        $question->delete();
        return back()->with('success', 'Savol o‘chirildi');
    }
    public function show(Question $question)
    {
        return view('questions.show', compact('question'));
    }
}
