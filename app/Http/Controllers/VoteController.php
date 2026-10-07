<?php

namespace App\Http\Controllers;

use App\Models\Vote;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    /**
     * 投票する
     */
    public function store(Request $request)
    {
        $request->validate([
            'answer_id' => 'required|exists:answers,id',
        ]);

        $userId = auth()->id();

        // 同じユーザーが同じ回答に二重投票しない
        $exists = Vote::where('answer_id', $request->answer_id)
            ->where('user_id', $userId)
            ->exists();

        if (!$exists) {

            Vote::create([
                'answer_id' => $request->answer_id,
                'user_id' => $userId,
            ]);
        }

        return back()->with('success', '投票しました。');
    }
}