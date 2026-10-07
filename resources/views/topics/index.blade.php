@extends('layouts.app')

@section('content')

<div class="topics-page">

    {{-- ページタイトル --}}
    <div class="page-header">

        <div class="title-area">
            <span class="title-icon">💡</span>

            <div>
                <h1>お題一覧</h1>
                <p class="page-subtitle">
                    みんなのお題に挑戦してみよう！
                </p>
            </div>
        </div>

        <a href="{{ route('topics.create') }}" class="create-button">
            <span>＋</span>
            新しいお題を投稿
        </a>

    </div>


    {{-- 投稿成功メッセージ --}}
    @if(session('success'))

        <div class="success-message">
            <span class="success-icon">✓</span>
            <span>{{ session('success') }}</span>
        </div>

    @endif


    {{-- お題がない場合 --}}
    @if($topics->isEmpty())

        <div class="empty-message">

            <div class="empty-icon">💭</div>

            <h2>まだお題がありません</h2>

            <p>
                最初のお題を投稿してみましょう！
            </p>

            <a href="{{ route('topics.create') }}" class="empty-button">
                ＋ お題を作成する
            </a>

        </div>

    @else

        {{-- お題一覧 --}}
        <div class="topics-list">

            @foreach($topics as $topic)

                <div class="topic-card">

                    {{-- 種類 --}}
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


                    {{-- お題タイトル --}}
                    <h2 class="topic-title">
                        {{ $topic->title }}
                    </h2>


                    {{-- 説明 --}}
                    @if($topic->description)

                        <p class="topic-description">
                            {{ $topic->description }}
                        </p>

                    @endif


                    {{-- 情報 --}}
                    <div class="topic-info">

                        <div class="info-item">
                            <span class="info-icon">💬</span>

                            <span>
                                回答数：{{ $topic->answers_count ?? 0 }}件
                            </span>
                        </div>


                        <div class="info-item">

                            <span class="info-icon">📋</span>

                            <span>
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

                            </span>

                        </div>


                        <div class="info-item">

                            <span class="info-icon">📅</span>

                            <span>
                                投稿日：
                                {{ $topic->created_at->format('Y-m-d H:i:s') }}
                            </span>

                        </div>

                    </div>


                    {{-- ボタン --}}
                    <div class="topic-actions">

                        <a
                            href="{{ route('topics.show', $topic) }}"
                            class="action-button detail-button"
                        >
                            🔎 詳細
                        </a>


                        @auth

                            <a
                                href="{{ route('topics.edit', $topic) }}"
                                class="action-button edit-button"
                            >
                                ✏️ 編集
                            </a>


                            <form
                                action="{{ route('topics.destroy', $topic) }}"
                                method="POST"
                                onsubmit="return confirm('このお題を削除しますか？');"
                            >

                                @csrf

                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="action-button delete-button"
                                >
                                    🗑️ 削除
                                </button>

                            </form>

                        @endauth

                    </div>

                </div>

            @endforeach

        </div>

    @endif

</div>


<style>

/* ========================================
   ページ全体
======================================== */

.topics-page {

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

    color: #1e3a5f;
}


/* ========================================
   ヘッダー
======================================== */

.page-header {

    width: 100%;
    max-width: 1450px;

    margin: 0 auto 45px;

    display: flex;

    align-items: flex-end;

    justify-content: space-between;

    gap: 30px;
}


.title-area {

    display: flex;

    align-items: center;

    gap: 22px;
}


.title-icon {

    font-size: 64px;

    flex-shrink: 0;
}


.title-area h1 {

    margin: 0;

    color: #173f70;

    font-size: 52px;

    line-height: 1.2;

    font-weight: 800;

    letter-spacing: 1px;
}


.page-subtitle {

    margin: 12px 0 0;

    color: #66788c;

    font-size: 19px;

    font-weight: 500;
}


/* ========================================
   新規投稿ボタン
======================================== */

