@extends('layouts.app')

@section('content')

<div class="ogiri-page rooms-page">


<div class="rooms-container">

    {{-- ヘッダー --}}
    <div class="rooms-header">

        <div>
            <div class="rooms-label">
                🎮 PARTY MODE
            </div>

            <h1 class="rooms-title">
                パーティールーム
            </h1>

            <p class="rooms-subtitle">
                みんなで参加して、大喜利を楽しもう！
            </p>
        </div>

        <a href="{{ route('rooms.create') }}" class="create-room-button">
            ＋ ルームを作成
        </a>

    </div>


    {{-- 成功メッセージ --}}
    @if(session('success'))
        <div class="success-message">
            ✓ {{ session('success') }}
        </div>
    @endif


    {{-- ルーム一覧 --}}
    @if($rooms->count() > 0)

        <div class="rooms-grid">

            @foreach($rooms as $room)

                <div class="room-card">

                    <div class="room-card-top">

                        <div class="room-icon">
                            🎮
                        </div>

                        @if($room->status === 'waiting')
                            <span class="room-status waiting">
                                参加受付中
                            </span>
                        @else
                            <span class="room-status">
                                {{ $room->status }}
                            </span>
                        @endif

                    </div>


                    <h2 class="room-name">
                        {{ $room->name }}
                    </h2>


                    <div class="room-info">

                        <div class="room-info-item">
                            <span class="info-icon">👤</span>
                            <span>
                                作成者：
                                {{ $room->host?->name ?? '不明' }}
                            </span>
                        </div>

                        <div class="room-info-item">
                            <span class="info-icon">📅</span>
                            <span>
                                {{ $room->created_at->format('Y/m/d H:i') }}
                            </span>
                        </div>

                    </div>


                    <a
                        href="{{ route('rooms.show', $room) }}"
                        class="enter-room-button"
                    >
                        ルームに入室
                        <span>→</span>
                    </a>

                </div>

            @endforeach

        </div>

    @else

        {{-- ルームがない場合 --}}
        <div class="empty-room">

            <div class="empty-icon">
                🎮
            </div>

            <h2>
                まだルームがありません
            </h2>

            <p>
                最初のパーティールームを作ってみましょう！
            </p>

            <a
                href="{{ route('rooms.create') }}"
                class="create-room-button empty-button"
            >
                ＋ ルームを作成する
            </a>

        </div>

    @endif

</div>


</div>

<style>

.rooms-page {
    min-height: calc(100vh - 64px);
    background:
        radial-gradient(circle at top left, rgba(168, 85, 247, 0.12), transparent 35%),
        radial-gradient(circle at bottom right, rgba(236, 72, 153, 0.12), transparent 35%),
        linear-gradient(135deg, #faf5ff, #ffffff, #fdf2f8);
}


/* =========================
   全体
========================= */

.rooms-container {
    width: 100%;
    max-width: 1450px;
    margin: 0 auto;
}


/* =========================
   ヘッダー
========================= */

.rooms-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 40px;
    margin-bottom: 45px;
}

.rooms-label {
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

.rooms-title {
    margin: 0;
    color: #4c1d95;
    font-size: 44px;
    line-height: 1.25;
    font-weight: 900;
}

.rooms-subtitle {
    margin-top: 12px;
    color: #64748b;
    font-size: 18px;
}


/* =========================
   作成ボタン
========================= */

.create-room-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;

    min-height: 56px;
    padding: 0 28px;

    border-radius: 14px;

    background: linear-gradient(
        135deg,
        #7c3aed,
        #ec4899
    );

    color: white;

    font-size: 17px;
    font-weight: 800;

    text-decoration: none;

    box-shadow:
        0 10px 25px rgba(124, 58, 237, 0.22);

    transition:
        transform 0.2s ease,
        box-shadow 0.2s ease;
}

.create-room-button:hover {
    transform: translateY(-2px);

    box-shadow:
        0 14px 30px rgba(124, 58, 237, 0.3);
}


/* =========================
   メッセージ
========================= */

.success-message {
    margin-bottom: 30px;
    padding: 18px 24px;

    border-radius: 14px;

    background: #ecfdf5;
    border: 1px solid #a7f3d0;

    color: #047857;

    font-size: 16px;
    font-weight: 700;
}


/* =========================
   ルーム一覧
========================= */

