<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RoomAnswerController extends Controller
{
    /**
     * 回答入力画面
     */
    public function create(Room $room)
    {
        $room->load('topic');

        return view('rooms.answer', compact('room'));
    }

    /**
     * 回答を保存
     */
    public function store(Request $request, Room $room)
    {
        // 入力チェック
        $request->validate([
            'answer_type' => 'required|in:text,drawing,image',
            'content' => 'nullable|max:1000',
            'description' => 'nullable|max:500',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:5120',
            'drawing_data' => 'nullable',
        ]);

        $content = null;
        $imagePath = null;
        $drawingPath = null;

        /*
        |--------------------------------------------------------------------------
        | 文字回答
        |--------------------------------------------------------------------------
        */
        if ($request->answer_type === 'text') {

            if (empty($request->content)) {
                return back()
                    ->withErrors([
                        'content' => '回答を入力してください。'
                    ])
                    ->withInput();
            }

            $content = $request->content;
        }

        /*
        |--------------------------------------------------------------------------
        | 画像回答
        |--------------------------------------------------------------------------
        */
        if ($request->answer_type === 'image') {

            if (!$request->hasFile('image')) {
                return back()
                    ->withErrors([
                        'image' => '画像を選択してください。'
                    ])
                    ->withInput();
            }

            $imagePath = $request->file('image')
                ->store('room_answers', 'public');
        }

        /*
        |--------------------------------------------------------------------------
        | イラスト回答
        |--------------------------------------------------------------------------
        */
        if ($request->answer_type === 'drawing') {

            if (empty($request->drawing_data)) {
                return back()
                    ->withErrors([
                        'drawing_data' => 'イラストを描いてください。'
                    ])
                    ->withInput();
            }

            $drawingData = $request->drawing_data;

            /*
             * data:image/png;base64,XXXX...
             * の形式を確認
             */
            if (preg_match(
    '/^data:image\/(\w+);base64,/',
    $drawingData,
    $matches
)) {

                // 「data:image/png;base64,」の部分を削除
                $drawingData = substr(
                    $drawingData,
                    strpos($drawingData, ',') + 1
                );

                // Base64をデコード
                $drawingData = base64_decode($drawingData);

                if ($drawingData === false) {
                    return back()
                        ->withErrors([
                            'drawing_data' => 'イラストの保存に失敗しました。'
                        ])
                        ->withInput();
                }

                // ファイル名を作成
                $fileName = 'drawing_' . uniqid() . '.png';

                // storage/app/public/room_answers に保存
                Storage::disk('public')->put(
                    'room_answers/' . $fileName,
                    $drawingData
                );

                $drawingPath = 'room_answers/' . $fileName;

            } else {

                return back()
                    ->withErrors([
                        'drawing_data' => 'イラストデータが正しくありません。'
                    ])
                    ->withInput();
            }
        }

        /*
        |--------------------------------------------------------------------------
        | データベースに保存
        |--------------------------------------------------------------------------
        */
RoomAnswer::create([
    'room_id' => $room->id,
    'topic_id' => $room->topic_id,
    'user_id' => auth()->id(),
    'answer_type' => $request->answer_type,
    'content' => $content,
    'image_path' => $imagePath,
    'drawing_path' => $drawingPath,
    'description' => $request->description,
]);
        /*
        |--------------------------------------------------------------------------
        | ルーム画面へ戻る
        |--------------------------------------------------------------------------
        */
        return redirect()
            ->route('rooms.show', $room)
            ->with('success', '回答を投稿しました！');
    }
}