
@extends('layouts.app')

@section('content')

<div class="ogiri-page party-show-page">

    <div class="party-container">

        {{-- =========================
             ヘッダー
        ========================== --}}
        <div class="party-header">

            <div>
                <div class="party-label">
                    🎮 PARTY MODE
                </div>

                <h1 class="party-title">
                    {{ $room->name }}
                </h1>

                <p class="party-subtitle">
                    みんなで大喜利を楽しもう！
                </p>
            </div>

            <a
                href="{{ route('rooms.index') }}"
                class="back-button"
            >
                ← ルーム一覧へ
            </a>

        </div>


        {{-- =========================
             成功メッセージ
        ========================== --}}
        @if(session('success'))

            <div class="success-message">
                ✓ {{ session('success') }}
            </div>

        @endif


        {{-- =========================
             エラーメッセージ
        ========================== --}}
        @if($errors->any())

            <div class="error-message">

                <strong>
                    入力内容を確認してください
                </strong>

                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

            </div>

        @endif


        {{-- =========================
             メインレイアウト
        ========================== --}}
        <div class="party-layout">

            {{-- =====================
                 左側
            ====================== --}}
            <div class="party-main">


                {{-- =====================
                     現在のお題
                ====================== --}}
                <section class="topic-card">

                    <div class="section-label">
                        📝 CURRENT TOPIC
                    </div>

                    @if($room->topic)

                        <h2 class="topic-title">
                            {{ $room->topic->title }}
                        </h2>

                        @if($room->topic->description)

                            <p class="topic-description">
                                {{ $room->topic->description }}
                            </p>

                        @endif

                    @else

                        <div class="no-topic">

                            <div class="no-topic-icon">
                                💡
                            </div>

                            <h2>
                                まだお題が設定されていません
                            </h2>

                            <p>
                                ホストがお題を設定すると、
                                ここに表示されます。
                            </p>

                        </div>

                    @endif

                </section>


                {{-- =====================
                     お題設定
                ====================== --}}
                @auth

                    @if($room->host_user_id === auth()->id())

                        <section class="setting-card">

                            <div class="section-label">
                                ⚙️ TOPIC SETTING
                            </div>

                            <h2 class="setting-title">
                                お題を設定
                            </h2>

                            <form
                                action="{{ route('rooms.topic', $room) }}"
                                method="POST"
                                class="topic-form"
                            >

                                @csrf

                                <select
                                    name="topic_id"
                                    class="topic-select"
                                >

                                    <option value="">
                                        お題を選択してください
                                    </option>

                                    @foreach($topics as $topic)

                                        <option
                                            value="{{ $topic->id }}"
                                            {{ $room->topic_id == $topic->id ? 'selected' : '' }}
                                        >
                                            {{ $topic->title }}
                                        </option>

                                    @endforeach

                                </select>

                                <button
                                    type="submit"
                                    class="setting-button"
                                >
                                    お題を設定する
                                </button>

                            </form>

                        </section>

                    @endif

                @endauth


                {{-- =====================
                     回答する
                ====================== --}}
                @if($room->topic)

                    <section class="answer-action-card">

                        <div>

                            <div class="section-label">
                                ✏️ ANSWER
                            </div>

                            <h2>
                                このお題に回答しよう！
                            </h2>

                            <p>
                                テキスト・イラスト・画像から
                                好きな方法で回答できます。
                            </p>

                        </div>

                        <a
                            href="{{ route('rooms.answer.create', $room) }}"
                            class="answer-button"
                        >
                            ✏️ 回答する
                            <span>→</span>
                        </a>

                    </section>

                @endif


                {{-- =====================
                     回答一覧
                ====================== --}}
                <section class="answers-section">

                    <div class="answers-header">

                        <div>

                            <div class="section-label">
                                💬 ANSWERS
                            </div>

                            <h2>
                                みんなの回答
                            </h2>

                        </div>

                        <span class="answer-count">
                            {{ $room->answers->count() }} 件
                        </span>

                    </div>


                    @if($room->answers->count() > 0)

                        <div class="answers-grid">

                            @foreach($room->answers as $answer)

                                <div class="answer-card">

                                    {{-- =====================
                                         回答者
                                    ====================== --}}
                                    <div class="answer-card-header">

                                        <div class="answer-user">

                                            <div class="user-icon">
                                                👤
                                            </div>

                                            <div>

                                                <strong>
                                                    {{ $answer->user?->name ?? 'ユーザー' }}
                                                </strong>

                                                <small>
                                                    {{ $answer->created_at->format('Y/m/d H:i') }}
                                                </small>

                                            </div>

                                        </div>

                                    </div>


                                    {{-- =====================
                                         回答内容
                                    ====================== --}}

                                    @if($answer->answer_type === 'text')

    <div class="answer-content">
        {{ $answer->content }}
    </div>

