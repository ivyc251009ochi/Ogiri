<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomAnswer;

class RoomScoreController extends Controller
{
    /**
     * 結果表示
     */
    public function result(Room $room)
    {
        $answers = RoomAnswer::where('room_id', $room->id)
            ->with('user')
            ->withCount('votes')
            ->orderByDesc('votes_count')
            ->get();

        return view('rooms.result', compact(
            'room',
            'answers'
        ));
    }
}