<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomAnswerController;
use App\Http\Controllers\RoomVoteController;
use App\Http\Controllers\RoomScoreController;
use Illuminate\Support\Facades\Route;


// ========================================
// ホーム
// ========================================

Route::get('/', function () {
    return view('welcome');
});


// ========================================
// お題
// ========================================

// お題一覧
Route::get('/topics', [TopicController::class, 'index'])
    ->name('topics.index');
Route::middleware('auth')->group(function () {

    Route::get('/answers/create/{topic_id}', [AnswerController::class, 'create'])
        ->name('answers.create');

    Route::post('/answers', [AnswerController::class, 'store'])
        ->name('answers.store');

    // 投稿モードの投票
    Route::post('/votes', [VoteController::class, 'store'])
        ->name('votes.store');

    Route::get('/answers/{answer}/edit', [AnswerController::class, 'edit'])
        ->name('answers.edit');

    Route::patch('/answers/{answer}', [AnswerController::class, 'update'])
        ->name('answers.update');

    Route::delete('/answers/{answer}', [AnswerController::class, 'destroy'])
        ->name('answers.destroy');
});
// お題作成・保存・編集・更新・削除
// ※ /topics/{topic} より前に置くことが重要
Route::middleware('auth')->group(function () {

    // お題作成画面
    Route::get('/topics/create', [TopicController::class, 'create'])
        ->name('topics.create');

    // お題保存
    Route::post('/topics', [TopicController::class, 'store'])
        ->name('topics.store');

    // 編集画面
    Route::get('/topics/{topic}/edit', [TopicController::class, 'edit'])
        ->name('topics.edit');

    // 更新
    Route::patch('/topics/{topic}', [TopicController::class, 'update'])
        ->name('topics.update');

    // 削除
    Route::delete('/topics/{topic}', [TopicController::class, 'destroy'])
        ->name('topics.destroy');

});


// お題詳細
// ★ create より後に置く
Route::get('/topics/{topic}', [TopicController::class, 'show'])
    ->name('topics.show');


// ========================================
// 人気ランキング
// ========================================

Route::get('/ranking', [TopicController::class, 'ranking'])
    ->name('topics.ranking');

// ========================================
// パーティーモード
// ========================================

Route::middleware('auth')->group(function () {

    // ルーム一覧・作成・詳細
    Route::resource('rooms', RoomController::class);

    // ルーム参加
    Route::post('/rooms/{room}/join', [RoomController::class, 'join'])
        ->name('rooms.join');

    // お題設定
    Route::post('/rooms/{room}/topic', [RoomController::class, 'setTopic'])
        ->name('rooms.topic');


    // ====================================
    // ルーム回答
    // ====================================

    Route::get('/rooms/{room}/answer', [RoomAnswerController::class, 'create'])
        ->name('rooms.answer.create');

    Route::post('/rooms/{room}/answer', [RoomAnswerController::class, 'store'])
        ->name('rooms.answer.store');


    // ====================================
    // ルーム投票
    // ====================================

    Route::post('/rooms/{room}/vote', [RoomVoteController::class, 'store'])
        ->name('rooms.vote');


    // ====================================
    // 結果発表
    // ====================================

    Route::get('/rooms/{room}/result', [RoomScoreController::class, 'result'])
        ->name('rooms.result');

    Route::post('/rooms/{room}/result', [RoomScoreController::class, 'store'])
        ->name('rooms.result.store');

});


// ========================================
// ダッシュボード
// ========================================

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// ========================================
// プロフィール
// ========================================

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

});


// ========================================
// Breeze 認証
// ========================================

require __DIR__.'/auth.php';