@elseif($answer->answer_type === 'image')

    @if($answer->image_path)
        <div class="answer-image">
            <img
                src="{{ asset('storage/' . $answer->image_path) }}"
                alt="回答画像"
            >
        </div>
    @endif

@elseif($answer->answer_type === 'drawing')

    @if($answer->drawing_path)
        <div class="answer-image">
            <img
                src="{{ asset('storage/' . $answer->drawing_path) }}"
                alt="回答イラスト"
            >
        </div>
    @endif

@endif


                                    {{-- =====================
                                         補足説明
                                    ====================== --}}

                                    @if($answer->description)

                                        <div class="answer-description">

                                            <span>
                                                💡 補足
                                            </span>

                                            {{ $answer->description }}

                                        </div>

                                    @endif


                                    {{-- =====================
     投票
===================== --}}

<div class="vote-area">

    <form
        action="{{ route('rooms.vote', $room) }}"
        method="POST"
    >

        @csrf

        <input
            type="hidden"
            name="room_answer_id"
            value="{{ $answer->id }}"
        >

        <button
            type="submit"
            class="vote-button"
        >
            ❤️ 投票する
        </button>

    </form>
    

    <span class="vote-count">
        ❤️ {{ $answer->votes->count() }}票
    </span>

</div>
<div class="result-button-area">

    <a
        href="{{ route('rooms.result', $room) }}"
        class="result-button"
    >
        🏆 結果を見る
    </a>

</div>


                                </div>

                            @endforeach

                        </div>

                    @else

                        <div class="empty-answers">

                            <div class="empty-answers-icon">
                                💭
                            </div>

                            <h3>
                                まだ回答がありません
                            </h3>

                            <p>
                                最初の回答を投稿してみましょう！
                            </p>

                        </div>

                    @endif

                </section>

            </div>


            {{-- =====================
                 右側：参加者
            ====================== --}}
            <aside class="party-sidebar">

                <section class="members-card">

                    <div class="section-label">
                        👥 MEMBERS
                    </div>

                    <div class="members-title-row">

                        <h2>
                            参加者
                        </h2>

                        <span class="member-count">
                            {{ $room->roomUsers->count() }}人
                        </span>

                    </div>


                    @if($room->roomUsers->count() > 0)

                        <div class="members-list">

                            @foreach($room->roomUsers as $roomUser)

                                <div class="member-item">

                                    <div class="member-icon">
                                        👤
                                    </div>

                                    <div class="member-name">

                                        {{ $roomUser->user?->name ?? 'ユーザー' }}

                                        @if($room->host_user_id === $roomUser->user_id)

                                            <span class="host-badge">
                                                HOST
                                            </span>

                                        @endif

                                    </div>

                                </div>

                            @endforeach

                        </div>

                    @else

                        <p class="no-members">
                            まだ参加者がいません。
                        </p>

                    @endif

                </section>


                {{-- =====================
                     参加ボタン
                ====================== --}}
                @auth

                    @php
                        $joined = $room->roomUsers
                            ->where('user_id', auth()->id())
                            ->count() > 0;
                    @endphp

                    @if(!$joined)

                        <section class="join-card">

                            <div class="join-icon">
                                🎮
                            </div>

                            <h2>
                                このルームに参加する
                            </h2>

                            <p>
                                参加して大喜利を楽しみましょう！
                            </p>

                            <form
                                action="{{ route('rooms.join', $room) }}"
                                method="POST"
                            >

                                @csrf

                                <button
                                    type="submit"
                                    class="join-button"
                                >
                                    ルームに参加する
                                </button>

                            </form>

                        </section>

                    @else

                        <div class="joined-message">
                            ✓ このルームに参加しています
                        </div>

                    @endif

                @endauth

            </aside>

        </div>

    </div>

</div>


<style>

/* =========================
   ページ
========================= */

