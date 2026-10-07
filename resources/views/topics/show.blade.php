@extends('layouts.app')

@section('content')

<div class="topic-show-container">

    {{-- ================================
         お題
    ================================= --}}

    <div class="topic-card">

        <div class="topic-type">

            @if($topic->topic_type === 'text')
                📝 テキスト
            @elseif($topic->topic_type === 'drawing')
                🎨 イラスト
            @elseif($topic->topic_type === 'image')
                🖼️ 画像
            @else
                📌 その他
            @endif

        </div>


        <h1>{{ $topic->title }}</h1>


        {{-- 説明 --}}
        @if($topic->description)

            <div class="topic-description">

                <strong>📝 説明</strong>

                <p>
                    {{ $topic->description }}
                </p>

            </div>

        @endif


        <p class="topic-type-text">

            種類：

            @if($topic->topic_type === 'text')
                テキスト
            @elseif($topic->topic_type === 'drawing')
                イラスト
            @elseif($topic->topic_type === 'image')
                画像
            @else
                その他
            @endif

        </p>


        {{-- お題画像 --}}
        @if($topic->image_path)

            <div class="topic-image">

                <img
                    src="{{ asset('storage/'.$topic->image_path) }}"
                    alt="お題画像"
                >

            </div>

        @endif


        {{-- お題ボタン --}}
        <div class="topic-buttons">

            <a
                href="{{ route('topics.edit', $topic) }}"
                class="edit-button"
            >
                ✏️ 編集
            </a>


            <a
                href="{{ route('answers.create', ['topic_id' => $topic->id]) }}"
                class="answer-button"
            >
                💬 回答する
            </a>

        </div>

    </div>


    {{-- ================================
         回答一覧
    ================================= --}}

    <div class="answers-section">

        <div class="answers-header">

            <div>
                <h2>💬 回答一覧</h2>

                <p class="answers-subtitle">
                    このお題へのみんなの回答
                </p>
            </div>

            <a
                href="{{ route('answers.create', ['topic_id' => $topic->id]) }}"
                class="answer-header-button"
            >
                ＋ 回答する
            </a>

        </div>


        @forelse($topic->answers as $answer)

            <div class="answer-card">

                {{-- 回答者 --}}
                <div class="answer-user">

                    <div class="user-icon">
                        👤
                    </div>

                    <div>

                        <h3>
                            {{ $answer->user->name ?? 'ゲスト' }}
                        </h3>

                        <div class="answer-date">
                            投稿日：
                            {{ $answer->created_at->format('Y-m-d H:i:s') }}
                        </div>

                    </div>

                </div>


{{-- 回答内容 --}}
@if($answer->answer_type === 'text')

    <div class="result-answer">

    {{-- テキスト回答 --}}
    @if($answer->answer_type === 'text')

        <div class="result-text">
            {{ $answer->content }}
        </div>

    {{-- 画像回答 --}}
    @elseif($answer->answer_type === 'image')

        @if($answer->image_path)
            <div class="result-answer-image">
                <img
                    src="{{ asset('storage/' . $answer->image_path) }}"
                    alt="回答画像"
                >
            </div>
        @endif

    {{-- イラスト回答 --}}
    @elseif($answer->answer_type === 'drawing')

        @if($answer->drawing_path)
            <div class="result-answer-image">
                <img
                    src="{{ asset('storage/' . $answer->drawing_path) }}"
                    alt="回答イラスト"
                >
            </div>
        @endif

    @endif

</div>
@endif
<div class="result-vote">
    <div class="vote-number">
        {{ $answer->votes_count }}
    </div>

    <div class="vote-label">
        票
    </div>