.create-button {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    gap: 10px;

    padding: 18px 30px;

    min-height: 58px;

    box-sizing: border-box;

    background:
        linear-gradient(
            135deg,
            #ff4f87,
            #ff3978
        );

    color: #ffffff !important;

    text-decoration: none;

    border-radius: 16px;

    font-size: 19px;

    font-weight: 700;

    white-space: nowrap;

    box-shadow:
        0 10px 25px
        rgba(255, 79, 135, 0.25);

    transition:
        transform 0.2s ease,
        box-shadow 0.2s ease;
}


.create-button span {

    font-size: 28px;

    line-height: 1;
}


.create-button:hover {

    transform: translateY(-3px);

    box-shadow:
        0 14px 30px
        rgba(255, 79, 135, 0.35);
}


/* ========================================
   成功メッセージ
======================================== */

.success-message {

    width: 100%;
    max-width: 1450px;

    margin: 0 auto 40px;

    display: flex;

    align-items: center;

    gap: 18px;

    padding: 20px 26px;

    box-sizing: border-box;

    background: #e9fff5;

    border: 2px solid #6ee7b7;

    border-radius: 16px;

    color: #087443;

    font-size: 19px;

    font-weight: 700;
}


.success-icon {

    display: flex;

    align-items: center;

    justify-content: center;

    width: 42px;

    height: 42px;

    flex-shrink: 0;

    background: #16a34a;

    color: #ffffff;

    border-radius: 50%;

    font-size: 25px;

    font-weight: bold;
}


/* ========================================
   お題一覧
======================================== */

.topics-list {

    width: 100%;
    max-width: 1450px;

    margin: 0 auto;

    display: flex;

    flex-direction: column;

    gap: 30px;
}


/* ========================================
   お題カード
======================================== */

.topic-card {

    position: relative;

    width: 100%;

    min-height: 300px;

    padding: 40px 48px;

    box-sizing: border-box;

    background:
        linear-gradient(
            135deg,
            #315da5,
            #426bb0
        );

    border-radius: 24px;

    color: #ffffff;

    box-shadow:
        0 14px 35px
        rgba(35, 63, 110, 0.22);

    overflow: hidden;

    transition:
        transform 0.2s ease,
        box-shadow 0.2s ease;
}


.topic-card:hover {

    transform: translateY(-3px);

    box-shadow:
        0 18px 40px
        rgba(35, 63, 110, 0.28);
}


/* ========================================
   カード右側の飾り
======================================== */

.topic-card::after {

    content: "💡";

    position: absolute;

    right: 45px;

    bottom: 20px;

    font-size: 130px;

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

    padding: 10px 20px;

    background:
        rgba(255, 255, 255, 0.20);

    border:
        1px solid
        rgba(255, 255, 255, 0.35);

    border-radius: 13px;

    color: #ffffff;

    font-size: 18px;

    font-weight: 700;

    margin-bottom: 22px;
}


/* ========================================
   お題タイトル
======================================== */

.topic-title {

    position: relative;

    z-index: 1;

    max-width: 1100px;

    margin: 0 0 25px;

    color: #ffffff !important;

    font-size: 36px;

    line-height: 1.5;

    font-weight: 800;

    letter-spacing: 0.5px;
}


/* ========================================
   説明
======================================== */

.topic-description {

    position: relative;

    z-index: 1;

    max-width: 1100px;

    margin: 0 0 28px;

    color: #edf4ff;

    font-size: 19px;

    line-height: 1.8;
}


/* ========================================
   お題情報
======================================== */

.topic-info {

    position: relative;

    z-index: 1;

    display: flex;

    flex-direction: column;

    gap: 14px;

    padding-bottom: 28px;

    border-bottom:
        1px solid
        rgba(255,255,255,0.35);

    margin-bottom: 28px;
}


.info-item {

    display: flex;

    align-items: center;

    gap: 14px;

    color: #ffffff;

    font-size: 18px;

    font-weight: 500;
}


.info-icon {

    width: 30px;

    flex-shrink: 0;

    font-size: 22px;

    text-align: center;
}


/* ========================================
   操作ボタン
======================================== */