.rooms-grid {
    display: grid;

    grid-template-columns:
        repeat(3, minmax(0, 1fr));

    gap: 28px;
}


/* =========================
   ルームカード
========================= */

.room-card {
    padding: 32px;

    border-radius: 24px;

    background: rgba(255, 255, 255, 0.95);

    border: 1px solid #e9d5ff;

    box-shadow:
        0 12px 35px rgba(76, 29, 149, 0.08);

    transition:
        transform 0.2s ease,
        box-shadow 0.2s ease;
}

.room-card:hover {
    transform: translateY(-5px);

    box-shadow:
        0 18px 45px rgba(76, 29, 149, 0.14);
}


/* =========================
   カード上部
========================= */

.room-card-top {
    display: flex;
    align-items: center;
    justify-content: space-between;

    margin-bottom: 24px;
}

.room-icon {
    display: flex;
    align-items: center;
    justify-content: center;

    width: 58px;
    height: 58px;

    border-radius: 16px;

    background: #f3e8ff;

    font-size: 28px;
}


/* =========================
   ステータス
========================= */

.room-status {
    padding: 7px 14px;

    border-radius: 999px;

    background: #f1f5f9;
    color: #64748b;

    font-size: 13px;
    font-weight: 800;
}

.room-status.waiting {
    background: #dcfce7;
    color: #15803d;
}


/* =========================
   ルーム名
========================= */

.room-name {
    margin: 0 0 24px;

    color: #312e81;

    font-size: 28px;
    line-height: 1.4;
    font-weight: 900;

    word-break: break-word;
}


/* =========================
   ルーム情報
========================= */

.room-info {
    display: flex;
    flex-direction: column;
    gap: 12px;

    margin-bottom: 28px;
}

.room-info-item {
    display: flex;
    align-items: center;
    gap: 10px;

    color: #64748b;

    font-size: 15px;
}

.info-icon {
    font-size: 18px;
}


/* =========================
   入室ボタン
========================= */

.enter-room-button {
    display: flex;
    align-items: center;
    justify-content: space-between;

    width: 100%;
    min-height: 52px;

    padding: 0 20px;

    border-radius: 12px;

    background: #f3e8ff;
    color: #6d28d9;

    font-size: 16px;
    font-weight: 800;

    text-decoration: none;

    transition:
        background 0.2s ease,
        transform 0.2s ease;
}

.enter-room-button:hover {
    background: #e9d5ff;
    transform: translateY(-1px);
}


/* =========================
   ルームなし
========================= */

.empty-room {
    padding: 90px 30px;

    text-align: center;

    border-radius: 28px;

    background: rgba(255, 255, 255, 0.95);

    border: 1px solid #e9d5ff;

    box-shadow:
        0 12px 35px rgba(76, 29, 149, 0.08);
}

.empty-icon {
    margin-bottom: 20px;

    font-size: 64px;
}

.empty-room h2 {
    margin: 0;

    color: #4c1d95;

    font-size: 30px;
    font-weight: 900;
}

.empty-room p {
    margin: 14px 0 28px;

    color: #64748b;

    font-size: 17px;
}

.empty-button {
    display: inline-flex;
}


/* =========================
   大画面
========================= */

@media (min-width: 1536px) {

    .rooms-container {
        max-width: 1550px;
    }

    .rooms-title {
        font-size: 50px;
    }

    .rooms-subtitle {
        font-size: 20px;
    }

    .rooms-grid {
        gap: 32px;
    }

    .room-card {
        padding: 36px;
    }

    .room-name {
        font-size: 30px;
    }

}


/* =========================
   タブレット
========================= */

@media (max-width: 1100px) {

    .rooms-grid {
        grid-template-columns:
            repeat(2, minmax(0, 1fr));
    }

}


/* =========================
   スマートフォン
========================= */

@media (max-width: 700px) {

    .rooms-header {
        flex-direction: column;
        align-items: stretch;
    }

    .rooms-title {
        font-size: 34px;
    }

    .rooms-subtitle {
        font-size: 16px;
    }

    .create-room-button {
        width: 100%;
    }

    .rooms-grid {
        grid-template-columns: 1fr;
    }

    .room-card {
        padding: 24px;
    }

    .room-name {
        font-size: 24px;
    }

}

</style>

@endsection
