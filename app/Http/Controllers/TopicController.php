<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TopicController extends Controller
{
    /**
     * お題一覧
     */
    public function index()
{
    $topics = Topic::withCount('answers')
                    ->latest()
                    ->get();

    return view('topics.index', compact('topics'));
}

    /**
     * お題作成画面
     */
    public function create()
    {
        return view('topics.create');
    }

/**
 * お題保存
 */
public function store(Request $request)
{
    $request->validate([
        'title' => 'required|max:255',
        'description' => 'nullable|string',
        'topic_type' => 'required|in:text,drawing,image',
    ]);

    Topic::create([
        'user_id' => 1, // ログイン機能完成後は Auth::id()
        'title' => $request->title,
        'description' => $request->description,
        'topic_type' => $request->topic_type,
    ]);

    return redirect()
        ->route('topics.index')
        ->with('success', 'お題を投稿しました。');
}
/**
 * お題詳細
 */
public function show(Topic $topic)
{
    $topic->load('answers.user');

    return view('topics.show', compact('topic'));
}

/**
 * 編集画面
 */
public function edit(Topic $topic)
{
    return view('topics.edit', compact('topic'));
}

/**
 * 更新
 */
public function update(Request $request, Topic $topic)
{
    $request->validate([
        'title' => 'required|max:255',
        'topic_type' => 'required',
    ]);

    $topic->update([
        'title' => $request->title,
        'topic_type' => $request->topic_type,
    ]);

    return redirect()
        ->route('topics.index')
        ->with('success', 'お題を更新しました。');
}

/**
 * 削除
 */
public function destroy(Topic $topic)
{
    $topic->delete();

    return redirect()
        ->route('topics.index')
        ->with('success', 'お題を削除しました。');

}
/**
 * ランキング
 */
public function ranking()
{
    $topics = Topic::withCount('answers')
                    ->orderByDesc('answers_count')
                    ->get();

    return view('topics.ranking', compact('topics'));
}

}