.topic-actions {

    position: relative;

    z-index: 2;

    display: flex;

    align-items: center;

    gap: 16px;

    flex-wrap: wrap;
}


.topic-actions form {

    margin: 0;
}


.action-button {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    min-width: 135px;

    min-height: 50px;

    padding: 13px 24px;

    box-sizing: border-box;

    border: none;

    border-radius: 13px;

    color: #ffffff !important;

    text-decoration: none;

    font-size: 18px;

    font-weight: 700;

    cursor: pointer;

    transition:
        transform 0.2s ease,
        filter 0.2s ease,
        box-shadow 0.2s ease;
}


/* 詳細 */

.detail-button {

    background: #2f80ed;

    box-shadow:
        0 6px 15px
        rgba(47, 128, 237, 0.25);
}


/* 編集 */

.edit-button {

    background: #35c878;

    box-shadow:
        0 6px 15px
        rgba(53, 200, 120, 0.25);
}


/* 削除 */

.delete-button {

    background: #f0445d;

    box-shadow:
        0 6px 15px
        rgba(240, 68, 93, 0.25);
}


/* ホバー */

.action-button:hover {

    transform: translateY(-2px);

    filter: brightness(1.08);

    box-shadow:
        0 8px 18px
        rgba(0,0,0,0.20);
}


/* ========================================
   お題がない場合
======================================== */

.empty-message {

    width: 100%;

    max-width: 900px;

    margin: 80px auto;

    padding: 80px 40px;

    box-sizing: border-box;

    text-align: center;

    background: #ffffff;

    border-radius: 24px;

    box-shadow:
        0 12px 35px
        rgba(30, 60, 100, 0.10);
}


.empty-icon {

    font-size: 80px;

    margin-bottom: 25px;
}


.empty-message h2 {

    margin: 0 0 12px;

    color: #173f70;

    font-size: 32px;

    font-weight: 800;
}


.empty-message p {

    margin: 0 0 32px;

    color: #60758c;

    font-size: 19px;
}


.empty-button {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    padding: 16px 28px;

    background: #ff4f87;

    color: #ffffff !important;

    text-decoration: none;

    border-radius: 13px;

    font-size: 18px;

    font-weight: 700;

    transition: 0.2s;
}


.empty-button:hover {

    transform: translateY(-2px);

    filter: brightness(1.08);
}


/* ========================================
   1536px以上
======================================== */

@media (min-width: 1536px) {

    .topics-page {

        padding-left: 70px;

        padding-right: 70px;
    }


    .page-header,
    .success-message,
    .topics-list {

        max-width: 1550px;
    }


    .topic-card {

        min-height: 320px;

        padding: 45px 55px;
    }


    .topic-title {

        font-size: 40px;
    }


    .topic-description {

        font-size: 20px;
    }

}


/* ========================================
   1024px以下
======================================== */

@media (max-width: 1024px) {

    .topics-page {

        padding: 40px 25px 70px;
    }


    .page-header {

        align-items: flex-start;

        flex-direction: column;
    }


    .create-button {

        width: 100%;
    }


    .topic-card {

        padding: 35px;
    }

}


/* ========================================
   スマートフォン
======================================== */

@media (max-width: 700px) {

    .topics-page {

        padding: 30px 15px 60px;
    }


    .title-area {

        gap: 12px;
    }


    .title-icon {

        font-size: 42px;
    }


    .title-area h1 {

        font-size: 34px;
    }


    .page-subtitle {

        font-size: 15px;
    }


    .create-button {

        width: 100%;

        font-size: 17px;
    }


    .topic-card {

        min-height: auto;

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


    .topic-title {

        font-size: 26px;
    }


    .topic-description {

        font-size: 16px;
    }


    .info-item {

        font-size: 15px;
    }


    .topic-actions {

        flex-direction: column;

        align-items: stretch;
    }


    .action-button {

        width: 100%;

        min-width: 0;
    }


    .topic-actions form {

        width: 100%;
    }


    .success-message {

        font-size: 16px;
    }

}

</style>

@endsection