</div>


                {{-- 補足説明 --}}
                @if($answer->description)

                    <div class="description">

                        <strong>💡 補足説明</strong>

                        <p>
                            {{ $answer->description }}
                        </p>

                    </div>

                @endif


                {{-- いいね --}}
                <div class="vote-area">

                    <form
                        action="{{ route('votes.store') }}"
                        method="POST"
                    >

                        @csrf

                        <input
                            type="hidden"
                            name="answer_id"
                            value="{{ $answer->id }}"
                        >

                        <button
                            type="submit"
                            class="vote-button"
                        >
                            👍 いいね
                        </button>

                    </form>


                    <span class="vote-count">
                        👍 {{ $answer->vote_count ?? 0 }}票
                    </span>

                </div>


                {{-- 編集・削除 --}}
                @auth

                    <div class="answer-actions">

                        <a
                            href="{{ route('answers.edit', $answer) }}"
                            class="answer-edit"
                        >
                            ✏️ 編集
                        </a>


                        <form
                            action="{{ route('answers.destroy', $answer) }}"
                            method="POST"
                        >

                            @csrf

                            @method('DELETE')

                            <button
                                type="submit"
                                class="answer-delete"
                                onclick="return confirm('回答を削除しますか？')"
                            >
                                🗑️ 削除
                            </button>

                        </form>

                    </div>

                @endauth

            </div>


        @empty

            <div class="no-answers">

                <div class="no-answers-icon">
                    💭
                </div>

                <h3>
                    まだ回答はありません
                </h3>

                <p>
                    最初の回答を投稿してみましょう！
                </p>

                <a
                    href="{{ route('answers.create', ['topic_id' => $topic->id]) }}"
                    class="answer-button"
                >
                    💬 回答する
                </a>

            </div>

        @endforelse

    </div>


    {{-- ================================
         戻る
    ================================= --}}

    <div class="back-area">

        <a
            href="{{ route('topics.index') }}"
            class="back-button"
        >
            ← お題一覧に戻る
        </a>

    </div>

</div>


<style>

/* ========================================
   ページ全体
======================================== */

.topic-show-container {

    width: 100%;

    min-height: calc(100vh - 80px);

    padding: 60px 50px 100px;

    box-sizing: border-box;

    background:
        linear-gradient(
            135deg,
            #f5f3ff 0%,
            #ffffff 45%,
            #fff1f7 100%
        );
}


/* ========================================
   お題カード
======================================== */

.topic-card {

    position: relative;

    width: 100%;

    max-width: 1450px;

    margin: 0 auto;

    padding: 50px 60px;

    box-sizing: border-box;

    background:
        linear-gradient(
            135deg,
            #315da5,
            #426bb0
        );

    border-radius: 28px;

    color: #ffffff;

    box-shadow:
        0 16px 40px
        rgba(35, 63, 110, 0.23);

   
}


/* カードの飾り */

.topic-card::after {

    content: "💡";

    position: absolute;

    right: 55px;

    bottom: 15px;

    font-size: 160px;

    opacity: 0.10;

    pointer-events: none;
}


/* ========================================
   種類ラベル
======================================== */

.topic-type {

    position: relative;

    z-index: 1;

    display: inline-block;

    padding: 11px 22px;

    background:
        rgba(255,255,255,0.20);

    border:
        1px solid
        rgba(255,255,255,0.35);

    border-radius: 14px;

    color: #ffffff;

    font-size: 19px;

    font-weight: 700;

    margin-bottom: 25px;
}


/* ========================================
   お題タイトル
======================================== */

.topic-card h1 {

    position: relative;

    z-index: 1;

    max-width: 1150px;

    margin: 0 0 30px;

    color: #ffffff;

    font-size: 46px;

    line-height: 1.45;

    font-weight: 800;

    letter-spacing: 0.5px;
}


/* ========================================
   種類
======================================== */

.topic-type-text {

    position: relative;

    z-index: 1;

    color: #edf4ff;

    font-size: 18px;

    margin: 20px 0;
}


/* ========================================
   説明
======================================== */

.topic-description {

    position: relative;

    z-index: 1;

    max-width: 1100px;

    margin: 25px 0;

    padding: 24px 28px;

    background:
        rgba(255,255,255,0.12);

    border:
        1px solid
        rgba(255,255,255,0.20);

    border-radius: 15px;

    color: #ffffff;
}


.topic-description strong {

    font-size: 20px;
}


.topic-description p {

    margin: 12px 0 0;

    color: #edf4ff;

    font-size: 18px;

    line-height: 1.8;

    white-space: pre-wrap;
}


/* ========================================
   お題画像
======================================== */

.topic-image {

    position: relative;

    z-index: 1;

    margin-top: 30px;
}


.topic-image img {

    width: auto;

    max-width: 700px;

    

    display: block;

    border-radius: 18px;

    box-shadow:
        0 8px 25px
        rgba(0,0,0,0.22);
}


/* ========================================
   お題ボタン
======================================== */

.topic-buttons {

    position: relative;

    z-index: 2;

    display: flex;

    gap: 18px;

    margin-top: 35px;

    flex-wrap: wrap;
}


.edit-button,
.answer-button {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    min-height: 54px;

    padding: 14px 28px;

    box-sizing: border-box;

    border-radius: 14px;

    text-decoration: none;

    font-size: 18px;

    font-weight: 700;

    color: #ffffff !important;

    transition: 0.2s;
}