.party-show-page {
    min-height: calc(100vh - 64px);

    background:
        radial-gradient(
            circle at top left,
            rgba(168, 85, 247, 0.12),
            transparent 35%
        ),
        radial-gradient(
            circle at bottom right,
            rgba(236, 72, 153, 0.12),
            transparent 35%
        ),
        linear-gradient(
            135deg,
            #faf5ff,
            #ffffff,
            #fdf2f8
        );
}

.party-container {
    width: 100%;
    max-width: 1450px;
    margin: 0 auto;
}


/* =========================
   ヘッダー
========================= */

.party-header {
    display: flex;
    align-items: center;
    justify-content: space-between;

    gap: 40px;

    margin-bottom: 40px;
}

.party-label {
    display: inline-block;

    margin-bottom: 12px;
    padding: 8px 18px;

    border-radius: 999px;

    background: #ede9fe;
    color: #7c3aed;

    font-size: 15px;
    font-weight: 800;

    letter-spacing: 0.08em;
}

.party-title {
    margin: 0;

    color: #4c1d95;

    font-size: 46px;
    line-height: 1.25;
    font-weight: 900;
}

.party-subtitle {
    margin-top: 12px;

    color: #64748b;

    font-size: 18px;
}

.back-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;

    min-height: 50px;
    padding: 0 22px;

    border-radius: 12px;

    background: white;
    border: 1px solid #ddd6fe;

    color: #6d28d9;

    font-size: 15px;
    font-weight: 800;

    text-decoration: none;
}


/* =========================
   メッセージ
========================= */

.success-message {
    margin-bottom: 25px;
    padding: 18px 24px;

    border-radius: 14px;

    background: #ecfdf5;
    border: 1px solid #a7f3d0;

    color: #047857;

    font-weight: 700;
}

.error-message {
    margin-bottom: 25px;
    padding: 20px 24px;

    border-radius: 14px;

    background: #fef2f2;
    border: 1px solid #fecaca;

    color: #b91c1c;
}

.error-message ul {
    margin-top: 8px;
}


/* =========================
   2カラム
========================= */

.party-layout {
    display: grid;

    grid-template-columns:
        minmax(0, 1fr)
        360px;

    gap: 30px;

    align-items: start;
}

.party-main {
    min-width: 0;
}

.party-sidebar {
    display: flex;
    flex-direction: column;

    gap: 24px;
}


/* =========================
   共通カード
========================= */

.topic-card,
.setting-card,
.answers-section,
.members-card,
.join-card {
    background: rgba(255, 255, 255, 0.96);

    border: 1px solid #e9d5ff;

    border-radius: 24px;

    box-shadow:
        0 12px 35px rgba(76, 29, 149, 0.08);
}


/* =========================
   お題
========================= */

.topic-card {
    padding: 38px;

    margin-bottom: 25px;
}

.section-label {
    margin-bottom: 12px;

    color: #7c3aed;

    font-size: 13px;
    font-weight: 900;

    letter-spacing: 0.08em;
}

.topic-title {
    margin: 0;

    color: #312e81;

    font-size: 38px;
    line-height: 1.4;
    font-weight: 900;
}

.topic-description {
    margin-top: 20px;

    color: #64748b;

    font-size: 17px;
    line-height: 1.8;

    white-space: pre-wrap;
}

.no-topic {
    padding: 35px 10px;

    text-align: center;
}

.no-topic-icon {
    margin-bottom: 12px;

    font-size: 48px;
}

.no-topic h2 {
    color: #4c1d95;

    font-size: 25px;
    font-weight: 900;
}

.no-topic p {
    color: #64748b;
}


/* =========================
   お題設定
========================= */

.setting-card {
    padding: 30px;

    margin-bottom: 25px;
}

.setting-title {
    margin: 0 0 18px;

    color: #312e81;

    font-size: 23px;
    font-weight: 900;
}

.topic-form {
    display: flex;

    gap: 12px;
}

.topic-select {
    flex: 1;

    min-height: 52px;

    padding: 0 16px;

    border-radius: 12px;

    border: 1px solid #ddd6fe;

    background: white;

    color: #312e81;

    font-size: 16px;
}

.setting-button {
    min-height: 52px;

    padding: 0 22px;

    border: 0;
    border-radius: 12px;

    background: #7c3aed;

    color: white;

    font-size: 15px;
    font-weight: 800;

    cursor: pointer;
}


