<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomUser;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * ルーム一覧
     */
    public function index()
    {
        $rooms = Room::latest()->get();

        return view('rooms.index', compact('rooms'));
    }

    /**
     * 作成画面
     */
    public function create()
    {
        return view('rooms.create');
    }

    /**
     * 保存
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
        ]);

        $room = Room::create([
            'name' => $request->name,
            'host_user_id' => auth()->id(),
            'status' => 'waiting',
        ]);

        return redirect()
            ->route('rooms.show', $room)
            ->with('success', 'ルームを作成しました。');
    }

    /**
     * 詳細
     */
    public function show(Room $room)
    {
        $room->load([
            'roomUsers.user',
            'topic',
            'answers.user',
            'answers.votes',
        ]);

        $topics = \App\Models\Topic::latest()->get();

        return view(
            'rooms.show',
            compact('room', 'topics')
        );
    }

    /**
     * ルーム参加
     */
    public function join(Room $room)
    {
        $userId = auth()->id();

        $exists = RoomUser::where('room_id', $room->id)
            ->where('user_id', $userId)
            ->exists();

        if (!$exists) {

            RoomUser::create([
                'room_id' => $room->id,
                'user_id' => $userId,
            ]);
        }

        return redirect()
            ->route('rooms.show', $room)
            ->with('success', 'ルームに参加しました。');
    }

    /**
     * お題設定
     */
    public function setTopic(Request $request, Room $room)
    {
        $request->validate([
            'topic_id' => 'required|exists:topics,id',
        ]);

        $room->update([
            'topic_id' => $request->topic_id,
        ]);

        return back()
            ->with('success', 'お題を設定しました。');
    }
}