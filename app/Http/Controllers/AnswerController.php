<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnswerController extends Controller
{
    /**
     * 回答入力画面
     */
    public function create(Request $request)
    {
        $topic = Topic::findOrFail($request->topic_id);

        return view('answers.create', compact('topic'));
    }

    /**
     * 回答を保存
     */
    public function store(Request $request)
    {
        $request->validate([
            'topic_id' => 'required|exists:topics,id',
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
                ->store('answers', 'public');
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

                // Base64部分だけ取り出す
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

                // ファイル名
                $fileName = 'drawing_' . uniqid() . '.png';

                // storage/app/public/answers に保存
                Storage::disk('public')->put(
                    'answers/' . $fileName,
                    $drawingData
                );

                $drawingPath = 'answers/' . $fileName;

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

        Answer::create([
            'topic_id' => $request->topic_id,
            'user_id' => auth()->id(),
            'answer_type' => $request->answer_type,
            'content' => $content,
            'image_path' => $imagePath,
            'drawing_path' => $drawingPath,
            'description' => $request->description,
        ]);

        /*
        |--------------------------------------------------------------------------
        | お題ページへ戻る
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('topics.show', $request->topic_id)
            ->with('success', '回答を投稿しました。');
    }

    /**
     * 回答編集画面
     */
    public function edit(Answer $answer)
    {
        // 自分の回答か確認
        if ($answer->user_id !== auth()->id()) {
            abort(403, 'この回答を編集する権限がありません。');
        }

        return view('answers.edit', compact('answer'));
    }

    /**
     * 回答更新
     */
    public function update(Request $request, Answer $answer)
    {
        // 自分の回答か確認
        if ($answer->user_id !== auth()->id()) {
            abort(403, 'この回答を編集する権限がありません。');
        }

        $request->validate([
            'content' => 'nullable|max:1000',
            'description' => 'nullable|max:500',
        ]);

        $answer->update([
            'content' => $request->content,
            'description' => $request->description,
        ]);

        return redirect()
            ->route('topics.show', $answer->topic_id)
            ->with('success', '回答を更新しました。');
    }

    /**
     * 回答削除
     */
    public function destroy(Answer $answer)
    {
        // 自分の回答か確認
        if ($answer->user_id !== auth()->id()) {
            abort(403, 'この回答を削除する権限がありません。');
        }

        $topicId = $answer->topic_id;

        // 回答に紐づく画像を削除
        if ($answer->image_path) {
            Storage::disk('public')->delete($answer->image_path);
        }

        // 回答に紐づくイラストを削除
        if ($answer->drawing_path) {
            Storage::disk('public')->delete($answer->drawing_path);
        }

        // 回答を削除
        $answer->delete();

        return redirect()
            ->route('topics.show', $topicId)
            ->with('success', '回答を削除しました。');
    }
}