/* =========================
   回答ボタン
========================= */

.answer-action-card {
    display: flex;

    align-items: center;
    justify-content: space-between;

    gap: 25px;

    margin-bottom: 25px;
    padding: 30px;

    border-radius: 24px;

    background:
        linear-gradient(
            135deg,
            #7c3aed,
            #ec4899
        );

    color: white;

    box-shadow:
        0 14px 35px rgba(124, 58, 237, 0.2);
}

.answer-action-card .section-label {
    color: #f5d0fe;
}

.answer-action-card h2 {
    margin: 0;

    font-size: 25px;
    font-weight: 900;
}

.answer-action-card p {
    margin-top: 8px;

    color: #f5f3ff;
}

.answer-button {
    display: inline-flex;

    align-items: center;
    justify-content: space-between;

    gap: 25px;

    min-width: 190px;
    min-height: 58px;

    padding: 0 22px;

    border-radius: 14px;

    background: white;

    color: #6d28d9;

    font-size: 17px;
    font-weight: 900;

    text-decoration: none;
}


/* =========================
   回答一覧
========================= */

.answers-section {
    padding: 32px;
}

.answers-header {
    display: flex;

    align-items: center;
    justify-content: space-between;

    margin-bottom: 25px;
}

.answers-header h2 {
    margin: 0;

    color: #312e81;

    font-size: 28px;
    font-weight: 900;
}

.answer-count,
.member-count {
    padding: 7px 14px;

    border-radius: 999px;

    background: #f3e8ff;

    color: #6d28d9;

    font-size: 14px;
    font-weight: 800;
}

.answers-grid {
    display: grid;

    grid-template-columns:
        repeat(2, minmax(0, 1fr));

    gap: 22px;

    min-width: 0;
}


/* =========================
   回答カード
========================= */

.answer-card {
    width: 100%;
    max-width: 100%;
    min-width: 0;

    padding: 25px;

    border-radius: 20px;

    background: #fafafa;

    border: 1px solid #e2e8f0;

    box-sizing: border-box;
}

.answer-card-header {
    margin-bottom: 20px;
}

.answer-user {
    display: flex;

    align-items: center;

    gap: 12px;
}

.user-icon {
    display: flex;

    align-items: center;
    justify-content: center;

    width: 44px;
    height: 44px;

    flex-shrink: 0;

    border-radius: 50%;

    background: #ede9fe;

    font-size: 20px;
}

.answer-user strong {
    display: block;

    color: #312e81;

    font-size: 15px;
}

.answer-user small {
    display: block;

    margin-top: 3px;

    color: #94a3b8;
}


/* =========================
   テキスト回答
========================= */

.answer-content {
    width: 100%;

    padding: 22px;

    box-sizing: border-box;

    border-radius: 15px;

    background: white;

    color: #1e1b4b;

    font-size: 22px;
    line-height: 1.7;
    font-weight: 700;

    white-space: pre-wrap;
    word-break: break-word;
}


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

.answer-image img {
    display: block;
    width: 80%;
    max-width: 100%;
    height: auto;
    margin: 0 auto;
    border-radius: 10px;
    object-fit: contain;
}


/* =========================
   補足
========================= */

.answer-description {
    margin-top: 16px;

    padding: 14px 16px;

    border-radius: 12px;

    background: #fefce8;

    color: #713f12;

    font-size: 14px;
    line-height: 1.6;

    word-break: break-word;
}

.answer-description span {
    display: block;

    margin-bottom: 4px;

    font-weight: 900;
}


/* =========================
   投票
========================= */

.vote-area {
    display: flex;

    align-items: center;
    justify-content: space-between;

    gap: 12px;

    margin-top: 20px;
}

.vote-button {
    min-height: 44px;

    padding: 0 18px;

    border: 0;
    border-radius: 10px;

    background: #fce7f3;

    color: #be185d;

    font-size: 14px;
    font-weight: 800;

    cursor: pointer;
}

.vote-count {
    color: #64748b;

    font-size: 14px;
    font-weight: 800;
}


/* =========================
   回答なし
========================= */

.empty-answers {
    padding: 70px 20px;

    text-align: center;
}

.empty-answers-icon {
    margin-bottom: 15px;

    font-size: 52px;
}

.empty-answers h3 {
    margin: 0;

    color: #4c1d95;

    font-size: 24px;
    font-weight: 900;
}

