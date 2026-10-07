@extends('layouts.app')

@section('content')

<div class="ogiri-home">

    {{-- ========================================
         ヒーローエリア
    ======================================== --}}

    <section class="home-hero">

        <div class="home-hero-inner">

            {{-- 左側 --}}
            <div class="home-text">

                <div class="home-badge">
                    🎨 クリエイティブSNS
                </div>

                <h1>
                    みんなで楽しむ<br>
                    <span>創作プラットフォーム</span>
                </h1>

                <p>
                    テキスト・イラスト・画像を使って<br>
                    大喜利や創作活動を楽しもう！
                </p>


                {{-- メインボタン --}}
                <div class="home-buttons">

                    <a
                        href="{{ route('topics.index') }}"
                        class="home-button primary"
                    >
                        🎯 お題を見る
                    </a>

                    <a
                        href="{{ route('rooms.index') }}"
                        class="home-button secondary"
                    >
                        🎉 パーティーモード
                    </a>

                </div>

            </div>


            {{-- 右側 --}}
            <div class="home-visual">

                <div class="visual-card card-one">
                    <span>💡</span>
                    <p>お題を考える</p>
                </div>

                <div class="visual-card card-two">
                    <span>✏️</span>
                    <p>自由に回答</p>
                </div>

                <div class="visual-card card-three">
                    <span>🏆</span>
                    <p>みんなで楽しむ</p>
                </div>

                <div class="visual-main">
                    🎨
                </div>

            </div>

        </div>

    </section>


    {{-- ========================================
         メニュー
    ======================================== --}}

    <section class="home-menu">

        <div class="home-container">

            <div class="section-heading">

                <p>FEATURE</p>

                <h2>
                    Ogiriを楽しもう
                </h2>

            </div>


            <div class="feature-grid">

                {{-- お題 --}}
                <a
                    href="{{ route('topics.index') }}"
                    class="feature-card"
                >

                    <div class="feature-icon purple">
                        💡
                    </div>

                    <div>
                        <h3>
                            お題を見る
                        </h3>

                        <p>
                            みんなが投稿した<br>
                            お題を見て回答しよう！
                        </p>
                    </div>

                    <span class="arrow">
                        →
                    </span>

                </a>


                {{-- パーティー --}}
                <a
                    href="{{ route('rooms.index') }}"
                    class="feature-card"
                >

                    <div class="feature-icon pink">
                        🎉
                    </div>

                    <div>
                        <h3>
                            パーティーモード
                        </h3>

                        <p>
                            友達とルームを作って<br>
                            みんなで大喜利を楽しもう！
                        </p>
                    </div>

                    <span class="arrow">
                        →
                    </span>

                </a>


                {{-- ランキング --}}
                <a
                    href="{{ route('topics.ranking') }}"
                    class="feature-card"
                >

                    <div class="feature-icon blue">
                        🏆
                    </div>

                    <div>
                        <h3>
                            人気ランキング
                        </h3>

                        <p>
                            人気のお題をチェックして<br>
                            面白い作品を探そう！
                        </p>
                    </div>

                    <span class="arrow">
                        →
                    </span>

                </a>

            </div>

        </div>

    </section>

</div>


{{-- ========================================
     CSS
======================================== --}}

<style>

/* ========================================
   ホーム全体
======================================== */

.ogiri-home {
    min-height: calc(100vh - 70px);
    background:
        linear-gradient(
            135deg,
            #faf5ff 0%,
            #ffffff 45%,
            #fdf2f8 100%
        );
}


/* ========================================
   ヒーロー
======================================== */

.home-hero {
    width: 100%;
    min-height: 600px;

    display: flex;
    align-items: center;

    padding: 70px 48px;
}


.home-hero-inner {
    width: 100%;
    max-width: 1400px;

    margin: 0 auto;

    display: grid;
    grid-template-columns: 1fr 0.85fr;

    gap: 80px;

    align-items: center;
}


/* ========================================
   左側テキスト
======================================== */

.home-text {
    max-width: 720px;
}


.home-badge {
    display: inline-block;

    padding: 10px 20px;

    margin-bottom: 24px;

    border-radius: 999px;

    background: #f3e8ff;

    color: #7e22ce;

    font-size: 16px;
    font-weight: 700;
}


.home-text h1 {
    margin: 0;

    font-size: clamp(48px, 5vw, 72px);

    line-height: 1.18;

    font-weight: 800;

    letter-spacing: -1px;

    color: #4c1d95;
}


.home-text h1 span {
    color: #9333ea;
}


.home-text p {
    margin-top: 28px;

    font-size: 20px;

    line-height: 1.8;

    color: #6b7280;
}


/* ========================================
   メインボタン
======================================== */

.home-buttons {
    display: flex;

    gap: 18px;

    margin-top: 40px;
}


.home-button {
    display: inline-flex;

    align-items: center;
    justify-content: center;

    min-width: 230px;

    min-height: 60px;

    padding: 14px 28px;

    border-radius: 16px;

    font-size: 18px;

    font-weight: 700;

    text-decoration: none;

    transition:
        transform 0.2s,
        box-shadow 0.2s;
}


.home-button:hover {
    transform: translateY(-3px);
}


/* メイン */
.home-button.primary {
    background: #9333ea;

    color: white;

    box-shadow:
        0 10px 25px
        rgba(147, 51, 234, 0.25);
}


.home-button.primary:hover {
    box-shadow:
        0 15px 30px
        rgba(147, 51, 234, 0.35);
}


/* サブ */
.home-button.secondary {
    background: white;

    color: #7e22ce;

    border: 2px solid #e9d5ff;

    box-shadow:
        0 8px 20px
        rgba(0, 0, 0, 0.06);
}


