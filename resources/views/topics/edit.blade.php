@extends('layouts.app')

@section('content')

<div class="topic-edit-container">

    <h1>✏️ お題を編集</h1>

    <p class="description">
        お題の内容を編集できます。
    </p>

    <form
        action="{{ route('topics.update', $topic) }}"
        method="POST"
    >

        @csrf
        @method('PATCH')

        <!-- お題 -->
        <div class="form-group">

            <label for="title">
                お題
            </label>

            <input
                type="text"
                id="title"
                name="title"
                value="{{ old('title', $topic->title) }}"
                placeholder="例：こんな学校は嫌だ。どんな学校？"
                required
            >

            @error('title')
                <p class="error">
                    {{ $message }}
                </p>
            @enderror

        </div>

        <!-- お題の種類 -->
        <div class="form-group">

            <label for="topic_type">
                お題の種類
            </label>

            <select
                id="topic_type"
                name="topic_type"
                required
            >

                <option
                    value="text"
                    {{ old('topic_type', $topic->topic_type) == 'text' ? 'selected' : '' }}
                >
                    テキスト
                </option>

                <option
                    value="drawing"
                    {{ old('topic_type', $topic->topic_type) == 'drawing' ? 'selected' : '' }}
                >
                    イラスト
                </option>

                <option
                    value="image"
                    {{ old('topic_type', $topic->topic_type) == 'image' ? 'selected' : '' }}
                >
                    画像
                </option>

            </select>

            @error('topic_type')
                <p class="error">
                    {{ $message }}
                </p>
            @enderror

        </div>

        <!-- 説明 -->
        <div class="form-group">

            <label for="description">
                説明
                <span>（任意）</span>
            </label>

            <textarea
                id="description"
                name="description"
                rows="5"
                placeholder="お題についての説明を入力してください"
            >{{ old('description', $topic->description) }}</textarea>

            @error('description')
                <p class="error">
                    {{ $message }}
                </p>
            @enderror

        </div>

        <!-- ボタン -->
        <div class="buttons">

            <button
                type="submit"
                class="update-button"
            >
                ✏️ お題を更新する
            </button>

            <a
                href="{{ route('topics.show', $topic) }}"
                class="back-button"
            >
                お題に戻る
            </a>

        </div>

    </form>

</div>


<style>

.topic-edit-container {
    max-width: 800px;

    margin: 40px auto;

    padding: 40px;

    background: #ffffff;

    border-radius: 20px;

    box-shadow:
        0 8px 25px rgba(0, 0, 0, 0.10);
}


/* タイトル */

.topic-edit-container h1 {
    margin-bottom: 10px;

    color: #3d0f5e;

    font-size: 32px;

    font-weight: bold;
}


/* 説明 */

.description {
    margin-bottom: 30px;

    color: #666;

    font-size: 16px;
}


/* フォーム */

.form-group {
    margin-bottom: 25px;
}


/* ラベル */

.form-group label {
    display: block;

    margin-bottom: 8px;

    color: #3d0f5e;

    font-size: 17px;

    font-weight: bold;
}


.form-group label span {
    color: #888;

    font-size: 14px;

    font-weight: normal;
}


/* 入力欄 */

.form-group input,
.form-group textarea,
.form-group select {

    width: 100%;

    box-sizing: border-box;

    padding: 14px;

    border: 2px solid #ddd;

    border-radius: 10px;

    background: #ffffff;

    color: #333;

    font-size: 16px;
}


/* フォーカス */

.form-group input:focus,
.form-group textarea:focus,
.form-group select:focus {

    outline: none;

    border-color: #ff4f87;

    box-shadow:
        0 0 0 3px rgba(255, 79, 135, 0.12);
}


/* セレクト */

.form-group select {
    cursor: pointer;
}


/* エラー */

.error {
    margin-top: 6px;

    color: #e53935;

    font-size: 14px;
}


/* ボタン */

.buttons {

    display: flex;

    gap: 15px;

    margin-top: 30px;
}


.update-button {

    padding: 14px 25px;

    border: none;

    border-radius: 10px;

    background: #ff4f87;

    color: white;

    font-size: 16px;

    font-weight: bold;

    cursor: pointer;

    transition: 0.2s;
}


.update-button:hover {

    background: #e83e76;

    transform: translateY(-2px);
}


.back-button {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    padding: 14px 25px;

    border-radius: 10px;

    background: #e8e8e8;

    color: #3d0f5e;

    text-decoration: none;

    font-weight: bold;

    transition: 0.2s;
}


.back-button:hover {

    background: #d8d8d8;

    transform: translateY(-2px);
}


/* スマホ */

@media (max-width: 600px) {

    .topic-edit-container {

        margin: 20px 15px;

        padding: 25px 20px;
    }

    .topic-edit-container h1 {

        font-size: 26px;
    }

    .buttons {

        flex-direction: column;
    }

    .update-button,
    .back-button {

        width: 100%;

        box-sizing: border-box;

        text-align: center;
    }

}

</style>

@endsection