.empty-answers p {
    color: #64748b;
}


/* =========================
   参加者
========================= */

.members-card {
    padding: 30px;
}

.members-title-row {
    display: flex;

    align-items: center;
    justify-content: space-between;

    margin-bottom: 20px;
}

.members-title-row h2 {
    margin: 0;

    color: #312e81;

    font-size: 25px;
    font-weight: 900;
}

.members-list {
    display: flex;

    flex-direction: column;

    gap: 12px;
}

.member-item {
    display: flex;

    align-items: center;

    gap: 12px;

    padding: 14px;

    border-radius: 13px;

    background: #faf5ff;
}

.member-icon {
    display: flex;

    align-items: center;
    justify-content: center;

    width: 40px;
    height: 40px;

    flex-shrink: 0;

    border-radius: 50%;

    background: #ede9fe;

    font-size: 18px;
}

.member-name {
    color: #312e81;

    font-size: 15px;
    font-weight: 700;

    word-break: break-word;
}

.host-badge {
    display: inline-block;

    margin-left: 6px;
    padding: 3px 7px;

    border-radius: 999px;

    background: #fce7f3;

    color: #be185d;

    font-size: 10px;
    font-weight: 900;
}

.no-members {
    color: #64748b;
}


/* =========================
   参加カード
========================= */

.join-card {
    padding: 30px;

    text-align: center;
}

.join-icon {
    margin-bottom: 12px;

    font-size: 48px;
}

.join-card h2 {
    margin: 0;

    color: #4c1d95;

    font-size: 22px;
    font-weight: 900;
}

.join-card p {
    color: #64748b;

    font-size: 14px;
    line-height: 1.7;
}

.join-button {
    width: 100%;

    min-height: 52px;

    border: 0;
    border-radius: 12px;

    background:
        linear-gradient(
            135deg,
            #7c3aed,
            #ec4899
        );

    color: white;

    font-size: 16px;
    font-weight: 900;

    cursor: pointer;
}

.joined-message {
    padding: 18px;

    border-radius: 14px;

    background: #ecfdf5;

    border: 1px solid #a7f3d0;

    color: #047857;

    text-align: center;

    font-size: 15px;
    font-weight: 800;
}
.result-button-area {
    margin-top: 30px;
    text-align: center;
}

.result-button {
    display: inline-block;

    padding: 15px 35px;

    background: linear-gradient(
        135deg,
        #7c3aed,
        #ec4899
    );

    color: white;

    text-decoration: none;

    border-radius: 14px;

    font-size: 18px;

    font-weight: 700;

    box-shadow: 0 5px 15px rgba(124, 58, 237, 0.25);

    transition: 0.2s;
}

.result-button:hover {
    transform: translateY(-2px);

    box-shadow: 0 8px 20px rgba(124, 58, 237, 0.35);
}

/* =========================
   大画面
========================= */

@media (min-width: 1536px) {

    .party-container {
        max-width: 1550px;
    }

    .party-title {
        font-size: 52px;
    }

    .party-layout {
        grid-template-columns:
            minmax(0, 1fr)
            390px;

        gap: 36px;
    }

    .topic-title {
        font-size: 42px;
    }

    .answers-grid {
        gap: 26px;
    }

}


/* =========================
   タブレット
========================= */

@media (max-width: 1100px) {

    .party-layout {
        grid-template-columns: 1fr;
    }

    .party-sidebar {
        display: grid;

        grid-template-columns:
            repeat(2, minmax(0, 1fr));
    }

}


/* =========================
   スマートフォン
========================= */

@media (max-width: 700px) {

    .party-header {
        flex-direction: column;

        align-items: stretch;
    }

    .party-title {
        font-size: 34px;
    }

    .back-button {
        width: 100%;
    }

    .topic-card,
    .setting-card,
    .answers-section,
    .members-card,
    .join-card {
        padding: 22px;

        border-radius: 18px;
    }

    .topic-title {
        font-size: 28px;
    }

    .topic-form {
        flex-direction: column;
    }

    .setting-button {
        width: 100%;
    }

    .answer-action-card {
        flex-direction: column;

        align-items: stretch;
    }

    .answer-button {
        width: 100%;
    }

    .answers-grid {
        grid-template-columns: 1fr;
    }

    .party-sidebar {
        display: flex;
    }

    .answer-image img {
        width: 80%;
    }

}
</style>

@endsection