/* ========================================
   右側ビジュアル
======================================== */

.home-visual {
    position: relative;

    min-height: 460px;

    display: flex;

    align-items: center;
    justify-content: center;
}


.visual-main {
    width: 300px;
    height: 300px;

    display: flex;

    align-items: center;
    justify-content: center;

    border-radius: 80px;

    background:
        linear-gradient(
            135deg,
            #c084fc,
            #f472b6
        );

    font-size: 130px;

    transform: rotate(-5deg);

    box-shadow:
        0 30px 60px
        rgba(147, 51, 234, 0.25);
}


/* ========================================
   周囲のカード
======================================== */

.visual-card {
    position: absolute;

    display: flex;

    align-items: center;

    gap: 12px;

    padding: 16px 22px;

    background: white;

    border-radius: 18px;

    box-shadow:
        0 15px 35px
        rgba(0, 0, 0, 0.10);

    font-weight: 700;

    color: #4b5563;
}


.visual-card span {
    font-size: 28px;
}


.visual-card p {
    margin: 0;
}


/* 左上 */
.card-one {
    top: 30px;
    left: 20px;
}


/* 右上 */
.card-two {
    top: 80px;
    right: 0;
}


/* 右下 */
.card-three {
    bottom: 40px;
    right: 30px;
}


/* ========================================
   FEATURE
======================================== */

.home-menu {
    padding: 70px 48px 100px;

    background: white;
}


.home-container {
    width: 100%;

    max-width: 1400px;

    margin: 0 auto;
}


/* ========================================
   セクションタイトル
======================================== */

.section-heading {
    text-align: center;

    margin-bottom: 45px;
}


.section-heading p {
    margin: 0 0 8px;

    color: #9333ea;

    font-size: 14px;

    font-weight: 800;

    letter-spacing: 3px;
}


.section-heading h2 {
    margin: 0;

    font-size: 36px;

    color: #4c1d95;

    font-weight: 800;
}


/* ========================================
   カード3列
======================================== */

.feature-grid {
    display: grid;

    grid-template-columns:
        repeat(3, 1fr);

    gap: 28px;
}


.feature-card {
    position: relative;

    display: flex;

    align-items: flex-start;

    gap: 22px;

    min-height: 210px;

    padding: 32px;

    border-radius: 24px;

    border: 1px solid #f3f4f6;

    background: #ffffff;

    text-decoration: none;

    box-shadow:
        0 10px 30px
        rgba(0, 0, 0, 0.06);

    transition:
        transform 0.2s,
        box-shadow 0.2s;
}


.feature-card:hover {
    transform: translateY(-6px);

    box-shadow:
        0 20px 40px
        rgba(0, 0, 0, 0.10);
}


/* ========================================
   アイコン
======================================== */

.feature-icon {
    flex-shrink: 0;

    width: 70px;
    height: 70px;

    display: flex;

    align-items: center;
    justify-content: center;

    border-radius: 20px;

    font-size: 34px;
}


.feature-icon.purple {
    background: #f3e8ff;
}


.feature-icon.pink {
    background: #fce7f3;
}


.feature-icon.blue {
    background: #dbeafe;
}


/* ========================================
   カード文字
======================================== */

.feature-card h3 {
    margin: 4px 0 10px;

    font-size: 22px;

    color: #4c1d95;

    font-weight: 800;
}


.feature-card p {
    margin: 0;

    color: #6b7280;

    font-size: 16px;

    line-height: 1.7;
}


/* ========================================
   矢印
======================================== */

.arrow {
    position: absolute;

    right: 25px;
    bottom: 22px;

    font-size: 24px;

    color: #a855f7;

    font-weight: 700;
}


/* ========================================
   1600px以上
======================================== */

@media (min-width: 1600px) {

    .home-hero {
        min-height: 680px;

        padding-top: 90px;
        padding-bottom: 90px;
    }

    .home-hero-inner {
        max-width: 1500px;

        gap: 100px;
    }

    .home-text h1 {
        font-size: 76px;
    }

    .visual-main {
        width: 340px;
        height: 340px;

        font-size: 150px;
    }

}


/* ========================================
   タブレット
======================================== */

@media (max-width: 1100px) {

    .home-hero {
        padding: 60px 30px;
    }

    .home-hero-inner {
        grid-template-columns: 1fr;

        gap: 50px;

        max-width: 900px;
    }

    .home-text {
        max-width: 800px;

        margin: 0 auto;

        text-align: center;
    }

    .home-buttons {
        justify-content: center;
    }

    .home-visual {
        min-height: 400px;
    }

    .feature-grid {
        grid-template-columns: 1fr;
    }

}


/* ========================================
   スマートフォン
======================================== */

@media (max-width: 640px) {

    .home-hero {
        padding: 45px 18px;
    }

    .home-text h1 {
        font-size: 38px;
    }

    .home-text p {
        font-size: 16px;
    }

    .home-buttons {
        flex-direction: column;
    }

    .home-button {
        width: 100%;
    }

    .home-visual {
        min-height: 320px;
    }

    .visual-main {
        width: 210px;
        height: 210px;

        border-radius: 55px;

        font-size: 90px;
    }

    .visual-card {
        padding: 10px 14px;

        font-size: 13px;
    }

    .visual-card span {
        font-size: 20px;
    }

    .card-one {
        left: 0;
    }

    .card-two {
        right: 0;
    }

    .card-three {
        right: 0;
        bottom: 10px;
    }

    .home-menu {
        padding: 50px 18px 70px;
    }

    .section-heading h2 {
        font-size: 28px;
    }

    .feature-card {
        padding: 24px;
    }

}

</style>

@endsection