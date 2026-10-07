@extends('layouts.app')

@section('content')

<div class="result-page">

    <div class="result-title">
        <div class="trophy">🏆</div>

        <h1>結果発表</h1>

        <p>
            パーティーの投票結果です
        </p>
    </div>


    @if($answers->count() === 0)

        <div class="empty-result">
            <p>まだ回答がありません。</p>
        </div>

    @else

        <div class="ranking">

            @foreach($answers as $index => $answer)

                @php
                    $rank = $index + 1;
                @endphp

                <div class="ranking-item">

                    {{-- 順位 --}}
                    <div class="rank">

                        @if($rank === 1)
                            🥇
                        @elseif($rank === 2)
                            🥈
                        @elseif($rank === 3)
                            🥉
                        @else
                            {{ $rank }}位
                        @endif

                    </div>


                    {{-- 回答 --}}
                    <div class="answer-area">

                        <div class="user-name">
                            {{ $answer->user->name ?? 'ユーザー' }}
                        </div>


                        {{-- テキスト --}}
                        @if($answer->answer_type === 'text')

                            <div class="answer-text">
                                {{ $answer->content }}
                            </div>


                        {{-- 画像 --}}
                        @elseif($answer->answer_type === 'image')

                            @if($answer->image_path)

                                <img
                                    src="{{ asset('storage/' . $answer->image_path) }}"
                                    class="answer-image"
                                    alt="回答画像"
                                >

                            @endif


                        {{-- イラスト --}}
                        @elseif($answer->answer_type === 'drawing')

                            @if($answer->drawing_path)

                                <img
                                    src="{{ asset('storage/' . $answer->drawing_path) }}"
                                    class="answer-image"
                                    alt="回答イラスト"
                                >

                            @endif

                        @endif


                        {{-- 説明 --}}
                        @if($answer->description)

                            <div class="description">
                                {{ $answer->description }}
                            </div>

                        @endif

                    </div>


                    {{-- 投票数 --}}
                    <div class="votes">

                        <span class="vote-number">
                            {{ $answer->votes_count }}
                        </span>

                        <span>
                            票
                        </span>

                    </div>

                </div>

            @endforeach

        </div>

    @endif


    <div class="result-back">

        <a
            href="{{ route('rooms.show', $room) }}"
        >
            ルームに戻る
        </a>

    </div>

</div>


<style>

.result-page {
    max-width: 1000px;
    margin: 50px auto;
    padding: 30px;
}

.result-title {
    text-align: center;
    margin-bottom: 40px;
}

.trophy {
    font-size: 70px;
}

.result-title h1 {
    margin: 10px 0;

    font-size: 42px;

    font-weight: 800;

    color: #2563eb;
}

.result-title p {
    color: #6b7280;
}


.ranking {
    display: flex;
    flex-direction: column;
    gap: 20px;
}


.ranking-item {

    display: flex;

    align-items: center;

    gap: 25px;

    padding: 25px;

    background: white;

    border-radius: 20px;

    border: 2px solid #e5e7eb;

    box-shadow:
        0 5px 20px rgba(0,0,0,0.08);

}


.rank {

    width: 80px;

    flex-shrink: 0;

    text-align: center;

    font-size: 30px;

    font-weight: 800;

}


.answer-area {

    flex: 1;

    min-width: 0;

}


.user-name {

    font-size: 18px;

    font-weight: 700;

    color: #374151;

    margin-bottom: 10px;

}


.answer-text {

    font-size: 24px;

    font-weight: 600;

    color: #111827;

    line-height: 1.6;

    word-break: break-word;

}


.answer-image {

    display: block;

    max-width: 350px;

    max-height: 250px;

    width: auto;

    height: auto;

    margin: 10px auto;

    border-radius: 12px;

}


.description {

    margin-top: 10px;

    color: #6b7280;

}


.votes {

    width: 100px;

    flex-shrink: 0;

    text-align: center;

    padding: 15px;

    background: #eff6ff;

    border-radius: 15px;

    color: #374151;

}


.vote-number {

    display: block;

    font-size: 36px;

    font-weight: 800;

    color: #2563eb;

}


.empty-result {

    background: white;

    padding: 50px;

    text-align: center;

    border-radius: 20px;

}


.result-back {

    text-align: center;

    margin-top: 40px;

}


.result-back a {

    display: inline-block;

    padding: 14px 30px;

    background: #2563eb;

    color: white;

    text-decoration: none;

    border-radius: 12px;

    font-weight: 700;

}


.result-back a:hover {

    background: #1d4ed8;

}
/* =========================
   回答画像・イラスト
========================= */
/* ランキングカード */
.ranking-item {
    display: grid;
    grid-template-columns: 80px minmax(0, 1fr) 130px;
    align-items: center;
    gap: 20px;

    padding: 25px;
    background: white;
    border-radius: 20px;
    border: 2px solid #e5e7eb;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);

    box-sizing: border-box;
}

/* 順位 */
.rank {
    width: 80px;
    text-align: center;
    font-size: 30px;
    font-weight: 800;
}

/* 回答エリア */
.answer-area {
    min-width: 0;
    width: 100%;
}

/* ユーザー名 */
.user-name {
    font-size: 18px;
    font-weight: 700;
    color: #374151;
    margin-bottom: 15px;
}

/* テキスト回答 */
.answer-text {
    font-size: 24px;
    font-weight: 600;
    color: #111827;
    line-height: 1.6;
    word-break: break-word;
}

/* 画像・イラスト */
.answer-image {
    display: block;
    width: auto;
    max-width: 100%;
    max-height: 250px;
    height: auto;
    object-fit: contain;
    margin: 10px auto;
    border-radius: 12px;
}

/* 説明 */
.description {
    margin-top: 15px;
    color: #6b7280;
    overflow-wrap: anywhere;
}

/* 投票数 */
.votes {
    width: 130px;
    min-height: 130px;
    box-sizing: border-box;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;

    padding: 15px;
    background: #eff6ff;
    border-radius: 20px;
    color: #374151;
}

/* 投票数の数字 */
.vote-number {
    display: block;
    font-size: 42px;
    font-weight: 800;
    line-height: 1.2;
    color: #2563eb;
}

</style>

@endsection