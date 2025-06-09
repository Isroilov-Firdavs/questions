<?php

namespace App\Http\Controllers;

use App\Models\TestSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResultController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sessions = TestSession::where('user_id', Auth::id())
            ->withCount([
                'userAnswers as correct_count' => function ($query) {
                    $query->where('is_correct', true);
                }
            ])
            ->orderBy('created_at', 'desc') // oxirgi yaratilgan birinchi chiqadi
            ->get();

        return view('result.index', compact('sessions'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