.edit-button {

    background: #35c878;

    box-shadow:
        0 7px 16px
        rgba(53,200,120,0.25);
}


.answer-button {

    background: #ff4f87;

    box-shadow:
        0 7px 16px
        rgba(255,79,135,0.25);
}


.edit-button:hover,
.answer-button:hover {

    transform: translateY(-3px);

    filter: brightness(1.08);
}


/* ========================================
   回答一覧
======================================== */

.answers-section {

    width: 100%;

    max-width: 1450px;

    margin: 55px auto 0;
}


/* 回答一覧ヘッダー */

.answers-header {

    display: flex;

    align-items: flex-end;

    justify-content: space-between;

    gap: 25px;

    margin-bottom: 30px;
}


.answers-section h2 {

    margin: 0;

    color: #173f70;

    font-size: 38px;

    line-height: 1.3;

    font-weight: 800;
}


.answers-subtitle {

    margin: 10px 0 0;

    color: #66788c;

    font-size: 17px;
}


.answer-header-button {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    min-height: 50px;

    padding: 12px 24px;

    background: #ff4f87;

    color: #ffffff !important;

    text-decoration: none;

    border-radius: 13px;

    font-size: 17px;

    font-weight: 700;

    box-shadow:
        0 7px 16px
        rgba(255,79,135,0.22);

    transition: 0.2s;
}


.answer-header-button:hover {

    transform: translateY(-2px);

    filter: brightness(1.08);
}


/* ========================================
   回答カード
======================================== */

.answer-card {

    position: relative;

    width: 100%;

    margin-bottom: 25px;

    padding: 32px 38px;

    box-sizing: border-box;

    background: #ffffff;

    border-radius: 22px;

    border-left: 7px solid #426bb0;

    box-shadow:
        0 9px 25px
        rgba(30,60,100,0.10);

    transition:
        transform 0.2s ease,
        box-shadow 0.2s ease;
}


.answer-card:hover {

    transform: translateY(-2px);

    box-shadow:
        0 13px 30px
        rgba(30,60,100,0.14);
}


/* ========================================
   回答者
======================================== */

.answer-user {

    display: flex;

    align-items: center;

    gap: 15px;

    margin-bottom: 22px;
}


.user-icon {

    display: flex;

    align-items: center;

    justify-content: center;

    width: 50px;

    height: 50px;

    flex-shrink: 0;

    background:
        linear-gradient(
            135deg,
            #eef4ff,
            #f5f0ff
        );

    border-radius: 50%;

    font-size: 25px;
}


.answer-card h3 {

    margin: 0;

    color: #315da5;

    font-size: 21px;

    font-weight: 700;
}


/* ========================================
   回答画像・イラスト
======================================== */

/* =========================
   回答画像・手書きイラスト
   ========================= */

/* =========================
   回答画像・手書きイラスト
   ========================= */

/* =========================
   回答画像・手書きイラスト
   ========================= */

/* =========================
   回答画像・手書きイラスト
   ========================= */

/* =========================
   回答画像・手書きイラスト
   ========================= */

/* =========================
   回答画像・手書きイラスト
========================= */

.answer-image {
    width: 100%;
    max-width: 100%;

    margin: 20px auto;

    padding: 15px;

    box-sizing: border-box;

    border-radius: 15px;

    background: #ffffff;

    text-align: center;

    overflow: hidden;
}


/* 実際の画像 */
.answer-image img {
    display: block;

    width: 80%;
    max-width: 100%;

    height: auto;

    margin: 0 auto;

    border-radius: 10px;

    object-fit: contain;
}
/* ========================================
   補足説明
======================================== */

.description {

    margin-top: 20px;

    padding: 20px 22px;

    background: #f2f7ff;

    border:
        1px solid
        #dce9fb;

    border-radius: 14px;

    color: #31506f;
}


.description strong {

    color: #315da5;

    font-size: 17px;
}


.description p {

    margin: 10px 0 0;

    font-size: 16px;

    line-height: 1.7;

    white-space: pre-wrap;
}


/* ========================================
   投稿日
======================================== */

.answer-date {

    margin-top: 5px;

    color: #718096;

    font-size: 14px;
}


/* ========================================
   いいね
======================================== */

.vote-area {

    display: flex;

    align-items: center;

    gap: 18px;

    margin-top: 22px;
}


