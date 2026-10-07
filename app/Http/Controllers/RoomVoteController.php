<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomAnswer;
use App\Models\RoomVote;
use Illuminate\Http\Request;

class RoomVoteController extends Controller
{
    /**
     * 投票する
     */
    public function store(Request $request, Room $room)
    {
        $request->validate([
            'room_answer_id' => 'required|exists:room_answers,id',
        ]);

        // 投票対象の回答を取得
        $answer = RoomAnswer::findOrFail(
            $request->room_answer_id
        );

        // 別のルームの回答には投票できないようにする
        if ($answer->room_id !== $room->id) {
            abort(403);
        }

        // ログイン中のユーザーID
        $userId = auth()->id();

        // 同じ回答への二重投票をチェック
        $alreadyVoted = RoomVote::where('room_id', $room->id)
            ->where('answer_id', $answer->id)
            ->where('user_id', $userId)
            ->exists();

        if ($alreadyVoted) {
            return back()->with(
                'error',
                'この回答にはすでに投票しています。'
            );
        }

        // 投票を保存
        RoomVote::create([
            'room_id' => $room->id,
            'answer_id' => $answer->id,
            'user_id' => $userId,
        ]);

        return back()->with(
            'success',
            '投票しました！'
        );
    }
}