.vote-area form {

    margin: 0;
}


.vote-button {

    min-height: 46px;

    padding: 10px 20px;

    border: none;

    border-radius: 12px;

    background: #ffcf4a;

    color: #5a4300;

    font-size: 16px;

    font-weight: 700;

    cursor: pointer;

    transition: 0.2s;
}


.vote-button:hover {

    transform: translateY(-2px);

    filter: brightness(1.05);

    box-shadow:
        0 5px 12px
        rgba(180,140,0,0.18);
}


.vote-count {

    color: #31506f;

    font-size: 16px;

    font-weight: 700;
}


/* ========================================
   回答編集・削除
======================================== */

.answer-actions {

    display: flex;

    align-items: center;

    gap: 20px;

    margin-top: 20px;

    padding-top: 18px;

    border-top:
        1px solid
        #e5eaf1;
}


.answer-actions form {

    margin: 0;
}


.answer-edit {

    color: #218c5b;

    text-decoration: none;

    font-size: 15px;

    font-weight: 700;
}


.answer-delete {

    border: none;

    background: none;

    color: #e0445d;

    font-size: 15px;

    font-weight: 700;

    cursor: pointer;
}


.answer-edit:hover,
.answer-delete:hover {

    text-decoration: underline;
}


/* ========================================
   回答なし
======================================== */

.no-answers {

    width: 100%;

    padding: 80px 30px;

    box-sizing: border-box;

    text-align: center;

    background: #ffffff;

    border-radius: 22px;

    box-shadow:
        0 9px 25px
        rgba(30,60,100,0.10);
}


.no-answers-icon {

    font-size: 75px;

    margin-bottom: 20px;
}


.no-answers h3 {

    margin: 0 0 12px;

    color: #31506f;

    font-size: 28px;
}


.no-answers p {

    margin: 0 0 30px;

    color: #718096;

    font-size: 17px;
}


/* ========================================
   戻るボタン
======================================== */

.back-area {

    width: 100%;

    max-width: 1450px;

    margin: 35px auto 0;
}


.back-button {

    display: inline-flex;

    align-items: center;

    min-height: 48px;

    padding: 11px 22px;

    background: #e7edf6;

    color: #31506f !important;

    text-decoration: none;

    border-radius: 12px;

    font-size: 16px;

    font-weight: 700;

    transition: 0.2s;
}


.back-button:hover {

    background: #dce5f2;

    transform: translateY(-2px);
}


/* ========================================
   1536px以上
======================================== */

@media (min-width: 1536px) {

    .topic-show-container {

        padding-left: 70px;

        padding-right: 70px;
    }


    .topic-card,
    .answers-section,
    .back-area {

        max-width: 1550px;
    }


    .topic-card {

        padding: 60px 70px;
    }


    .topic-card h1 {

        font-size: 50px;
    }


    .answer-content {

        font-size: 22px;
    }

}


/* ========================================
   1024px以下
======================================== */

@media (max-width: 1024px) {

    .topic-show-container {

        padding: 45px 25px 80px;
    }


    .topic-card {

        padding: 40px;
    }


    .answers-header {

        align-items: flex-start;

        flex-direction: column;
    }


    .answer-header-button {

        width: 100%;
    }

}


/* ========================================
   スマートフォン
======================================== */

@media (max-width: 700px) {

    .topic-show-container {

        padding: 30px 15px 60px;
    }


    .topic-card {

        padding: 28px 22px;

        border-radius: 20px;
    }


    .topic-card::after {

        right: 10px;

        font-size: 90px;
    }


    .topic-type {

        font-size: 16px;
    }


    .topic-card h1 {

        font-size: 28px;
    }


    .topic-description {

        padding: 18px;
    }


    .topic-description p {

        font-size: 16px;
    }


    .topic-image img {

        width: 100%;

        height: auto;
    }


    .topic-buttons {

        flex-direction: column;
    }


    .edit-button,
    .answer-button {

        width: 100%;

        text-align: center;
    }


    .answers-section h2 {

        font-size: 28px;
    }


    .answer-header-button {

        width: 100%;
    }


    .answer-card {

        padding: 24px 20px;

        border-radius: 18px;
    }


    .answer-content {

        font-size: 18px;

        padding: 18px;
    }


    .vote-area {

        align-items: flex-start;

        flex-direction: column;
    }


    .answer-actions {

        flex-wrap: wrap;
    }


    .no-answers {

        padding: 60px 20px;
    }

}

</style>

@endsection